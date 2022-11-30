@extends('backend.layouts.app')

@section('title', __('Upload CSV'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Upload CSV')
        </x-slot>

        @if ($logged_in_user->hasAllAccess())
            <x-slot name="headerActions">
                <x-utils.link
                    icon="c-icon cil-plus"
                    class="card-header-action"
                    :href="route('admin.transactions.index')"
                    :text="__('Back to RCNs')"
                />
            </x-slot>
        @endif

        <x-slot name="body">
            <form action="{{ route('admin.transactions.processUpload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group mt-4">
                    <input type="file" name="file" accept=".csv">
                </div>
                <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Import</button>
            </form>
        </x-slot>
    </x-backend.card>
@endsection
