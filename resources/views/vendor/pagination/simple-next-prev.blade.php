@if ($paginator->hasPages())
    <nav role="navigation" class="pagination-wrapper">
        <ul class="pagination-list">
            @if ($paginator->onFirstPage())
                <li class="disabled" aria-disabled="true">
                    <span>Prethodna stranica</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Prethodna stranica</a>
                </li>
            @endif

            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">Sljedeća stranica</a>
                </li>
            @else
                <li class="disabled" aria-disabled="true">
                    <span>Sljedeća stranica</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
