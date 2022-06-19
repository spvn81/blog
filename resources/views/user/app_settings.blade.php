@extends('user.layout')

@section('main_section')
@section('page_title', 'app settings')
@section('main_title', 'app settings')
@section('main_title_active', 'app settings')
@section('settings', 'active')
<meta name="csrf-token" content="{{ csrf_token() }}">
@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;

@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        {!! regularModules::defaultNotification('info') !!}


        <div class="msg"></div>


        <div class="row">



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="app_info_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="card-body">



                                    <div class="form-group">
                                        <label for="title">app name</label>
                                        <input type="text" name="app_name" value="{{ $app[0]->app_name }}"
                                            class="form-control" id="app_name">
                                    </div>


                                    <div class="form-group">
                                        <label for="title">title</label>
                                        <input type="text" name="title" value="{{ $app[0]->title }}"
                                            class="form-control" id="title">
                                            <label>show title</label>

                                            @php
                                                if( $app[0]->show_title==1){
                                                        $show_title ='checked';
                                                }else{
                                                    $show_title ='';

                                                }
                                            @endphp
                                            <input type="checkbox"  {{ $show_title }}  name="show_title" value="1">

                                    </div>


                                    <div class="form-group">
                                        <label for="title">sub title</label>
                                        <input type="text" name="sub_title" value="{{ $app[0]->sub_title }}"
                                            class="form-control" id="sub_title">
                                    </div>






                                    <div class="form-group">
                                        <label for="title">app url</label>
                                        <input type="text" name="app_url" value="{{ $app[0]->app_url }}"
                                            class="form-control" id="app_url">
                                    </div>




                                    <div class="form-group">
                                        <label for="title">logo</label>
                                        <input type="file" name="logo" class="form-control" id="logo">


                                        @php
                                        if( $app[0]->show_logo==1){
                                                $show_logo ='checked';
                                        }else{
                                            $show_logo ='';

                                        }
                                    @endphp

                                    </div>

                                    @if(!empty($app[0]->logo))

                                    <img src="{{ url('storage/media/'.$app[0]->logo) }}" width="100">

                                    <label>show Logo</label>
                                    <input type="checkbox" {{ $show_logo }}  name="show_logo" value="1">


                                    @endif


                                    <div class="form-group">
                                        <label for="title">favicon</label>
                                        <input type="file" name="favicon" class="form-control" id="favicon">

                                        @if(!empty($app[0]->favicon))
                                        <img src="{{ url('storage/media/'.$app[0]->favicon) }}" width="50">
                                        @endif


                                    </div>



                                    <div class="form-group">
                                        <label for="title">email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{  $app[0]->email  }}" id="email">
                                    </div>



                                    <div class="form-group">
                                        <label for="title">phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{  $app[0]->phone  }}" id="phone" maxlength="12">
                                    </div>




                                    <div class="form-group">
                                        <label for="title">address</label>
                                        <textarea name="address" class="form-control"
                                            id="address">{{ $app[0]->address }}</textarea>
                                    </div>








                                    <div class="form-group">
                                        <label for="title">description</label>
                                        <textarea name="description" class="form-control"
                                            id="description">{{ $app[0]->description }}</textarea>
                                    </div>


                                    <div class="form-group">
                                        <label for="title">About Page link</label>
                                        <input type="text" class="form-control"  name="about_page_ink" placeholder="https://example.com" value="{{ $app[0]->about_page_ink }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="title">keywords</label>
                                        <textarea name="keywords" class="form-control"
                                            id="keywords">{{ $app[0]->keywords }}</textarea>
                                    </div>
                                    <input type="hidden" name="id" value="{{ $app[0]->id }}">




                                </div>
                                <!-- /.card-footer -->







                            </div>
                        </div>
                </div>


                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" id="msg_button" class="btn btn-primary">
                        Save
                    </button>
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



@endsection


@push('backend_scripts')
<script>
    $("#app_info_form").submit(function(e) {
        e.preventDefault();


        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/app-settings/process',
            data: plan_form,
            success: function(data) {

                if (data.errors) {


                    $.each(data.errors, function(key, value) {
                        toastr.error(value)
                    })


                } else {



                    toastr.success(data.success)


                    if (data.ste == 'updated') {
                        setTimeout(function() {}, 3000);
                    } else {

                        setTimeout(function() {

                        }, 1000);


                    }





                }

            },
            contentType: false,
            processData: false,
            cache: false,

        });

    })
</script>
@endpush
