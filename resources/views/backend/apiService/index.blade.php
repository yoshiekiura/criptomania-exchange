@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
    {!! $list['filters'] !!}
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width: 100% !important;">
                        <thead>
                        <tr>
                            <th class="all text-center">{{ __('Api Core') }}</th>
                            <th class="text-center">{{ __('Api Name') }}</th>
                            <th class="text-center">{{ __('Created At') }}</th>
                            <!-- <th class="text-center all no-sort">{{ __('Action') }}</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list['query'] as $apiservices)
                            <tr>
                                <td class="text-center">{{ array_key_exists($apiservices->api_value, api_services()) ? api_services($apiservices->api_value) : '' }}</td>
                                <td class="text-center">{{ $apiservices->api_name }}</td>
                                <td class="text-center">{{ $apiservices->created_at->toFormattedDateString() }}</td>

                             </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {!! $list['pagination'] !!}
@endsection

@section('script')
    <!-- for datatable and date picker -->
    <script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
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