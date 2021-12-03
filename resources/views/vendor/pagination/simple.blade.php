@if ($paginator->hasPages())
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="btn btn-outline-secondary rounded-circle">
            <i class="fa fa-angle-down fa-2x"></i>
        </a>
    @endif
@endif
