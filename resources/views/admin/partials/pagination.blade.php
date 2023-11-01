<div class="pagination-wrapper">
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a class="prev page-numbers__disabled pagination__disabled" href="javascript:;">{{ __('Предыдущая') }}</a>
        @else
            <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}">{{ __('Предыдущая') }}</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a class="page-numbers pagination__disabled" href="javascript:;">{{ $element }}</a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="page-numbers current">{{ $page }}</span>
                    @else
                        <a class="page-numbers" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}">{{ __('Следующая') }}</a>
        @else
            <a class="next page-numbers__disabled pagination__disabled" href="javascript:;">{{ __('Следующая') }}</a>
        @endif
    </div>
</div>
