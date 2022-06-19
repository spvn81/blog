@extends('user.layout')

@section('main_section')
@section('page_title','Manage Album view')
@section('main_title','Manage Album view')
@section('main_title_active', 'Manage Album view')
@section('linkste-web','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp





  <!-- Main content -->
  <section class="content">
    <div class="col-3 col-sm-12 col-md-3">
        <a href="{{ url('albums') }}"><button type="button"
                class="btn btn-block bg-gradient-info btn-flat">Back</button></a>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
        <h1>Album {{ $images[0]->name }}</h1>
         </div>



      <div class="card card-success">

        <div class="card-body">

          <div class="row">

              @foreach ($images as $images_data )
              <div class="col-sm-2" id="{{ $images_data->id }}">

                  @if($images_data->file_type=='image')
                <a href="{{ url('storage/media/'.$images_data->file_name) }}" data-toggle="lightbox" data-title="sample 1 - white" data-gallery="gallery">
                  <img src="{{ url('storage/media/'.$images_data->file_name) }}" class="img-fluid mb-2" alt="white sample"/ style="height: 200px">
                  @endif

                  @if($images_data->file_type=='video')
                  <video width="100%" style="height: 200px" controls>
                      <source src="{{ url('storage/media/'.$images_data->file_name) }}" >

                    </video>
                  @endif


                </a>
                       <div class="row">

                        <a href="{{ url('manage-album/upload/album-id/'.$images_data->album_id.'/file-id/'.$images_data->id) }}"><i class="fas fa-edit text-primary"></i></a>
                          &nbsp;
                        <a  onclick="deleteFile({{ $images_data->id }})"><i class="fas fa-trash-alt text-danger"></i></a>
                        &nbsp;
                        @if($images_data->file_type=='video')
                        <a href="{{ url('upload-video/thumbnail/'.$images_data->id) }}"  title="upload thumbnail"><i class="fas fa-upload text-info"></i></a>
                        @endif

                      </div>
              </div>
              @endforeach



          </div>

        </div>
      </div>





    </div><!-- /.container-fluid -->
  </section>





@push('backend_scripts')


<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });


      function deleteFile(id){
         let confirm_dleete = confirm("Are sure want to delete ?")
         if(confirm_dleete==true){


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:'post',
                url:'/manage-album/file/delete',
                data:'id='+id,
                success:function(data){
                    if(data.success=='deleted'){
                        $('#'+id).remove();


                    }
                }

            })


         }
      }
</script>





@endpush

@endsection
