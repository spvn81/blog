@extends('user.layout')



@section('main_section')
@section('page_title','Manage social Links')
@section('main_title','Manage social Links')
@section('main_title_active', 'Manage social Links')
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
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="foter_links_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="fount_awesome_class"> Icon class</label>
                                        <input type="text" class="form-control" name="fount_awesome_class" value="{{ $fount_awesome_class }}">
                                    </div>


                                    <div class="form-group">
                                        <label for="link"> link class</label>
                                        <input type="text" class="form-control" name="link" value="{{ $link }}">
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







<div class="row">
    <div class="col-12">
        <div class="card-body">
            <table id="categoty_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Icon</th>

                    </tr>
                </thead>
                <tbody>
                     @foreach($social_links as $social_links_data )

                    <tr id="{{ $social_links_data->id }}">
                        <td>{{ $social_links_data->id }}</td>
                        <td><i class="{{ $social_links_data->fount_awesome_class }}"></i></td>
                        <td>

                            <div class="row text-capitalize">

                                <div class="col-md-3">
                                    {!! CustomBackEnd::getEdit('/add-social-links/'.$social_links_data->id) !!}
                                </div>



                                <div class="col-md-3">

                                    {!! CustomBackEnd::get_delete($social_links_data->id) !!}

                                </div>
                            </div>



                        </td>

                    </tr>
                    @endforeach

            </table>
        </div>
    </div>
</div>




@push('backend_scripts')

<script>
    $("#foter_links_form").submit(function(e) {
        e.preventDefault();
        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/add-social-links/process',
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







    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
             delete_table_data(id,'/add-social-links-delete','danger')
        }else{

        }
     }










</script>


@endpush

@endsection
