@extends('user.layout')

@section('main_section')
@section('page_title','manage category')
@section('main_title','manage category')
@section('linkste-web','active')
@section('linkste-categories','active')


<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <div class="row">





        <div class="col-3 col-sm-12 col-md-3">
            <a href="{{ url('categories') }}">
                <button type="button" class="btn btn-block bg-gradient-success btn-flat">Back</button>
            </a>
            </div>


        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
              <!-- form start -->
              <form id="manage_category">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="Category">Category</label>
                    <input type="text" class="form-control" id="categories" name="categories" value="{{ $categories }}" placeholder="Enter Category name">
                    <span id="categories-error" class="error"></span>

                </div>

                  <div class="form-group">
                    <label for="categories_slug">Category slug</label>
                    <input type="text" class="form-control" id="categories_slug"  name="categories_slug" value="{{ $categories_slug }}" placeholder="Enter Category slug">
                    <span id="categories_slug-error" class="error"></span>
                    </div>


                    <div class="form-group">
                        <label for="categories_slug">category image</label>
                        <input type="file" class="form-control" id="category_image"  name="category_image" >

                        @if(!empty($category_image))
                        <img  src="{{ url('storage/media/'.$category_image) }}" width="200px">
                        @endif

                        </div>



                        @php
                        $is_home_checked = '';
                            if($is_home==1){
                                $is_home_checked = 'checked';
                            }
                        @endphp
                        <div class="form-group">
                            <label for="categories_slug">is home</label>
                            <input {{ $is_home_checked }} type="checkbox"  id="is_home"  name="is_home" value="1" >

                            </div>



                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control">{{ $description }}</textarea>

                                </div>



                                <div class="form-group">
                                    <label for="keywords">keywords</label>
                                    <textarea name="keywords" class="form-control" placeholder="ex:-key word one, key word two">{{ $keywords }}</textarea>
                                    </div>


                                        @php
                                            $category_type  = ['post'=>'post','gallery'=>'gallery'];
                                            $check_type = '';

                                        @endphp
                                    <div class="form-group">
                                        <label for="keywords">Category Type</label>
                                        @foreach ( $category_type as $key => $category_type_data )

                                        @php
                                        if($key===$type){
                                            $check_type = 'checked';

                                        }else{
                                            $check_type = '';
                                        }

                                        @endphp

                                        <input type="radio" {{ $check_type }}  name="type"  value="{{ $key }}"  name="type" required> : {{ $category_type_data }}
                                        @endforeach


                                        </div>




                <input type="hidden" name="id" value="{{ $id }}">

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

    $("#manage_category").submit(function(e) {
        e.preventDefault();
        var manage_category = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-category/process',
            data: manage_category,
            success: function(data) {

                $("#categories-error").html(' ')
                $("#categories_slug-error").html(' ')
                $("#category_type-error").html(' ')
                if(data.errors){
                    $("#categories-error").html(data.errors.categories)
                    $("#categories_slug-error").html(data.errors.categories_slug)
                    $("#category_type-error").html(data.errors.category_type)

                }else{
                $("#categories-error").html(' ')
                $("#categories_slug-error").html(' ')
                $("#category_type-error").html(' ')
                window.location.href = '/categories'

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
