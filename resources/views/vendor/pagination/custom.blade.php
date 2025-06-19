@if ($paginator->hasPages())
<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="disabled"><a href="#"><i class="ti-arrow-left"></i></a></li>
    @else
        <li><a href="{{ $paginator->previousPageUrl() }}"><i class="ti-arrow-left"></i></a></li>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="disabled page-item"><span>{{ $element }}</span></li>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active"><a href="#">{{ $page }}</a></li>
                @else
                    <li class><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li><a href="{{ $paginator->nextPageUrl() }}"><i class="ti-arrow-right"></i></a></li>
    @else
        <li class="disabled"><a href="#"><i class="ti-arrow-right"></i></a></li> 
    @endif
</ul>
@endif 