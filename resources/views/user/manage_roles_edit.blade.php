@extends('user.layout')



@section('main_section')
@section('page_title','Mnage Roles Edit')
@section('main_title','Mnage Roles Edit')
@section('main_title_active', 'Mnage Role Edit')
@section('roles_permissions','active')


<!-- Main content -->
<div class="content">
    <div class="container-fluid">
            <div class="row">
            <div class="col-3 col-sm-12 col-md-3">
                <a href="{{ url('create-roles') }}"><button type="button" class="btn btn-block bg-gradient-success btn-flat">Back</button></a>
            </div>



            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">

                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="role_form" class="text-capitalize" enctype="multipart/form-data">
                        @csrf

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body">
                                            @csrf
                                            <div class="form-group">
                                                <label for="Category">Role Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $name }}" placeholder="Enter Role name">
                                                <span id="role-error" class="error"></span>
                                            </div>
                                            <input type="hidden" name="id" value="{{ $id }}">

                                        </div>
                                </div>
                            </div>

                            <div class="card-body">
                            <div class="row">


                                <div class="col-12">

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                          <input type="checkbox"  class="custom-control-input" id="checkAll">
                                          <label class="custom-control-label text-success" for="checkAll">Check All</label>
                                        </div>
                                      </div>
                                </div>




                                @foreach ($permissions as $key => $permissions_data )
                                    <div class="col-3">

                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                          <input type="checkbox" name="permission_id[]" value="{{ $permissions_data->id }}" class="custom-control-input" id="{{ $permissions_data->name }}"

                                                @foreach ($permissions_data_val as $permissions_data_val_data )
                                                @if($permissions_data_val_data->permission_id ==  $permissions_data->id)
                                                checked
                                                @else
                                                ''
                                                @endif

                                                @endforeach
                                                >
                                          <label class="custom-control-label" for="{{ $permissions_data->name }}">{{ $permissions_data->name }}</label>
                                        </div>
                                      </div>
                                </div>
                                      @endforeach




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

@push('backend_scripts')

<script>

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });


    $("#role_form").submit(function(e) {
        e.preventDefault();
        var role_form_data = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            url: '/manage-role/process',
            data: role_form_data,
            success: function(data) {
                $("#role-error").html(' ')
                if(data.errors){
                    $("#role-error").html(data.errors.name)

                }else{
                $("#role-error").html(' ')



                toastr.success(data.success)
                setTimeout(function(){
                 //  window.location.href = '/create-roles'
               }, 2000);


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
