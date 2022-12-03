@if ($paginator->hasPages())
    
<div class="col-md-12">
    <div class="post-pagination">
        @if ($paginator->onFirstPage())
            <a href="#" class="btn disabled pagination-back pull-left">@lang('web.back')</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-back pull-left">@lang('web.back')</a>
        @endif

        <ul class="pages">
            @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            {{-- @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif --}}

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active">{{ $page }}</li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
            @endforeach
        </ul>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-next pull-right">@lang('web.next')</a>
        @else
            <a href="#" class="btn disabled pagination-next pull-right">@lang('web.next')</a>
        @endif
    </div>
</div>

@endif