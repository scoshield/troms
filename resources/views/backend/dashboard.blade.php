@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
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
                   <table class="table table-striped table-sm table-bordered">
                        <thead>
                        <tr class="text-center">
                                <th colspan="4">INVOICES</th>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <th>USD</th>
                                <th>KES</th>
                            </tr>
                        </thead>
                        <?php array_walk_recursive($sum, function($item, $key) use (&$final){
                                $final[$key] = isset($final[$key]) ?  $item + $final[$key] : $item;
                            }); 
                        ?>
                        <!-- merge the arrays of the same status -->
                        <?php $dollar_total = 0; $kes_total = 0; ?>
                        <tbody>
                            @foreach($sum as $sm)
                            <?php 
                            $dollar_total = $dollar_total + $sm->dollars_amount;
                            $kes_total = $kes_total + $sm->kes_amount;
                            
                            ?>
                            <tr>                            
                                <td style="text-transform: uppercase">{{ucfirst(str_replace("_", " ", $sm->status))}}</td>
                                <!-- <td>{{$sm->name}}</td> -->
                                <td>{{number_format($sm->dollars_amount, 2)}}</td>
                                <td>{{number_format($sm->kes_amount, 2)}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>TOTAL</strong></td>
                                <td>{{ number_format($dollar_total, 2) }}</td>
                                <td>{{ number_format($kes_total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="col-sm-6">
                    <?php $total_dollars = 0; $total_kes = 0; $final = array(); ?>
                   <table class="table table-striped table-sm table-bordered">
                        <thead>
                        <tr class="text-center">
                                <th colspan="2">BOOKED RCN.</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            @foreach($booked as $sm)
                            <tr>
                                <th>{{$sm->name}}</th>
                                <td>{{number_format($sm->amount, 2)}}</td>
                            <!-- </tr>
                            <tr> -->
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{{count($booked)}}">&nbsp;</td>
                            </tr>                            
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="row">
            <div class="col-sm-6" >
                   <table class="table table-striped table-sm table-bordered">
                        <thead>
                            <tr class="text-center">
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
                    <?php $total_dollars = 0; $total_kes = 0; $final = array(); ?>
                   <table class="table table-striped table-sm table-bordered">
                        <thead>
                        <tr class="text-center">
                                <th colspan="4">MONTHLY INVOICES.</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th>NO.</th>
                            </tr>
                        </thead>                       
                        <tbody>
                            @foreach($invoices as $sm)
                            <tr>
                            <?php 
                                $total_dollars = $total_dollars + $sm->dollars_amount; 
                                $total_kes = $total_kes + $sm->kes_amount; 
                            ?>
                                <td style="text-transform: uppercase">{{$sm->start_month}}</td>
                                <td>{{$sm->records}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>&nbsp;</td>
                                <td></td>
                            </tr>                            
                        </tfoot>
                    </table>
                </div>
            </div>

            
        </x-slot>
    </x-backend.card>

    <x-backend.card>
        
    </x-backend.card>
@endsection
