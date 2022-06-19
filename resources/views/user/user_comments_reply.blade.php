@extends('user.layout')

@section('main_section')
@section('page_title', 'User Comments Reply')
@section('main_title', 'User Comments Reply')
@section('main_title_active', 'User Comments Reply')
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






            <div class="col-md-12">
                <!-- Box Comment -->
                <div class="card card-widget">
                    <div class="card-header">
                        <div class="user-block">
                            <img class="img-circle" src="{{ asset('front/img/noimage_person.png') }}" alt="User Image">
                            <span class="username"><a href="#">{{ $comment->name }}</a></span>
                            <span class="description">
                                {{\Carbon\Carbon::parse($comment->updated_at)->diffForhumans() }}

                            </span>
                        </div>
                        <!-- /.user-block -->
                        <div class="card-tools">




                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        {{ $comment->message }}


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer card-comments">



                        @foreach ($get_replays as $get_replays_data )

                        <div class="card-comment">
                            <!-- User image -->
                            <img class="img-circle img-sm" src="{{ url('storage/media/'.$get_replays_data->avatar) }}" alt="User Image">

                            <div class="comment-text">
                                <span class="username">
                                    {{ $get_replays_data->name }}
                         <span class="text-muted float-right">{{\Carbon\Carbon::parse($get_replays_data->updated_at)->diffForhumans() }}</span>
                                </span>
                                <!-- /.username -->
                              {{ $get_replays_data->message }}
                            </div>
                            <!-- /.comment-text -->
                        </div>
                        @endforeach








                    </div>
                    <!-- /.card-footer -->


                    <div class="card-footer">

                            <img class="img-fluid img-circle img-sm" src="{{ url('storage/media/'.Auth()->user()->avatar) }}" alt="Alt Text">
                            <!-- .img-push is used to add margin to elements next to floating images -->


                            <div class="img-push">
                                <form id="reply_comments">
                                    @csrf
                            <div class="input-group">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                 <span class="input-group-append"><button type="submit" class="btn btn-primary">Send</button></span>
                                </div>
                                </form>


                        </div>






                    </div>



                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->






        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>

@push('backend_scripts')
<script>







    $("#reply_comments").submit(function(e) {
        e.preventDefault();
        $('#user_regirester').prop('disabled', true);
          var page_load = `<div class="overlay-wrapper">
            <div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">please wait...</div></div>
          </div>`
          $('.pageloader').html(page_load)

        var reply_comments = new FormData($(this)[0])
        $.ajax({
            type: "post",
            Headers: {
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            },
            url: '/user-comments-reply/send',
            data: reply_comments,
            success: function(data) {
                if (data.success){
                    $("#reply_comments")[0].reset()
                    toastr.success(data.success)
                   setTimeout(function(){
                      location.reload();
                   }, 2000);


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


</script>

@endpush



@endsection
