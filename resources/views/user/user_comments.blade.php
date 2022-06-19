@extends('user.layout')

@section('main_section')
@section('page_title', 'User Comments')
@section('main_title', 'User Comments')
@section('main_title_active', 'User Comments')
@section('linkste-user-comments', 'active')
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





        <div class="col-12">
            <div class="card-body">
                <table id="comments_table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Post</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>


                @foreach($comments as $comments_data )

                @php
                $font_weight_bold ='';
                    if($comments_data->read_status==null){
                        $font_weight_bold = 'font-weight-bold';
                    }else{
                        $font_weight_bold ='';
                    }
                @endphp

                  <tr  id="{{ $comments_data->id }}" class="{{ $font_weight_bold }}">
                    <td>{{  $comments_data->id }}</td>
                    <td><a href="{{ url($comments_data->category_link.'/'.$comments_data->link) }}" target="_blank"><i class="fas fa-external-link-square-alt"></i> {{ substr( $comments_data->page_name,0,16) }}..</a></td>
                    <td>{{  $comments_data->name }}</td>
                    <td>{{  $comments_data->email }}</td>
                    <td>{{ substr( $comments_data->message,0,30) }}..</td>
                    <td>

                        <div class="row text-capitalize">

                            <div class="col-md-4">
                                <a title="reply" href="{{ url('user-comments-reply/'.$comments_data->id) }}"> <i class="fas fa-reply"></i>
                            </a>
                             </div>



                             <div class="col-md-4">

                             {!!  CustomBackEnd::get_delete($comments_data->id) !!}

                             </div>

                          </div>



                    </td>
                  </tr>
                  @endforeach





                  </tbody>
                </table>
              </div>


            </div>






        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>

@push('backend_scripts')
<script>



    $(document).ready( function () {
        $('#comments_table').DataTable();
    } );





    function delete_data(id){
        var del =  confirm("Want to delete?");
        if(del==true){
             delete_table_data(id,'/user-comments/delete','danger')

        }else{

        }
     }

</script>

@endpush



@endsection



