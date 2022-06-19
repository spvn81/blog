@extends('user.layout')



@section('main_section')
@section('page_title','Manage page')
@section('main_title','Manage page')
@section('main_title_active', 'Manage page')
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
                <a href="{{ url('page') }}"><button type="button"
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
                            <div class="col-9">
                                <div class="card-body">




                                    <div class="form-group">
                                        <label for="slug">page name</label>
                                        <input type="text" name="page_name" value="{{ $page_name  }}"
                                            class="form-control" placeholder="Enter page  Name">
                                    </div>


                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" value="{{ $slug  }}" class="form-control"
                                            placeholder="Enter Slug  Name">
                                    </div>


                                    <div class="form-group">
                                        <label for="name">page title</label>

                                        <textarea name="page_title" id="page_title" placeholder="Enter title"
                                            class="form-control">{!! $page_title !!} </textarea>

                                    </div>


                                    <div class="form-group">
                                        <label for="slug">Main image</label>
                                        <input type="file" name="main_image" class="form-control">
                                    </div>

                                    @if(!empty($main_image))
                                    <div class="row" id="{{ $id }}">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <img src="{{ url('storage/media/'.$main_image) }}" width="200">
                                                {!! CustomBackEnd::get_delete($id) !!}

                                            </div>
                                        </div>




                                    </div>

                                    @endif







                                    <textarea id="editor"  name="page_description">{!!  $page_description !!}</textarea>


                                    <div class="form-group">
                                        <label for="description">small description</label>
                                        <textarea name="small_description" id="small_description"
                                            placeholder="Enter page smal ldescription"
                                            class="form-control">{!!  $small_description !!} </textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">keywords</label>
                                        <textarea name="post_keywords" id="post_keywords" class="form-control">{!!  $post_keywords !!} </textarea>
                                    </div>








                                    <input type="hidden" value="{{ $id }}" name="id">








                                </div>
                            </div>









                            <div class="col-3">
                                <div class="card-body">

                                    <div class="form-group">
                                        <label>Select Categories</label>
                                        <div id="side-categories">

                                            @php
                                            $ck='';
                                            $category_id_arr = array();
                                            if(!empty($category_id)){
                                            foreach($category_id as $category_id_data){
                                            $category_id_arr[] = $category_id_data->category_id;
                                            }
                                            }



                                            @endphp


                                            @foreach ($categories as $key => $categories_data )

                                            <div class="custom-control custom-checkbox">
                                                <input name="category_id[]" {{ in_array($categories_data->id,
                                                $category_id_arr)?'checked':'' }} class="custom-control-input"
                                                type="checkbox" id="customCheckbox{{ $categories_data->id }}" value="{{
                                                $categories_data->id }}">
                                                <label for="customCheckbox{{ $categories_data->id }}"
                                                    class="custom-control-label">{{ $categories_data->categories
                                                    }}</label>
                                            </div>
                                            @endforeach

                                        </div>

                                    </div>

                                    @php
                                    $draft = '';
                                    $publish = '';
                                    $valid_class = '';
                                    if($status==0){
                                    $draft = 'selected';
                                    $valid_class = 'is-invalid';

                                    }else{
                                    $publish = 'selected';
                                    $valid_class = 'is-valid';

                                    }
                                    @endphp

                                    <div class="form-group">
                                        <select name="status" class="form-control {{ $valid_class  }}">
                                            <option {{ $draft }} value="draft">Draft</option>
                                            <option {{ $publish }} value="publish">Publish</option>
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label> Publisher </label>

                                        <select name="published_author_id" class="form-control">
                                            <option value="">--SELECT--</option>
                                            @php
                                            $auther_select = '';
                                            @endphp
                                            @foreach ($user as $user_data )

                                            @php
                                            if($published_author_id==$user_data->id){
                                            $auther_select = 'selected';
                                            }else{
                                            $auther_select = '';
                                            }
                                            @endphp
                                            <option {{ $auther_select }} value="{{ $user_data->id }}">{{
                                                $user_data->name }}</option>
                                            @endforeach


                                        </select>

                                    </div>










                                    @if(!empty($page_links))
                                    <label> Page Links </label>
                                    <div id="side-categories">
                                        @foreach ($page_links as $page_links_data )

                                        @php
                                        $protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';

                                        @endphp

                                        <span id="copy{{ $page_links_data->categories_id }}">{{
                                            $protocol.'://'.$_SERVER['HTTP_HOST'].'/'.$page_links_data->category_link.'/'.$page_links_data->link}}</span>
                                        &nbsp;<i class="fas fa-copy"
                                            onclick="copyToClipboard('#copy{{ $page_links_data->categories_id }}')"
                                            title="text copy"></i><br>


                                        @endforeach
                                    </div>
                                    @endif






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
  ClassicEditor
	.create( document.querySelector( '#editor' ), {
     toolbar: [ 'ckfinder','mediaEmbed','bold', 'italic', '|',
     'undo', 'redo', '|', 'numberedList', 'bulletedList',
     'heading', '|',
     'fontfamily', 'fontsize', '|',
     'alignment', '|',
     'fontColor', 'fontBackgroundColor', '|',
     'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
     'link', '|',
     'outdent', 'indent', '|',
     'bulletedList', 'numberedList', 'todoList', '|',
     'sourceEditing',
     'code', 'codeBlock', '|',
     'insertTable', '|',
     'blockQuote', '|',
     'undo', 'redo'

     ]} )
	.catch( error => {
		console.error( error );
	} );















    $("#plan_form").submit(function(e) {
        e.preventDefault();

        for ( instance in ClassicEditor.instances ) {
            ClassicEditor.instances[instance].updateElement();
        }

        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-page/process',
            data: plan_form,
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
                    window.location.href=data.url
                }





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
















    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
             delete_table_data(id,'/manage-page-image/delete','danger')

        }else{

        }
     }






     function copyToClipboard(element){
        alert('text copied')
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }

    $(".fa-copy").hover(function() {
        $(this).css('cursor','pointer');

    }, function() {
        $(this).css('cursor','auto');
    });



</script>


@endpush

@endsection
