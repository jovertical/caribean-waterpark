@if ($paginator->hasPages())
    <div class="page__pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-prev">
                <i class="fa fa-caret-left"></i>
            </span>            
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                <i class="fa fa-caret-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="current">{{ $page }}</span></li>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="pagination-next" href="{{ $paginator->nextPageUrl() }}" rel="next">
                <i class="fa fa-caret-right"></i>
            </a>
        @else
            <i class="fa fa-caret-right"></i>
        @endif
    </div>
@endif