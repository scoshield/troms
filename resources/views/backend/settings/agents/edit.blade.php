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
        @lang('Edit agent details')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link class="card-header-action" :href="route('admin.settings.agents.index')"
            :text="__('View agents')" />
    </x-slot>
    @endif

    <x-slot name="body">

        <form action="{{ route('admin.settings.agents.update', $agent->id) }}" method="POST">
            @csrf()

            <div class="row">
                <div class="col-sm-8 col-md-5">
                    <label for="name">Name</label>
                    <div class="input-group">
                        <input value="{{ $agent->name }}" class="form-control" type="text" name="name" />
                    </div>
                </div>


            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Email</label>
                    <div class="input-group">
                        <input value="{{ $agent->email }}" class="form-control" type="text" name="email" />
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Mobile</label>
                    <div class="input-group">
                        <input value="{{ $agent->tel }}" class="form-control" type="text" name="mobile" />
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Address</label>
                    <div class="input-group">
                        <input value="{{ $agent->address }}" class="form-control" type="text" name="address" />
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">P.O Box</label>
                    <div class="input-group">
                        <input value="{{ $agent->po_box }}" class="form-control" type="text" name="po_box" />
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Country</label>
                    <div class="input-group">
                        <input value="{{ $agent->country }}" class="form-control" type="text" name="country" />
                    </div>
                </div>

                <div class="col-sm-6 col-md-3">
                    <label for="cancelled_on">Town</label>
                    <div class="input-group">
                        <input value="{{ $agent->town }}" class="form-control" type="text" name="town" />
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-slot>
</x-backend.card>
@endsection