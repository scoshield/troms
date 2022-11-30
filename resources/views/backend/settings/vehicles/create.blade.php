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
        @lang('Create Vehicles')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link class="card-header-action" :href="route('admin.settings.vehicles.index')"
            :text="__('View vehicles')" />
    </x-slot>
    @endif

    <x-slot name="body">

        <form action="{{ route('admin.settings.vehicles.store') }}" method="POST">
            @csrf()

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="mb-3">
                        <label for="rcn_no" class="form-label">Carrier</label>
                        <select class=" js-states form-control" name="carrier_id" id="id_label_single">
                            <option>Select</option>
                            @foreach($carriers as $carrier)
                            <option value="{{ $carrier->id }}" {{ old("carrier")==$carrier->id
                                ? "selected" : ""}}>{{ $carrier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Vehicles number</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="number" />
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Trailer</label>
                    <div class="input-group">
                        <input class="form-control" type="text" name="trailer" />
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </x-slot>
</x-backend.card>
@endsection