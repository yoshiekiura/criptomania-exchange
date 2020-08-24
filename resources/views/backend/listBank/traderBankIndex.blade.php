@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            {!! $list['filters'] !!}
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <table class="table datatable dt-responsive display nowrap dc-table"
                                style="width: 100% !important;">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('User ID') }}</th>
                                        <th class="text-center">{{ __('Bank Name') }}</th>
                                        <th class="all text-center">{{ __('Account Number') }}</th>
                                        <th class="text-center">{{ __('Created Date') }}</th>
                                        <!-- <th class="text-center all no-sort">{{ __('Action') }}</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($list['query'] as $bankName)
                                    <tr>
                                        <td class="text-center">{{ $bankName->users_id }}</td>
                                        <td class="text-center">{{ $bankName->bank_name }}</td>
                                        <td class="text-center">{{ $bankName->account_number }}</td>
                                        <td class="text-center">{{ $bankName->created_at->toFormattedDateString() }}
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