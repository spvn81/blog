


@if ($paginator->hasPages())
<div class="float-right">


    <div class="btn-group">


        <ul class="pagination">

            @if ($paginator->onFirstPage())


                <button type="button" class="btn btn-default btn-sm">

                    @lang('pagination.previous')
                         </button>


            @else


                <a href="{{ $paginator->previousPageUrl() }}" ><button type="button" class="btn btn-default btn-sm">

                    @lang('pagination.previous')
                    </button></a>


            @endif



            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())


                <a href="{{ $paginator->nextPageUrl() }}"  >
                    <button type="button" class="btn btn-default btn-sm">
                    @lang('pagination.next')
                    </button></a>

            @else
                <button type="button" class="btn btn-default btn-sm">

                    @lang('pagination.next')</button>

            @endif
        </ul>


    </div>
    </div>
@endif

