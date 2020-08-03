<div>
    {{ Form::open(['route'=>['trader.upload-id.store'], 'class'=>'validator', 'enctype'=>'multipart/form-data']) }}
        <input type="hidden" name="base_key" value="{{ base_key() }}">
        <transition name="fade" mode="out-in">
            {{--step 1 --}}
            <section key="1" v-if="step == 1">
                <h3 class="text-center margin-bottom">{{ __('Select ID Type') }}</h3>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="box bg-aqua box-borderless text-center box-clickable" @click="nextStep({{ ID_PASSPORT }})">
                            <div class="box-body">
                                <i class="fa fa-address-book-o fa-5x fa-align-center"></i>
                            </div>
                            <p class="custom-box-footer">
                                {{ __('PASPORT') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box bg-green box-borderless text-center box-clickable" @click="nextStep({{ ID_NID }})">
                            <div class="box-body">
                                <i class="fa fa-id-card-o fa-5x fa-align-center"></i>
                            </div>
                            <p class="custom-box-footer">
                                {{ __('NID CARD') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box bg-yellow box-borderless text-center box-clickable" @click="nextStep({{ ID_DRIVER_LICENSE }})">
                            <div class="box-body">
                                <i class="fa fa-truck fa-5x fa-align-center"></i>
                            </div>
                            <p class="custom-box-footer">
                                {{ __("DRIVING LICENSE") }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{--step 2--}}
            <section key="2" v-if="step == 2" class="text-center">
                <input type="hidden" name="{{ fake_field('id_type') }}" v-model="idType">

                <h3 class="text-center margin-bottom">{{ __('Upload ID') }}</h3>
                <div class="row">
                    <div class="col-sm-8 col-md-offset-2">
                        <div class="row">

                            <!-- id upload -->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('id_card_front') ? 'has-error' : '' }}">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <i class="fa fa-address-book-o fa-5x"></i>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">{{ __("Upload") }} <span>{{ __('ID') }}</span></span>
                                                <span class="fileinput-exists">{{ __('Change') }}</span>
                                                {{ Form::file(fake_field('id_card_front'), ['class' => '','id' => fake_field('id_card_front'),'data-cval-name' => 'The ID card','data-cval-rules' => 'files:jpg,png,jpeg|max:2048']) }}
                                            </span>
                                            <a href="javascript:;" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ __('Remove') }}</a>
                                        </div>
                                    </div>
                                    <p class="help-block">{{ __('Upload scan copy of ID card front less than or equal 2MB.') }}</p>

                                    <span class="validation-message cval-error" data-cval-error="{{ fake_field('id_card_front') }}">{{ $errors->first('id_card_front') }}</span>
                                </div>
                            </div>
                            <!-- end here -->


                            <!-- KYC UPLOAD-->
                            <div class="col-sm-6">
                                <div class="form-group {{ $errors->has('kyc_upload') ? 'has-error' : '' }}">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <i class="fa fa-address-book-o fa-5x"></i>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-default btn-file">
                                                <span class="fileinput-new">{{ __("Upload") }} <span>{{ __('KYC') }}</span></span>
                                                <span class="fileinput-exists">{{ __('Change') }}</span>
                                                {{ Form::file(fake_field('kyc_upload'), ['class' => '','id' => fake_field('kyc_upload'),'data-cval-name' => 'The KYC','data-cval-rules' => 'files:jpg,png,jpeg|max:2048']) }}
                                            </span>
                                            <a href="javascript:;" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{ __('Remove') }}</a>
                                        </div>
                                    </div>
                                    <p class="help-block">{{ __('Upload your self and your id less than or equal 2MB. Your KYC must be easily readable') }}<span><a href="javascript:void(0);" data-toggle="modal" data-target="#kycModal" class="kyc">. See Example Here</a></span></p>

                                    <span class="validation-message cval-error" data-cval-error="{{ fake_field('kyc_upload') }}">{{ $errors->first('kyc_upload') }}</span>
                                </div>
                            </div>
                            <!-- end here -->

                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm-block btn-success">{{ __('Submit ID') }}</button>
                <a class="btn btn-sm-block btn-warning" @click.prevent="previousStep">{{ __('Back') }}</a>
            </section>
        </transition>
    {{ Form::close() }}
</div>

    <div class="modal fade" id="kycModal">
        <div class="modal-dialog" role="document">
            <div class="form-group">
                <img src="{{asset('frontend/images/kyc_photo.png')}}" class="img-responsive">  
            </div>  
    </div>
