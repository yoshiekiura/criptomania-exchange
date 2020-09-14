@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <h3 class="page-header">{{ __('My Referral Users') }}</h3>
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <table class="table datatable dt-responsive display nowrap dc-table"
                                style="width:100% !important;" id="referral-users">
                                <thead>
                                    <tr>
                                        <th class="all">{{ __('First Name') }}</th>
                                        <th class="all">{{ __('Last Name') }}</th>
                                        <th class="min-desktop">{{ __('Registration Date') }}</th>
                                        <th class="all text-center">{{ __('Action') }}</th>
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
    $('#referral-users').DataTable({
        processing: true,
        serverSide: true,
        // bInfo: false,
        language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
        ajax: "{{ route('reports.trader.referral.json') }}",
        order : [2, 'desc'],
        columns: [

            {data:'first_name', name:'first_name'},
            {data:'last_name', name:'last_name'},
            {data:'created_at', name:'created_at'},
            {data:'action', name:'action', orderable: false, searchable: false, className:'text-center'},

        ]



    });
</script>
@endsection