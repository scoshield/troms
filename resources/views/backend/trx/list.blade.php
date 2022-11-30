@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@push('after-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('RCNs')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('admin.transactions.upload')"
            :text="__('Upload RCNs')" />
    </x-slot>
    @endif

    <x-slot name="body">

        <div>
            <form action="{{ route('admin.transactions.list')}}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-sm-3">
                        <div class="mb-3">
                            <input class="form-control" type="text" name="search"
                                placeholder="Search by: rcn no, shipper, carrier, tracking no">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <select class=" js-states form-control" name="status">
                            <option value="Select">Filter by status</option>
                            <option value="0">Pending</option>
                            <option value="1">Invoice Attached</option>
                            <option value="3">Invoice Amount Mismatch</option>
                            <option value="4">Partially Approved</option>
                            <option value="5">Approved</option>
                            <option value="6">Cancelled</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class=" js-states form-control" name="type">
                            <option value="Select">Filter by state</option>
                            <option value="not_null" @if(request("type") == "not_null")selected @endif>Consumed</option>
                            <option value="is_null" @if(request("type") == "is_null")selected @endif>Not Consumed</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div>
                            <button type="submit" class="btn btn-primary">filter</button>
                            <button name="clear" type="input" value="true" class="btn btn-primary">clear</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>RCN Number</span><br />
                    <span>Vehicle</span>
                </th>
                <th>
                    <span>Agent Departure</span><br />
                    <span>Agent Destination</span>
                </th>
                <th>
                    <span>Carrier</span><br />
                    <span>Shipper</span>
                </th>
                <th>
                    <span>Consignee</span><br />
                    <span>Tracking no</span>
                </th>
                <th>
                    <span>Invoice</span><br />
                </th>
                <th>
                    <span>Quantity</span><br />
                    <span>Weight</span>
                </th>
                <th>
                    <span>Status</span><br />
                    <span>Source</span>
                </th>
            </tr>
            @foreach($transactions as $trx)
            <tr>
                <td>
                    <div class="dropdown show">
                        <span>{{ $trx->id }}</span>
                        <a class="btn  dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 302 302"
                                style="enable-background:new 0 0 302 302;" xml:space="preserve">
                                <g>
                                    <rect y="36" width="302" height="30" />
                                    <rect y="236" width="302" height="30" />
                                    <rect y="136" width="302" height="30" />
                                </g>
                            </svg>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('admin.transactions.view', $trx->id) }}">View</a>
                        </div>
                    </div>
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->rcn_no }}</span><br />
                    <span style="color: gray">{{ @$trx->vehicleR->number }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ @$trx->agent->name }}</span><br />
                    <span style="color: gray">{{ @$trx->destination->name }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ @$trx->carrierR->name }}</span><br />
                    <span style="color: gray">{{ @$trx->shipperR->name }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->consigneeR->name }}</span><br />
                    <span style="color: gray">{{ @$trx->tracking_no }}</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">@if($trx->invoice_id) <span class="badge badge-success">Consumed</span>@else <span class="badge badge-danger">Not Consumed</span>@endif</span><br />
                </td>
                <td>
                    <span style="font-weight: 500">{{ $trx->quantity }}</span><br />
                    <span style="color: gray">{{ @$trx->weight }}</span><br />
                </td>
                <td>
                    @if($trx->status == App\Models\Transaction::$PENDING)
                    <a href="#" class="badge badge-info">Pending</a>
                    @elseif($trx->status == App\Models\Transaction::$AMOUNT_NOT_EQUAL)
                    <a href="#" class="badge badge-danger">Invoice mismatch</a>
                    @elseif($trx->status == App\Models\Transaction::$INVOICE_MATCHED)
                    <a href="#" class="badge badge-success">Invoice matched</a>
                    @elseif($trx->status == App\Models\Transaction::$INVOICE_ATTACHED)
                    <a href="#" class="badge badge-primary">Invoice attached</a>
                    @elseif($trx->status == App\Models\Transaction::$APPROVED)
                    <a href="#" class="badge badge-primary">Approved</a>
                    @elseif($trx->status == App\Models\Transaction::$PARTIALLY_APPROVED)
                    <a href="#" class="badge badge-primary">Partially Approved</a>
                    @endif

                    <br />
                    @if ($trx->source_type == App\Models\Transaction::$SOURCE_TYPE_UPLOADED || $trx->source_type ==
                    "Uploaded")
                    <a href="#" class="text-danger font-bold">upload</a>
                    @else
                    <a href="#" class="text-success font-bold">manual</a>
                    @endif

                </td>
            </tr>
            @endforeach
        </table>

        <div>
            {{ $transactions->links() }}
        </div>
    </x-slot>
</x-backend.card>
@endsection