@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Search for RCN')
    </x-slot>

    <x-slot name="body">
        <div class="container">
            <form action="{{ route('admin.transactions.attach-invoice') }}" method="get" novalidate="novalidate">
                @csrf()

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                                <label for="exampleFormControlInput1" class="form-label">Search by RCN No.</label>
                                <input type="text" name="rcn_no" class="form-control search-slt"
                                    placeholder="Search for rcn">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                        <button type="submit" class="btn btn-primary wrn-btn">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </x-slot>
</x-backend.card>
@endsection