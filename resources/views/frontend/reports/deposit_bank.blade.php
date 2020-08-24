@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <h3 class="page-header">{{ __('Deposits of :itemName', ['itemName' => $wallet->stockItem->item]) }}</h3>
            {!! $list['filters'] !!}

            <div class="row">
                <div class="col-lg-12">
                    @include('backend.reports._payment_nav', ['routeName' => 'reports.trader.deposits-bank', 'walletId'
                    => $wallet->id])
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <table class="table datatable dt-responsive display nowrap dc-table"
                                style="width:100% !important;">
                                <thead>
                                    <tr>
                                        <th class="min-desktop">{{ __('Ref ID') }}</th>
                                        <th class="all">{{ __('Amount') }}</th>
                                        @if(!$status)
                                        <th class="all">{{ __('Status') }}</th>
                                        @endif
                                        <th class="none">{{ __('Bank Name') }}</th>
                                        <th class="none">{{ __('Account Number') }}</th>
                                        <th class="none">{{ __('Struck Upload') }}</th>
                                        <th class="min-desktop">{{ __('Date') }}</th>
                                        <th class="all">{{ __('Action') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list['query'] as $transaction)
                                    <tr>
                                        <td>{{ $transaction->ref_id }}</td>
                                        <td>{{ $transaction->amount }} <span
                                                class="strong">{{ $transaction->item }}</span></td>
                                        @if(!$status)
                                        <td>
                                            <span
                                                class="label label-{{ config('commonconfig.payment_status.' . $transaction->status . '.color_class') }}">{{ payment_status($transaction->status) }}
                                            </span>
                                        </td>
                                        @endif
                                        <td>{{ $transaction->bank_name }}</td>
                                        <td>{{ $transaction->account_number }}</td>
                                        <td>
                                            <!-- if paymeny prove is NULL open form to upload payment prove -->
                                            @if($transaction->payment_prove == NULL)
                                            <!-- and if status payment is Pending, open form -->
                                            @if($transaction->status == PAYMENT_PENDING)

                                            <!-- after if payment prove is null and status payment is Pending, check permission if active then open form-->
                                            @if(has_permission('trader.wallets.deposit.struckUpload'))


                                            {{ Form::open(['route'=>['trader.wallets.deposit.struckUpload', $transaction->id], 'class'=>'validator', 'enctype'=>'multipart/form-data', 'id'=> 'form_struck']) }}

                                            {{ Form::file(fake_field('payment_prove'), ['class' => '','id' => fake_field('payment_prove'),'data-cval-name' => 'The Payment Prove','data-cval-rules' => 'files:jpg,png,jpeg|max:2048']) }}

                                            <input type="submit" value="submit">

                                            {{ Form::close() }}
                                            @endif
                                            <!-- end if permisson -->

                                            <!-- and if status payment is complete or failed then show the label transaction has been completed  -->
                                            @elseif($transaction->status == PAYMENT_COMPLETED || $transaction->status ==
                                            PAYMENT_FAILED)

                                            <span class="label" style="color:black;">This transaction has been completed
                                                and your payment prove is invalid</span>
                                            @endif
                                            <!-- end if check status payment -->

                                            @else
                                            <!-- if all condition is false then show the payment prove document -->
                                            {{$transaction->payment_prove}}
                                            @endif
                                            <!-- end if -->




                                        </td>
                                        <td>{{ $transaction->created_at->toFormattedDateString() }}</td>
                                        <td class="cm-action">
                                            <div class="btn-group pull-right">
                                                <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <i class="fa fa-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu pull-right">
                                                    @if(has_permission('trader.wallets.invoice'))
                                                    <li>
                                                        <a
                                                            href="{{ route('trader.wallets.invoice', [$transaction->id, $transaction->wallet_id,$transaction->id]) }}"><i
                                                                class="fa fa-eye"></i> {{ __('Show') }}</a>
                                                    </li>
                                                    @endif




                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {!! $list['pagination'] !!}
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- for datatable and date picker -->
<script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
<script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script>
<script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}">
</script>
<script src="{{asset('common/vendors/datatable_responsive/table-datatables-responsive.js')}}"></script>
<script type="text/javascript">
    //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
</script>
@endsection