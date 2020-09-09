<div class="box market-trade-buy">
    <div class="box-body">
        <form method="post" action="{{ route('trader.orders.store') }}" id="buy_order_form"
            class="form-horizontal show-form-data" data-ajax-submission="y" data-reset-on-success="y">
            @csrf
            <input type="hidden" value="{{ base_key() }}" name="base_key">
            <input type="hidden" value="{{ EXCHANGE_BUY }}" name="{{ fake_field('exchange_type') }}">
            <input type="hidden" value="{{ CATEGORY_EXCHANGE }}" name="{{ fake_field('category') }}">
            <input type="hidden" value="{{ $stockPair->id }}" name="{{ fake_field('stock_pair_id') }}"
                class="stock-pair">
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
            <div class="row">
                <div class="col-12 box-tools text-center" style="margin-top: -10px">
                    <a class="btn btn-box-tool" href="depositPageLink">{{ __('Deposit') }}
                        <span class="base_item"></span>
                    </a>
                </div>
            </div>
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
                        <label class="col-4 font-light margin-bottom-none">{{ __('Lowest Ask') }}:</label>
                        <div class="col-8">
                            <div class=" text-right">
                                <span class="clickable lowest_ask"></span>
                                <span class="base_item"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endauth

            <div style="margin-top: -10px">
                {{ __('Fee: :makerFee/:takerFee%',['makerFee' =>admin_settings('exchange_maker_fee'),'takerFee' => admin_settings('exchange_taker_fee')]) }}
            </div>
            @auth
            <button class="btn buy btn-sm btn-block form-submission-button" style="margin-top: -3px">{{ __('Buy') }}
                <span class="stock_item"></span></button>
            @endauth
            @guest
            <div class="border-btn text-center">
                <a href="{{ route('login') }}">{{__('Login')}}</a> {{ __('or') }}
                <a href="{{ route('register.index') }}">{{ __('Register') }}</a>{{ __(' to trade') }}
            </div>
            @endguest
        </form>
    </div>
</div>