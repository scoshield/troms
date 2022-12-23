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
        @lang('REPORT')
    </x-slot>

    @if ($logged_in_user->can('admin.access.rcns.report'))
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" href="{{ url('admin/transactions/invalid-report?download=1') }}"
            :text="__('Export')" />
    </x-slot>
    @endif

    <x-slot name="body">
        
    <div class="row">
        <div class="col-md-12">
            
       

        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>Booking Date</span>
                </th>
                <th>
                    <span>Invoice Number</span>
                </th>
                <th>
                    <span>RCN(s)</span>
                </th>
                <th>File Number</th>
                <th>
                    <span>Transporter</span>
                </th>
                <th>
                    <span>Amount</span>
                </th>
                <th>
                    <span>Currency</span>
                </th>           
                <th>Notes.</th>     
                <th>
                    <span>
                        Status
                    </span>
                </th>
            </tr>
            @foreach($transactions as $trx)
            <tr>
                <td>
                    <div class="dropdown show">
                        <span>{{ $trx->id }}</span>
                    </div>
                </td>
                <td>
                    <span style="font-weight: 400">{{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y')}} </span>
                </td>
                <td>
                    <span style="font-weight: 400">{{ $trx->invoice_number }}</span>
                </td>
                <td>
                    @if(count($trx->rcns) < 1)
                        <span class="badge badge-danger">No RCN</span>
                    @else
                        @foreach($trx->rcns as $rcn)
                            <span>{{$rcn->rcn_no}}</span> <br/>
                        @endforeach
                    @endif
                </td>
                <td>{{ $trx->file_number }}</td>
                <td>                    
                    @foreach($trx->rcns as $rcn)
                        <span>{{@$rcn->carrierR->transporter_name}}</span> <br/>
                    @endforeach
                </td>
                <td>
                    <span style="font-weight: 400">{{ number_format($trx->invoice_amount, 2) }}</span>
                </td>
                <td>{{ @$trx->currency->symbol}} </td>
                <td>
                <span class="badge badge-danger">{{ @$trx->comments}}</span>
                </td>                
                <td>
                    <a href="#" class="badge badge-info">{{$trx->status}}</a>    
                    @foreach($trx->rcns as $rcn)
                        @if(!$rcn->purchase_order_no)
                            {{$rcn->rcn_no}}<span class="badge badge-danger">No Purchase Number</span>
                        @endif
                    @endforeach
                </td>
            </tr>
            @endforeach
        </table>

        </div>
    </div>
        <div>
            {{ $transactions->links() }}
        </div>
    </x-slot>
</x-backend.card>
@endsection