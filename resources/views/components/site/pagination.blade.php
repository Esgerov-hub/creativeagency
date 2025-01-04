@if( $posts->lastPage() > 1)
<div id="pagination">
    <ul>
        <!-- Previous Page Link -->
        @if (!$posts->onFirstPage())
            <li class="arrow_prev">
                <a href="{{ $posts->previousPageUrl() }}">
                    <img src="{{ asset('site/assets/images/svg/pagination_arrow.svg') }}" alt="" />
                </a>
            </li>
        @endif

    <!-- Page Numbers -->
        @foreach (range(1, $posts->lastPage()) as $i)
            @if ($i == 1 || $i == $posts->lastPage() || abs($posts->currentPage() - $i) <= 1)
            <!-- İlk, sonuncu və cari səhifəyə yaxın səhifələr -->
                <li class="page-item {{ $posts->currentPage() == $i ? 'active' : '' }}">
                    <a href="{{ $posts->url($i) }}">{{ $i }}</a>
                </li>
            @elseif (($i == 2 && $posts->currentPage() > 3) || ($i == $posts->lastPage() - 1 && $posts->currentPage() < $posts->lastPage() - 2))
            <!-- Nöqtələr (1-dən sonra və son səhifədən əvvəl) -->
                <li class="dots">
                    <span>...</span>
                </li>
            @endif
        @endforeach

    <!-- Next Page Link -->
        @if ($posts->hasMorePages())
            <li class="arrow_next">
                <a href="{{ $posts->nextPageUrl() }}">
                    <img src="{{ asset('site/assets/images/svg/pagination_arrow.svg') }}" alt="" class="arrow_next_img" />
                </a>
            </li>
        @endif
    </ul>
</div>
    @endif
