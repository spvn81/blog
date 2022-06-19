@extends('user.layout')

@section('main_section')
@section('page_title','Manage Album')
@section('main_title','Manage Album')
@section('main_title_active', 'Manage Album')
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



    <div class="card card-success">
      <div class="card-body">

        <form id="save_album_form_data">

            @csrf

            <div class="form-group">
                <label for="menu">select category</label>
                <select name="menu_id" class="form-control">
                    <option value="">--SELECT--</option>
                    @php
                    $menu_sel = '';
                    @endphp
                    @foreach ($category as $category_data )
                    @php

                        if($category_id==$category_data->id){
                            $menu_sel = "selected";
                        }
                    @endphp
                    <option  {{ $menu_sel }} value="{{ $category_data->id }}">{{ $category_data->categories }}</option>
                    @endforeach
                </select>
              </div>


            <div class="form-group">
                <label for="menu">name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $name }}" >
              </div>


              <div class="form-group">
                <label for="menu">slug</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ $slug }}" >
              </div>

              <div class="form-group">
                <label for="menu">Description</label>
                <textarea  class="form-control" id="description" name="description">{{ $description }}</textarea>
              </div>

              <div class="form-group">
                <label for="menu">Album thumbnail</label>
                <input type="text" class="form-control" id="album_thumbnail" name="album_thumbnail" value="{{ $album_thumbnail }}"  placeholder="if available enter image link">
              </div>


              <input type="hidden" name="id"  value="{{ $id }}">






              <div class="card-footer">
                <button type="submit" id="mannage_menu" class="btn btn-primary">Save</button>
              </div>
            </form>
      </div>
    </div>
    </div><!-- /.container-fluid -->
</section>


@push('backend_scripts')



<script>
    $("#save_album_form_data").submit(function(e){
        e.preventDefault();


        var pageloader = `<div class="preloader flex-column justify-content-center align-items-center">
        <div class="overlay-wrapper">
          <div class="overlay">
              <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              <div class="text-bold pt-2">Loading...</div></div>
        </div>
      </div>`;
        $(".pagloader").html(pageloader)

    var save_album_form_data = new FormData($(this)[0])
    $.ajax({
            type: "post",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/manage-album/save',
            data: save_album_form_data,
        success: function (data){
            $(".pagloader").html(' ')


            if(data.errors){

                var errors = data.errors;
                $.each(errors,function(kay,val){

            $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'manage album',
            body:val

          })



                })

            }else{

            $(document).Toasts('create', {
            class: 'bg-success',
            title: 'manage album',
            body:data.sucess
          })
          window.location.href = '/albums'


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
