@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{!! __('Details of :listBank', ['listBank' => '<strong>' .
                                    $listBank->bank_name . '</strong>']) !!}</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-horizontal show-form-data">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ __('Bank Name') }}</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $listBank->bank_name }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ __('Account Number') }}</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $listBank->account_number }}</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{ __('Created Date') }}</label>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $listBank->created_at }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer clearfix">
                            <div class="row">
                                <div class="col-md-6">
                                    @if(has_permission('admin.list-bank.edit'))
                                    <a href="{{ route('admin.list-bank.edit', $listBank->id) }}"
                                        class="btn btn-sm btn-info btn-flat btn-sm-block">{{ __('Edit Bank Name') }}</a>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">
                                    @if(has_permission('admin.list-bank.index'))
                                    <a href="{{ route('admin.list-bank.index') }}"
                                        class="btn btn-primary btn-sm back-button btn-sm-block">{{ __('View all Bank Name') }}</a>

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