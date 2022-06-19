@extends('user.layout')

@section('main_section')
@section('page_title', 'Test Email')
@section('main_title', 'Test Email')
@section('main_title_active', 'Test Email')
@section('settings', 'active')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;

@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        {!! regularModules::defaultNotification('info') !!}


        <div class="msg"></div>


        <div class="row">



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="app_info_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">



                                    <div class="form-group">
                                        <label for="title">Email</label>
                                        <input type="email" name="emailAddress" value="" class="form-control"
                                            id="email">
                                    </div>


                                    <div class="form-group">
                                        <label for="title">Message</label>
                                        <textarea class="form-control" name="message"></textarea>
                                    </div>











                                </div>
                                <!-- /.card-footer -->







                            </div>
                        </div>
                </div>


                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" id="msg_button" class="btn btn-primary">
                        Send
                    </button>
                </div>

                </form>
            </div>


            <!-- /.card -->
        </div>









    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>



@endsection


@push('backend_scripts')
<script>
    $("#app_info_form").submit(function(e) {
        e.preventDefault();


        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/send-email',
            data: plan_form,
            success: function(data) {

                if (data.errors) {


                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })


                } else {



                    toastr.success(data.success)


                    if (data.ste == 'updated') {
                        setTimeout(function() {}, 3000);
                    } else {

                        setTimeout(function() {

                        }, 1000);


                    }





                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })
</script>
@endpush
