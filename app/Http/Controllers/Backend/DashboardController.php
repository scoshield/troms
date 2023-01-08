<?php

namespace App\Http\Controllers\Backend;

use App\Models\RecoveryInvoice;
use App\Models\Transaction;
use App\Models\TransactionInvoice;
use Carbon\Carbon;

/**
 * Class DashboardController.
 */
class DashboardController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    { 
        $today = Carbon::now();
        $previous = Carbon::now()->startOfMonth()->subMonths(5);

        $usd_approved = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 120)->where("r.status", "approved")->get();
        $ksh_approved = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 119)->where("r.status", "approved")->get();

        $usd_partial = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 120)->where("r.status", "partially_approved")->get();
        $ksh_partial = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 119)->where("r.status", "partially_approved")->get();

        $usd_rejected = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 120)->where("r.status", "rejected")->get();
        $ksh_rejected = TransactionInvoice::join("recovery_invoices as r", "transaction_invoices.invoice_id", "r.id")->selectRaw("SUM(transaction_invoices.invoice_amount) amount, COUNT(*) as total")->where("transaction_invoices.currency_id", 119)->where("r.status", "rejected")->get();

        $ksh_booked_rcn = Transaction::join("transaction_invoices as tn", "transactions.invoice_id", "tn.id")->selectRaw("SUM(tn.invoice_amount) as amount, COUNT(*) as booked_rcns")->where("tn.currency_id", 119)->get();
        $usd_booked_rcn = Transaction::join("transaction_invoices as tn", "transactions.invoice_id", "tn.id")->selectRaw("SUM(tn.invoice_amount) as amount, COUNT(*) as booked_rcns")->where("tn.currency_id", 120)->get();

        $ksh_not_booked_rcn = Transaction::selectRaw("SUM(amount) as amount, COUNT(*) as booked_rcns")->where("currency_id", 119)->get();
        $usd_not_booked_rcn = Transaction::selectRaw("SUM(amount) as amount, COUNT(*) as booked_rcns")->where("currency_id", 120)->get();

        $transporters = Transaction::join("carriers", "transactions.carrier", "carriers.id")->selectRaw("sum(transactions.amount) amount, carriers.transporter_name")
                                ->groupBy("carriers.transporter_name")->orderBy("amount", "desc")->limit(5)->get();

        $invoices = Transaction::join('transaction_invoices', "transactions.invoice_id", "transaction_invoices.id")
                                // ->join('recovery_invoices', 'transaction_invoices.invoice_id', 'recovery_invoices.id')
                                ->selectRaw("DATE_FORMAT(transaction_invoices.created_at, '%b') start_month, count(*) as records")
                                ->whereBetween("transaction_invoices.created_at", [$previous, $today])
                                ->groupBy("start_month")
                                ->get();
        // return $sum;
        return view('backend.dashboard', compact('transporters', 'invoices', 'usd_approved', 'ksh_approved', 'usd_partial', 'ksh_partial', 'usd_rejected', 'ksh_rejected', 'ksh_booked_rcn', 'usd_booked_rcn', 'ksh_not_booked_rcn', 'usd_not_booked_rcn'));
    }
}
