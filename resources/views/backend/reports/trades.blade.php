@extends('backend.layouts.main_layout')
@section('content')
    <h3 class="page-header">{{ __('My Trades') }}</h3>
    <div class="row">
        <div class="col-lg-12">
            @include('backend.reports._category_nav', ['routeName' => 'reports.admin.allTrades'])
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;" id="trade-history">
                        <thead>
                        <tr>
                            <th class="all">{{ __('Market') }}</th>
                            <th class="all">{{ __('Type') }}</th>
                            @if(!$categoryType )
                            <th class="min-desktop">{{ __('Category') }}</th>
                            @endif
                            <th class="all">{{ __('Price') }}</th>
                            <th class="min-desktop">{{ __('Amount') }}</th>
                            <th class="min-desktop">{{ admin_settings('referral') ? __('Fee + Referral Earning') : __('Fee') }}</th>
                            <th class="min-desktop">{{ __('Total') }}</th>
                            <th class="all">{{ __('User') }}</th>
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
    <!-- <script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script> -->
    <script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
    <!-- <script src="{{asset('common/vendors/datatable_responsive/table-datatables-responsive.js')}}"></script> -->
    <script>

          $('#trade-history').DataTable({

          processing: true,

          serverSide: true,

          bInfo: false,

          language: {search: "", searchPlaceholder: "{{ __('Search...') }}",info: ""},
          ajax: "{{ route('reports.admin.trades.json',$user,$categoryType) }}",

          columns: [
              {data: 'coin-pair', name: 'coin-pair', className:'text-center'},
              {data: 'exchange_type', name: 'exchange_type'},
              {data: 'category', name: 'category'},
              {data: 'price', name: 'price'},
              {data: 'amount', name: 'amount'},
              {data: 'referral', name: 'referral'},
              {data: 'total', name: 'total'},
              {data: 'email', name: 'email'},
              {data: 'created_at', name: 'stock_exchanges.created_at'},
          ]



      });
    </script>
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
