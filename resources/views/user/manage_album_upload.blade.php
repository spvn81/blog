@extends('user.layout')

@section('main_section')
@section('page_title','Manage Album upload files')
@section('main_title','Manage Album upload files')
@section('main_title_active', 'Manage Album upload files')
@section('linkste-web','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp






  <!-- Main content -->
  <section class="content">
    <div class="col-3 col-sm-12 col-md-3">
        <a href="{{ url('manage-album/view/'.$album_id) }}"><button type="button"
                class="btn btn-block bg-gradient-info btn-flat">Back</button></a>
    </div>

    <div class="container-fluid">

        <div class="col-sm-12">
            <h1>Upload Files  "{{ $album_name }}"</h1>
          </div>


      <div class="card card-success">
        <div class="card-body">
          <small class="text-danger">video/image</small>
          <div class="dropzone dropzone-previews" id="my-awesome-dropzone"></div>

          @if($file_type=='image')

            @if(!empty($file_name))
          <img src="{{ url('storage/media/'.$file_name) }}" width="250">
          <br>

          {{ $image_link }}
          @endif
          @endif

        </div>
      </div>





    </div><!-- /.container-fluid -->
  </section>





@push('backend_scripts')


<script>


    Dropzone.autoDiscover = false
      $(document).ready(function() {
        let album_id = "{{ $album_id }}"
        let file_id = "{{ $file_id }}"
        let url_data;

        if(album_id !='' && file_id != '' ){
         url_data = "/manage-album/upload/files/"+album_id+'/'+file_id
        }else{
      url_data = "/manage-album/upload/first/data/insert/files/"+album_id
        }

      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $("div#my-awesome-dropzone").dropzone({
          url: url_data,
          headers: {
                      'x-csrf-token': CSRF_TOKEN,

                  },
             acceptedFiles: 'video/*,image/*',
           success: function(file, response){

            if(response.errors){
            $(document).Toasts('create', {
              class: 'bg-danger',
              title: 'upload files error',
              body:response.errors.file
            })
          }else{
            if(response.success=='update'){
              location.reload();
            }
          }


          }


        });

      });

  </script>





@endpush

@endsection
