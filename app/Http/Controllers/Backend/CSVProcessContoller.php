<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\CargoType;
use App\Models\Carrier;
use App\Models\Consignee;
use App\Models\Destination;
use App\Models\Department;
use App\Models\Shipper;
use App\Models\Transaction;
use App\Models\UploadedTransaction;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CSVProcessContoller extends Controller
{
    public function index()
    {
        $transactions = UploadedTransaction::all();
        return view('backend.trx.index', compact("transactions"));
    }

    public function upload()
    {
        return view('backend.process-csv');
    }

    public function processUpload(Request $request)
    {
        ini_set('max_execution_time', 0);

        $file = $request->file('file');

        if ($file) {
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes
            //Check for file extension and size
            $this->checkUploadedFileProperties($extension, $fileSize);

            //Where uploaded file will be stored on the server
            $location = 'uploads'; //Created an "uploads" folder for that

            // Upload file
            $file->move($location, $filename);

            // In case the uploaded file path is to be stored in the database
            $filepath = public_path($location . "/" . $filename);

            // Reading file
            $file = fopen($filepath, "r");
            $importData_arr = array(); // Read through the file and store the contents as an array
            $i = 0;

            $reader = \CsvReader::open($filepath);
            $header = $reader->getHeader();
            //var_dump($header);
            while (($line = $reader->readLine()) !== false) {
                $slugged = [];
                foreach ($line as $key => $value) {
                    $slugged[str_replace("-", "_", Str::slug($key))] = $value;
                }

                try {
                    //var_dump(count($slugged));
                    $this->saveUploadedRcn($slugged);
                    unset($slugged['rcn_status']);
                    unset($slugged['anomaly_on']);
                    unset($slugged['anomaly_code']);
                    unset($slugged['rcn_date']);
                    unset($slugged['rcn_author']);
                    unset($slugged['rcn_validation_date']);
                    unset($slugged['rcn_validation_author']);
                    UploadedTransaction::updateOrCreate(["rcn_no" => $slugged["rcn_no"]], $slugged);
                } catch (\Exception $exception) {
                    Log::info($slugged);
                }
            }
            //Read the contents of the uploaded file
            return redirect()->back()->with("flash_success", "records successfully uploaded");
        } else {
            return redirect()->back()->with("flash_danger", "No file was uploaded");
        }
    }

    private function saveUploadedRcn($slugged)
    {
        $agent = Agent::updateOrCreate(["name" => $slugged['corridor_departure']]);
        $destination = Destination::updateOrCreate(["name" => $slugged["corridor_destination"]]);
        $carrier = Carrier::updateOrCreate(["name" => $slugged["carrier_contact"]], ["transporter_name" => $slugged["transporter_name"]]);
        $shipper = Shipper::updateOrCreate(["name" => $slugged["consignee_shipper"]]);
        $consignee = Consignee::updateOrCreate(["name" => $slugged["consignee_shipper"]]);
        $vehicle = Vehicle::updateOrCreate(["number" => $slugged["vector"], "carrier_id" => $carrier->id], ["trailer" => $slugged["trailer"]]);
        // $department = Department::updateOrCreate(["name"=> "Import", "code"=> $slugged["department_code"], "com"->$slugged["com"], "branch"=>$slugged["branch_code"]]);
        // $cargo_type = CargoType::updateOrCreate(["name" => $slugged[""]]);

        $trx = Transaction::updateOrCreate(['rcn_no' => $slugged["rcn_no"]], [
            "agent_departure" => $agent->id,
            "agent_destination" => $destination->id,
            "carrier" => $carrier->id,
            "shipper" => $shipper->id,
            "consignee" => $consignee->id,
            "vehicle" => $vehicle->id,
            "date" => $slugged["loading_date"] ? Carbon::createFromFormat("d/m/Y", $slugged["loading_date"]) : null,
            "tracking_no" => $slugged["tracking_file_no"], // good
            "marks" => "marks hard coded import",
            "cargo_type" => 1,
            "cargo_desc" => "",
            "quantity" => $slugged["planned_quantity_20"],
            "weight" => $slugged["planned_weight_kgs"],
            "remarks" => "hard coded remarks on import",
            "rcn_no" => $slugged["rcn_no"],
            "purchase_order_no" => $slugged["purchasing_order_no"],
            "customs_no" => $slugged["parcel_seal_no"],
            "notes" => $slugged["po_instructions"],
            "status" => $slugged["rcn_status"],
            "amount" => $slugged["estimated_rate"],
            "department_code" => $slugged["department_code"],
            "department_com" => $slugged["com"],
            "source_type" => Transaction::$SOURCE_TYPE_UPLOADED
        ]);
    }

    public function checkUploadedFileProperties($extension, $fileSize)
    {
        $valid_extension = array("csv", "xlsx"); //Only want csv and excel files
        $maxFileSize = 2000097152; // Uploaded file size limit is 2mb
        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
            } else {
                throw new \Exception('No file was uploaded', Response::HTTP_REQUEST_ENTITY_TOO_LARGE); //413 error
            }
        } else {
            throw new \Exception('Invalid file extension', Response::HTTP_UNSUPPORTED_MEDIA_TYPE); //415 error
        }
    }

    public function sendEmail($email, $name)
    {
        $data = array(
            'email' => $email,
            'name' => $name,
            'subject' => 'Welcome Message',
        );
        Mail::send('welcomeEmail', $data, function ($message) use ($data) {
            $message->from('welcome@myapp.com');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });
    }
}
