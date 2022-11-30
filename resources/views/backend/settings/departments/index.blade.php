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
        @lang('Departments')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action"
            :href="route('admin.settings.departments.create')" :text="__('Create departments')" />
    </x-slot>
    @endif

    <x-slot name="body">
        <table class="table table-hover table-striped">
            <tr>
                <th>
                    <span>Name</span>
                </th>
                <th>
                    <span>Code</span>
                </th>
                <th>
                    <span>Com</span>
                </th>
                <th>
                    <span>Branch</span>
                </th>

                <th>
                    <span>Actions</span>
                </th>
            </tr>
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->code }}</td>
                <td>{{ $department->com }}</td>
                <td>{{ $department->branch }}</td>
                <td>
                    <a href="{{ route('admin.settings.departments.edit', $department->id)}}" class="btn btn-info
                        btn-xs">edit</a>
                    <a href="{{ route('admin.settings.departments.destroy', $department->id)}}" class="btn btn-danger
                        btn-xs">delete</a>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $departments->links() }}
    </x-slot>
</x-backend.card>
@endsection