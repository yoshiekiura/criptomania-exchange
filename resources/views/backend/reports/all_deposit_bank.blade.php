@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
 <h3 class="page-header">{{ __('List of Deposits') }}</h3>
    {!! $list['filters'] !!}
    <div class="row">
        <div class="col-lg-12">
            @include('backend.reports._payment_nav', ['routeName' => 'reports.admin.all-deposits-bank'])
            <div class="nav-tabs-custom">
                <div class="tab-content">
                    <table class="table datatable dt-responsive display nowrap dc-table" style="width:100% !important;">
                        <thead>
                        <tr>
                            <th class="min-desktop">{{ __('Ref ID') }}</th>
                            <th class="all">{{ __('Stock Name') }}</th>
                            <th class="all">{{ __('Amount') }}</th>
                            @if(!$status)
                            <th class="all">{{ __('Status') }}</th>
                            @endif
                            <th class="all">{{ __('User') }}</th>
                            <th class="none">{{ __('Deposit ID') }}</th>
                            <th class="none">{{ __('Bank Name') }}</th>
                            <th class="none">{{ __('Account Number') }}</th>
                            <th class="none">{{ __('Struk Upload') }}</th>
                            <th class="min-desktop">{{ __('Date') }}</th>
                            <th class="min-desktop">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list['query'] as $transaction)
                            <tr>
                                <td>{{ $transaction->ref_id }}</td>
                                <td>{{ $transaction->item_name }} ({{ $transaction->item }})</td>
                                <td>{{ $transaction->amount }} <span class="strong">{{ $transaction->item }}</span></td>
                                @if(!$status)
                                <td>
                                    <span class="label label-{{ config('commonconfig.payment_status.' . $transaction->status . '.color_class') }}">{{ payment_status($transaction->status) }}
                                    </span>
                                </td>
                                @endif
                                <td>
                                    @if(has_permission('users.show'))
                                        <a href="{{ route('users.show', $transaction->users_id) }}">{{ $transaction->email }}</a>
                                    @else
                                        {{ $transaction->email }}
                                    @endif
                                </td>
                                 <td>
                                    {{$transaction->id}}
                                </td>
                                <td>
                                    @if(has_permission('admin.list-bank.show'))
                                        <a href="{{ route('admin.list-bank.show', $transaction->admin_bank_id) }}">{{ $transaction->bank_name }}</a>
                                    @else
                                       {{ $transaction->bank_name}}
                                    @endif

                                   
                                </td>
                                 <td>
                                    
                                    {{ $transaction->account_number }}
                                    
                                      
                                   
                                </td>
                                <td>
                                    @if($transaction->payment_prove != NULL)
                                                                  <a href="#"
                                                                  data-id = "{{$transaction->id}}" data-struck = "{{ get_struck($transaction->payment_prove) }}"
                                                data-toggle="modal" data-target="#modal-insert" class="show-struck">{{ $transaction->payment_prove }}</a>
                                    @else
                                    <span class="strong">The User Doesn't have a Payment Prove'</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->created_at->toFormattedDateString() }}</td>
                               <td class="cm-action">
                                    <div class="btn-group pull-right">
                                        <button class="btn green btn-xs btn-outline dropdown-toggle"
                                                data-toggle="dropdown">
                                            <i class="fa fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu pull-right">
                                            @if(has_permission('admin.users.wallets.editBankBalance'))
                                                <li>
                                                    <a href="{{ route('admin.users.wallets.editBankBalance', [$transaction->users_id, $transaction->wallet_id,$transaction->id]) }}"><i
                                                                class="fa fa-eye"></i> {{ __('Reviews') }}</a>
                                                </li>
                                            @endif

                                          

                                          

                                            
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {!! $list['pagination'] !!}
    <!-- Modal -->
    <div class="modal fade" id="modal-insert">
        <div class="modal-dialog" role="document">
         <div class="form-group">
         <!-- <input type="file" class="form-control" name="struck_foto" id="struck_foto"> -->
        <!--  <img style="max-width: calc(100% - 20px)" src="{{get_struck($transaction->payment_prove)}}" id="struck" alt="{{ __('Struck Upload') }}"> -->
        <img src="{{ get_struck($transaction->payment_prove) }}" alt="{{ __('Profile Image') }}" id="struck" class="img-responsive cm-center">
      
        </div>
    <!--  -->
@endsection

@section('script')
    <!-- for datatable and date picker -->
    <script src="{{ asset('common/vendors/datepicker/datepicker.js') }}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/datatables/plugins/bootstrap/datatables.bootstrap.js')}}"></script>
    <script src="{{asset('common/vendors/datatable_responsive/table-datatables-responsive.js')}}"></script>
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
        $(document).ready(function(){
     // Upload
     $(document).on('click', '.show-struck', function() {
     // this part
     $('#struck').attr('src',$(this).data('struck'));
   });

});
    </script>
@endsection