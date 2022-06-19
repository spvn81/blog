<div class="custom-pagination">

@if ($paginator->hasPages())

        @if ($paginator->onFirstPage())

                <a class="prev" href="#" >Previous</a>

        @else

                <a class="prev" href="{{ $paginator->previousPageUrl() }}">Previous</a>

        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                           @if ($page == $paginator->currentPage())<a  class="active">{{ $page }}</a>

                                @else

                            <a href="{{ $url }}" >{{ $page }}</a>

                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())

                <a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>

        @else

                <a class="next" href="#">Next</a>

        @endif

@endif
</div>











