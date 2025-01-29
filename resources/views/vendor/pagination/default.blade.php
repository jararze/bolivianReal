@if ($paginator->hasPages())
    <div class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="prev page-numbers disabled"><i class="fa fa-angle-left"></i></span>
        @else
            <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}">
                <i class="fa fa-angle-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="page-numbers">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-numbers current">{{ $page }}</span>
                    @else
                        <a class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">
                <i class="fa fa-angle-right"></i>
            </a>
        @else
            <span class="next page-numbers disabled">
                <i class="fa fa-angle-right"></i>
            </span>
        @endif
    </div>
@endif
