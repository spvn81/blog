@extends('user.layout')



@section('main_section')
@section('page_title','Manage Banner')
@section('main_title','Manage Banner')
@section('main_title_active','Manage Banner')
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
                <a href="{{ url('banner') }}"><button type="button"
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
                                        <label for="name">Description</label>

                                        <textarea name="description" id="description" placeholder="Enter Description"
                                            class="form-control">{!! $description !!} </textarea>

                                    </div>


                                    <div class="form-group">
                                        <label for="slug">Banner image</label>
                                        <input type="file" name="banner" class="form-control">
                                    </div>

                                    @if(!empty($banner))
                                    <div class="row" id="{{ $id }}">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <img src="{{ url('storage/media/'.$banner) }}" width="200">

                                            </div>
                                        </div>




                                    </div>

                                    @endif


                                    <div class="form-group">
                                        <label for="alt_name">alt name</label>
                                        <input type="text" name="alt_name" value="{{ $alt_name }}" class="form-control">
                                    </div>




                                    <div class="form-group">
                                        <label for="link">External link</label>
                                        <input type="text" name="link"  value="{{ $link }}" placeholder="Ex:- https://example.com" class="form-control">
                                    </div>

                                    @php
                                      $target_ck = '';
                                        $target = [
                                            '_blank','_self','_parent','_top'
                                        ];



                                    @endphp

                                    <div class="form-group">
                                        <label for="alt_name">target</label>
                                        <select class="form-control" name="target">
                                            @foreach ($target as  $kay => $target_ddata)
                                            @php

                                                if($target_ddata==$target_store){
                                                    $target_ck = 'selected';
                                                }else{
                                                    $target_ck ='';
                                                }
                                            @endphp
                                            <option   value="{{ $target_ddata }}"  {{ $target_ck }}>{{ $target_ddata }}</option>
                                            @endforeach
                                        </select>
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
            url: '/manage-banner/process',
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


    $(['#description']).summernote({
        toolbar: [
            ['style', ['fontname', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize', 'undo', 'redo']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['search', ['findnreplace', 'changecolor']]
        ],
    })












</script>


@endpush

@endsection
