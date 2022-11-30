<?php

use App\Http\Controllers\Backend\ApprovalLevelController;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CSVProcessContoller;
use App\Http\Controllers\Backend\TransactionsController;
use App\Http\Controllers\Backend\Settings\ConsigneesController;
use App\Http\Controllers\Backend\Settings\AgentsController;
use App\Http\Controllers\Backend\Settings\CargoTypesController;
use App\Http\Controllers\Backend\Settings\CarriersController;
use App\Http\Controllers\Backend\Settings\DepartmentController;
use App\Http\Controllers\Backend\Settings\DestinationsController;
use App\Http\Controllers\Backend\Settings\ShippersController;
use App\Http\Controllers\Backend\Settings\VehiclesController;
use App\Models\Carrier;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    })->middleware('permission:admin.access.dashboard');

Route::group(['middleware' => 'permission:admin.access.dashboard'], function () {
    Route::get('transactions', [CSVProcessContoller::class, 'index'])
        ->name('transactions.index')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Process CSV'), route('admin.transactions.index'));
        })->middleware('permission:admin.access.rcns.list');

    Route::get('transactions/upload', [CSVProcessContoller::class, 'upload'])->name('transactions.upload')->middleware('permission:admin.access.rcns.upload_rcn');
    Route::post('transactions/processUpload', [CSVProcessContoller::class, 'processUpload'])->name('transactions.processUpload')->middleware('permission:admin.access.rcns.upload_rcn');

    Route::get('transactions/create', [TransactionsController::class, 'create'])
        ->name('transactions.create')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Create Transaction Mannually'), route('admin.transactions.create'));
        })->middleware('permission:admin.access.rcns.create');

    Route::post('transactions/store', [TransactionsController::class, 'store'])
        ->name('transactions.store')
        ->middleware('permission:admin.access.rcns.create');

    Route::get('transactions/list', [TransactionsController::class, 'index'])
        ->name('transactions.list')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('List RCNs'), route('admin.transactions.list'));
        })->middleware('permission:admin.access.rcns.list');

    Route::get('transactions/report', [TransactionsController::class, 'transactionsReport'])
        ->name('transactions.report')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Transactions Report'), route('admin.transactions.report'));
        })->middleware('permission:admin.access.rcns.reports');

    Route::get('transactions/invalid-report', [TransactionsController::class, 'invalidInvoicesReport'])
        ->name('transactions.invalid-report')
        ->breadcrumbs(function (Trail $trail) {
            $trail->push(__('Invalid Incoices Report'), route('admin.transactions.invalid-report'));
        })->middleware('permission:admin.access.rcns.report');

    Route::get('transactions/{id}/view', [TransactionsController::class, 'view'])
        ->name('transactions.view');

    Route::get('transactions/{id}/print', [TransactionsController::class, 'print'])
        ->name('transactions.print');

    Route::get('report/export/', [TransactionsController::class, 'exportReports'])
        ->name('transactions.export');
    
    Route::get('recovery_invoice/{id}/print', [TransactionsController::class, 'printInvoice'])
        ->name('recovery_invoice.print');

    Route::get('transactions/attach-invoice', [TransactionsController::class, 'attachInvoice'])
        ->name('transactions.attach-invoice')
        ->middleware('permission:admin.access.rcns.attach_invoice');

    Route::get('transactions/{invoice}/edit-invoice', [TransactionsController::class, 'editInvoice'])
        ->name('transactions.edit_invoice')
        ->middleware('permission:admin.access.rcns.edit_invoice');
    
    Route::get('transactions/{invoice}/view-invoice', [TransactionsController::class, 'viewInvoice'])
        ->name('transactions.view_invoice')
        ->middleware('permission:admin.access.rcns.view_invoice');
    
    Route::get('transactions/{invoice}/discard-invoice', [TransactionsController::class, 'discardInvoice'])
        ->name('transactions.discard_invoice')
        ->middleware('permission:admin.access.rcns.attach_invoice');

    Route::get('transactions/{invoice}/edit-recovery-invoice', [TransactionsController::class, 'editRecoveryInvoice'])
        ->name('transactions.edit_recovery_invoice')
        ->middleware('permission:admin.access.rcns.edit_recovery_invoice');

    Route::post('transactions/{transaction_id}/update-recovery-invoice', [TransactionsController::class, 'updateRecoveryInvoice'])
        ->name('transactions.update_recovery_invoice')
        ->middleware('permission:admin.access.rcns.edit_recovery_invoice');

    Route::get('transactions/{invoice}/transfer-invoice', [TransactionsController::class, 'transferInvoice'])
        ->name('transactions.transfer_invoice')
        ->middleware('permission:admin.access.rcns.transfer_invoice');

    Route::post('transactions/{transaction_id}/post-invoice-transfer', [TransactionsController::class, 'saveTransferInvoice'])
        ->name('transactions.post-invoice-transfer')
        ->middleware('permission:admin.access.rcns.transfer_invoice');
    // reject transporteer invoice
    Route::get('transactions/{transaction_id}/invoice_reject', [TransactionsController::class, 'invoiceReject'])
        ->name('transactions.invoice_reject')
        ->middleware('permission:admin.access.rcns.invoice_reject');
    // reject recovery invoice
    Route::get('transactions/{invoice}/reject-invoice', [TransactionsController::class, 'rejectInvoice'])
        ->name('transactions.reject_invoice')
        ->middleware('permission:admin.access.rejected.invoices');

    Route::post('transactions/{transaction_id}/update-invoice', [TransactionsController::class, 'saveUpdatedInvoice'])
        ->name('transactions.update-invoice')
        ->middleware('permission:admin.access.rcns.edit_invoice');

    Route::post('transactions/{transaction_id}/attach-invoice', [TransactionsController::class, 'saveAttachedInvoice'])
        ->name('transactions.save-invoice')
        ->middleware('permission:admin.access.rcns.attach_invoice');

    Route::get('rcns/invoices', [TransactionsController::class, 'invoices'])
        ->name('transactions.invoices')
        ->middleware('permission:admin.access.rcns.invoices');

    Route::post('recovery-invoices/{recovery_invoice_id}/approve', [TransactionsController::class, 'recoveryInvoiceApprove'])
        ->name('transactions.approve-recovery-invoice')
        ->middleware('permission:admin.access.rcns.approve_rcn');

    Route::match(['GET', 'POST'], 'invoices/{invoice_id}/attach_recovery_invoice', [TransactionsController::class, 'attachRecoveryInvoice'])
        ->name('invoices.attach_recovery_invoice')
        ->middleware('permission:admin.access.rcns.add_recovery_invoice');

    Route::get('rcns/recovery-invoices', [TransactionsController::class, 'recoveryInvoices'])
        ->name('rcns.recovery-invoices')
        ->middleware('permission:admin.access.rcns.recovery_invoices');

    Route::get('rcns/recovery-invoices/{invoice_id}/view', [TransactionsController::class, 'viewRecoveryInvoice'])
        ->name('rcns.recovery-invoices.view')
        ->middleware('permission:admin.access.rcns.recovery_invoices');
});

Route::group(["prefix" => "settings/", "as" => "settings."], function () {
    /** -------------------------- Consignees setup ---------------------------- */
    Route::get("consignee", [ConsigneesController::class, 'index'])->name("consignee.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Consignees'), route('admin.settings.consignee.index'));
    });
    Route::get("consignee/create", [ConsigneesController::class, 'create'])->name("consignee.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Consignees'), route('admin.settings.consignee.create'));
    });
    Route::post("consignee/store", [ConsigneesController::class, 'store'])->name("consignee.store");
    Route::get("consignee/{id}/edit", [ConsigneesController::class, 'edit'])->name("consignee.edit")->breadcrumbs(function (Trail $trail, $id) {
        $trail->push(__('Edit Consignee'), route('admin.settings.consignee.edit', $id));
    });
    Route::post("consignee/{id}/update", [ConsigneesController::class, 'update'])->name("consignee.update");
    Route::get("consignee/{id}/destroy", [ConsigneesController::class, 'destroy'])->name("consignee.destroy");


    /** -------------------------- Agents setup ---------------------------- */
    Route::get("agents", [AgentsController::class, 'index'])->name("agents.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Agents'), route('admin.settings.agents.index'));
    });
    Route::get("agents/create", [AgentsController::class, 'create'])->name("agents.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Agent'), route('admin.settings.agents.create'));
    });
    Route::post("agents/store", [AgentsController::class, 'store'])->name("agents.store");
    Route::get("agents/{id}/edit", [AgentsController::class, 'edit'])->name("agents.edit")->breadcrumbs(function (Trail $trail, $id) {
        $trail->push(__('Edit Agent'), route('admin.settings.agents.edit', $id));
    });
    Route::post("agents/{id}/update", [AgentsController::class, 'update'])->name("agents.update");
    Route::get("agents/{id}/destroy", [AgentsController::class, 'destroy'])->name("agents.destroy");


    /** -------------------------- Cargo Types setup ---------------------------- */
    Route::get("cargo-types", [CargoTypesController::class, 'index'])->name("cargo-types.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Cargo Types'), route('admin.settings.cargo-types.index'));
    });
    Route::get("cargo-types/create", [CargoTypesController::class, 'create'])->name("cargo-types.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Cargo Type'), route('admin.settings.cargo-types.create'));
    });
    Route::post("cargo-types/store", [CargoTypesController::class, 'store'])->name("cargo-types.store");
    Route::get("cargo-types/{id}/edit", [CargoTypesController::class, 'edit'])->name("cargo-types.edit")->breadcrumbs(function (Trail $trail, $id) {
        $trail->push(__('Edit Cargo Type'), route('admin.settings.cargo-types.edit', $id));
    });
    Route::post("cargo-types/{id}/update", [CargoTypesController::class, 'update'])->name("cargo-types.update");
    Route::get("cargo-types/{id}/destroy", [CargoTypesController::class, 'destroy'])->name("cargo-types.destroy");


    /** -------------------------- Carriers setup ---------------------------- */
    Route::get("carriers", [CarriersController::class, 'index'])->name("carriers.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Carriers'), route('admin.settings.carriers.index'));
    });
    Route::get("carriers/create", [CarriersController::class, 'create'])->name("carriers.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Carrier'), route('admin.settings.carriers.create'));
    });
    Route::post("carriers/store", [CarriersController::class, 'store'])->name("carriers.store");
    Route::get("carriers/{id}/edit", [CarriersController::class, 'edit'])->name("carriers.edit")->breadcrumbs(function (Trail $trail, $carrier_id) {
        $trail->push(__('Edit Carrier'), route('admin.settings.carriers.edit', $carrier_id));
    });
    Route::post("carriers/{id}/update", [CarriersController::class, 'update'])->name("carriers.update");
    Route::get("carriers/{id}/destroy", [CarriersController::class, 'destroy'])->name("carriers.destroy");


    /** -------------------------- Destinations setup ---------------------------- */
    Route::get("destinations", [DestinationsController::class, 'index'])->name("destinations.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Destinations'), route('admin.settings.destinations.index'));
    });
    Route::get("destinations/create", [DestinationsController::class, 'create'])->name("destinations.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Destination'), route('admin.settings.destinations.create'));
    });
    Route::post("destinations/store", [DestinationsController::class, 'store'])->name("destinations.store");
    Route::get("destinations/{id}/edit", [DestinationsController::class, 'edit'])->name("destinations.edit")->breadcrumbs(function (Trail $trail, $carrier_id) {
        $trail->push(__('Edit Carrier'), route('admin.settings.destinations.edit', $carrier_id));
    });
    Route::post("destinations/{id}/update", [DestinationsController::class, 'update'])->name("destinations.update");
    Route::get("destinations/{id}/destroy", [DestinationsController::class, 'destroy'])->name("destinations.destroy");


    /** -------------------------- Shippers setup ---------------------------- */
    Route::get("shippers", [ShippersController::class, 'index'])->name("shippers.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Shippers'), route('admin.settings.shippers.index'));
    });
    Route::get("shippers/create", [ShippersController::class, 'create'])->name("shippers.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Shipper'), route('admin.settings.shippers.create'));
    });
    Route::post("shippers/store", [ShippersController::class, 'store'])->name("shippers.store");
    Route::get("shippers/{id}/edit", [ShippersController::class, 'edit'])->name("shippers.edit")->breadcrumbs(function (Trail $trail, $carrier_id) {
        $trail->push(__('Edit Carrier'), route('admin.settings.shippers.edit', $carrier_id));
    });
    Route::post("shippers/{id}/update", [ShippersController::class, 'update'])->name("shippers.update");
    Route::get("shippers/{id}/destroy", [ShippersController::class, 'destroy'])->name("shippers.destroy");


    /** -------------------------- Vehicles setup ---------------------------- */
    Route::get("vehicles", [VehiclesController::class, 'index'])->name("vehicles.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List vehicles'), route('admin.settings.vehicles.index'));
    });
    Route::get("vehicles/create", [VehiclesController::class, 'create'])->name("vehicles.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Shipper'), route('admin.settings.vehicles.create'));
    });
    Route::post("vehicles/store", [VehiclesController::class, 'store'])->name("vehicles.store");
    Route::get("vehicles/{id}/edit", [VehiclesController::class, 'edit'])->name("vehicles.edit")->breadcrumbs(function (Trail $trail, $carrier_id) {
        $trail->push(__('Edit Carrier'), route('admin.settings.vehicles.edit', $carrier_id));
    });
    Route::post("vehicles/{id}/update", [VehiclesController::class, 'update'])->name("vehicles.update");
    Route::get("vehicles/{id}/destroy", [VehiclesController::class, 'destroy'])->name("vehicles.destroy");


    /** -------------------------- Departments setup ---------------------------- */
    Route::get("departments", [DepartmentController::class, 'index'])->name("departments.index")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('List Departments'), route('admin.settings.departments.index'));
    });
    Route::get("departments/create", [DepartmentController::class, 'create'])->name("departments.create")->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Create Department'), route('admin.settings.departments.create'));
    });
    Route::post("departments/store", [DepartmentController::class, 'store'])->name("departments.store");
    Route::get("departments/{id}/edit", [DepartmentController::class, 'edit'])->name("departments.edit")->breadcrumbs(function (Trail $trail, $carrier_id) {
        $trail->push(__('Edit Carrier'), route('admin.settings.departments.edit', $carrier_id));
    });
    Route::post("departments/{id}/update", [DepartmentController::class, 'update'])->name("departments.update");
    Route::get("departments/{id}/destroy", [DepartmentController::class, 'destroy'])->name("departments.destroy");
});

/** -------------------------- Approval Levels setup ---------------------------- */
Route::group(
    [
        'prefix' => 'approval-levels',
        'as' => 'approval-levels.',
    ],
    function () {
        Route::get('/', [ApprovalLevelController::class, 'index'])->name('index');
        Route::post('/store', [ApprovalLevelController::class, 'store'])->name('store');
        Route::get('/{id}/destroy', [ApprovalLevelController::class, 'destroy'])->name('destroy');
    }
);
