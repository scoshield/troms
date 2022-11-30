@extends('backend.layouts.app')

@section('title', __('Upload/Manage RCNs'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@push("after-styles")
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet"
    type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .c-stepper__item {
        position: relative;
        display: flex;
        gap: 1rem;
        padding-bottom: 1rem;
    }

    .c-stepper__item:before {
        content: "";
        flex: 0 0 var(--circle-size);
        height: var(--circle-size);
        border-radius: 50%;
        background-color: lightgrey;
    }

    .c-stepper__item:not(:last-child):after {
        content: "";
        position: absolute;
        left: 0;
        top: calc(var(--circle-size) + var(--spacing));
        bottom: var(--spacing);
        z-index: -1;
        transform: translateX(calc(var(--circle-size) / 2));
        width: 2px;
        background-color: #e0e0e0;
    }

    .c-stepper__title {
        font-weight: bold;
        font-size: clamp(1rem, 4vw, 1.25rem);
        margin-bottom: clamp(0.85rem, 2vmax, 1rem);
    }

    .c-stepper__desc {
        color: grey;
        font-size: clamp(0.85rem, 2vmax, 1rem);
    }
</style>
@endpush

@section('content')

<x-backend.card>
    <x-slot name="header">
        @lang('Create a RCN')
    </x-slot>

    @php $model = App\Domains\Auth\Models\User::first() @endphp

    <x-slot name="body">
        <form action="{{ route('admin.transactions.store') }}" method="POST">
            @csrf()
            <div>
                <ol class="c-stepper">
                    <li class="c-stepper__item">

                        <div class="c-stepper__content">
                            <h3 class="c-stepper__title">Details</h3>

                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">File Number</label> <br />
                                        <input class="form-control" type="number" value="{{ old('file_no') }}"
                                            placeholder="file no." name="file_no">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">Agent departure</label> <br />
                                        <select class=" js-states form-control" name="agent_departure"
                                            id="id_label_single">
                                            <option>Select</option>
                                            @foreach($agents as $agent)
                                            <option value="{{ $agent->id }}" {{ old("agent_departure")==$agent->id
                                                ? "selected" : ""}}>{{ $agent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="purchase_order_no" class="form-label">Agent Destination</label>
                                        <select class=" js-states form-control" name="agent_destination"
                                            id="id_label_single">
                                            <option>Select</option>
                                            @foreach($destinations as $destination)
                                            <option value="{{ $destination->id }}" {{
                                                old("agent_destination")==$destination->id
                                                ? "selected" : ""}}>{{ $destination->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">Carrier</label>
                                        <select class=" js-states form-control" name="carrier" id="id_label_single">
                                            <option>Select</option>
                                            @foreach($carriers as $carrier)
                                            <option value="{{ $carrier->id }}" {{ old("carrier")==$carrier->id
                                                ? "selected" : ""}}>{{ $carrier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <label for="po_type" class="form-label">Shipper</label>
                                    <select class=" js-states form-control" name="shipper" id="id_label_single">
                                        <option>Select</option>
                                        @foreach($shippers as $shipper)
                                        <option value="{{ $shipper->id }}" {{ old("shipper")==$shipper->id
                                            ? "selected" : ""}}>{{ $shipper->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="po_type" class="form-label">Consignee</label>
                                        <select class=" js-states form-control" name="consignee" id="id_label_single">
                                            <option>Select</option>
                                            @foreach($consignees as $consignee)
                                            <option value="{{ $consignee->id }}" {{ old("consignee")==$consignee->id
                                                ? "selected" : ""}}>{{ $consignee->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="po_type" class="form-label">Vehicle</label>
                                        <select class=" js-states form-control" name="vehicle" id="id_label_single">
                                            <option>Select</option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old("vehicle")==$vehicle->id
                                                ? "selected" : ""}}>{{ $vehicle->number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <label for="cancelled_on">Date </label>
                                    <div class="datepicker input-group date" data-date-format="mm-dd-yyyy">
                                        <input class="form-control" type="text" name="date" readonly />
                                        <span class="input-group-addon"><i
                                                class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="c-stepper__item">

                        <div class="c-stepper__content">
                            <h3 class="c-stepper__title">Cargo Details</h3>

                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">Trailer Number</label> <br />
                                        <input class="form-control" type="text" value="{{ old('trailer_no') }}"
                                            placeholder="trailer no." name="trailer_no">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">Tracking No</label>
                                        <input class="form-control" type="number" value="{{ old('tracking_no') }}"
                                            name="tracking_no">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="purchase_order_no" class="form-label">Marks</label>
                                        <input class="form-control" value="{{ old('marks') }}" name="marks">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">Cargo Type</label>
                                        <select class=" js-states form-control" name="cargo_type">
                                            <option>Select</option>
                                            @foreach($cargo_types as $cargo_type)
                                            <option value="{{ $cargo_type->id }}" {{ old("cargo_type")==$cargo_type->id
                                                ? "selected" : ""}}>{{ $cargo_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="cancelled_on" class="form-label">Cargo Description</label>
                                        <input class="form-control" value="{{ old('cargo_desc') }}" name="cargo_desc">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">Container Number</label> <br />
                                        <input class="form-control" type="number" value="{{ old('container_no') }}"
                                            placeholder="container no." name="container_no">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="po_type" class="form-label">Quantity</label>
                                        <input class="form-control" value="{{ old('quantity') }}" type="number"
                                            name="quantity">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="po_type" class="form-label">Weight</label>
                                        <input class="form-control" value="{{ old('weight') }}" type="number"
                                            name="weight">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">Remarks</label>
                                        <textarea class="form-control" value="{{ old('remarks') }}"
                                            name="remarks"> </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="c-stepper__item">

                        <div class="c-stepper__content" style="width: 100%">
                            <h3 class="c-stepper__title">Finish</h3>

                            <div class="row">
                                {{-- <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="com" class="form-label">RCN no</label>
                                        <input class="form-control" value="{{ old('rcn_no') }}" name="rcn_no">
                                    </div>
                                </div> --}}
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="po_type" class="form-label">Agreed rate</label>
                                        <input class="form-control" value="{{ old('agreed_rate') }}" type="number"
                                            name="agreed_rate">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <label for="exampleFormControlInput1" class="form-label">Currency</label>
                                    @include('backend.trx.currencies_partial')
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="purchase_order_no" class="form-label">Customs no</label>
                                        <input class="form-control" type="number" value="{{ old('customs_no') }}"
                                            name="customs_no">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="department_code" class="form-label">Department</label>
                                        <select class=" js-states form-control" name="department_code" id="id_label_single">
                                            <option>Select</option>
                                            @foreach($departments as $dept)
                                            <option value="{{ $dept->code }}" {{ old("dept")==$dept->code
                                                ? "selected" : ""}}>{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-5">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">Notes</label>
                                        <textarea class="form-control" value="{{ old('notes') }}"
                                            name="notes"> </textarea>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">RCN no</label>
                                        <input class="form-control" type="text" value="{{ old('rcn_no') }}"
                                            name="rcn_no">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="department_com" class="form-label">COM</label>
                                        <input class="form-control" type="text" value="{{ old('department_com') }}"
                                            name="department_com">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="mb-3">
                                        <label for="rcn_no" class="form-label">Purchase Order No.</label>
                                        <input class="form-control" type="text" value="{{ old('purchase_order_no') }}"
                                            name="purchase_order_no">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Generate RCN</button>
                                <button name="print" type="input" value="true" class="btn btn-primary">Generate & Print
                                    RCN</button>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
        </form>
    </x-slot>
</x-backend.card>
@endsection

@push("after-scripts")
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.').select2();
    });

    $(function () {
      $(".datepicker").datepicker({ 
            autoclose: true, 
            todayHighlight: true
      }).datepicker('update', new Date());
    });
</script>
<script>

</script>
@endpush