@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="user-role">
                        <thead>
                        <tr>
                            <th class="all text-center">{{ __('Role Name') }}</th>
                            <th class="min-phone-l text-center">{{ __('Status') }}</th>
                            <th class="min-phone-l text-center">{{ __('Created Date') }}</th>
                            <th class="text-center all no-sort">Action</th>
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
    <!-- <script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script> -->
    <script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
    <!-- <script src="{{asset('common/vendors/datatable_responsive/table-datatables-responsive.js')}}"></script> -->
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

        $('#user-role').DataTable({

            processing: true,

            serverSide: true,

            bInfo: false,

            dom: 'l<"toolbar">frtip',

            language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
            ajax: "{{ route('user-role-managements.json') }}",

            columns: [
                {data: 'role_name', name: 'role_name', className:'text-center'},
                {data: 'is_active', name: 'is_active', className:'text-center'},
                {data: 'created_at', name: 'created_at',className:'text-center'},
                {data: 'action', name: 'action', orderable: false, searchable: false,className:'cm-action'},
            ]
    });
    </script>
@endsection
