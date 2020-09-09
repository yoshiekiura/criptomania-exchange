<div class="box market-trade-buy">
    <div class="box-body">
        <form method="post" action="{{ route('trader.orders.store') }}" id="stop_limit_form"
            class="form-horizontal show-form-data" data-ajax-submission="y" data-reset-on-success="y">
            @csrf
            <input type="hidden" value="{{ base_key() }}" name="base_key">
            <input type="hidden" value="{{ CATEGORY_EXCHANGE }}" name="{{ fake_field('category') }}">
            <input type="hidden" value="{{ $stockPair->id }}" name="{{ fake_field('stock_pair_id') }}"
                class="stock-pair">
            <div class="input-group">
                <input type="text" class="form-control" id="stop_limit" name="{{ fake_field('stop_limit') }}"
                    placeholder="{{ __('Stop') }}">
                <div class="input-group-append text-uppercase">
                    <span class="base_item input-group-text"></span>
                </div>
            </div>
            <div class="input-group">
                <input type="text" class="form-control price" name="{{ fake_field('price') }}"
                    placeholder="{{ __('Price') }}">
                <div class="input-group-append text-uppercase">
                    <span class="base_item input-group-text"></span>
                </div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control amount" name="{{ fake_field('amount') }}"
                    placeholder="{{ __('Amount') }}">
                <div class="input-group-append text-uppercase">
                    <span class="stock_item input-group-text"></span>
                </div>
            </div>

            <div class="input-group">
                <input type="text" class="form-control total" placeholder="{{ __('Total') }}">
                <div class="input-group-append text-uppercase">
                    <span class="base_item input-group-text"></span>
                </div>
            </div>

            @auth
            <div class="form-horizontal show-form-data">
                <div class="form-group margin-bottom-none">
                    <div class="row">
                        <label class="col-4 font-light margin-bottom-none">{{ __('You have') }}:</label>
                        <div class="col-8">
                            <div class="text-right">
                                <span class="clickable base_item_balance"></span>
                                <span class="base_item"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group margin-bottom-none">
                    <div class="row">
                        <label class="col-4 font-light margin-bottom-none">{{ __('You have') }}:</label>
                        <div class="col-8">
                            <div class=" text-right">
                                <span class="clickable stock_item_balance">0</span>
                                <span class="stock_item"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            @auth
            <div class="row" style="margin-top: -35px">
                <div class="col-6">
                    <button class="btn buy btn-sm btn-block form-submission-button"
                        name="{{ fake_field('exchange_type') }}" value="{{ EXCHANGE_BUY }}">Buy</button>
                </div>
                <div class="col-6">
                    <button class="btn sell btn-sm btn-block form-submission-button"
                        name="{{ fake_field('exchange_type') }}" value="{{ EXCHANGE_SELL }}">Sell</button>
                </div>
            </div>
            @endauth

            @guest
            <div class="border-btn-sl text-center">
                <a href="{{ route('login') }}">{{__('Login')}}</a> {{ __('or') }}
                <a href="{{ route('register.index') }}">{{ __('Register') }}</a>{{ __(' to trade') }}
            </div>
            @endguest
        </form>
    </div>
</div>