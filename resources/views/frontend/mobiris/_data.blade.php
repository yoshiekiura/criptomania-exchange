    <div class="overlay-dark section-space">
                <div class="container-fluid">
                    <div class="row dc-clear">
                        <div class="col-md-3 col-sm-6 text-center text-white">
                            <div class="pad-t-20">
                                <img src="{{asset('frontend/images/icons/icon-01.png')}}" alt="">
                                <div class="pad-t-20 font-20">Total User</div>
                                <div class="primary-color font-35">{{DB::table('users')->where('user_role_management_id',2)->count()}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center text-white">
                            <div class="pad-t-20">
                                <img src="{{asset('frontend/images/icons/icon-02.png')}}" alt="">
                                <div class="pad-t-20 font-20">Total Coins</div>
                                <div class="primary-color font-35">{{DB::table('stock_items')->where('item_type',2)->count()}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center text-white">
                            <div class="pad-t-20">
                                <img src="{{asset('frontend/images/icons/icon-03.png')}}" alt="">
                                <div class="pad-t-20 font-20">Total Orders</div>
                                <div class="primary-color font-35">{{DB::table('stock_orders')->count()}}</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 text-center text-white">
                            <div class="pad-t-20">
                                <img src="{{asset('frontend/images/icons/icon-04.png')}}" alt="">
                                <div class="pad-t-20 font-20">Total Transactions</div>
                                <div class="primary-color font-35">{{DB::table('transactions')->count()}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
