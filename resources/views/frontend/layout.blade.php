<!DOCTYPE html>
<html lang="en">

@php
use App\Helpers\getApp;
use App\Helpers\CustomBackEnd;
$getSocialLinks = getApp::getSocialLinks();


@endphp

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>{{ getApp::title() }} - @yield('page_title')</title>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">





    <!-- Favicons -->
    <link href="{{ url('storage/media/'.getApp::favicon()) }}" rel="icon">
    <link href="{{ url('storage/media/'.getApp::favicon()) }}" rel="apple-touch-icon">


    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- Template Main CSS Files -->
    <link href="{{ asset('front/assets/css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: ZenBlog - v1.0.0
  * Template URL: https://bootstrapmade.com/zenblog-bootstrap-blog-template/
  * Author: BootstrapMade.com
  * License: https:///bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="{{ url('/') }}" class="logo d-flex align-items-center">


                @if(getApp::show_logo()==1)
            <img src="{{ url('storage/media/'.getApp::logo()) }}" alt="{{ getApp::getAppName() }}">
               @endif


              @if(getApp::show_title()==1)
                <h1>{{ getApp::title() }} </h1>
                @endif
            </a>



            <nav id="navbar" class="navbar">




                {!! getTopNavCat() !!}




            </nav><!-- .navbar -->

            <div class="position-relative">

                @foreach ($getSocialLinks as  $getSocialLinks_data)
                <a href="{{ $getSocialLinks_data->link }}" target="_blank" class="mx-2"><span class="{{ $getSocialLinks_data->fount_awesome_class }}"></span></a>
                @endforeach








                <a href="#" class="mx-2 js-search-open"><span class="bi-search"></span></a>
                <i class="bi bi-list mobile-nav-toggle"></i>

                <!-- ======= Search Form ======= -->
                <div class="search-form-wrap js-search-form-wrap" id="searchbox">

                    <form action="{{ url('search/post/data') }}"  method="get" class="search-form ">

                        <span class="icon bi-search"></span>
                        <input type="text" placeholder="Search" name="q" class="form-control">




                     </form>

                </div><!-- End Search Form -->

            </div>

        </div>

    </header><!-- End Header -->

    <main id="main">




        @section('main_section')

        @show


    </main><!-- End #main -->


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="footer-content">
            <div class="container">

                <div class="row g-5">

                    <div class="col-lg-4">
                        <h3 class="footer-heading">About {{ getApp::title() }}</h3>
                        <p>
                            {{ getApp::description() }}

                        </p>


                        <p><a href="{{ getApp::about_page_ink() }}" class="footer-link-more">Learn More</a></p>
                    </div>




                    @php
                        $footer_links = CustomBackEnd::getFooterLinks();
                    @endphp

                    @foreach ( $footer_links as   $footer_links_data)
                    {!!  $footer_links_data !!}
                    @endforeach


                    <div class="col-lg-4">
                        <h3 class="footer-heading">Recent Posts</h3>

                        <ul class="footer-links footer-blog-entry list-unstyled">

                             @php
                            $get_latest_post = get_latest_post(5);
                            @endphp
                            @foreach ($get_latest_post as $get_latest_post_data )

                            <li>

                                <a href="{{ url($get_latest_post_data->category_link.'/'.$get_latest_post_data->link) }}" class="d-flex align-items-center">
                                    @if(!empty($get_latest_post_data->main_image))
                                      <img src="{{ url('storage/media/'.$get_latest_post_data->main_image) }}"
                                        alt="{{ $get_latest_post_data->page_title }}" class="img-fluid me-3">
                                        @endif
                                    <div>
                                        <div class="post-meta d-block"><span class="date">{{
                                                $get_latest_post_data->categories }}</span> <span
                                                class="mx-1">&bullet;</span> <span>
                                                {{
                                                \Carbon\Carbon::parse($get_latest_post_data->updated_at)->diffForhumans()
                                                }}
                                            </span></div>
                                        <span>{{ $get_latest_post_data->page_title }}</span>

                                    </div>
                                </a>



                            </li>
                            @endforeach

                        </ul>

                    </div>
                </div>
            </div>
        </div>

        <div class="footer-legal">
            <div class="container">

                <div class="row justify-content-between">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <div class="copyright">
                            © Copyright {{ Date('Y') }} <strong><span>{{ getApp::getAppName() }}</span></strong>.
                        </div>

                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/herobiz-bootstrap-business-template/ -->
                            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> &  {!! getApp::copyRight() !!}
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="social-links mb-3 mb-lg-0 text-center text-md-end">

                            @foreach ($getSocialLinks as  $getSocialLinks_data)
                            <a href="{{ $getSocialLinks_data->link }}" target="_blank"><i class="{{ $getSocialLinks_data->fount_awesome_class }}"></i></a>
                            @endforeach


                        </div>

                    </div>

                </div>

            </div>
        </div>

    </footer>

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i></a>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('front/assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>



    @stack('front_scripts')


</body>

</html>
