@extends('user.layout')

@section('main_section')
@section('page_title','menu')
@section('main_title','menu')
@section('main_title_active','menu')
@section('linkste-web','active')
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

        <div class="col-3 col-sm-12 col-md-3">
        <a href="{{ url('/manage-menu') }}"><button type="button" class="btn btn-block bg-gradient-success btn-flat">Create Menu</button></a>
        </div>

        <div class="col-12">
        <div class="card-body">
            <table id="menu_table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Id</th>
                <th>menu</th>
                <th>parent id</th>
                <th>menu slug</th>
                <th>menu link</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($menu as $menu_data )

              <tr  id="{{ $menu_data->id }}">
                <td>{{  $menu_data->id }}</td>
                <td>{{  $menu_data->menu_name }}</td>
                <td>{{  $menu_data->menu_parent_id }}</td>
                <td>{{  $menu_data->menu_slug }}</td>
                <td><a href="{{ $menu_data->link  }}" target="_blank">Link</a></td>
                <td>

                    <div class="row text-capitalize">

                        <div class="col-md-4">
                            {!! CustomBackEnd::getEdit('/manage-menu/'.$menu_data->id) !!}
                         </div>

                         <div class="col-md-4">

                         {!!  CustomBackEnd::get_delete($menu_data->id) !!}

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
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

function delete_data(id){
   var del =  confirm("Want to delete?");
   if(del==true){
        delete_table_data(id,'/menu/delete','danger')

   }else{

   }
}





  </script>



@endpush
