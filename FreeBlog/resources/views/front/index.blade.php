@extends('front.layouts.front_layout')

@section('content')
	<div class="parallax-container">
		<div class="parallax"><img src="{{ asset('img/system32/header-home.jpg') }}"></div>
		<div id="page-title" class="container">
            <h1>{{ isset($title_page)?$title_page:env('APP_NAME') }}</h1>
        </div>
	</div>
	<div class="section white">
		<div class="row container index-container">
			<div class="col s12 m12 l8">
				@foreach($articles as $article)
					<div class="card">
						<div class="card-image">
							<img src="{{ $article->image->image }}">
							<a class="btn-floating btn-large halfway-fab waves-effect waves-light red"><i class="material-icons">add</i></a>
						</div>
						<div class="card-content">
							<span class="card-title">{{ $article->title }}</span>
							<p>{!! $article->content = str_limit($article->content, 300) !!}</p>
						</div>
					</div>
				@endforeach
			</div>
			<div class="col s12 m12 l8">
				
			</div>
		</div>
	</div>
@endsection()