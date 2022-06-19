@extends('frontend.layout')

@section('main_section')
<section class="single-post-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9" data-aos="fade-up">
                <div class="row">
                    @foreach ($gallery_files as $gallery_files_data )
                        @if($gallery_files_data->file_type=='image')
                        <div class="col-md-4">
                            <a href="{{ url('storage/media/'.$gallery_files_data->file_name) }}" class="glightbox">
                                <img src="{{ url('storage/media/'.$gallery_files_data->file_name) }}" alt="image" / width="100%" height="200">
                              </a>
                        </div>
                        @endif

                        @if($gallery_files_data->file_type=='video')
                        <div class="col-md-4">
                        <a href="{{ url('storage/media/'.$gallery_files_data->file_name) }}" class="glightbox" data-gallery="gallery1">
                            @if(!empty($gallery_files_data->video_thumbnail))


                            <div class="card bg-dark text-white">
                                <img class="card-img" src="{{ url('storage/media/'.$gallery_files_data->video_thumbnail) }}" alt="Card image"  width="100%" height="200">
                                <div class="card-img-overlay">
                                    <i class="bi bi-collection-play" style="font-size: 50px"></i>

                                </div>
                              </div>


                            @else

                            <div class="card bg-dark text-white">
                                <img class="card-img" src="{{ asset('front/img/video-player.png') }}" alt="Card image"  width="100%" height="200">
                                <div class="card-img-overlay">
                                    <i class="bi bi-collection-play" style="font-size: 50px"></i>

                                </div>
                              </div>


                            @endif

                          </a>
                        </div>
                        @endif
                        @endforeach


                </div>
            </div>
            <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
                @include('frontend.sidebar')
            </div>
        </div>
    </div>
</section>







@endsection
