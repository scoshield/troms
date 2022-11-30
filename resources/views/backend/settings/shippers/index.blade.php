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
        @lang('Shippers')
    </x-slot>

    @if ($logged_in_user->hasAllAccess())
    <x-slot name="headerActions">
        <x-utils.link icon="c-icon cil-plus" class="card-header-action" :href="route('admin.settings.shippers.create')"
            :text="__('Create shipper')" />
    </x-slot>
    @endif

    <x-slot name="body">
        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>Name</span>
                </th>
                <th>
                    <span>Email</span>
                </th>
                <th>
                    <span>Address</span>
                </th>
                <th>
                    <span>P.O Box</span>
                </th>
                <th>
                    <span>Country</span>
                </th>
                <th>
                    <span>Town</span>
                </th>
                <th>
                    <span>Actions</span>
                </th>
            </tr>
            @foreach($shippers as $shipper)
            <tr>
                <td>{{ $shipper->id }}</td>
                <td>{{ $shipper->name }}</td>
                <td>{{ $shipper->email }}</td>
                <td>{{ $shipper->address }}</td>
                <td>{{ $shipper->po_box }}</td>
                <td>{{ $shipper->country }}</td>
                <td>{{ $shipper->town }}</td>
                <td>
                    <a href="{{ route('admin.settings.shippers.edit', $shipper->id)}}" class="btn btn-info
                        btn-xs">edit</a>
                    <a href="{{ route('admin.settings.shippers.destroy', $shipper->id)}}" class="btn btn-danger
                        btn-xs">delete</a>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $shippers->links() }}
    </x-slot>
</x-backend.card>
@endsection