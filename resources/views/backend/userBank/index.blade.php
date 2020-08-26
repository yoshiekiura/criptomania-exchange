@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="settings-profile">
            {!! $list['filters'] !!}
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <table class="table datatable dt-responsive display nowrap dc-table"
                                style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('Bank Name') }}</th>
                                        <th class="all text-center">{{ __('Account Number') }}</th>
                                        <th class="text-center">{{ __('Created Date') }}</th>
                                        <th class="text-center all no-sort">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list['query'] as $bankName)
                                    <tr>

                                        <td class="text-center">{{ $bankName->bank_name }}</td>
                                        <td class="text-center">{{ $bankName->account_number }}</td>
                                        <td class="text-center">{{ $bankName->created_at->toFormattedDateString() }}
                                        </td>
                                        <td class="cm-action">
                                            <div class="btn-group pull-right">
                                                <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                    data-toggle="dropdown">
                                                    <i class="fa fa-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-stock-pair pull-right">
                                                    @if(has_permission('trader.trader-bank.edit'))
                                                    <li>
                                                        <a href="{{ route('trader.trader-bank.edit', $bankName->id) }}"><i
                                                                class="fa fa-pencil"></i> {{ __('Edit') }}</a>
                                                    </li>
                                                    @endif


                                                    @if(has_permission('trader.trader-bank.destroy'))
                                                    <li>
                                                        <a data-form-id="delete-{{ $bankName->id }}"
                                                            data-form-method="DELETE"
                                                            href="{{ route('trader.trader-bank.destroy', $bankName->id) }}"
                                                            class="confirmation"
                                                            data-alert="{{__('Do you want to delete this Bank Name?')}}"><i
                                                                class="fa fa-trash-o"></i> {{ __('Delete') }}</a>
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