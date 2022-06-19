@extends('user.layout')



@section('main_section')
@section('page_title','upload video thumbnail')
@section('main_title','upload video thumbnail')
@section('main_title_active', 'upload video thumbnail')
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
                <a href="{{ url('manage-album/view/'.$album_id) }}"><button type="button"
                        class="btn btn-block bg-gradient-info btn-flat">Back</button></a>
            </div>



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="upload_video_thumbnail" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-9">
                                <div class="card-body">





                                    <div class="form-group">
                                        <label for="video_thumbnail">video thumbnail</label>
                                        <input type="file" name="video_thumbnail" class="form-control">
                                    </div>

                                    @if(!empty($video_thumbnail))
                                    <div class="col-md-4">
                                        <img src="{{ url('storage/media/'.$video_thumbnail) }}" width="100%" >
                                    </div>
                                    @else
                                    <div class="col-md-4">

                                    <img src="{{ asset('front/img/video-player.png') }}" alt="image" / width="100%"  >
                                </div>

                                    @endif

                                    <input type="hidden" name="file_id" value="{{ $file_id }}">








                                </div>
                            </div>











                        </div>


                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Save</button>
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
    $("#upload_video_thumbnail").submit(function(e) {
        e.preventDefault();


        var upload_video_thumbnail = new FormData($(this)[0])
        $.ajax({
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/upload-video/thumbnail/process',
            data: upload_video_thumbnail,
            success: function(data) {

                if(data.errors){

                    $.each(data.errors,function(key,value){
                        toastr.error(value)
                    })



                }else{
                $("#role-error").html(' ')
                toastr.success(data.success)
                if(data.status=='updated'){
                 location.reload();

                }else{
                    location.reload();

                }





                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })






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
