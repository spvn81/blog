@extends('frontend.layout')

@section('main_section')



@if(!empty($get_single_post[0]->page_title))
@section('page_title',$get_single_post[0]->page_title)
@endif


@if(!empty($get_single_post[0]->small_description))
@section('description',$get_single_post[0]->small_description)
@endif

@if(!empty($get_single_post[0]->post_keywords))
@section('keywords',$get_single_post[0]->post_keywords)
@endif






<section class="single-post-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9 post-content" data-aos="fade-up">
                <!-- ======= Single Post Content ======= -->
                <div class="single-post">




                    @foreach ($get_single_post as $get_single_post_data)

                    <div class="post-meta"><span class="date">{{ $get_single_post_data->categories }}</span>
                        <span class="mx-1">&bullet;</span> <span>
                            {{\Carbon\Carbon::parse($get_single_post_data->updated_at)->diffForhumans() }}
                        </span>
                    </div>


                    {!! $get_single_post_data->page_description !!}
                    @endforeach




                </div>
                <!-- End Single Post Content -->






                <!-- ======= Comments ======= -->
                <div class="comments">
                    <h5 class="comment-title py-4">{{ count($comments) }} Comments</h5>



                        @foreach ($comments as $comments_data )


                    <div class="comment d-flex mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar avatar-sm rounded-circle">
                                <img class="avatar-img" src="{{ asset('front/img/noimage_person.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>


                        <div class="flex-grow-1 ms-2 ms-sm-3">
                            <div class="comment-meta d-flex align-items-baseline">
                                <h6 class="me-2">{{ $comments_data->name }}</h6>
                                <span class="text-muted">
                                    {{\Carbon\Carbon::parse($comments_data->updated_at)->diffForhumans() }}
                                </span>
                            </div>

                            <div class="comment-body">

                                {{ $comments_data->message }}

                            </div>

                            <div class="comment-replies bg-light p-3 mt-3 rounded">
                                @if( count($replays[$comments_data->id]) !=0)
                                <h6 class="comment-replies-title mb-4 text-muted text-uppercase">{{ count($replays[$comments_data->id]) }} replies</h6>
                                @endif



                                @foreach ($replays[$comments_data->id] as $replays_data )


                                <div class="reply d-flex mb-4">
                                    <div class="flex-shrink-0">
                                        <div class="avatar avatar-sm rounded-circle">
                                            <img class="avatar-img" src="{{ url('storage/media/'.$replays_data->avatar) }}" alt="{{ $replays_data->name }}"
                                                class="img-fluid">
                                        </div>
                                    </div>

                                    <div class="flex-grow-1 ms-2 ms-sm-3">
                                        <div class="reply-meta d-flex align-items-baseline">
                                            <h6 class="mb-0 me-2"> {{ $replays_data->name }}</h6>
                                            <span class="text-muted">
                                                {{\Carbon\Carbon::parse($replays_data->updated_at)->diffForhumans() }}

                                            </span>
                                        </div>
                                        <div class="reply-body">
                                            {{ $replays_data->message }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach










                            </div>
                        </div>
                    </div>

                    @endforeach






                </div>
                <!-- End Comments -->

                <!-- ======= Comments Form ======= -->
                <div class="row justify-content-center mt-5">

                    <div class="col-lg-12">
                        <h5 class="comment-title">Leave a Comment</h5>
                        <div class="row">



                                <form id="comment_form">
                                    @csrf
                            <div class="col-lg-6 mb-3">
                                <label for="comment-name">Name</label>
                                <input type="text" class="form-control" id="comment-name" placeholder="Enter your name" name="name">
                                <span class="text-danger" id="name"></span>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="comment-email">Email</label>
                                <input type="text" class="form-control" id="comment-email" placeholder="Enter your email" name="email">
                                <span class="text-danger" id="email"></span>

                            </div>
                            <div class="col-12 mb-3">
                                <label for="comment-message">Message</label>

                                <textarea class="form-control" id="comment-message" placeholder="Enter your name" cols="30" rows="10" name="message"></textarea>
                                    <span class="text-danger" id="message"></span>

                            </div>
                            <input type="hidden" name="post_id" value="{{ $post_id }}" >
                            <div class="col-12">
                                <input type="submit" id="comment_submit_btn" class="btn btn-primary" value="Post comment">
                            </div>
                        </form>


                        </div>
                    </div>
                </div>
                <!-- End Comments Form -->

            </div>

            <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
                @include('frontend.sidebar')
            </div>
        </div>
    </div>
</section>



@push('front_scripts')

<script>
    $("#comment_form").submit(function(e) {
        e.preventDefault();
        $("#comment_submit_btn").prop('disabled',true)
        $("#name").html(' ')
        $("#email").html(' ')
        $("#message").html(' ')
        var plan_form = new FormData($(this)[0])
        $.ajax({
            type: "post",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/submit-comment/process',
            data: plan_form,
            success: function(data) {

                if(data.errors){
                    $("#comment_submit_btn").prop('disabled',false)

                    $("#name").html(data.errors.name)
                    $("#email").html(data.errors.email)
                    $("#message").html(data.errors.message)

                }else{

                    $("#name").html(' ')
                    $("#email").html(' ')
                    $("#message").html(' ')
                    $("#comment_submit_btn").attr('value','Thank you !')
                    setTimeout(function() {
                        $("#comment_submit_btn").prop('disabled',false)
                        $("#comment_submit_btn").attr('value','post comment')
                        $("#comment_form")[0].reset()
                    }, 2500);




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
