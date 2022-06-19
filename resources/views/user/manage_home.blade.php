@extends('user.layout')



@section('main_section')
@section('page_title','Manage Home')
@section('main_title','Manage Home')
@section('main_title_active', 'Manage Home')
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
            <div class="col-3 col-sm-12 col-md-3">
                <a href="{{ url('home') }}"><button type="button"
                        class="btn btn-block bg-gradient-info btn-flat">Back</button></a>
            </div>



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="plan_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="slug">page name</label>
                                        <input type="text" name="title" value="{{ $title  }}" class="form-control"
                                            placeholder="Enter   title">
                                    </div>
                                    <div class="form-group">
                                        <label for="description"> description</label>
                                        <textarea name="description" id="description" placeholder="Enter  description"
                                            class="form-control">{!!  $description !!} </textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="slug">Order</label>
                                        <input type="number" name="order" value="{{ $order  }}" class="form-control"
                                            placeholder="Enter order">
                                    </div>
                                    <input type="hidden" value="{{ $id }}" name="id">
                                </div>
                            </div>
                        </div>


                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
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

@push('backend_scripts')

<script>
    $("#plan_form").submit(function(e) {
        e.preventDefault();
        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-home/process',
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




    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });





      summerNote('description')




    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
             delete_table_data(id,'/manage-page-image/delete','danger')

        }else{

        }
     }







</script>


@endpush

@endsection
