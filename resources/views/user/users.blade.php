@extends('user.layout')

@section('main_section')
@section('page_title','users')
@section('main_title','users')
@section('main_title_active','users')
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
        {!!regularModules::defaultNotification('info') !!}



        <div class="col-3 col-sm-12 col-md-3">
            <a href="{{ url('manage-user') }}"><button type="button"
                    class="btn btn-block bg-gradient-success btn-flat">Create User</button></a>
        </div>



        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card card-primary card-tabs">

                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-users" role="tabpanel"
                                aria-labelledby="custom-tabs-all-users">



                                <div class="row">


                                    <div class="col-12">
                                        <div class="card-body">
                                            <table id="create_onlne_class_table"
                                                class="table table-bordered table-striped text-capitalize">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>name</th>
                                                        <th>email</th>
                                                        <th>email verified</th>
                                                        <th>user type</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach($user_data as $user_data_show )

                                                    <tr id="{{ $user_data_show->id }}">
                                                        <td>{{ $user_data_show->id }}</td>
                                                        <td>{{ $user_data_show->name }}</td>
                                                        <td>{{ $user_data_show->email }}</td>
                                                        <td>{{ $user_data_show->email_verified_at }}</td>
                                                        <td>{{ $user_data_show->user_type }}</td>

                                                        <td>
                                                            <div class="row text-capitalize">
                                                                <div class="col-md-3">

                                                                    {!!
                                                                    CustomBackEnd::get_status($user_data_show->user_status,'/manage-user/status/'.$user_data_show->id)
                                                                    !!}
                                                                </div>
                                                                <div class="col-md-3">
                                                                    {!!
                                                                    CustomBackEnd::getEdit('/manage-user/'.$user_data_show->id)
                                                                    !!}
                                                                </div>

                                                                <div class="col-md-3">

                                                                    {!! CustomBackEnd::get_delete($user_data_show->id)
                                                                    !!}

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





                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

        </div>












    </div>
    <!-- /.container-fluid -->
</div>











<!-- Modal -->
<div class="modal fade" id="blockuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Block User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" name="" placeholder="Enter  Description"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                <button type="button" class="btn btn-primary">Block</button>
            </div>
        </div>
    </div>
</div>







@endsection

@push('backend_scripts')

<script>
    var table = $('#create_onlne_class_table').DataTable();

var filteredData = table
    .columns( [0, 1] )
    .data()
    .flatten()
    .filter( function ( value, index ) {
        return value > 3 ? true : false;
    } );




function delete_data(id){
   var del =  confirm("Want to delete?");
   if(del==true){
        delete_table_data(id,'/create-user/delete','danger')
   }else{

   }
}

</script>



@endpush
