@extends('user.layout')

@section('main_section')



@section('page_title', 'Role-permissions')
@section('main_title', 'Role-permissions')
@section('main_title_active', 'Role-permissions')
@section('roles_permissions','active')
<meta name="csrf-token" content="{{ csrf_token() }}">




@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        {!!regularModules::defaultNotification('info')  !!}



        <div class="msg"></div>

        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <form id="role_permissions_form">
                        @csrf




                        <div class="form-group">
                            <label for="Category">name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $name  }}"
                                placeholder="Enter  permission name">
                            <span id="name-error" class="error"></span>
                        </div>


                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>


                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <table id="permission_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>name</th>
                                <th>guard_name </th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>



                            @foreach($RolePermission as $RolePermission_data )

                            <tr  id="{{ $RolePermission_data->id }}">
                                <td>{{  $RolePermission_data->id }}</td>
                              <td>{{  $RolePermission_data->name }}</td>
                              <td>{{  $RolePermission_data->guard_name }}</td>


                              <td>

                                  <div class="row text-capitalize">

                                      <div class="col-md-4">
                                          {!! CustomBackEnd::getEdit('/role-permissions/'.$RolePermission_data->id) !!}
                                       </div>

                                       <div class="col-md-4">

                                       {!!  CustomBackEnd::get_delete($RolePermission_data->id) !!}

                                       </div>
                                    </div>



                              </td>







                            </tr>
                            @endforeach






                    </table>
                </div>


            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>



@endsection

@push('backend_scripts')

<script>




    $('#permission_table').dataTable({
        'iDisplayLength': 100
      });

    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
             delete_table_data(id,'/role-permissions/delete','danger')

        }else{

        }
     }




$("#role_permissions_form").submit(function(e) {
    e.preventDefault();
    var role_permissions_form = new FormData($(this)[0])
    $.ajax({
        type: "post",
        Headers: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        },
        url: '/permissions-role/process',
        data: role_permissions_form,
        success: function(data) {
            $("#roleid-name").html(' ')
            if(data.errors){
                $("#name-error").html(data.errors.name)

                $("#operation-error").html(data.errors.operation)


            }else{
                $("#name-error").html(' ')
              window.location.href='/role-permissions';


            }

        },
        contentType: false,
        processData: false,
        cache: false,

    });

})








</script>



@endpush
