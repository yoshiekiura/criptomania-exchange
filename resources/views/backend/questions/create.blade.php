@extends('backend.layouts.main_layout')
@section('title', $title)
@section('content')
<div class="card">
    <div class="card-body">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-primary box-borderless">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12 col-sm-offset-2">
                                    {{ Form::open(['route'=>'trader.questions.store', 'method' => 'post', 'class'=>'form-horizontal validator','files'=> true]) }}
                                    @include('backend.questions._form',['buttonText' => __('Create')])
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('common/vendors/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('common/vendors/cvalidator/cvalidator.js') }}"></script>
<script>
    tinymce.init({
            selector: "#content_textarea",
            menubar: false,
            theme: "modern",
            relative_urls: false,
            force_div_newlines: true,
            force_h1_newlines: true,
            force_h2_newlines: true,
            force_h3_newlines: true,
            force_h4_newlines: true,
            force_h5_newlines: true,
            force_h6_newlines: true,
            force_ul_newlines: true,
            force_ol_newlines: true,
            force_li_newlines: true,
            force_hr_newlines: true,
            forced_br_newlines: true,
            forced_p_newlines: false,
            forced_root_block: false,
            remove_linebreaks: true,
            convert_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
            toolbar2: "print preview | forecolor backcolor | code link image",
            image_advtab: false,
        });


        $(document).ready(function () {
            $('.validator').cValidate();

        });
</script>
@endsection