@extends('backend.layouts.app')

@section('title', __('Invoices'))

@section('breadcrumb-links')
{{-- @include('backend.auth.user.includes.breadcrumb-links')--}}
@endsection

@section('content')
<x-backend.card>
    <x-slot name="header">
        @lang('View Recovery invoice : #' . $recovery_invoice->invoice_number)
    </x-slot>

    @if ($logged_in_user->can('admin.access.rcns.recovery_invoices'))
    <x-slot name="headerActions">
        <div class="row">
            <div class="col-md-12">
            @if($levels[0]['weight'] == $recovery_invoice->weight )
        <p>Pending Your Approval</p>
        @else
        <p>CURRENT LEVEL: {{$recovery_invoice->level}}</p>
        @endif

        <?php $array = str_split(preg_replace('/[^A-Za-z0-9\-]/', '', @$recovery_invoice->edit_fields));?>
        @if($recovery_invoice->level == @auth()->user()->approvalLevel->weight && $recovery_invoice->status != 'approved')
        <a>
            <button class="btn btn-sm btn-primary" data-toggle="modal"
                data-target="#approveModal{{$recovery_invoice->id}}">@lang("Approve")</button>
        </a>
        @else
        <button class="btn btn-sm btn-primary disabled">
            <span style="text-transform: uppercase;">{{ ucfirst(str_replace("_", " ", $recovery_invoice->status)) }}</span>
        </button>
        @endif
        
        <a href="{{ route('admin.recovery_invoice.print', $recovery_invoice->id)}}">
            <button class="btn btn-sm btn-primary">@lang("Print")</button>
        </a>
            </div>
        </div>
        <!-- Modal -->       
        <div class="modal fade" id="approveModal{{$recovery_invoice->id}}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approve Recovery invoice, Invoice and the
                            attached RCN(s)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 style="text-decoration: underline">Approval Logs</h6>
                            @foreach($recovery_invoice->approvalLogs as $log)
                            <div style="padding: 6px">
                                <div>
                                    <span class="font-weight-bold">{{
                                        App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$log->weight] }}
                                    </span> <br />
                                    <span class="font-weight-bold">{{ @$log->user->name }}</span>
                                    <span>{{ $log->created_at->format('Y-M-d H:i')}}</span>
                                </div>

                                <div>
                                    {{ $log->comments }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <form method="POST"
                            action="{{ route('admin.transactions.approve-recovery-invoice', $recovery_invoice->id)}}">
                            @csrf()
                            <div class="form-group">
                                <label class="col-form-label">Comments:</label>
                                <textarea class="form-control" name="comments"></textarea>
                            </div>

                            @if(@auth()->user()->approvalLevel->can_mark_as_approved)
                            <div class="row">
                                <div class="input-group ml-3">
                                    <div class="ml-4 mt-1 mb-3">
                                        <input class="form-check-input" type="checkbox" id="check1"
                                            name="mark_as_approved">
                                        <label for="rcn_no" class="form-label ml-3">Mark RCN as
                                            approved</label>
                                    </div>
                                </div>
                            </div>
                            @endif


                            <button type="submit" name="type" , value="approve" class="btn btn-primary">Approve</button>
                            <a href="{{route('admin.transactions.reject_invoice', $recovery_invoice->id)}}" class="btn btn-danger">Reject</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
    @endif
    <?php $invoice = $recovery_invoice->invoice ?>
    <x-slot name="body">
        {{-- Recovery Invoice --}}
        @if(count($array) > 0 && $array[0] != null)
        <div class="row">
            <div class="col-md-12 alert alert-danger">
                <p>The invoice has been rejected with the comment: <span style="font-weight: bold; text-decoration: underline;">{{@$recovery_invoice->recalled->comments}}</span></p>
                @if(in_array(1, $array))
                <a href=""><button class="btn btn-sm btn-info" disabled>Edit RCN</button></a>
                @endif 
                @if(in_array(2, $array))
                <a href="{{route('admin.transactions.edit_invoice', $recovery_invoice->invoice_id)}}"><button class="btn btn-sm btn-info">Edit Invoice</button></a>
                @endif 
                @if(in_array(3, $array))
                <a href=""><button class="btn btn-sm btn-info" disabled>Edit Recovery Invoice</button></a>
                @endif 
            </div>
        </div>
        @endif
        <div>
            <!-- <h5 class="font-weight-bold" style="text-decoration: underline">Recovery Invoice</h5> -->
            <div class="row">
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>CUSTOMER</th>
                            <td>{{@$invoice->rcns[0]->consigneeR->name}}</td>
                        </tr>
                        <tr>
                            <th>CONSIGNEE</th>
                            <td>{{@$invoice->rcns[0]->consigneeR->name}}</td>
                        </tr>
                        <tr>
                            <th>TRANSPORTER</th>
                            <td>{{@$invoice->rcns[0]->carrierR->transporter_name}}</td>
                        </tr>
                        <tr>
                            <th>TRACKING FILE NUMBER</th>
                            <td>{{@$invoice->rcns[0]->tracking_no}}</td>
                        </tr>
                        <tr>
                            <th>P.O NUMBER</th>
                            <td>{{@$invoice->rcns[0]->purchase_order_no}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 col-sm-12 col-lg-6">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <th>LOADING COUNTRY</th>
                            <td>{{@$invoice->rcns[0]->agent->name}}</td>
                        </tr>
                        <tr>
                            <th>LOADING PLACE</th>
                            <td>{{@$invoice->rcns[0]->agent->name}}</td>
                        </tr>
                        <tr>
                            <th>UNLOADING PLACE</th>
                            <td>{{@$invoice->rcns[0]->destination->name}}</td>
                        </tr>
                        <tr>
                            <th>DEPARTMENT</th>
                            <td>{{@$invoice->rcns[0]->department_code}}</td>
                        </tr>
                        <tr>
                            <th>BRANCH</th>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
            <h5 class="font-weight-bold mt-4" style="text-decoration: underline">RCN DETAILS</h5>
            <!-- <hr> -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>RCN NO.</th>
                                <th>TRUCK</th>
                                <th>CARRIER CONTACT</th>
                                <th>AMOUNT</th>
                                <th>CURRENCY</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($invoice->rcns as $rcn)
                            <tr>
                                <td>{{$rcn->date ? Carbon\Carbon::parse($rcn->date)->format('m-d-Y') : 'NA'}}</td>
                                <td><a href="{{ route('admin.transactions.view', $rcn->id) }}">
                                    <span class="">{{ $rcn->rcn_no }}</span>
                                </a></td>
                                <td>{{$rcn->vehicleR->number}} - {{$rcn->vehicleR->trailer}}</td>
                                <td>{{$rcn->carrierR->name}}</td>
                                <td>@if($rcn->amount)<span class="font-weight-bold">{{ number_format($rcn->amount , 2)
                                    }}</span>@endif</td>
                                <td>{{@$rcn->currency->name ? $rcn->currency->name : 'NA'}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <h5 class="font-weight-bold mt-4" style="text-decoration: underline">INVOICE DETAILS</h5>
            <div class="row justify-center">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <table class="table table-bordered table-sm">
                        <tr>
                            <th>INV. DATE</th>
                            <td>{{
                            Carbon\Carbon::parse($invoice->invoice_date)->format('F d Y') }}</td>
                            <th>INV. NO</th>
                            <td>{{ $invoice->invoice_number }}</td>
                            <th>INV. AMOUNT</th>
                            <td>{{ number_format($invoice->invoice_amount) }}</td>
                        </tr>
                        <tr>
                            <th>CREDIT NOTE DATE</th>
                            <td> {{ $invoice->credit_note ? Carbon\Carbon::parse($invoice->invoice_date)->format('F d Y') : 'NA'}} </td>
                            <th>CREDIT NOTE. NO</th>
                            <td>{{ $invoice->credit_note ? $invoice->credit_note : 'NA' }}</td>
                            <th>CREDIT NOTE. AMOUNT</th>
                            <td>{{ $invoice->credit_note_amount ? $invoice->credit_note_amount : 'NA' }}</td>
                        </tr>
                        <tr>
                            <th>RECOVERY INVOICE</th>
                            <td>{{
                            Carbon\Carbon::parse($recovery_invoice->invoice_date)->format('F d Y') }}</td>
                            <th>REC. INV. NO</th>
                            <td>{{ $recovery_invoice->invoice_number }}</td>
                            <th>REC. INV. AMOUNT</th>
                            <td>{{ number_format($recovery_invoice->invoice_amount) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5 class="font-weight-bold mt-4" style="text-decoration: underline">APPROVAL LOGS</h5>
            <div class="row justify-center">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th>DATE</th>
                            <th>ROLE</th>
                            <th>NAME</th>
                            <th>TYPE</th>
                            <th>COMMENTS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($recovery_invoice->approvalLogs as $log)
                            <tr @if(@$log->type == 'rejected') style="background-color: #ffd8d8;" @endif>
                                <td>{{ $log->created_at->format('Y-M-d H:i')}}</td>
                                <td>{{
                            App\Models\ApprovalLevel::APPROVAL_WEIGHTS[@$log->weight] }}</td>
                                <td>{{ @$log->user->name }}</td>
                                <td><span style="text-transform: capitalize">{{$log->type}}</span></td>
                                <td>{{ $log->comments }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </x-slot>
</x-backend.card>
@endsection