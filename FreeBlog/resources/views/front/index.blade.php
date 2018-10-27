@extends('front.layouts.front_layout')

@section('content')
	<a href="{{ route('welcome') }}" class="title-top">
		<div class="parallax-container">
			<div class="parallax"><img src="{{ asset('img/system32/header-home.jpg') }}"></div>
			<!--
			<div id="page-title" class="container">
	            <h1>{{ isset($title_page)?$title_page:env('APP_NAME') }}</h1>
	        </div>
    		-->
    	</div>
    </a>
	<div class="section white">
		<div class="row container index-container">
			<div class="col s12 m12 l8">
				@if(count($articles)==0)
					<h1>No se encuentran resultados ...</h1>
				@else 
					@foreach($articles as $article)
						<div class="card">
							<div class="card-image">
								<a href="{{ route('articles.show-front', $article->slug) }}"><img src="{{ $article->image->image }}"></a>
								<a href="{{ route('articles.show-front', $article->slug) }}" class="btn-floating btn-large halfway-fab waves-effect waves-light"><i class="material-icons">more_horiz</i></a>
							</div>
							<div class="card-content">
								<div class="card-header-index">
									<span class="card-title card-title-index"><a class="a-title" href="{{ route('articles.show-front', $article->slug) }}">{{ $article->title }}</a></span>
									<div class="card-icons">
										<ul>
											<li><i class="material-icons">calendar_today</i>{{ $article->created_at->diffForHumans() }}</li>
											<!--
											<li><i class="material-icons">favorite</i>
												@if(count($article->likes) < 1000)
													{{ count($article->likes) }}
												@else
													{{ count($article->likes)/1000 }}k
												@endif
											</li>
											<li><i class="material-icons">feedback</i>
												@if(count($article->comments) < 1000)
													{{ count($article->comments) }}
												@else
													{{ count($article->comments)/1000 }}k
												@endif
											</li>
										-->
											<li><i class="material-icons">remove_red_eye</i>{{ $article->views }}</li>
										</ul>								
									</div>
								</div>
								<div class="card-content-index">
									{!! $article->content = str_limit($article->content, 300) !!}
								</div>
								<div class="card-footer-index">
									@foreach($article->tags as $tag)
										<a href="{{ route('welcome', ['tag_id' => $tag->id]) }}"><div class="chip">{{ $tag->name }}</div></a>
									@endforeach								
								</div>
							</div>
						</div>
					@endforeach
				@endif
				<?php $paginator = $articles;?>
			    @include('layouts.partials._paginator')
			</div>
			@include('front.layouts.partials._lateral-panel')
		</div>
	</div>
@endsection()

@section('js')
	@include('front.layouts.partials._lateral-panel-js')
@endsection()