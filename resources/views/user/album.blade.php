@extends('user.layout')

@section('main_section')
@section('page_title','album')
@section('main_title','album')
@section('main_title_active','album')
@section('linkste-web','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;

@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        {!!regularModules::defaultNotification('info') !!}
        <div class="msg"></div>





        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="col-sm-3 col-xs-12 col-lg-3">
                    <a href="{{ url('/manage-album') }}">
                        <button type="button" class="btn btn-block bg-gradient-success"> create album <i
                                class="fas fa-plus-circle"></i></button>
                    </a>
                </div>
                <div class="card card-success">
                    <div class="card-body">

                        <table class="table table-bordered table-hover" id="menutable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category</th>
                                    <th>name</th>
                                    <th>thumbnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($albums as $albums_data )
                                <tr id="{{ $albums_data->id }}">
                                    <td>{{ $albums_data->id }}</td>
                                    <td>{{ $albums_data->categories }}</td>

                                    <td>{{ $albums_data->name }}</td>
                                    <td>
                                        @if(!empty($albums_data->album_thumbnail))
                                        <img src="{{ url('storage/media/'.$albums_data->album_thumbnail) }}"
                                            style="width: 100px">
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('/manage-album/view/'.$albums_data->id) }}"
                                            title="view album photos"><button class="btn btn-primary btn-sm"><i
                                                    class="fa fa-eye"></i></button></a>

                                        <a href="{{ url('/manage-album/upload/'.$albums_data->id) }}"><button
                                                class="btn btn-success btn-sm"><i class="fa fa-upload"></i></button></a>
                                        <a href="{{ url('/manage-album/edit/'.$albums_data->id) }}"><button
                                                class="btn btn-info btn-sm"><i class="fas fa-pen"></i></button></a>
                                        <button onclick='deleteAlbum("{{ $albums_data->id }}")'
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>




    </div>
    <!-- /.container-fluid -->
</div>



@push('backend_scripts')

<script>
    function deleteAlbum(id){
      var con =  confirm("Are you sure want to delete all album data of images and video files will permanently deleted ?");
      if(con==true){
          $.ajax({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  type:'post',
                  url:'/albums/data/delete',
                  data:'id='+id,
                  success:function(data){

                      if(data.success){
                          $('#'+id).remove();

                       }
                  }

              })



          }

      }


</script>


@endpush



@endsection
