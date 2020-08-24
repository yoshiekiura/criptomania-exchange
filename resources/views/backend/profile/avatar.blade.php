<div class="box box-primary">
    <div class="box-body box-profile">
        <img src="{{ get_avatar($user->avatar) }}" alt="{{ __('Profile Image') }}" class="img-responsive cm-center">
        <h4 class="cm-mt-10 text-center">{{ $user->userInfo->full_name }}</h4>
    </div>

    <div class="box-footer no-padding">
        <ul class="nav nav-stacked">
            <table>
                @if(has_permission($profileRouteInfo['walletRouteName']))
                <tr>
                    <td>
                        <li><a href="{{ $profileRouteInfo['walletRoute'] }}">{{ __('Wallets') }}</a>
                        </li>
                    </td>
                    <td>
                        <span class="pull-right badge badge-success"
                            style="padding-top: 5px">{{ $profileRouteInfo['totalWallets'] }}</span>
                    </td>
                </tr>
                @endif

                @if(has_permission($profileRouteInfo['openOrderRouteName']))
                <tr>
                    <td>
                        <li>
                            <a href="{{ $profileRouteInfo['openOrderRoute'] }}">{{ __('Open Orders') }} </a>
                        </li>
                    </td>
                    <td>
                        <span class="pull-right badge badge-success"
                            style="padding-top: 5px">{{ $profileRouteInfo['totalOpenOrders'] }}</span>
                    </td>
                </tr>
                @endif

                @if(has_permission($profileRouteInfo['tradeHistoryRouteName']))
                <tr>
                    <td>
                        <li><a href="{{ $profileRouteInfo['tradeHistoryRoute'] }}">{{ __('Trade History') }}</a>
                        </li>
                    </td>
                    <td>
                        <span class="pull-right badge badge-success"
                            style="padding-top: 5px">{{ $profileRouteInfo['totalTrades'] }}</span>
                    </td>
                </tr>
                @endif
            </table>
        </ul>
    </div>
</div>