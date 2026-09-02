@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between" aria-label="Page navigation">
        <div>
            <p class="small text-muted mb-0">
                {!! __('Showing') !!}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <ul class="pagination mb-0">
            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item first disabled" aria-disabled="true">
                    <span class="page-link"><i class="icon-base bx bx-chevrons-left icon-sm"></i></span>
                </li>
            @else
                <li class="page-item first">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')">
                        <i class="icon-base bx bx-chevrons-left icon-sm"></i>
                    </a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item prev disabled" aria-disabled="true">
                    <span class="page-link"><i class="icon-base bx bx-chevron-left icon-sm"></i></span>
                </li>
            @else
                <li class="page-item prev">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="icon-base bx bx-chevron-left icon-sm"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item next">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="icon-base bx bx-chevron-right icon-sm"></i>
                    </a>
                </li>
            @else
                <li class="page-item next disabled" aria-disabled="true">
                    <span class="page-link"><i class="icon-base bx bx-chevron-right icon-sm"></i></span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item last">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="@lang('pagination.last')">
                        <i class="icon-base bx bx-chevrons-right icon-sm"></i>
                    </a>
                </li>
            @else
                <li class="page-item last disabled" aria-disabled="true">
                    <span class="page-link"><i class="icon-base bx bx-chevrons-right icon-sm"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
