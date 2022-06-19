@extends('user.layout')

@section('main_section')
@section('page_title', 'app settings')
@section('main_title', 'app settings')
@section('main_title_active', 'app settings')
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
                                        <label for="title">driver</label>
                                        <input type="text" name="driver" value="{{ !empty($email_config[0]->driver)?$email_config[0]->driver:'' }}" class="form-control"
                                            id="driver">
                                    </div>


                                    <div class="form-group">
                                        <label for="title">host</label>
                                        <input type="text" name="host" value="{{!empty( $email_config[0]->host)? $email_config[0]->host:'' }}" class="form-control"
                                            id="host">
                                    </div>


                                    <div class="form-group">
                                        <label for="title">port</label>
                                        <input type="text" name="port" value="{{ !empty($email_config[0]->port)?$email_config[0]->port:'' }}" class="form-control"
                                            id="port">
                                    </div>



                                    <div class="form-group">
                                        <label for="title">encryption</label>
                                        <input type="text" name="encryption" value="{{ !empty($email_config[0]->encryption)?$email_config[0]->encryption:'' }}" class="form-control"
                                            id="encryption">
                                    </div>



                                    <div class="form-group">
                                        <label for="title">user_name</label>
                                        <input type="text" name="user_name" value="{{ !empty($email_config[0]->user_name)?$email_config[0]->user_name:'' }}" class="form-control"
                                            id="user_name">
                                    </div>




                                    <div class="form-group">
                                        <label for="title">password</label>
                                        <input type="text" name="password" value="{{ !empty($email_config[0]->password )?$email_config[0]->password:''}}" class="form-control"
                                            id="password">
                                    </div>



                                    <div class="form-group">
                                        <label for="title">sender_name</label>
                                        <input type="text" name="sender_name" value="{{ !empty($email_config[0]->sender_name)?$email_config[0]->sender_name:'' }}" class="form-control"
                                            id="sender_name">
                                    </div>






                                    <div class="form-group">
                                        <label for="title">sender_email</label>
                                        <input type="text" name="sender_email" value="{{ !empty($email_config[0]->sender_email)?$email_config[0]->sender_email:'' }}" class="form-control"
                                            id="sender_email">
                                    </div>







                                    <input type="hidden" name="id" value="{{ !empty( $email_config[0]->id)? $email_config[0]->id:'' }}" >









                                </div>
                                <!-- /.card-footer -->







                            </div>
                        </div>
                </div>


                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" id="msg_button" class="btn btn-primary">
                        Save
                    </button>
                </div>

                </form>
                <a href="{{ url('test-mail') }}">Click to send test mail</a>
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
            url: '/email-configs/process',
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
