@extends('frontend.layout')

@section('main_section')


@if(!empty($post_by_category[0]->categories))
@section('page_title',$post_by_category[0]->categories)
@endif


@if(!empty($post_by_category[0]->cat_description))
@section('description',$post_by_category[0]->cat_description)
@endif

@if(!empty($post_by_category[0]->cat_keywords))
@section('keywords',$post_by_category[0]->cat_keywords)
@endif




<section class="single-post-content">
    <div class="container">
        <div class="row">
            <div class="col-md-9" data-aos="fade-up">

                @if(!empty($album[0]))
                <div class="row">

                    @foreach ($album as  $album_data)

            <div class="col-md-4">
                <a href="{{ url('gallery/'.$category.'/'.$album_data->link) }}" >
                    @if(!empty($album_data->album_thumbnail))
                    <img src="{{ url('storage/media/'.$album_data->album_thumbnail) }}" alt="image" / width="100%" height="200">
                        @else
                        <img src="{{ asset('front/img/no-thumbnail-medium.png') }}" alt="image" / width="100%" height="200">
                        @endif
                        <h4 class="text-uppercase">{{ strlen($album_data->name)<18?$album_data->name:substr($album_data->name,0,17).'..' }}</h4>

                    </a>
                </div>
                @endforeach




                </div>
                @endif




                @if(!empty($post_by_category[0]))
                <h3 class="category-title">Category: {{ $post_by_category[0]->categories  }}</h3>
                @foreach ($post_by_category as  $post_by_category_data)
                <div class="d-md-flex post-entry-2 half">
                    @if(!empty($post_by_category_data->main_image))
                    <a href="{{ url($post_by_category_data->category_link.'/'.$post_by_category_data->link) }}" class="me-4 thumbnail">
                        <img src="{{ url('storage/media/'.$post_by_category_data->main_image) }}" alt="{{ $post_by_category_data->page_title }}" class="img-fluid">
                    </a>
                    @endif
                    <div>
                        <div class="post-meta"><span class="date">{{ $post_by_category_data->categories }}</span> <span class="mx-1">&bullet;</span> <span>
                             {{ \Carbon\Carbon::parse($post_by_category_data->updated_at)->diffForhumans() }}
                            </span></div>
                        <h3><a href="{{ url($post_by_category_data->category_link.'/'.$post_by_category_data->link) }}">{{ $post_by_category_data->page_title }}</a></h3>
                        {!! $post_by_category_data->small_description !!}
                        ..
                        <a href="{{ url($post_by_category_data->category_link.'/'.$post_by_category_data->link) }}" class="text-capitalize " style="color:blue">continue to reading</a>

                        <div class="d-flex align-items-center author">
                            @if(!empty($post_by_category_data->avatar))
                            <div class="photo">
                                <img src="{{ url('storage/media/'. $post_by_category_data->avatar) }}" alt="" class="img-fluid">
                            </div>
                            @endif
                            <div class="name">
                                <h3 class="m-0 p-0">{{ $post_by_category_data->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="text-start py-4">

                        {{ $post_by_category->links('vendor.pagination.custom_pagination')  }}

                 </div>
                @endif






            </div>








            <div class="col-md-3">
                <!-- ======= Sidebar ======= -->
                @include('frontend.sidebar')
            </div>
        </div>
    </div>
</section>







@endsection
