@if ($paginator->hasPages())
    <div class="shop_page_nav d-flex flex-row">

        {{-- Previous Page Link --}}

        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
            <div class="page_prev d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-chevron-left"></i>
            </div>
            </a>
        @endif
    
        <ul class="page_nav d-flex flex-row">

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="bg-primary text-light" style="cursor: default" aria-current="page"><strong>{{ $page }}</strong></li>
                        @else
                            <li><a style="padding: 12px 22px" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

        </ul>

        {{-- Next Page Link --}}

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
            <div class="page_next d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-chevron-right"></i>
            </div>
        </a>
        @endif

    </div>
@endif
