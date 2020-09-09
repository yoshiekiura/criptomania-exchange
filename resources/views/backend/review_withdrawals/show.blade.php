@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    @include('backend.profile.avatar', ['profileRouteInfo' => profileRoutes('admin', $user->id)])
                    @php
                    $bankName = \App\Models\User\BankName::select('bank_name')->where('account_number',
                    $withdrawal->address)->first()->bank_name;
                    @endphp
                </div>
                <div class="col-md-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{!! __('Withdrawal Details of :user for :stockItem', ['user' =>
                                '<strong>' . $user->userInfo->full_name . '</strong>', 'stockItem' => '<strong>' .
                                    $withdrawal->stockItem->item . '</strong>']) !!}</h3>
                            <a href="{{ route('admin.review-withdrawals.index') }}"
                                class="btn btn-primary btn-sm back-button">{{ __('Back') }}</a>
                        </div>
                        <div class="box-body">
                            <div class="form-horizontal show-form-data">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Ref ID') }}</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ $withdrawal->ref_id }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Stock Item') }}</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ $withdrawal->stockItem->item_name }}
                                            ({{ $withdrawal->stockItem->item }})</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Withdrawal Amount') }}</label>
                                    <div class="col-sm-6">
                                        <input type="hidden" class="form-control" value="{{ $withdrawal->amount }}"
                                            name="amount">
                                        <p class="form-control-static"><span
                                                class="strong text-danger">{{ $withdrawal->amount }}
                                                {{ $withdrawal->stockItem->item }}</span></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Address') }}</label>
                                    <div class="col-sm-6">
                                        @if($withdrawal->payment_method == BANK_TRANSFER)
                                        <p class="form-control-static"> <span class="well well-sm">{{$bankName}}
                                                {{ $withdrawal->address }}</span></p>
                                        @else
                                        <p class="form-control-static"> <span
                                                class="well well-sm">{{ $withdrawal->address }}</span></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Current Wallet Balance') }}</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static"><span
                                                class="strong text-green">{{ $withdrawal->wallet->primary_balance }}
                                                {{ $withdrawal->stockItem->item }}</span></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Status') }}</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">
                                            <span
                                                class="label label-{{ config('commonconfig.payment_status.' . $withdrawal->status . '.color_class') }}">{{ payment_status($withdrawal->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">{{ __('Txn ID') }}</label>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">
                                            {{ !empty($withdrawal->txn_id) ? $withdrawal->txn_id : '-'  }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer clearfix">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    @if($withdrawal->status == PAYMENT_REVIEWING)
                                    @if($withdrawal->payment_method == BANK_TRANSFER)

                                    @if( has_permission('admin.review-withdrawals.approveBank') )
                                    <a href="{{ route('admin.review-withdrawals.approveBank', ['id' => $withdrawal->id]) }}"
                                        class="btn btn-sm btn-primary btn-flat btn-sm-block confirmation"
                                        data-form-id="approve-{{ $withdrawal->id }}" data-form-method="PUT"
                                        data-alert="{{__('Do you want to approve this withdrawal?')}}">{{ __('Approve WD Bank') }}</a>
                                    @endif

                                    @else

                                    @if( has_permission('admin.review-withdrawals.approve') )
                                    <a href="{{ route('admin.review-withdrawals.approve', ['id' => $withdrawal->id]) }}"
                                        class="btn btn-sm btn-primary btn-flat btn-sm-block confirmation"
                                        data-form-id="approve-{{ $withdrawal->id }}" data-form-method="PUT"
                                        data-alert="{{__('Do you want to approve this withdrawal?')}}">{{ __('Approve') }}</a>
                                    @endif

                                    @endif


                                    @if($withdrawal->payment_method == BANK_TRANSFER)

                                    @if( has_permission('admin.review-withdrawals.declineBank') )
                                    <a href="{{ route('admin.review-withdrawals.declineBank', ['id' => $withdrawal->id]) }}"
                                        class="btn btn-sm btn-danger btn-flat btn-sm-block confirmation"
                                        data-form-id="decline-{{ $withdrawal->id }}" data-form-method="PUT"
                                        data-alert="{{__('Do you want to decline this withdrawal?')}}">{{ __('Decline WD Bank') }}</a>
                                    @endif

                                    @else

                                    @if( has_permission('admin.review-withdrawals.decline') )
                                    <a href="{{ route('admin.review-withdrawals.decline', ['id' => $withdrawal->id]) }}"
                                        class="btn btn-sm btn-danger btn-flat btn-sm-block confirmation"
                                        data-form-id="decline-{{ $withdrawal->id }}" data-form-method="PUT"
                                        data-alert="{{__('Do you want to decline this withdrawal?')}}">{{ __('Decline') }}</a>
                                    @endif

                                    @endif

                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection