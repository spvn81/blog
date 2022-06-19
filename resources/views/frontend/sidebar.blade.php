



                <div class="aside-block">

                    <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Trending</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">




                        <!-- Trending -->
                        <div class="tab-pane fade show active" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">



                           @php
                            $get_trending_posts_html =   get_trending_posts_html();
                            $get_latest_post_html = get_latest_post_html();
                            $get_category = get_category();
                            $get_tags = get_tags();
                           @endphp

                           @foreach ($get_trending_posts_html as $get_trending_posts_html_data )
                            {!! $get_trending_posts_html_data  !!}
                           @endforeach


                        </div>
                        <!-- End Trending -->

                        <!-- Latest -->
                        <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
                            @foreach ($get_latest_post_html as $get_latest_post_html_data )
                            {!! $get_latest_post_html_data  !!}
                           @endforeach
                        </div>
                        <!-- End Latest -->

                    </div>
                </div>




                <div class="aside-block">
                    <h3 class="aside-title">Categories</h3>
                    <ul class="aside-links list-unstyled">
                        @foreach ($get_category as $categories_data )
                        <li><a href="{{ url($categories_data->link) }}"><i class="bi bi-chevron-right"></i>{{ $categories_data->categories}}</a></li>
                        @endforeach

                    </ul>
                </div>
                <!-- End Categories -->

                <div class="aside-block">
                    <h3 class="aside-title">Tags</h3>
                    <ul class="aside-tags list-unstyled">
                    @foreach ($get_tags as $get_tags_data )
                        <li><a href="{{ url( $get_tags_data->category_link) }}">{{ $get_tags_data->categories }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <!-- End Tags -->

