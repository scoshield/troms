@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Upload/Manage RCNs')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('admin.transactions.upload')"
            :text="__('Upload RCNs')" />
    </x-slot>
    @endif

    <x-slot name="body">
        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>Purchasing Order No</th>
                <th>RCN Number</th>
                <th>PO Type</th>
                <th>TRO Status</th>
                <th>Status Date</th>
                <th>Status Author</th>
                <th>Action</th>
            </tr>
            @foreach($transactions as $trx)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$trx->purchasing_order_no}}</td>
                <td>{{$trx->rcn_no}}</td>
                <td>{{$trx->po_type}}</td>
                <td>{{$trx->tro_status}}</td>
                <td>{{$trx->status_date}}</td>
                <td>{{$trx->status_author}}</td>
                <td>
                    <a href="#" class="btn btn-primary btn-xs">Approve</a>
                </td>
            </tr>
            @endforeach
        </table>
    </x-slot>
</x-backend.card>
@endsection