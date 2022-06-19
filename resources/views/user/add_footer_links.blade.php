@extends('user.layout')



@section('main_section')
@section('page_title','Manage Footer Links')
@section('main_title','Manage Footer Links')
@section('main_title_active', 'Manage Footer Links')
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
                                        <label for="description"> title</label>
                                        <input type="text" class="form-control" name="title" value="{{ $title }}">
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
                        <th>category</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($footer_links_title as $footer_links_title_data )

                    <tr id="{{ $footer_links_title_data->id }}">
                        <td>{{ $footer_links_title_data->id }}</td>
                        <td>{{ $footer_links_title_data->title }}</td>
                        <td>

                            <div class="row text-capitalize">

                                <div class="col-md-3">
                                    {!! CustomBackEnd::getEdit('/add-footer-links/'.$footer_links_title_data->id) !!}
                                </div>

                                <div class="col-md-3">
                                    <a href="{{ url('footer-links/'.$footer_links_title_data->id) }}">
                                    <i class="fas fa-link"></i>
                                 </a>

                                </div>


                                <div class="col-md-3">

                                    {!! CustomBackEnd::get_delete($footer_links_title_data->id) !!}

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
            url: '/add-footer-links/process',
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
             delete_table_data(id,'/add-footer-links-title-delete','danger')
        }else{

        }
     }










</script>


@endpush

@endsection
