{{-- @push('styles') --}}
<style>
    .shop_page_nav {
        width: 100%;
        height: 50px;
        margin-top: 80px;
    }

    .page_prev,
    .page_next {
        width: 50px;
        height: 100%;
        border: solid 1px #e5e5e5;
        border-radius: 5px;
        cursor: pointer;
    }

    .page_prev i,
    .page_next i {
        font-size: 12px;
        color: #e5e5e5;
        -webkit-transition: all 200ms ease;
        -moz-transition: all 200ms ease;
        -ms-transition: all 200ms ease;
        -o-transition: all 200ms ease;
        transition: all 200ms ease;
    }

    .page_prev:hover i,
    .page_next:hover i {
        color: #636363;
    }

    .page_nav {
        border: solid 1px #e5e5e5;
        border-radius: 5px;
        margin-left: 15px;
        margin-right: 15px;
    }

    .page_nav li {
        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        border-right: solid 1px #e5e5e5;
        cursor: pointer;
    }

    .page_nav li a {
        font-weight: 500;
        color: rgba(0, 0, 0, 0.7);
        -webkit-transition: all 200ms ease;
        -moz-transition: all 200ms ease;
        -ms-transition: all 200ms ease;
        -o-transition: all 200ms ease;
        transition: all 200ms ease;
    }

    .page_nav li:hover a {
        color: #0e8ce4;
    }

    .page_nav li:last-child {
        border-right: none;
    }
</style>
{{-- @endpush --}}

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