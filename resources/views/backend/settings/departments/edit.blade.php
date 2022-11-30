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
        @lang('Edit Department')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link class="card-header-action" :href="route('admin.settings.departments.index')"
            :text="__('View department')" />
    </x-slot>
    @endif

    <x-slot name="body">

        <form action="{{ route('admin.settings.departments.update', $department->id) }}" method="POST">
            @csrf()

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <label>Department name</label>
                    <div class="input-group">
                        <input value="{{ $department->name }}" class="form-control" type="text" name="name" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <label>Code</label>
                    <div class="input-group">
                        <input value="{{ $department->code }}" class="form-control" type="text" name="code" />
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="com">COM</label>
                    <div class="input-group">
                        <input value="{{ $department->com }}" class="form-control" type="text" name="com" />
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-6 col-md-3">
                    <label for="Branch">Branch</label>
                    <div class="input-group">
                        <input  value="{{ $department->branch }}" class="form-control" type="text" name="branch" />
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </x-slot>
</x-backend.card>
@endsection