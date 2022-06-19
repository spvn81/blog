@extends('user.layout')

@section('main_section')
@section('page_title','web page')
@section('main_title','web page')
@section('main_title_active','web page')
@section('linkste-web','active')
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



            <div class="col-4">
                <div class="card-body">
                   <a href="{{ url('manage-page') }}" title="create page">
                    <button type="button" class="btn btn-success"><i class="fas fa-plus-circle"></i></button>

                    </a>
                </div>
                </div>







            <div class="col-12">
                <div class="card-body">
                    <table id="users_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>page name</th>
                                <th>page title</th>
                                <th>views</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($page as $page_data )

                            <tr id="{{ $page_data->id }}">
                                <td>{{ $page_data->id }}</td>
                                <td>{{ $page_data->page_name }}</td>
                                <td>{{ $page_data->page_title }}</td>
                                <td>


                                    @foreach ($post_view_count[$page_data->id] as $post_count_data )


                                        {{ $post_count_data->count !=0 ?$post_count_data->count:'0' }}
                                    @endforeach

                                    <i class="fas fa-eye text-success"></i></td>


                                <td>

                                    <div class="row text-capitalize">

                                        <div class="col-md-4">
                                            {!! CustomBackEnd::getEdit('/manage-page/'.$page_data->id) !!}
                                         </div>

                                        <div class="col-md-4">

                                            {!! CustomBackEnd::get_delete($page_data->id) !!}

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
      $("#users_table").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#users_table .col-md-6:eq(0)');
    });

function delete_data(id){
   var del =  confirm("Want to delete?");
   if(del==true){
        delete_table_data(id,'/page/delete','danger')

   }else{

   }
}









</script>



@endpush
