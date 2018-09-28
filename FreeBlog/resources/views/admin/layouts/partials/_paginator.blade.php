	<div class="row center-align">
		@if ($paginator->lastPage() > 1)
			<ul class="pagination">
				<!--@if ($paginator->currentPage() != 1 && $paginator->lastPage() >= 5)
					<li><a href="{{ $paginator->url($paginator->url(1)) }}"><<</a></li>
				@endif-->
				<li class="{{ $paginator->currentPage()==1?'disabled':'' }}"><a href="{{ $paginator->url($paginator->currentPage()-1) }}"><i class="material-icons">chevron_left</i></a></li>
				@for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+4,$paginator->lastPage()); $i++)
					<li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
				@endfor
				<li class="{{ $paginator->currentPage()==$paginator->lastPage()?'disabled':'' }}"><a href="{{ $paginator->url($paginator->currentPage()+1) }}"><i class="material-icons">chevron_right</i></a></li>
				<!--@if ($paginator->currentPage() != $paginator->lastPage() && $paginator->lastPage() >= 5)
					<li><a href="{{ $paginator->url($paginator->lastPage()) }}">>></a></li>
				@endif-->
			</ul>
		@endif
    </div>