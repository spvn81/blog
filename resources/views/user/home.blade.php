@extends('user.layout')

@section('main_section')
@section('page_title','home page')
@section('main_title','home page')
@section('main_title_active','home page')
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
                    <a href="{{ url('manage-home') }}" title="create page">
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
                                <th> title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($home as $home_data )

                            <tr id="{{ $home_data->id }}">
                                <td>{{ $home_data->id }}</td>
                                <td>{{ $home_data->title }}</td>


                                <td>

                                    <div class="row text-capitalize">

                                        <div class="col-md-4">
                                            {!! CustomBackEnd::getEdit('/manage-home/'.$home_data->id) !!}
                                        </div>

                                        <div class="col-md-4">

                                            {!! CustomBackEnd::get_delete($home_data->id) !!}

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
        delete_table_data(id,'/home/delete','danger')

   }else{

   }
}





function copyToClipboard(element){
    alert('text copied')
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}



$(".fa-copy").hover(function() {
    $(this).css('cursor','pointer');

}, function() {
    $(this).css('cursor','auto');
});





</script>



@endpush
