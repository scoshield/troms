@extends('backend.layouts.app')

@section('title', __('Approval Levels'))

@push('after-styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/css/bootstrap-multiselect.min.css"
    integrity="sha512-fZNmykQ6RlCyzGl9he+ScLrlU0LWeaR6MO/Kq9lelfXOw54O63gizFMSD5fVgZvU1YfDIc6mxom5n60qJ1nCrQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .btn-group>button {
        width: 300px;
    }
</style>
@endpush

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('Approval Level Management')
    </x-slot>

    <x-slot name="body">

        <form action="{{ route('admin.approval-levels.store') }}" method="POST">
            @csrf()

            <div class="row">
                <div class="col-8 col-md-4">
                    <div class="input-group">
                        <div class="mb-3 col-sm-6">
                            <div>
                                <div for="rcn_no" class="form-label">User</div>
                            </div>
                            <div>
                                <select id="approval-log-users" name="user_id" required>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-8 col-md-4">
                    <div class="input-group">
                        <div class="mb-3 ml-3">
                            <label for="rcn_no" class="form-label">Departments</label> <br />
                            <select id="approval-log-department" multiple="multiple" style="width: 300px"
                                name="departments[]">
                                @foreach($departments as $department)
                                <option value={{ $department->code}}>{{ $department->code . ' - (' .
                                    $department->name .
                                    ')' }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-8 col-md-4">
                    <div class="input-group">
                        <div class="mb-3 col-sm-6">
                            <label for="rcn_no" class="form-label">Type</label>
                            <select id="approval-log-weight" name="weight" required>
                                @foreach($weights as $key => $desc)
                                <option value="{{ $key }}">{{ $desc }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-8 col-md-5">
                    <div class="input-group">
                        <div class="ml-4 mt-1 mb-3 col-sm-6">
                            <input class="form-check-input" type="checkbox" id="check1" name="can_mark_as_approved">
                            <label for="rcn_no" class="form-label ml-3">Can RCN Mark as approved</label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="ml-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>


        <br />

        <table class="table table-hover table-striped">
            <tr>
                <th>#</th>
                <th>
                    <span>User</span>
                </th>
                <th>
                    <span>Approval Level</span>
                </th>
                <th>
                    <span>Can Mark RCN As Approved</span>
                </th>
                <th>
                    <span>Departments</span>
                </th>
                <th>
                    <span>Actions</span>
                </th>
            </tr>
            @foreach($approval_levels as $approval_level)
            <tr>
                <td>{{ $approval_level->id }}</td>
                <td>{{ $approval_level->user->name }}</td>
                <td>{{ App\Models\ApprovalLevel::APPROVAL_WEIGHTS[$approval_level->weight] }}</td>
                <td>{{ $approval_level->can_mark_as_approved ? "Y" : "N" }}</td>
                <td>{{ json_encode($approval_level->departments) }}</td>
                <td>
                    <a href="{{ route('admin.approval-levels.destroy', $approval_level->id)}}" class="btn btn-danger
                                            btn-xs">delete</a>
                </td>
            </tr>
            @endforeach
        </table>

        {{ $approval_levels->links() }}

    </x-slot>
</x-backend.card>
@endsection

@push('after-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
    integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.2/js/bootstrap-multiselect.min.js"
    integrity="sha512-lxQ4VnKKW7foGFV6L9zlSe+6QppP9B2t+tMMaV4s4iqAv4iHIyXED7O+fke1VeLNaRdoVkVt8Hw/jmZ+XocsXQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#approval-log-department').multiselect();
        $('#approval-log-users').multiselect();
        $('#approval-log-weight').multiselect();
    });
</script>
@endpush