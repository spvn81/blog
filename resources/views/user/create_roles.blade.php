@extends('user.layout')

@section('main_section')
@section('page_title','create-roles')
@section('main_title','create-roles')
@section('main_title_active','create-roles')
@section('roles_permissions','active')
<meta name="csrf-token" content="{{ csrf_token() }}">

@php
use App\Helpers\CustomBackEnd;
use App\Helpers\regularModules;
@endphp


<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        {!!regularModules::defaultNotification('info') !!}



        <div class="msg"></div>

        <div class="row">
            <div class="col-3">
                <div class="card-body">
                   <a href="{{ url('manage-roles') }}"> <button type="button" class="btn btn-primary btn-block">Create  <i class="fa fa-plus"></i></button></a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <table id="roles_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>name</th>
                                <th>guard_name </th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>





                            @foreach($roles as $roles_data )

                            <tr id="{{ $roles_data->id }}">
                                <td>{{ $roles_data->id }}</td>
                                <td>{{ $roles_data->name }}</td>
                                <td>{{ $roles_data->guard_name }}</td>

                                <td>



                                    <div class="row text-capitalize">

                                        <div class="col-md-4">
                                            {!! CustomBackEnd::getEdit('/manage-roles/'.$roles_data->id) !!}
                                        </div>

                                        <div class="col-md-4">

                                            {!! CustomBackEnd::get_delete($roles_data->id) !!}

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
    $(function () {
      $("#roles_table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#roles_table .col-md-6:eq(0)');
    });

function delete_data(id){
   var del =  confirm("Want to delete?");
   if(del==true){
        delete_table_data(id,'/create-roles/delete','danger')

   }else{

   }
}



</script>



@endpush
