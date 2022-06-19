@extends('user.layout')



@section('main_section')
@section('page_title','Manage Footer')
@section('main_title','Manage Footer')
@section('main_title_active', 'Manage Footer')
@section('linkste-web','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp



<!-- Main content -->
<div class="content">
    <div class="container-fluid">


        <div class="row">




            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="foter_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="description"> About</label>
                                        <textarea name="footer_description" id="footer_description" placeholder="Enter  description"
                                            class="form-control">{!! $footer_description !!}</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="description"> copyright message</label>
                                        <textarea name="copyright_message"  placeholder="Enter copyright message"
                                            class="form-control">{!! $copyright_message !!}</textarea>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $id }}">


                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                    <div class="row">

                    <b><a href="{{ url('add-footer-links') }}">Click to add footer links</a></b>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b><a href="{{ url('add-social-links') }}">Click to add social links</a></b>
                    </div>



                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

@push('backend_scripts')

<script>
    $("#foter_form").submit(function(e) {
        e.preventDefault();
        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-footer/process',
            data: plan_form,
            success: function(data) {

                if(data.errors){

                    $.each(data.errors,function(key,value){
                        toastr.error(value)
                    })



                }else{
                $("#role-error").html(' ')

                toastr.success(data.success)
                setTimeout(function(){
                    location.reload();

               }, 2000);


                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })

















</script>


@endpush

@endsection
