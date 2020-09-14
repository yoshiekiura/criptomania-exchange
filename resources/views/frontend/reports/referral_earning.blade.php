@extends('backend.layouts.main_layout')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="">


            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <table class="table datatable dt-responsive display nowrap dc-table"
                                style="width:100% !important;" id="referral-earning">
                                <thead>
                                    <tr>
                                        <th class="all">{{ __('Symbol') }}</th>
                                        <th class="all text-center">{{ __('Stock Item') }}</th>
                                        <th class="all text-right">{{ __('Total Earning') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- for datatable and date picker -->
<script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
<script src="{{ asset('common/vendors/datatable_responsive/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('common/vendors/datatable_responsive/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('common/vendors/datatable_responsive/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('common/vendors/datatable_responsive/datatables/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    //Init jquery Date Picker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            orientation: 'bottom',
            todayHighlight: true,
        });
</script>
<script>
    $('#referral-earning').DataTable({
        processing: true,
        serverSide: true,
        language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
        ajax:{
             type: "GET",
             url: "{{route('reports.trader.referral-earning')}}",
             data : {
                ref : "{{$data}}",
             },

        },
        columns: [

            {data:'symbol', name:'symbol'},
            {data:'item', name:'item', className:'text-center'},
            {data:'amount', name:'amount', className:'text-right'},

        ]
    });
</script>
@endsection