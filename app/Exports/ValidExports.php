<?php

namespace App\Exports;

use App\Models\TransactionInvoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ValidExports implements FromView
{
    protected $view;
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function view(): View
    // {
    //     return view('backend.trx.report', ['transactions' => TransactionInvoice::all()]);
    // }

     public function __construct($view)
    {
        $this->view = $view;
    }

    public function view(): View
    {
        return $this->view;
    }
}
