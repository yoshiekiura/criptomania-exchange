@extends('backend.layouts.main_layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary box-borderless">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('List of Audit') }}</h3>
                </div>
                <div class="box-body">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="audit-table">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Event') }}</th>
                            <th class="all">{{ __('Model') }}</th>
                            <th class="none">{{ __('User') }}</th>
                            <th class="none">{{ __('Old Data') }}</th>
                            <th class="none">{{ __('New Data') }}</th>
                            <th class="min-desktop">{{ __('Created Date') }}</th>
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
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.5/js/responsive.bootstrap4.min.js"></script>

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

      var table = $('#audit-table').DataTable({

          processing: true,
          serverSide: true,
          bInfo: false,
          language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
          order : [5, 'desc'],

          ajax : "{{route('audits.json')}}",

          columns: [
            {data:'event',name:'event'},
            {data:'auditable_type',name:'auditable_type'},
            {data:'full_name',name:'full_name'},
            {data:'old_values',name:'old_values'},
            {data:'new_values',name:'new_values'},
            {data:'created_at',name:'created_at'},
          ]


      });

    </script>
@endsection
