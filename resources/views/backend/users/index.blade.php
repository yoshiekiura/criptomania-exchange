@extends('backend.layouts.main_layout')
@section('content')
<h3 class="page-header">{{ __('User List') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="user-info">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Email') }}</th>
                            <th  class="min-phone-l">{{ __('First Name') }}</th>
                            <th  class="min-phone-l">{{ __('Last Name') }}</th>
                            <th class="min-phone-l">{{ __('User Group') }}</th>
                            <th class="min-phone-l">{{ __('Username') }}</th>
                            <th class="none">{{ __('Registered Date') }}</th>
                            <th class="text-center min-phone-l">{{ __('Status') }}</th>
                            <th class="text-center all no-sort">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                    </table>
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

    $('#user-info').DataTable({

    processing: true,

    serverSide: true,

    bInfo: false,


    language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
    ajax: "{{ route('users.json') }}",

    columns: [
        {data: 'email', name: 'email'},
        {data: 'first_name', name: 'user_infos.first_name'},
        {data: 'last_name', name: 'user_infos.last_name'},
        {data: 'role_name', name: 'user_role_managements.role_name'},
        {data: 'username', name: 'username'},
        {data: 'created_at', name: 'users.created_at'},
        {data: 'is_active', name: 'is_active',className:'text-center'},
        {data: 'action', name: 'action', orderable: false, searchable: false,className:'text-center cm-action'},
    ]
});


    </script>
@endsection

