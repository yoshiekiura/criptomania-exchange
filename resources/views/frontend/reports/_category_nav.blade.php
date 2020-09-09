<ul class="nav nav-tabs">
    <table cellpadding="10">
        <tr>
            <td>
                <li class="{{ is_current_route($routeName, 'active', ['categoryType' => null]) }}">
                    <a href="{{ route($routeName, ['categoryType' => null]) }}">{{ __('All') }}</a>
                </li>
            </td>
            @foreach(config('commonconfig.category_slug') as $key => $value)
            <td>
                <li class="{{ is_current_route($routeName, 'active', ['categoryType' => $key]) }}">
                    <a href="{{ route($routeName, ['categoryType' => $key]) }}">{{ category_type($value) }}</a>
                </li>
            </td>
            @endforeach
        </tr>
    </table>
</ul>