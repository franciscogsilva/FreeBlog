@extends('front.layouts.front_layout')

@section('content')
	<div class="parallax-container">
		<div class="parallax"><img src="{{ asset('img/system32/header-home.jpg') }}"></div>
		<div id="page-title" class="container">
            <h1><a href="{{ route('welcome') }}" class="title-top">{{ isset($title_page)?$title_page:env('APP_NAME') }}</a></h1>
        </div>
	</div>
	<div class="section white">
		<div class="row container index-container">
			<div class="col s12 m12 l8">
				<div class="card">
					<div class="card-image">
						<img src="{{ $article->image->image }}">
					</div>
					<div class="card-content">
						<div class="card-header-index">
							<span class="card-title card-title-index">{{ $article->title }}</span>
							<div class="card-icons">
								<ul>
									<li><i class="material-icons">calendar_today</i>{{ $article->created_at->diffForHumans() }}</li>
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
									<li><i class="material-icons">remove_red_eye</i>{{ $article->countViews($article) }}</li>
								</ul>								
							</div>
						</div>
						<div class="card-content-index">
							{!! $article->content !!}
						</div>
						<div class="card-footer-index">
							@foreach($article->tags as $tag)
								<a href="{{ route('welcome', ['tag_id' => $tag->id]) }}"><div class="chip">{{ $tag->name }}</div></a>
							@endforeach								
						</div>
						<div class="social_sharing" style="text-align: center;">
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('articles.show-front', $article->slug) }}" class="popup popup-facebook">
								<span class="icon"><i class="fa fa-facebook"></i></span>
								<span class="text">Facebook</span>
							</a>
							<a target="_blank" href="http://twitter.com/home?status={{ $article->title }} {{ route('articles.show-front', $article->slug) }}" class="popup popup-twitter">
								<span class="icon"><i class="fa fa-twitter"></i></span>
							</a>
							<a target="_blank" href="//plus.google.com/share?url={{ route('articles.show-front', $article->slug) }}" class="popup popup-google">
								<span class="icon"><i class="fa fa-google-plus"></i></span>
							</a>
						</div>
					</div>
				</div>
			</div>
			@include('front.layouts.partials._lateral-panel')
		</div>
	</div>
@endsection()

@section('js')
	@include('front.layouts.partials._lateral-panel-js')
@endsection()