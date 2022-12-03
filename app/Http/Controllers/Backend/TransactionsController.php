<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\ApprovalLevel;
use App\Models\ApprovalLog;
use App\Models\CargoType;
use App\Models\Department;
use App\Models\Carrier;
use App\Models\Consignee;
use App\Models\Destination;
use App\Models\RecoveryInvoice;
use App\Models\RecoveryInvoiceStatus;
use App\Models\Shipper;
use App\Models\Transaction;
use App\Models\TransactionInvoice;
use App\Models\Vehicle;
use App\Models\TransferLog;
use Carbon\Carbon;
use DB;
use Auth;
use App\Models\ReasonCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\Facades\DNS1DFacade;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ValidExports;

class TransactionsController extends Controller
{
    public function index()
    {
        // $permitted = 
        $transactions = Transaction::filter(request()->all())->latest()->paginate(20);

        return view('backend.trx.list', compact("transactions"));
    }

    public function create()
    {
        $agents = Agent::all();
        $destinations = Destination::all();
        $carriers = Carrier::all();
        $shippers = Shipper::all();
        $vehicles = Vehicle::all();
        $cargo_types = CargoType::all();
        $consignees = Consignee::all();
        $departments = Department::all();

        return view('backend.trx.create', compact('agents', 'destinations', 'departments', 'shippers', 'vehicles', 'carriers', 'cargo_types', 'consignees'));
    }

    public function store()
    {
        $validated = request()->validate([
            "agent_departure" => "required|numeric|exists:agents,id",
            "agent_destination" => "required|numeric|exists:destinations,id",
            "carrier" => "required|numeric|exists:carriers,id",
            "shipper" => "required|numeric|exists:shippers,id",
            "consignee" => "required|numeric|exists:consignees,id",
            "vehicle" => "required|numeric|exists:vehicles,id",
            "date" => "required|string",
            "tracking_no" => "required|numeric",
            "marks" => "required|string",
            "cargo_type" => "required|numeric|exists:cargo_types,id",
            "cargo_desc" => "required|string",
            "quantity" => "required|string",
            "weight" => "required|string",
            "remarks" => "required|string",
            "customs_no" => "required|string",
            "notes" => "required|string",
            "file_no" => "required|numeric",
            "trailer_no" => "required|numeric",
            "container_no" => "required|numeric",
            "agreed_rate" => "required|numeric",
            "currency" => "required|numeric",
            "rcn_no" => "string"
        ]);

        $validated['currency_id'] = $validated['currency'];
        $validated['purchase_order_no'] = $validated['purchase_order_no'];
        $validated["rcn_no"] = request()->has('rcn_no') && request('rcn_no') ? request("rcn_no") : "TROM" . strtoupper($this->generateRandomString(9)) . "00" . rand(100, 1000);
        $validated['source_type'] = Transaction::$MANUAL_TRANSACTION;
        $validated["date"] = Carbon::createFromFormat("m-d-Y", $validated["date"])->format("Y-m-d");

        $rcn = Transaction::updateOrCreate(['rcn_no' => request('rcn_no')], $validated);

        if (request()->has("print") && request("print")) {
            return $this->print($rcn->id);
        } else {
            return redirect()->to(route('admin.transactions.list'))->with("flash_success", "Transaction created successfully");
        }
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function view($id)
    {

        $transaction = Transaction::with('vehicleR')->with('shipperR')->with('carrierR')->with('consigneeR')->with('destination')->with('agent')->findOrFail($id);

        // return response()->json($transaction);
        return view('backend.trx.view', compact("transaction"));
    }

    public function print($id)
    {
        $transaction = Transaction::findOrFail($id);


        if ($transaction->source_type == Transaction::$SOURCE_TYPE_UPLOADED) {
            $qrcode = base64_encode(QrCode::format('svg')->size(150)->errorCorrection('H')->generate('string'));
        } else {
            $qrcode = base64_encode(DNS1DFacade::getBarcodeHTML('4546435345', 'UPCA', 3, 150));
        }

        $pdf = Pdf::loadView('backend.trx.print_trx', [
            'transaction' => $transaction,
            'qrcode' => $qrcode
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('transactions -' . $transaction->rcn_no . '.pdf');

        return view('backend.trx.print_trx', compact("transaction", "qrcode"));
    }

    public function searchRcn()
    {
        return view('backend.trx.search_rcn');
    }

    public function attachInvoice()
    {
        // $invoice = null;
        if (request()->has("clear")) {
            $cleaned_rcns = explode(',', request('rcns'));

            if (($key = array_search(request('rcn_no'), $cleaned_rcns)) !== false) {
                unset($cleaned_rcns[$key]);
            }

            return redirect()->to(route('admin.transactions.attach-invoice') . '?rcns=' . implode(',', $cleaned_rcns));
        }

        
        // $status = request('status');
        $status = session("status");
        // if(!isset($status))
        // {
        //     $status = null;
        // }
        // $request->session()->forget('status');

        if (request()->has("rcn_no")) {
            $rcn = Transaction::where("rcn_no", request("rcn_no"))->first();            
            if (!$rcn) {
                $status = session("status", true);
                return redirect()->back()->with("flash_danger", "RCN no: " . request("rcn_no") . " not found. Continue and add transporter name? <a href='".route("admin.transactions.attach-invoice")."?rcns=".request('rcn_no').":0"."&status=".$status."'> Yes </a>")->withInput();
            }            
            // $invoice = $rcn->invoice_id;
            $current_rcns = request('rcns') ? request('rcns') . "," : "";
            $cleaned_rcns = $this->cleanRcnQueryString($current_rcns);
            $rcns =  $current_rcns . $rcn->rcn_no . ':' . $rcn->amount;

            if (in_array(request('rcn_no'), $cleaned_rcns)) {
                return redirect()->to(route('admin.transactions.attach-invoice') . '?rcns=' . request('rcns'))->with("flash_danger", "RCN no: " . request("rcn_no") . " added already");
            }
            // $invoice = request('invoice_id') ?  request('invoice_id') : $rcn->invoice_id;

            if ($rcn->invoice_id) {
                return redirect()->back()->with("flash_danger", "RCN no: " . request("rcn_no") . " has an invoice attached already. Would you like to proceed? <a href='".route("admin.transactions.attach-invoice")."?rcns=".$rcns."&status=".$status."'> Yes </a>")->withInput();
                // return redirect()->to(route('admin.transactions.attach-invoice') . '?rcns=' . $rcns  .'&invoice='.$invoice);
            }

            if (request()->has('invoice')) {
                if($rcn->invoice_id != request('invoice'))
                {
                    return redirect()->back()->with("flash_danger", "ERROR: The invoice numbers ".$rcn->invoice_id. ' and ' . request("invoice") . "do not match")->withInput();
                }
            }

            return redirect()->to(route('admin.transactions.attach-invoice') . '?rcns=' . $rcns.'&status='.$status)->withInput();

        }

        return view('backend.trx.attach_invoice');
    }

    private function cleanRcnQueryString($current_rcns, $with_total = false)
    {
        $rcn_arr = explode(",", $current_rcns);

        $cleaned_rcns = [];
        if (count($rcn_arr) > 0) {
            foreach ($rcn_arr as $rc) {
                $l = explode(":", $rc);
                if (count($l) > 1) {
                    $n = $with_total ? $l : $l[0];
                    array_push($cleaned_rcns, $n);
                }
            }
        }

        return $cleaned_rcns;
    }

    public function saveAttachedInvoice()
    {
        $inv = TransactionInvoice::where('invoice_number', request('invoice_number'))->first();

        if ($inv) {
            return redirect()->back()
                // ->to(route('admin.transactions.attach-invoice') . '?rcns=' . request('rcns'))
                ->with("flash_danger", "Invoice number " . request('invoice_number') . " already exists")->withInput();
        }

        $rcns = $this->cleanRcnQueryString(request('rcns'), true);

        $total = 0;
        foreach ($rcns as $rcn) {
            $total += $rcn[1] ? $rcn[1] : 0;
        }
        $total_matched = request('invoice_amount') == $total;

        if (count($rcns) < 1) {
            return redirect()
                ->to(route('admin.transactions.attach-invoice') . '?rcns=' . request('rcns'))
                ->with("flash_danger", "Please attach at least one RCN")->withInput();
        }

        request()->validate([
            'credit_note_amount'=>'required_with:credit_note',
            'invoice_number' => 'required',
            'invoice_amount' => 'required',
            // 'delivery_note' => 'required',
            'invoice_date' => 'required',
            'currency' => 'required|numeric',
        ]);

        $invoice = TransactionInvoice::create([
        //     "invoice_number" =>
        //     request("invoice_number"),
        // ], [
            "user_id" => auth()->user()->id,
            "invoice_number" => request("invoice_number"),
            "invoice_amount" => request("invoice_amount"),
            "delivery_note" => request("delivery_note"),
            "file_number" => request("file_number"),
            "invoice_date" => Carbon::createFromFormat("m-d-Y", request("invoice_date")),
            "dnote_date" => Carbon::createFromFormat("m-d-Y", request("dnote_date")),
            "comments" => request("comments"),
            "tracking_no" => request("tracking_number"),
            "tracking_date" => Carbon::createFromFormat("m-d-Y", request("tracking_date")),
            "currency_id" => request("currency"),
            "credit_note" => request("credit_note"),
            "credit_note_amount" => request("credit_note_amount")
        ]);


        foreach ($rcns as $rcn) {
            $transaction = Transaction::where('rcn_no', $rcn[0])->first();

            if(!$transaction)
            {
                $transaction = Transaction::create([
                    'rcn_no' => $rcn[0],
                    "agent_departure" => 0,
                    "agent_destination" => 0,
                    "carrier" => 0,
                    "shipper" => 0,
                    "consignee" => request("transporter"),
                    "vehicle" => 0,
                    "date" => date("Y-m-d"),
                    "tracking_no" => 0,
                    "marks" => "Override",
                    "cargo_type" => 0,
                    "cargo_desc" => 0,
                    "quantity" => 0,
                    "weight" => 0,
                    "remarks" => "NA",
                    "customs_no" => "NA",
                    "notes" => "NA",
                    "file_no" => 0,
                    "trailer_no" => 0,
                    "container_no" => 0,
                    "agreed_rate" => 0,
                    "currency" => 0,

                ]);
            }

            if ($transaction->source_type == Transaction::$MANUAL_TRANSACTION) {
                $transaction->update([
                    "status" => Transaction::$INVOICE_ATTACHED,
                    "invoice_id" => $invoice->id
                ]);
            } else if (!$total_matched) {
                $transaction->update([
                    "status" => Transaction::$AMOUNT_NOT_EQUAL,
                    "invoice_id" => $invoice->id
                ]);
            } else {
                $transaction->update([
                    "status" => Transaction::$INVOICE_MATCHED,
                    "invoice_id" => $invoice->id
                ]);
            }

            
        }

        return redirect()
            ->to(route("admin.transactions.attach-invoice"))
            ->with("flash_success", "Invoice number " . request('invoice_number') . " added successfully");
    }

    // discard and attach RCN's
    public function discardInvoice($invoice_id)
    {
        $invoice = TransactionInvoice::find($invoice_id);

        // get invoice approval log reason code
        $code = $invoice->recoveryInvoice->approvalLogs->last()->reason->id;

        // return $code !== 2 || $code !== 4;

        // if($code != 0)
        if(!in_array($code, [2, 4], true))
        {
            return redirect()->back()->with("flash_danger", "The request can't be completed. The invoice reason code and action mismatch");
        }

        $rcns = Transaction::where('invoice_id', $invoice_id)->get();
        foreach($rcns as $rcn){
            $rcn->update([
                'invoice_id' => null,
            ]);
        }

        $invoice->update([
            'comments' => 'Invoice discarded.',
        ]);

        return redirect()->to(route('admin.transactions.attach-invoice'))->with('flash_danger', "The invoice has been sucessfully discarded.");
    }

    public function saveUpdatedInvoice($invoice_id)
    {
        request()->validate([
            'credit_note_amount'=>'required_with:credit_note',
            'invoice_number' => 'required',
            'invoice_amount' => 'required',
            // 'delivery_note' => 'required',
            'invoice_date' => 'required',
            'currency' => 'required|numeric',
        ]);

        // return request();

        $invoice = TransactionInvoice::find($invoice_id);
        $invoice->invoice_number = request("invoice_number");
        $invoice->invoice_amount = request("invoice_amount");
        $invoice->delivery_note = request("delivery_note");
        $invoice->file_number = request("file_number");
        $invoice->invoice_date = Carbon::createFromFormat("m-d-Y", request("invoice_date"));
        $invoice->dnote_date = Carbon::createFromFormat("m-d-Y", request("dnote_date"));
        $invoice->comments = request("comments");
        $invoice->tracking_no = request("tracking_number");
        $invoice->tracking_date = Carbon::createFromFormat("m-d-Y", request("tracking_date"));
        $invoice->currency_id = request("currency");
        $invoice->credit_note = request("credit_note");
        $invoice->credit_note_amount = request("credit_note_amount");
        $invoice->comments = request("comments");
        $invoice->status = "pending";
        $invoice->save();

        // find the invoice RCNs
        $rcns = Transaction::where('invoice_id', $invoice_id)->get();

        $total = 0;
        foreach ($rcns as $rcn) {
            $total += $rcn->amount;
        }
        $total_matched = request('invoice_amount') == $total;

        foreach($rcns as $transaction)
        {
            if (!$total_matched) {
                $transaction->update([
                    "status" => Transaction::$AMOUNT_NOT_EQUAL,
                ]);
            } else{
                $transaction->update([
                    "status" => Transaction::$INVOICE_MATCHED,
                ]);
            }
        }

        // any time the invoice is edited, restart the approval process.
        if($invoice->recoveryInvoice)
        {
            // $log = $invoice->recoveryInvoice->approvalLogs->last();
            $recovery = $invoice->recoveryInvoice;
            // $weight = $log->weight;
            $recovery->level = 1;
            $recovery->status = 'partially_approved';
            $recovery->save();

            $approver = ApprovalLevel::where("user_id", auth()->user()->id)->first();
            $insert = ApprovalLog::create([
                "user_id" => auth()->user()->id,
                "recovery_id" => $recovery->id,
                "comments" => 'Edited',
                "weight" => $approver->weight,
                "is_approved" => false,
                "type" => ApprovalLog::$EDITED,
                // "reason_code" => request("reason_code")
            ]);
        }

        return redirect()->back()->with("flash_success", "The invoice " . request('invoice_number') . " has been updated and user notified.");

        // return redirect()
        //     ->to(route("admin.transactions.invoices"))
        //     ->with("flash_success", "Invoice number " . request('invoice_number') . " updated successfully");

    }

    public function invoiceReject($id)
    {
        $invoice = TransactionInvoice::find($id);

        if(!$invoice)
        {
            return redirect()->back()->with("flash_danger", "The invoice is not found.");
        }

        if($invoice->recoveryInvoice)
        {
            return redirect()->back()->with("flash_danger", "The request can't be completed. The invoice already has begun the approval process.");
        }

        $invoice->status = "rejected";
        $invoice->save();

        return redirect()->back()->with("flash_success", "The invoice has been rejected and user notified.");
    }

    public function recoveryInvoiceApprove($recovery_id)
    {
        $recovery_invoice = RecoveryInvoice::find($recovery_id);

        // return request();

        if (!$recovery_invoice) {
            return redirect()
                ->back()
                ->with("flash_danger", "Selected Recovery Invoice not found");
        }

        $approver = ApprovalLevel::where("user_id", auth()->user()->id)->first();
        if (!$approver) {
            return redirect()
                ->back()
                ->with("flash_danger", "You are not set as an approver");
        }


        if ($approver->departments) {
            // departments
        }

        if (request('type') == 'reject') {

            $validated = request()->validate([
                "reason_code" => "required",
                "comments" => "required"
            ]);

            $get_code = ReasonCode::find(request('reason_code'));

            $insert = ApprovalLog::create([
                "user_id" => auth()->user()->id,
                "recovery_id" => $recovery_id,
                "comments" => $get_code->code.': '.request("comments"),
                "weight" => $approver->weight,
                "is_approved" => false,
                "type" => ApprovalLog::$REJECTED,
                "reason_code" => request("reason_code")
            ]);

            if(request("status") == "cancelled")
            {
                $recovery_invoice->update([
                    "status" => RecoveryInvoiceStatus::CANCELLED
                ]);
            }else{
                $recovery_invoice->update([
                    "status" => RecoveryInvoiceStatus::REJECTED
                ]);
            }           

            if(request('reason_code'))
            {
                $recovery_invoice->update([
                    "level" => $get_code->level,
                    "recalled_id" => $insert->id,
                    // "edit_fields" => request("edit_fields")
                ]);
            }
        } else {

            $approved = false;
            if (request("mark_as_approved") == "on") {
                $approved = true;
            }

            if ($approver->weight >= ApprovalLevel::HIGHEST_WEIGHT) {
                $approved = true;
            }

            // ApprovalLog::updateOrCreate(["user_id" => auth()->user()->id, "recovery_id" => $recovery_id], [
            ApprovalLog::create([
                "user_id" => auth()->user()->id,
                "recovery_id" => $recovery_id,
                "comments" => request("comments"),
                "weight" => $approver->weight,
                "is_approved" => $approved,
                "type" => ApprovalLog::$APPROVED
            ]);
            
            $level = $approver->weight;
            if($approver->weight >= ApprovalLevel::HIGHEST_WEIGHT)
            {
                $level = $approver->weight;
            }else{
                $level = $level + 1;
            }

            $recovery_invoice->update([
                "level" => $level,
                "status" => $approved ? RecoveryInvoiceStatus::APPROVED : RecoveryInvoiceStatus::PARTIALLY_APPROVED
            ]);

        }
        return redirect()
                ->to(route('admin.rcns.recovery-invoices'))
                ->with("flash_success", "Recovery invoice : " . $recovery_invoice->invoice_number . " has been ".$recovery_invoice->status." with comments ".request("comments"));
    }

    public function saveTransferInvoice($invoice_id)
    {
        $invoice = TransactionInvoice::find($invoice_id);

        $validated = request()->validate([
            "to_user_id" => "required",
            "comments" => "required"
        ]);

        $user = User::find(request("to_user_id"));

        // prevent self assigning
        if(Auth::user()->id == request("to_user_id"))
        {
            return redirect()
                ->back()
                ->with("flash_danger", "The request failed. You can not transfer the invoice to " . User::find(request("to_user_id"))->name . " (Yourself) ");
        }

        // prevent wrong department transfer
        $permitted = ApprovalLevel::selectRaw("departments")->where("user_id", request("to_user_id"))->first();

        if(!in_array(request("department_code"), $permitted->departments))
        {
            return redirect()
                ->back()
                ->with("flash_danger", "Failed. ". User::find(request("to_user_id"))->name. " can not access department " . request("department_code"). ". Authorized departments: ". implode(",", $permitted->departments));
        }

        
        try{
            DB::beginTransaction();

            $rcns = $invoice->rcns;
            // save the transfer log
            TransferLog::create([
                "invoice_id" => $invoice_id,
                "from_user_id" => Auth::id(),
                "to_user_id" => request("to_user_id"),
                "from_department_code" => $rcns[0]->department_code,
                "to_department_code" => request("department_code"),
                "status" => "pending",
                "comments" => request("comments")
            ]);

            // change dept of all the RCNs attached to the invoice
            foreach($rcns as $rcn)
            {
                $rcn->department_code = request("department_code");
                $rcn->save();
            }

            DB::commit();

            return redirect()
            ->back()
            ->with("flash_success", "The invoice transfer request sent to ". User::find(request("to_user_id"))->name ." for further processing");
        } catch(\Exception $e)
        {

            DB::rollback();

            return redirect()
            ->back()
            ->with("flash_danger", "The request failed. No information available at this moment ".$e->getMessage());
        }
    }

    public function updateRecoveryInvoice($invoice_id)
    {
        // $invoice = TransactionInvoice::find($invoice_id);

        if (request()->method() == 'GET') {
            return view('backend.trx.attach_recovery_invoice', compact('invoice'));
        }

        request()->validate([
            'invoice_number' => 'required',
            'invoice_amount' => 'required',
            'ein_available' => 'required',
            'pod_available' => 'required',
            'comments' => 'string',
            'invoice_date' => 'required',
            'currency' => 'required|numeric',
        ]);

        // check the current approval level
        $recover = RecoveryInvoice::find($invoice_id);

        $recover->update(['invoice_id' => $invoice_id,
            'invoice_number' => request('invoice_number'),
            'invoice_amount' => (float) request('invoice_amount'),
            'comments' => request('comments'),
            'currency_id' => request('currency'),
            'ein_available' => request('ein_available'),
            'pod_available' => request('pod_available'),
            'invoice_date' => 
            Carbon::createFromFormat("m-d-Y", request("invoice_date")),
            'user_id' => auth()->user()->id
        ]);      
        $recover->level = 1;
        $recover->status = 'partially_approved';
        $recover->save();

        if($recover->approvalLogs)
        {
            $approver = ApprovalLevel::where("user_id", auth()->user()->id)->first();

            $insert = ApprovalLog::create([
                "user_id" => auth()->user()->id,
                "recovery_id" => $recover->id,
                "comments" => 'Edited',
                "weight" => $approver->weight,
                "is_approved" => false,
                "type" => ApprovalLog::$EDITED,
                // "reason_code" => request("reason_code")
            ]);
        }


        return redirect()
            ->to(route('admin.transactions.invoices'))
            ->with("flash_success", "Recovery invoice for invoice no.  : " . $recover->invoice_number . " updated successfuly.");
    }

    public function attachRecoveryInvoice($invoice_id)
    {
        $invoice = TransactionInvoice::find($invoice_id);

        // return request();

        if (request()->method() == 'GET') {
            return view('backend.trx.attach_recovery_invoice', compact('invoice'));
        }

        $reject = request('type');

        // return request();

        // if the user sends a reject request.
        if(request('type') == 'reject')
        {
            request()->validate([
                'comments' => 'required'
            ]);

            // if the recovery invoice is already attached, cancel transaction with error
            if($invoice->invoice_id)
            {
                return redirect()->back()->with('flash_danger', 'The invoice can not be rejected at this level. Recovery invoice is already updated.');
            }

            // create a temporary recovery invoice
            $recover = RecoveryInvoice::create([
                'invoice_number' => 0,
                'invoice_amount' => (float) 0,
                'comments' => 0,
                'invoice_id' => $invoice->id,
                'ein_available' => 0,
                'pod_available' => 0,
                'status' => 'rejected',
                'currency_id' => $invoice->currency_id,
                // Carbon::createFromFormat("m-d-Y", date('Y-m-d')),
                'user_id' => auth()->user()->id
            ]);

            // create REJECTION logs for the COM invoice rejection
            $approver = ApprovalLevel::where("user_id", auth()->user()->id)->first();
            $insert = ApprovalLog::create([
                "user_id" => auth()->user()->id,
                "recovery_id" => $recover->id,
                "comments" => request('comments'),
                "weight" => $approver->weight,
                "is_approved" => false,
                "type" => ApprovalLog::$REJECTED,
                // "reason_code" => request("reason_code")
            ]);

            // update the invoice with status rejected
            $invoice->status = 'rejected';
            $invoice->invoice_id = $recover->id;
            $invoice->save();

            // create recovery invoice log
            return redirect()->back()->with('flash_danger', 'The recovery invoice is rejected and sent back for review.');
        }

        request()->validate([
            'invoice_number' => 'required',
            'invoice_amount' => 'required',
            'ein_available' => 'required',
            'pod_available' => 'required',
            'comments' => 'string',
            'invoice_date' => 'required',
            'currency' => 'required|numeric',
        ]);

        // return request();

        // check the current approval level
        $recover = RecoveryInvoice::updateOrCreate(['invoice_id' => $invoice_id], [
            'invoice_number' => request('invoice_number'),
            'invoice_amount' => (float) request('invoice_amount'),
            'comments' => request('comments'),
            'currency_id' => request('currency'),
            'ein_available' => request('ein_available'),
            'pod_available' => request('pod_available'),
            'level' => 1,
            'invoice_date' =>
            Carbon::createFromFormat("m-d-Y", request("invoice_date")),
            'user_id' => auth()->user()->id
        ]);

        $invoice->invoice_id = $recover->id;
        $invoice->save();

        if($recover)
        {
            $this->recoveryInvoiceApprove($recover->id);
        }

        return redirect()
            ->to(route('admin.transactions.invoices'))
            ->with("flash_success", "Recovery invoice for invoice no.  : " . $invoice->invoice_number . " attached and approved.");
    }

    public function invoices()
    {
        $permitted = ApprovalLevel::selectRaw("departments")->where("user_id", Auth::id())->first();
        // return $permitted["departments"];
        if(!$permitted)
        {
            return redirect()
            ->back()
            ->with ("flash_danger", "Restricted. You do not have any departments assigned at the moment.");
        }

        $invoices = TransactionInvoice::with(['rcns' => function($query) use ($permitted){
                        $query->whereIn("transactions.department_code", $permitted['departments']);
                    }])
                    ->whereNull('invoice_id') 
                    ->orWhereIn('status', ['rejected', 'pending'])
                    ->filter(request()->all())->latest()->paginate(20);
      
        return view('backend.trx.invoices', compact('invoices'));
    }

    public function editInvoice($id)
    {
        $invoice = TransactionInvoice::find($id);

        return view('backend.trx.edit_invoice', compact('invoice'));
    }

    public function viewInvoice($id)
    {
        $invoice = TransactionInvoice::find($id);

        return view('backend.trx.view_invoice', compact('invoice'));
    }


    public function editRecoveryInvoice($id)
    {
        $invoice = RecoveryInvoice::find($id);

        return view('backend.trx.edit_recovery_invoice', compact('invoice'));
    }

    public function transferInvoice($id)
    {
        $invoice = TransactionInvoice::find($id);

        return view('backend.trx.transfer_invoice', compact('invoice'));
    }

    public function rejectInvoice($id)
    {
        $invoice = TransactionInvoice::find($id);

        return view('backend.trx.reject_invoice', compact('invoice'));
    }

    public function recoveryInvoices()
    {
        $level = ApprovalLevel::selectRaw("weight, departments")->where("user_id", Auth::id())->first();
        $levels = ApprovalLevel::all();

        if(request('status'))    
        {
            $recovery_invoices = RecoveryInvoice::with(['invoice.rcns' => function($query) use ($level){
                $query->whereIn("transactions.department_code", $level["departments"]);
            }])
            ->filter(request()->all())->latest()->paginate(20); 
        }else{

            $recovery_invoices = RecoveryInvoice::with(['invoice.rcns' => function($query) use ($level){
                $query->whereIn("transactions.department_code", $level["departments"]);            
            }])
            ->whereIn("recovery_invoices.status", ["partially_approved"])
            ->filter(request()->all())->latest()->paginate(20);   
            
        }
        
        
        
        if(request('status') == 'rejected')
        {
            return view('backend.trx.rejected_invoice', compact('recovery_invoices', 'levels'));
        }

        return view('backend.trx.recovery_invoice', compact('recovery_invoices', 'levels'));
    }

    public function viewRecoveryInvoice($recovery_id)
    {
        $levels = ApprovalLevel::all();
        $recovery_invoice = RecoveryInvoice::find($recovery_id);

        return view('backend.trx.view_recovery_invoice', compact('recovery_invoice', 'levels'));
    }


    public function printInvoice($recovery_id)
    {
        $levels = ApprovalLevel::all();
        $recovery_invoice = RecoveryInvoice::find($recovery_id);
        
        $pdf = Pdf::loadView('backend.trx.print_invoice', [
            'recovery_invoice' => $recovery_invoice,
            // 'qrcode' => $qrcode,
            'levels' => $levels
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('recovery_invoice -' . $recovery_invoice->invoice_number . '.pdf');

        return view('backend.trx.print_invoice', compact("recovery_invoice", "levels"));


        return view('backend.trx.view_recovery_invoice', compact('recovery_invoice', 'levels'));
    }

    public function transactionsReport()
    {
        $transactions = TransactionInvoice::whereHas('recoveryInvoice', function($query){
            $query->whereIn('status', ['approved']);
        })->whereHas('rcns', function($query){
            $query->where('purchase_order_no', '!=', null);
        })->filter(request()->all())->latest()->paginate(20);
        // return response()->json($transactions);

        if (request('download') == 1) {      
            $view = view('backend.trx.report_export',
                compact('transactions'));   

                return Excel::download(new ValidExports($view),  ' Valid invoices report ' . date('Y-m-h H:i:s') . '.csv');

        }
        return view('backend.trx.report', compact("transactions"));
    }

    public function invalidInvoicesReport()
    {
        $transactions = TransactionInvoice::with('recoveryInvoice')
                    ->whereHas('rcns', function($query){
                        $query->whereNull('purchase_order_no');
                        // ->orWhere()
                    })
                    ->orWhereDoesntHave('rcns')
                    ->filter(request()->all())->latest()->paginate(20);

        if (request('download') == 1) {      
            $view = view('backend.trx.invalid_report_export',
                compact('transactions'));   

                return Excel::download(new ValidExports($view),  ' Invalid invoices report ' . date('Y-m-h H:i:s') . '.csv');

        }
        return view('backend.trx.invalid_report', compact("transactions"));
    }

    public function exportReports()
    {  
        $transactions = TransactionInvoice::whereHas('recoveryInvoice', function($query){
            $query->whereIn('status', ['approved']);
        })->whereHas('rcns', function($query){
            $query->where('purchase_order_no', '!=', null);
        })->applyScopes(request());
        // ->selectRaw('transaction_invoices.invoice_number');

        // return json_encode($transactions);
        $view = view('backend.trx.report_export', compact('transactions'));

        return Excel::download(new ValidExports($view), 'report.xlsx');
    }
}
