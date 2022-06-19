@extends('user.layout')



@section('main_section')
@section('page_title','Mnage user')
@section('main_title','Mnage user')
@section('main_title_active','Mnage user')
@section('linkste-create-user','active')
@section('manage-users','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="msg"></div>

        {!!regularModules::defaultNotification('info')  !!}


        <div class="row">





            <div class="col-3 col-sm-12 col-md-3">
                <a href="{{ url('create-user') }}"><button type="button"
                        class="btn btn-block bg-gradient-success btn-flat">Back</button></a>
            </div>



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="user_regireter_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Fullname">Full Name</label>
                                <input type="text" name="name" value="{{ $name }}" class="form-control" id="name" placeholder="Enter Full Name">
                              </div>

                              <div class="form-group">
                                <label for="mobile_number">Mobile Number</label>
                                <input type="text" name="mobile_number" value="{{ $mobile_number }}" class="form-control" id="mobile_number" placeholder="Enter Mobile Number">
                              </div>

                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" value="{{ $email }}" id="exampleInputEmail1" placeholder="Enter email">
                            <span class="error" id="emailerr"></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">Email Request</label>
                            Yes: <input type="radio" name="email_request" value=""  id="email_request" required>
                            NO: <input type="radio" name="email_request" value="no"  id="email_request" required>
                        </div>

                          <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password"  class="form-control" id="password" placeholder="Password">
                          </div>


                          <div class="form-group">
                            <label for="exampleInputPassword2">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">

                        </div>


                        <div class="form-group">
                            <label for="avatar">Avatar</label>
                            <input type="file" name="avatar" class="form-control" id="avatar" >


                          </div>











                        <div class="form-group">
                            <label for="user_type">User Role</label>
                            <select class="form-control" name="user_type">
                                <option value="">--Select--</option>
                                  @foreach ($user_role_data as $user_role_data_view )
                                  @php
                                      if($user_role_data_view->name==$user_type){
                                          $selected ='selected';
                                      }else{
                                        $selected ='';
                                      }
                                  @endphp
                                <option  {{ $selected  }} value="{{ $user_role_data_view->name  }}">{{ $user_role_data_view->name }}</option>
                                  @endforeach

                            </select>

                        </div>

                        <input type="hidden" name="user_id_created_by" value="{{Auth::user()->id }}">
                        <input type="hidden" name="id" value="{{ $id }}">
                        <input type="hidden" name="user_id" value="{{Auth::user()->id }}">
                        <input type="hidden" name="terms" value="on">




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


    $("#user_regireter_form").submit(function(e) {
        e.preventDefault();
        $('#user_regirester').prop('disabled', true);
          var page_load = `<div class="overlay-wrapper">
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
          </div>`
          $('.pageloader').html(page_load)

        var user_regireter_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            },
            url: '/register',
            data: user_regireter_form,
            success: function(data) {
                if (data.success){
                    $("#user_regireter_form")[0].reset()
                    toastr.success(data.success)
                   setTimeout(function(){

                    window.location.href ='/create-user'

                   }, 3000);


                }else{
                    $('.pageloader').html(' ')
                    $('#user_regirester').prop('disabled', false);

                    $.each(data.errors,function(key,value){
                        toastr.error(value)
                    })

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


</script>


<script>


    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
            delete_table_data_with_method(id,'/api/uploader/media/'+id,'danger','DELETE')
        }else{

        }
     }

  </script>






@endpush

@endsection
