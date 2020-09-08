@extends('backend.layouts.main_layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary box-borderless">
            <div class="box-body">
                <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="notification-table">
                    <thead>
                        <tr>
                            <th style="display:none;">{{ __('ID') }}</th>
                            <th class="all">{{ __('Notice') }}</th>
                            <th class="min-phone-l">{{ __('Date') }}</th>
                            <th class="min-phone-l">{{ __('Status') }}</th>
                            <th class="all no-sort">Action</th>
                        </tr>
                    </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- for datatable and date picker -->
<script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
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
  var table = $('#notification-table').DataTable({
    processing: true,
    serverSide: true,
    language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
    order : [0, 'desc'],
    ajax: "{{route('notices.json')}}",
    columns: [
      {data:'id', name:'id'},
      {data:'data', name:'data'},
      {data:'date', name:'date'},
      {data:'status', name:'status'},
      {data: 'action', name: 'action', orderable: false, searchable: false,className:'cm-action'},
    ]
  });

  table.columns([0]).visible(false);
</script>
@endsection
