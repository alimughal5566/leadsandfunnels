@if ($paginator->hasPages())
    <div class="pagination-block">
        <div class="row">
            <div class="col-6">
                <div class="pagination-block__box">
                    <span>Funnels per page</span>
                    <ul class="pagination">
                        <li class="active @if($paginator->total() < 10) disabled @endif"><a href="{{ $paginator->path() . '?page=' . $paginator->currentPage() }}&perPage=10">10</a></li>
                        <li class="@if($paginator->total() < 25) disabled @endif"><a href="{{ $paginator->path() . '?page=' . $paginator->currentPage() }}&perPage=25">25</a></li>
                        <li class="@if($paginator->total() < 50) disabled @endif"><a href="{{ $paginator->path() . '?page=' . $paginator->currentPage() }}&perPage=50">50</a></li>
                        <li class="@if($paginator->total() < 100) disabled @endif"><a href="{{ $paginator->path() . '?page=' . $paginator->currentPage() }}&perPage=100">100</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-6">
                <div class="pagination-block__box justify-content-end">
                    <span>Page</span>
                    <ul class="pagination">
                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="active"><a href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
