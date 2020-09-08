@extends('backend.layouts.main_layout')
@section('content')
    <h3 class="page-header">{{ __('Open Orders') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="open-orders">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Market') }}</th>
                            <th class="min-desktop">{{ __('Type') }}</th>
                            <th class="min-desktop">{{ __('Category') }}</th>
                            <th class="all">{{ __('Price') }}</th>
                            <th class="min-desktop">{{ __('Amount') }}</th>
                            <th class="min-desktop">{{ __('Total') }}</th>
                            <th class="min-desktop">{{ __('User') }}</th>
                            <th class="none">{{ __('Stop/Rate') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
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

      var table = $('#open-orders').DataTable({

          processing: true,

          serverSide: true,

          // bInfo: false,

          language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
          ajax: "{{ route('reports.admin.open-orders.json',$hideUser) }}",

          order : [8, 'desc'],

          columns: [
              {data: 'coin-pair', name: 'coin-pair', className:'text-center'},
              {data: 'exchange_type', name: 'exchange_type'},
              {data: 'category', name: 'category'},
              {data: 'price', name: 'price'},
              {data: 'amount', name: 'amount'},
              {data: 'total', name: 'total'},
              {data: 'email', name: 'email'},
              {data: 'stop-limit', name: 'stop-limit'},
              {data: 'created_at', name: 'created_at'},
          ],
      });

     //  $('.filter-satuan').change(function () {
     //     table.column( $(this).data('column'))
     //     .search( $(this).val() )
     //     .draw();
     // });

    </script>
@endsection