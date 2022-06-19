@extends('user.layout')

@section('main_section')
@section('page_title','manage menu')
@section('main_title','manage menu')
@section('main_title_active','manage menu')
@section('linkste-web','active')


<!-- Main content -->
<div class="content">
  <div class="container-fluid">

    <div class="row">





        <div class="col-3 col-sm-12 col-md-3">
            <a href="{{ url('menu') }}">
                <button type="button" class="btn btn-block bg-gradient-success btn-flat">Back</button>
            </a>
            </div>


        <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">

              <!-- /.card-header -->
              <!-- form start -->
              <form id="manage_menu">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="menu_name">Menu</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ $menu_name }}" placeholder="Enter menu name">
                    <span id="menu_name-error" class="error"></span>

                </div>

                  <div class="form-group">
                    <label for="menu_slug">Menu slug</label>
                    <input type="text" class="form-control" id="menu_slug"  name="menu_slug" value="{{ $menu_slug }}" placeholder="Enter Menu slug">
                    <span id="menu_slug-error" class="error"></span>
                    </div>


                    <div class="form-group">
                        <label for="menu_slug">Menu parent</label>
                        <select class="form-control" name="menu_parent_id">
                            <option value="">--SELECT--</option>
                            @foreach ($menu as $menu_data_show )
                            @if($id != $menu_data_show->id)
                            @php
                            if($menu_data_show->id==$menu_parent_id){
                                $check = 'selected';
                            }else{
                                $check = '';

                            }

                            @endphp
                            <option {{ $check }} value="{{ $menu_data_show->id }}">{{ $menu_data_show->menu_name }}</option>
                            @endif

                            @endforeach

                        </select>

                        </div>




                    <div class="form-group">
                        <label for="link">Menu link</label>
                        <input type="text" class="form-control" id="link"  name="link" value="{{ $link }}" placeholder="Enter Menu link">
                        <span id="link-error" class="error"></span>
                        </div>




                <div class="form-group">

                        @foreach ($menu_type_data as $menu_type_data_show )

                        @php
                            if($menu_type==$menu_type_data_show->category_type){
                                $ck = 'checked';
                            }else{
                                $ck = '';

                            }
                        @endphp

                      <input type="radio" name="menu_type"   {{ $ck }}  value="{{ $menu_type_data_show->category_type  }}">
                      <label for="menu_type">{{ $menu_type_data_show->category_type  }}</label>
                      &nbsp&nbsp
                      @endforeach

                      <span id="menu_type-error" class="error"></span>
                </div>


              @php
              $checked = '';
              if($is_data==1){
                $checked = 'checked';
              }else{
                $checked = '';

              }

              @endphp



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

    $("#manage_menu").submit(function(e) {
        e.preventDefault();
        var manage_category = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-menu/process',
            data: manage_category,
            success: function(data) {

                $("#menu_name-error").html(' ')
                $("#menu_slug-error").html(' ')
                $("#menu_parent_id-error").html(' ')
                $("#link-error").html(' ')
                $("#menu_type-error").html(' ')


                if(data.errors){
                    $("#menu_name-error").html(data.errors.menu_name)
                    $("#menu_slug-error").html(data.errors.menu_slug)
                    $("#menu_type-error").html(data.errors.menu_type)
                    $("#link-error").html(data.errors.link)


                }else{
                $("#menu_name-error").html(' ')
                $("#categories_slug-error").html(' ')
                $("#menu_type-error").html(' ')
                $("#link-error").html(' ')

                window.location.href = '/menu'

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
