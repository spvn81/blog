@extends('user.layout')

@section('main_section')
@section('page_title','categories')
@section('main_title','categories')
@section('main_title_active','categories')
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
        <a href="{{ url('/manage-category') }}"><button type="button" class="btn btn-block bg-gradient-success btn-flat">Create category</button></a>
        </div>



        <div class="col-12">
        <div class="card-body">
            <table id="categoty_table" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Id</th>
                <th>category</th>
                <th>link</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
                 @foreach($category as $category_data )

              <tr  id="{{ $category_data->id }}">
                <td>{{  $category_data->id }}</td>
                <td>{{  $category_data->categories }}</td>
                <td><span id="copy{{ $category_data->id }}">{{ $category_data->link }}</span>
                    <i class="fas fa-copy" onclick="copyToClipboard('#copy{{ $category_data->id }}')" title="text copy"></i></td>
                <td>

                    <div class="row text-capitalize">
                        <div class="col-md-4">

                        {!!   CustomBackEnd::get_status($category_data->status,'/categories/status/'.$category_data->id) !!}
                        </div>
                        <div class="col-md-4">
                            {!! CustomBackEnd::getEdit('/manage-category/'.$category_data->id) !!}
                         </div>

                         <div class="col-md-4">

                         {!!  CustomBackEnd::get_delete($category_data->id) !!}

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
      $("#categoty_table").DataTable()
    });



function delete_data(id){
   var del =  confirm("Want to delete?");
   if(del==true){
        delete_table_data(id,'/categories/delete','danger')

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
