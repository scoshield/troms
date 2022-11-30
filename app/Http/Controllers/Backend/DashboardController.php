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

        // return $previous;
        $sum = TransactionInvoice::join('currencies', 'transaction_invoices.currency_id', 'currencies.id')
                                ->join('recovery_invoices', 'transaction_invoices.invoice_id', 'recovery_invoices.id')
                                ->selectRaw("(CASE WHEN currencies.id = 1 THEN sum(transaction_invoices.invoice_amount) ELSE 0 END) dollars_amount, (CASE WHEN currencies.id = 2 THEN sum(transaction_invoices.invoice_amount) ELSE 0 END) kes_amount, recovery_invoices.status status, currencies.name")
                                // ->selectRaw("SUM(transaction_invoices.invoice_amount) amount, recovery_invoices.status, currencies.name")
                                ->groupBy("recovery_invoices.status", "currencies.name", "currencies.id")
                                ->orderBy('currencies.name', 'desc')
                                ->get();
        $booked = Transaction::join('transaction_invoices', "transactions.invoice_id", "transaction_invoices.id")
                                ->join('recovery_invoices', 'transaction_invoices.invoice_id', 'recovery_invoices.id')
                                ->join('currencies', "transaction_invoices.currency_id", "currencies.id")
                                ->selectRaw("SUM(transaction_invoices.invoice_amount) as amount, currencies.name")
                                // ->selectRaw("(CASE WHEN transaction_invoices.currency_id = 1 THEN sum(transaction_invoices.invoice_amount) ELSE 0 END) dollars_amount, (CASE WHEN transaction_invoices.currency_id = 2 THEN sum(transaction_invoices.invoice_amount) ELSE 0 END) kes_amount")
                                ->groupBy("transaction_invoices.currency_id")
                                ->orderBy("currencies.id", "asc")
                                ->get();
        $transporters = Transaction::join("carriers", "transactions.carrier", "carriers.id")->selectRaw("sum(transactions.amount) amount, carriers.transporter_name")
                                ->groupBy("carriers.transporter_name")->orderBy("amount", "desc")->limit(5)->get();

        $invoices = Transaction::join('transaction_invoices', "transactions.invoice_id", "transaction_invoices.id")
                                ->join('recovery_invoices', 'transaction_invoices.invoice_id', 'recovery_invoices.id')
                                ->selectRaw("DATE_FORMAT(transaction_invoices.created_at, '%b') start_month, count(*) as records")
                                ->whereBetween("transaction_invoices.created_at", [$previous, $today])
                                ->groupBy("start_month")
                                ->get();
        // return $sum;
        return view('backend.dashboard', compact('sum', 'transporters', 'booked', 'invoices'));
    }
}
