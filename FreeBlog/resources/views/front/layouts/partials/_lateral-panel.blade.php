			<div class="col s12 m12 l4">
				<div class="card-panel card-panel-index">
					{!! Form::open(['route' => 'welcome', 'method' => 'GET']) !!}
						<input id="search_name" type="text" class="validate" name="search" placeholder="Buscar Aquí">
						<button id="btn-search-index" class="btn-floating btn-large halfway-fab waves-effect waves-light" type="submit"><i class="material-icons">search</i></button>
	                {!! Form::close() !!}
				</div>
				<h5 class="title-index">Categorias</h5>
				<ul class="category">
					{!! Form::open(['route' => 'welcome', 'method' => 'GET', 'id' => 'form-category-id']) !!}
						<input type="hidden" name="category_id" id="category_id">
						@foreach($categories as $category)
							<li>
								<a onclick="setCategoryIdValue('{{ $category->id }}')" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="{{ count($category->articles)===1?count($category->articles).' articulo':count($category->articles).' articulos' }}">{{ $category->name }}</a>
							</li>
						@endforeach
	                {!! Form::close() !!}
				</ul>
				<h5 class="title-index">Articulos Populares</h5>				
				<div class="card-panel card-panel-popular-index">
					@foreach($popularArticles as $article)
						<div class="row">
							<a href="{{ route('articles.show-front', $article->slug) }}" class="a-title valign-wrapper">
								<div class="col s4 col-img-popular">
									<img src="{{ $article->image->image }}" class="responsive-img img-popular-index">
								</div>
								<div class="col s8">
									<p class="popular-articles-title">{{ $article->title }}</p>
									<div class="popular-content">
										{!! $article->content = str_limit($article->content, 80) !!}									
									</div>
								</div>
							</a>
						</div>
					@endforeach
				</div>
				<h5 class="title-index">Tags</h5>
				<ul class="category">
					{!! Form::open(['route' => 'welcome', 'method' => 'GET', 'id' => 'form-tag-id']) !!}
						<input type="hidden" name="tag_id" id="tag_id">
						@foreach($tags as $tag)
							<li>
								<a onclick="setTagIdValue('{{ $tag->id }}')" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="{{ count($tag->articles)===1?count($tag->articles).' articulo':count($tag->articles).' articulos' }}">{{ $tag->name }}</a>
							</li>
						@endforeach
	                {!! Form::close() !!}
				</ul>
			</div>