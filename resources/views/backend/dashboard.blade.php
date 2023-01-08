@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
<style>
    .rowh {        
        color: #fff;
    }
    .rowb{
        background-color: #000;
    }
    .rowg{
        background-color: green;
    }

    body{
        font-family: Roboto, sans-serif;
    }
</style>
    <x-backend.card>
        <x-slot name="header">
            @lang('Welcome :Name', ['name' => $logged_in_user->name])
        </x-slot>
    </x-backend.card>
    <x-backend.card>
        <x-slot name="body">
            <div class="row space-around">
                <div class="col-sm-6">
                    <?php $total_dollars = 0; $total_kes = 0; $final = array(); ?>
                   <table class="table table-sm table-bordered">
                        <thead>
                        <colgroup>
                            <col>
                            <col span="2" style="border: 2px solid #000">
                            <col style="background-color:yellow">
                        </colgroup>
                        <tr class="text-center rowh rowb" style="border-top: 2px solid #000">
                                <th colspan="5">INVOICES</th>
                            </tr>
                            <tr class="text-center rowh rowg">
                                <th></th>
                                <th colspan="2" class="rowb">AMOUNT</th>
                                <th>NUMBER</th>
                                <th>AGE</th>
                            </tr>
                            <tr class="text-center">
                                <th></th>
                                <th style="width: 18%;">USD</th>
                                <th style="width: 18%;">KES</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                                                <!-- merge the arrays of the same status -->
                        <?php $dollar_total = 0; $kes_total = 0; ?>
                        <tbody>
                           <tr>
                                <th>APPROVED</th>
                                <td>{{ number_format(@$usd_approved[0]['amount'], 2) }}</td>
                                <td>{{ number_format(@$ksh_approved[0]['amount'], 2) }}</td>
                                <td>{{ $total_approved = @$usd_approved[0]['total'] + @$ksh_approved[0]['total']}}</td>
                                <td></td>
                           </tr>
                           <tr>
                                <th>PARTIAL</th>
                                <td>{{ number_format(@$usd_partial[0]['amount'], 2) }}</td>
                                <td>{{ number_format(@$ksh_partial[0]['amount'], 2) }}</td>
                                <td>{{ $total_partial = @$usd_partial[0]['total'] + @$ksh_partial[0]['total']}}</td>
                                <td></td>
                           </tr>
                           <tr>
                                <th>REJECTED</th>
                                <td>{{ number_format(@$usd_rejected[0]['amount'], 2) }}</td>
                                <td>{{ number_format(@$ksh_rejected[0]['amount'], 2) }}</td>
                                <td>{{ $total_rejected = @$usd_rejected[0]['total'] + @$ksh_rejected[0]['total']}}</td>
                                <td></td>
                           </tr>
                           
                           
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td>
                                    @php $total_usd_approval = @$usd_approved[0]['amount'] + @$usd_partial[0]['amount'] + @$usd_rejected[0]['amount'] @endphp
                                    {{number_format($total_usd_approval, 2) }}</td>
                                <td>
                                    @php $total_ksh_approval = @$ksh_approved[0]['amount'] + @$ksh_partial[0]['amount'] + @$ksh_rejected[0]['amount'] @endphp
                                    {{  number_format($total_ksh_approval, 2) }}</td>
                                <td>{{ $total_approvals = $total_approved + $total_partial + $total_rejected }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-sm-6">
                    <?php $total_dollars = 0; $total_kes = 0; $final = array(); ?>
                   <table class="table table-sm table-bordered" style="width: 80%">
                        <thead>
                            <tr class="text-center rowb rowh" style="border-top: 2px solid #000">
                                <th colspan="4">RCN STATISTICS.</th>
                            </tr>
                            <colgroup>
                            <col>
                                <col span="2" style="border: 2px solid #000; width: 20%;">
                            </colgroup>
                            <tr>
                                <th></th>
                                <th>USD</th>
                                <th>KES</th>
                                <th>RCN's</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            <tr>
                                <th>BOOKED</th>
                                <td>{{ number_format(@$usd_booked_rcn[0]['amount'], 2)}}</td>
                                <td>{{ number_format(@$ksh_booked_rcn[0]['amount'], 2)}}</td>
                                <td>{{$booked_rcns = @$usd_booked_rcn[0]['booked_rcns'] + @$ksh_booked_rcn[0]['booked_rcns']}}</td>
                            </tr>
                            <tr>
                                <th>NOT BOOKED</th>
                                <td>{{ number_format(@$usd_not_booked_rcn[0]['amount'], 2) }}</td>
                                <td>{{ number_format(@$ksh_not_booked_rcn[0]['amount'], 2) }}</td>
                                <td>{{$not_booked_rcns = @$usd_not_booked_rcn[0]['booked_rcns'] + @$ksh_not_booked_rcn[0]['booked_rcns']}}</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <td>{{ number_format(@$usd_booked_rcn[0]['amount'] + @$usd_not_booked_rcn[0]['amount'], 2)}}</td>
                                <td>{{ number_format(@$ksh_booked_rcn[0]['amount'] + @$ksh_not_booked_rcn[0]['amount'], 2)}}</td>
                                <td>{{ $booked_rcns + $not_booked_rcns }}</td>
                            </tr>   
                            <tr style="background-color: red; border: 2px solid #000" class="rowh">
                                <td colspan="4"><p class="text-sm ma-2">RCN booked pending approval process: <br/> USD:{{number_format(@$usd_booked_rcn[0]['amount'] - @$total_usd_approval, 2)}} | KES: {{number_format(@$ksh_booked_rcn[0]['amount'] - @$total_ksh_approval, 2)}}</p></td>
                            </tr>                         
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-6" >
                   <table class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr class="text-center rowb rowh">
                                <th colspan="2">TOP TRANSPORTERS</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transporters as $txn)
                            <tr>
                                <th>{{$txn->transporter_name}}</th>
                                <td>{{number_format($txn->amount, 2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>
                   </div>
                   <div class="col-sm-6">
                    <?php $total_dollars = 0; $total_kes = 0; $total_invoices = 0; $final = array(); ?>
                   <table class="table table-striped table-sm table-bordered" style="width: 80%">
                        <thead>
                        <tr class="text-center rowb rowh">
                                <th colspan="4">MONTHLY INVOICES.</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th style="width: 40%">NO.</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            @foreach($invoices as $sm)
                            <tr>
                            <?php 
                                $total_dollars = $total_dollars + $sm->dollars_amount; 
                                $total_kes = $total_kes + $sm->kes_amount;
                                $total_invoices = $total_invoices + $sm->records; 
                            ?>
                                <td style="text-transform: uppercase">{{$sm->start_month}}</td>
                                <td>{{$sm->records}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>TOTAL</th>
                                <td>{{$total_invoices}}                              
                                </td>
                            </tr>                            
                        </tfoot>
                    </table>
                    <p><strong>Performance Indicator: {{ round(($total_approvals / $total_invoices) * 100, 2)}}% </strong> of all invoices being processed. <strong>{{ round(($total_approved / $total_invoices) * 100, 2)}}%</strong> fully approved</p>
                </div>
            </div>

            
        </x-slot>
    </x-backend.card>
@endsection
