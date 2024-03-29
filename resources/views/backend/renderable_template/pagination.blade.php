<div class="row">
    <div class="col-lg-12">
        <div class="box box-primary box-borderless">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        @if ($query->hasPages())
                        <ul class="pagination small">
                            <!-- {{-- Previous Page Link --}} -->
                            @if ($query->onFirstPage())
                            <li class="disabled"><a class="page-link"><span>&lsaquo;</span></a></li>
                            @else
                            <li><a href="{{ $query->previousPageUrl() }}" rel="prev" class="page-link">&lsaquo;</a></li>
                            @endif

                            @if($query->currentPage() > 3)
                            <li class="hidden-xs"><a href="{{ $query->url(1) }}" class="page-link">1</a></li>
                            @endif
                            @if($query->currentPage() > 4)
                            <li><a class="page-link"><span>...</span></a></li>
                            @endif
                            @foreach(range(1, $query->lastPage()) as $i)
                            @if($i >= $query->currentPage() - 2 && $i <= $query->currentPage() + 2)
                                @if ($i == $query->currentPage())
                                <li class="active"><a class="page-link"><span>{{ $i }}</span></a></li>
                                @else
                                <li><a href="{{ $query->url($i) }}" class="page-link">{{ $i }}</a></li>
                                @endif
                                @endif
                                @endforeach
                                @if($query->currentPage() < $query->lastPage() - 3)
                                    <li><a class="page-link"><span>...</span></a></li>
                                    @endif
                                    @if($query->currentPage() < $query->lastPage() - 2)
                                        <li class="hidden-xs"><a href="{{ $query->url($query->lastPage()) }}"
                                                class="page-link">{{ $query->lastPage() }}</a>
                                        </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($query->hasMorePages())
                                        <li><a href="{{ $query->nextPageUrl() }}" rel="next"
                                                class="page-link">&rsaquo;</a></li>
                                        @else
                                        <li class="disabled"><a class="page-link"><span>&rsaquo;</span></a></li>
                                        @endif
                        </ul>
                        @endif
                    </div>
                    <div class="col-sm-6 text-right">
                        <?php
                        $pagcountst = ($query->currentPage() - 1) * $itemPerPage + 1;
                        $pagcountnd = ($query->currentPage() - 1) * $itemPerPage + $query->count();
                        $currentItem = '';
                        if ($pagcountnd == 0 || $pagcountst > $pagcountnd) {
                            $current = '0';
                        } elseif ($pagcountst == $pagcountnd) {
                            $current = $pagcountnd;
                            $currentItem = __('no.') . ' ';
                        } else {
                            $current = $pagcountst . ' - ' . $pagcountnd;
                        }
                        ?>
                        <div class="pagination-text">{!! __('showing: :currentItem <span>:current</span> of
                            <span>:total</span> :itemname',['currentItem'=>$currentItem, 'current'=>$current,
                            'total'=>$query->total(), 'itemname'=>$itemName]) !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>