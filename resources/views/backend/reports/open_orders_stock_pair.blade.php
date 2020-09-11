@extends('backend.layouts.main_layout')
@section('content')
<hr>
    <h5 class="page-header">{{ __('Stock Pair Open Orders') }}</h5>
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="open-orders">
                                <thead>
                                <tr>
                                    <th class="none">{{ __('Stop/Rate') }}</th>
                                    <th class="all">{{ __('Market') }}</th>
                                    <th class="min-desktop">{{ __('Type') }}</th>
                                    <th class="min-desktop">{{ __('Category') }}</th>
                                    <th class="all">{{ __('Price') }}</th>
                                    <th class="min-desktop">{{ __('Amount') }}</th>
                                    <th class="min-desktop">{{ __('Total') }}</th>
                                    <th class="min-desktop">{{ __('User') }}</th>
                                    <th class="min-desktop">{{ __('Date') }}</th>
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

      var table = $('#open-orders').DataTable({

          processing: true,

          serverSide: true,

          // bInfo: false,

          language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
          ajax: "{{ route('reports.admin.stock-pairs-id.open-orders',$stockPairId) }}",

          order : [8, 'desc'],

          columns: [
              {data: 'stop-limit', name: 'stop-limit'},
              {data: 'coin-pair', name: 'coin-pair', className:'text-center'},
              {data: 'exchange_type', name: 'exchange_type'},
              {data: 'category', name: 'category'},
              {data: 'price', name: 'price'},
              {data: 'amount', name: 'amount'},
              {data: 'total', name: 'total'},
              {data: 'email', name: 'email'},
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