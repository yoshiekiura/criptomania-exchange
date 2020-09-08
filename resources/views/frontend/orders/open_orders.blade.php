@extends('backend.layouts.main_layout')
@section('content')
    <h3 class="page-header">{{ __('Open Orders') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="open-orders-trader">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Market') }}</th>
                            <th class="min-desktop">{{ __('Type') }}</th>
                            <th class="min-desktop">{{ __('Category') }}</th>
                            <th class="all">{{ __('Price') }}</th>
                            <th class="min-desktop">{{ __('Amount') }}</th>
                            <th class="min-desktop">{{ __('Total') }}</th>
                            <th class="min-desktop">{{ __('Stop/Rate') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
                            @if(has_permission('trader.orders.destroy'))
                                <th class="all">{{ __('Action') }}</th>
                            @endif
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

        var table = $('#open-orders-trader').DataTable({

          processing: true,

          serverSide: true,

          // bInfo: false,

          language: {search: "", searchPlaceholder: "{{ __('Search...') }}"},
          ajax: "{{ route('trader.orders.open-orders-json') }}",

          order : [7, 'desc'],

          columns: [
              {data: 'coin-pair', name: 'coin-pair', className:'text-center'},
              {data: 'exchange_type', name: 'exchange_type'},
              {data: 'category', name: 'category'},
              {data: 'price', name: 'price'},
              {data: 'amount', name: 'amount'},
              {data: 'total', name: 'total'},
              {data: 'stop-limit', name: 'stop-limit'},
              {data: 'created_at', name: 'created_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ],
      });

    //   $('.filter-satuan').change(function () {
    //      table.column( $(this).data('column'))
    //      .search( $(this).val() )
    //      .draw();
    //  });

    // $('.filter-coin-pair').change(function () {
    //      table.column( $(this).data('column'))
    //      .search( $(this).val() )
    //      .draw();
    //  });

        @if(has_permission('trader.orders.destroy'))
        $(document).on('click', '.cancel-order', function (event) {
            event.preventDefault();
            let token = $('meta[name="csrf-token"]').attr('content');
            let $this = $(this);
            let url = $this.attr('href');
            let column = $this.closest('td');
            column.html('<span class="text-red">{{ __('Cancelling') }}</span>');

            $.ajax({
                type: 'POST',
                url: url,
                data: {_token: token, _method: 'DELETE'},
                success: function (data) {
                    let message = data.success || data.dismiss || data.error;
                    if (data.dismiss || data.error) {
                        flashBox('error', message);
                        column.html($this);
                    } else {
                        flashBox('success', message);
                    }

                }
            });
        });

        let userId = '{{ auth()->id() }}';
        let channelPrefix = '{{ channel_prefix() }}';
        let stockPairId = null;
        @foreach($list->unique('stock_pair_id') as $stockOrder)
        stockPairId = '{{ $stockOrder->stock_pair_id }}';
        Echo.private(channelPrefix + 'orders.' + stockPairId + '.' + userId).listen('Exchange.BroadcastPrivateCancelOrder', (data) => {
            $('.datatable').DataTable().row("#order-" + data.order_number).remove().draw();
        });
        @endforeach

        @endif

    </script>
@endsection