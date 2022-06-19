@extends('frontend.layout')

@section('main_section')






<section class="single-post-content">
    <div class="container">
        <div class="row">



            <div class="col-md-9" data-aos="fade-up">


                <h3 class="category-title">{{ count($search) }} Search Results</h3>

                @foreach ($search as  $search_data)

                <div class="d-md-flex post-entry-2 small-img">
                    @if(!empty($search_data->main_image))
                  <a href="{{ url($search_data->category_link.'/'.$search_data->link) }}" class="me-4 thumbnail">
                    <img src="{{ url('storage/media/'. $search_data->main_image) }}" alt="{{ $search_data->page_title }}" class="img-fluid">
                  </a>
                  @endif
                  <div>
                    <div class="post-meta"><span class="date">{{ $search_data->categories }}</span> <span class="mx-1">&bullet;</span> <span>
                        {{ \Carbon\Carbon::parse($search_data->updated_at)->diffForhumans() }}
                    </span></div>
                    <h3><a href="{{ url($search_data->category_link.'/'.$search_data->link) }}">
                        {{ $search_data->page_title }}
                    </a></h3>


                    {!! $search_data->small_description !!}


                    <div class="d-flex align-items-center author">
                        @if(!empty($search_data->avatar))
                      <div class="photo">
                          <img src="{{ url('storage/media/'. $search_data->avatar) }}" alt="" class="img-fluid">
                        </div>
                        @endif
                      <div class="name">
                        <h3 class="m-0 p-0">{{ $search_data->publisher }}</h3>
                      </div>
                    </div>
                  </div>
                </div>

                @endforeach




                <div class="text-start py-4">

                    {{ $search->links('vendor.pagination.custom_pagination')  }}

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
