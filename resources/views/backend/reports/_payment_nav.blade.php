@php $parameters = ['paymentTransactionType' => null] @endphp
@if(isset($walletId) && !empty($walletId))
@php $parameters['id'] = $walletId @endphp
@endif
<ul class="nav nav-tabs">
    <table cellpadding="10">
        <tr>
            <td>
                <li class="{{ is_current_route($routeName, 'active', ['paymentTransactionType' => null]) }}">
                    <a href="{{ route($routeName, $parameters) }}">{{ __('All') }}</a>
                </li>
            </td>
            @foreach(config('commonconfig.payment_slug') as $key => $value)
            @php $parameters['paymentTransactionType'] = $key @endphp
            <td>
                <li class="{{ is_current_route($routeName, 'active', ['paymentTransactionType' => $key]) }}">
                    <a href="{{ route($routeName, $parameters) }}">{{ payment_status($value) }}</a>
                </li>
            </td>
            @endforeach
        </tr>
    </table>
</ul>