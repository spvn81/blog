@extends('frontend.layout')

@php
use App\Helpers\getApp;
use App\Helpers\CustomBackEnd;

@endphp


@section('main_section')

@section('page_title','Home')
@section('description',getApp::description())
@section('keywords',getApp::keywords())










<!-- ======= Post Grid Section ======= -->
<section id="posts" class="posts">
    <div class="container" data-aos="fade-up">
        <div class="row g-5">


            @if(!empty($get_latest_post[0]))


            <div class="col-lg-4">
                <div class="post-entry-1 lg">
                    @if(!empty($get_latest_post[0]->main_image))

                    <a href="{{ url($get_latest_post[0]->category_link.'/'.$get_latest_post[0]->link) }}">

                        <img src="{{ url('storage/media/'.$get_latest_post[0]->main_image) }}" alt="{{ $get_latest_post[0]->page_title }}" class="img-fluid">


                    </a>
                    @endif
                    <div class="post-meta"><span class="date">{{ $get_latest_post[0]->categories }}</span> <span
                            class="mx-1">&bullet;</span> <span>
                            {{ \Carbon\Carbon::parse($get_latest_post[0]->updated_at)->diffForhumans() }}
                        </span></div>
                    <h2><a href="{{ url($get_latest_post[0]->category_link.'/'.$get_latest_post[0]->link) }}">{{
                            $get_latest_post[0]->page_title }}</a></h2>
                    <p class="mb-4 d-block">
                        {!! substr($get_latest_post[0]->small_description,0,600) !!}..
                        <a href="{{ url($get_latest_post[0]->category_link.'/'.$get_latest_post[0]->link) }}" class="text-capitalize " style="color:blue">continue to reading</a>

                    </p>

                    <div class="d-flex align-items-center author">
                        @if(!empty($get_latest_post[0]->avatar))
                                 <div class="photo"><img src="{{ url('storage/media/'.$get_latest_post[0]->avatar) }}" alt="{{ $get_latest_post[0]->publisher }}"
                                class="img-fluid"></div>
                                @endif


                        <div class="name">
                            <h3 class="m-0 p-0">{{ $get_latest_post[0]->publisher }}</h3>
                        </div>
                    </div>
                </div>

            </div>
            @endif




            <div class="col-lg-8">
                <div class="row g-5">


                    <div class="col-lg-4 border-start custom-border">


                        @foreach ($get_latest_post as $get_latest_post_data)
                        <div class="post-entry-1">
                            @if(!empty($get_latest_post_data[0]->main_image))
                            <a href="{{ url($get_latest_post_data->category_link.'/'.$get_latest_post_data->link) }}">

                                <img src="{{ url('storage/media/'.$get_latest_post_data->main_image) }}" alt="{{ $get_latest_post_data->page_name }}" class="img-fluid"></a>
                                @endif
                            <div class="post-meta"><span class="date">{{ $get_latest_post_data->categories }}</span>
                                <span class="mx-1">&bullet;</span> <span>
                                    {{ \Carbon\Carbon::parse($get_latest_post_data->updated_at)->diffForhumans() }}
                                </span>
                            </div>
                            <h2><a href="{{ url($get_latest_post_data->category_link.'/'.$get_latest_post_data->link) }}">{{
                                    $get_latest_post_data->page_name }}</a></h2>
                        </div>
                        @endforeach
                    </div>


                    <div class="col-lg-4 border-start custom-border">

                        @foreach ($get_latest_post_two as $get_latest_post_two_data)

                        <div class="post-entry-1">
                               @if(!empty($get_latest_post_two_data->main_image))
                            <a href="{{ url($get_latest_post_two_data->category_link.'/'.$get_latest_post_two_data->link) }}">


                                <img src="{{ url('storage/media/'.$get_latest_post_two_data->main_image) }}" alt="{{ $get_latest_post_two_data->page_name }}" class="img-fluid"></a>
                                    @endif


                            <div class="post-meta"><span class="date">{{ $get_latest_post_two_data->categories }}</span>
                                <span class="mx-1">&bullet;</span> <span>
                                    {{ \Carbon\Carbon::parse($get_latest_post_two_data->updated_at)->diffForhumans() }}

                                </span>
                            </div>
                            <h2><a
                                    href="{{ url($get_latest_post_two_data->category_link.'/'.$get_latest_post_two_data->link) }}">
                                    {{ $get_latest_post_two_data->page_name }}
                                </a></h2>
                        </div>
                        @endforeach




                    </div>

                    <!-- Trending Section -->
                    <div class="col-lg-4">

                        <div class="trending">
                            <h3>Trending</h3>
                            <ul class="trending-post">

                                @php
                                $i=1;
                                @endphp
                                @foreach ($get_trending_posts as $get_trending_posts_dadta )

                                <li>
                                    <a
                                        href="{{ url($get_trending_posts_dadta->category_link.'/'.$get_trending_posts_dadta->link) }}">
                                        <span class="number">{{ $i }}</span>
                                        <h3>{{ $get_trending_posts_dadta->page_title }}</h3>
                                        <span class="author">{{ $get_trending_posts_dadta->publisher }}</span>
                                    </a>
                                </li>

                                @php
                                $i++;
                                @endphp
                                @endforeach

                            </ul>
                        </div>

                    </div> <!-- End Trending Section -->
                </div>
            </div>

        </div> <!-- End .row -->
    </div>
</section> <!-- End Post Grid Section -->








<!-- =======  Category Section ======= -->

@foreach ($categories as $categories_data )

@php
  $categories_id = $categories_data->id;
@endphp


<section class="category-section">
    <div class="container" data-aos="fade-up">

        <div class="section-header d-flex justify-content-between align-items-center mb-5">
            <h2 class="text-uppercase">{{ $categories_data->categories }}</h2>
            <div><a href="{{ url($categories_data->link) }}" class="more">See All {{ $categories_data->categories }}</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">


                @if(!empty($post_with_categories[$categories_id][0]))
                <div class="d-lg-flex post-entry-2">
                    @if(!empty($post_with_categories[$categories_id][0]->main_image))
                    <a href="{{ url($post_with_categories[$categories_id][0]->category_link.'/'.$post_with_categories[$categories_id][0]->link) }}"
                        class="me-4 thumbnail mb-4 mb-lg-0 d-inline-block">

                        <img src="{{ url('storage/media/'.$post_with_categories[$categories_id][0]->main_image) }}"
                            alt="{{ $post_with_categories[$categories_id][0]->page_title }}" class="img-fluid">

                    </a>
                    @endif
                    <div>
                        <div class="post-meta"><span class="date">{{
                                $post_with_categories[$categories_id][0]->categories }}</span> <span
                                class="mx-1">&bullet;</span> <span>
                                {{
                                \Carbon\Carbon::parse($post_with_categories[$categories_id][0]->updated_at)->diffForhumans()
                                }}
                            </span></div>
                        <h3>
                            <a href="{{ url($post_with_categories[$categories_id][0]->category_link.'/'.$post_with_categories[$categories_id][0]->link) }}">{{
                                $post_with_categories[$categories_id][0]->page_title }}</a>
                        </h3>
                        {!! $post_with_categories[$categories_id][0]->small_description !!}..
                        <a href="{{ url( $post_with_categories[$categories_id][0]->category_link.'/'.$post_with_categories[$categories_id][0]->link) }}" class="text-capitalize " style="color:blue">continue to reading</a>
                        <div class="d-flex align-items-center author">
                            <div class="photo">
                                <img src="{{ url('storage/media/'.$post_with_categories[$categories_id][0]->avatar) }}"
                                    alt="{{ $post_with_categories[$categories_id][0]->publisher }}" class="img-fluid">
                            </div>
                            <div class="name">
                                <h3 class="m-0 p-0">{{ $post_with_categories[$categories_id][0]->publisher }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                @endif


                <div class="row">

                    @if(!empty($post_with_categories[$categories_id][1]))
                    <div class="col-lg-4">
                        <div class="post-entry-1 border-bottom">
                            @if(!empty($post_with_categories[$categories_id][1]->main_image))

                            <a href="{{ url($post_with_categories[$categories_id][1]->category_link.'/'.$post_with_categories[$categories_id][0]->link) }}">
                                <img src="{{ url('storage/media/'.$post_with_categories[$categories_id][1]->main_image) }}"
                                    alt="{{ $post_with_categories[$categories_id][1]->page_title }}" class="img-fluid"></a>
                                    @endif


                            <div class="post-meta"><span class="date">Culture</span> <span class="mx-1">&bullet;</span>
                                <span>
                                    {{
                                    \Carbon\Carbon::parse($post_with_categories[$categories_id][1]->updated_at)->diffForhumans()
                                    }}
                                </span>
                            </div>
                            <h2 class="mb-2">
                                <a
                                    href="{{ url($post_with_categories[$categories_id][1]->category_link.'/'.$post_with_categories[$categories_id][1]->link) }}">{{
                                    $post_with_categories[$categories_id][1]->page_title
                                    }}</a>
                            </h2>
                            <span class="author mb-3 d-block">{{$post_with_categories[$categories_id][1]->publisher}}</span>
                            <p class="mb-4 d-block">
                                {{ $post_with_categories[$categories_id][1]->small_description}}..
                        <a href="{{ url($post_with_categories[$categories_id][1]->category_link.'/'.$post_with_categories[$categories_id][1]->link) }}" class="text-capitalize " style="color:blue">continue to reading</a>
                            </p>
                        </div>


                        <div class="post-entry-1">
                            <div class="post-meta"><span class="date">{{
                                    $post_with_categories[$categories_id][1]->categories }}</span> <span
                                    class="mx-1">&bullet;</span> <span>
                                    {{
                                    \Carbon\Carbon::parse($post_with_categories[$categories_id][1]->updated_at)->diffForhumans()
                                    }}

                                </span></div>
                            <h2 class="mb-2"><a
                                    href="{{ url($post_with_categories[$categories_id][1]->category_link.'/'.$post_with_categories[$categories_id][1]->link) }}">{{
                                    $post_with_categories[$categories_id][1]->page_title }}</a></h2>
                            <span class="author mb-3 d-block">{{
                                $post_with_categories[$categories_id][1]->publisher}}</span>
                        </div>
                    </div>
                    @endif


                    @if(!empty($post_with_categories[$categories_id][2]))

                    <div class="col-lg-8">
                        <div class="post-entry-1">
                            @if(!empty($post_with_categories[$categories_id][2]->main_image))

                            <a href="{{ url($post_with_categories[$categories_id][2]->category_link.'/'.$post_with_categories[$categories_id][2]->link) }}"><img
                                    src="{{ url('storage/media/'.$post_with_categories[$categories_id][2]->main_image) }}"
                                    alt="{{ $post_with_categories[$categories_id][2]->page_title }}" class="img-fluid"></a>
                                @endif

                            <div class="post-meta"><span class="date">{{
                                    $post_with_categories[$categories_id][2]->categories }}</span> <span
                                    class="mx-1">&bullet;</span> <span>
                                    {{
                                    \Carbon\Carbon::parse($post_with_categories[$categories_id][2]->updated_at)->diffForhumans()
                                    }}

                                </span></div>
                            <h2 class="mb-2"><a
                                    href="{{ url($post_with_categories[$categories_id][2]->category_link.'/'.$post_with_categories[$categories_id][2]->link) }}">{{
                                    $post_with_categories[$categories_id][2]->page_title }}</a></h2>
                            <span class="author mb-3 d-block">{{
                                $post_with_categories[$categories_id][2]->publisher}}</span>
                            <p class="mb-4 d-block">
                                {{ $post_with_categories[$categories_id][2]->small_description}}..
                        <a href="{{ url($post_with_categories[$categories_id][2]->category_link.'/'.$post_with_categories[$categories_id][2]->link) }}" class="text-capitalize " style="color:blue">continue to reading</a>

                            </p>
                        </div>
                     </div>
                    @endif




                </div>
            </div>

            <div class="col-md-3">


                @foreach ( $post_with_categories[$categories_id] as $post_with_categories_data)

                <div class="post-entry-1 border-bottom">
                    <div class="post-meta"><span class="date">{{ $post_with_categories_data->categories }}</span> <span
                            class="mx-1">&bullet;</span> <span>
                            {{ \Carbon\Carbon::parse($post_with_categories_data->updated_at)->diffForhumans() }}

                        </span></div>
                    <h2 class="mb-2"><a href="{{ url($post_with_categories_data->category_link.'/'.$get_latest_post[0]->link) }}">{{
                            $post_with_categories_data->page_title }}</a></h2>
                    <span class="author mb-3 d-block">{{ $post_with_categories_data->publisher }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endforeach



@endsection
