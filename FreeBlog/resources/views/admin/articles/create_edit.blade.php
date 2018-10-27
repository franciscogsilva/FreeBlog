@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">
				<div class="card-panel card-panel-table-factories">
			        <div class="head-edit">
			            <div class="section">              
							@if(isset($article))
								<p class="caption-title center-align">Editar Articulo</p>
							@else 
			               		<p class="caption-title center-align">Crear nuevo Articulo</p>
							@endif
			            </div>
        				@include('admin.layouts.partials._messages')
			            <div class="section ">
			                @if(isset($article))
			                    {!! Form::open(['route' => ['articles.update', $article->id], 'method' => 'PUT', 'files' => 'true'], ['class' => 'form-container col s12 center-block']) !!}
			                @else 
			                    {!! Form::open(['route' => 'articles.store', 'method' => 'POST', 'files' => 'true'], ['class' => 'form-container col s12 center-block']) !!}
			                @endif
			                    <div class="input-field col s12 m12 l12">
			                        <i class="material-icons prefix">description</i>
			                        {!! Form::text('title', isset($article)?$article->title:null, ['class' => '', 'required', 'id' => 'title']) !!}
			                        <label for="title">Titulo de la Articulo</label>
			                    </div>
								<div class="row">
									<div class="input-field col s12 m12 l12">
			                        <span class="txt-title">Contenido</span>
										{!! Form::textArea('content', isset($article)?$article->content:null, ['class' => 'textArea_content', 'required', 'id' => 'content']) !!}
									</div>
								</div>
								@include('admin.layouts.partials._images_alert_image')
								<div class="row">									
									<div class="file-field input-field col s12 m12 l12">
										<div class="btn btn-fgs-edit">
											<span>Imagen</span>
											<input id="image" type="file" name="image" value="{{isset($article)?$article->image:''}}">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text" placeholder="Selecciona la imagen de la Articulo"">
										</div>
										<div class="center-align">
											<img id="image_container" src="{{isset($article)?$article->image->image:''}}" class="responsive-img img-preview-fgs"/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="input-field col s12 m6 l6">
										<i class="material-icons prefix">person</i>
										<select id="user_id" class="icons" name="user_id">
											<option value="" disabled selected>Selecciona el Autor</option>
											@foreach($users as $user)
												@if(isset($article))
													<option value="{{ $user->id }}" {{($user->id===$article->user->id)?'selected=selected':''}}>{{ $user->name }}</option>
												@else 
													<option value="{{ $user->id }}">{{ $user->name }}</option>
												@endif
											@endforeach
										</select>
										<label for="user_id">Autor</label>
									</div>
									<div class="input-field col s12 m6 l6">
										<i class="material-icons prefix">person</i>
										<select id="article_status_id" class="icons" name="article_status_id">
											<option value="" disabled selected>Selecciona el Estado</option>
											@foreach($articleStatuses as $status)
												@if(isset($article))
													<option value="{{ $status->id }}" {{($status->id===$article->status->id)?'selected=selected':''}}>{{ $status->name }}</option>
												@else 
													<option value="{{ $status->id }}">{{ $status->name }}</option>
												@endif
											@endforeach
										</select>
										<label for="article_status_id">Estado</label>
									</div>
									<div class="input-field col s12 m6 l6">
										<i class="material-icons prefix">tune</i>
										<select id="categories" class="icons" name="categories[]" multiple>
											<option value="" disabled selected>Selecciona la/las categoria</option>
											@foreach($categories as $category)
												@if(isset($article))
													<option value="{{ $category->id }}" {{in_array($category->id, $article->categories->pluck('id')->ToArray())?'selected=selected':''}}>{{ $category->name }}</option>
												@else 
													<option value="{{ $category->id }}">{{ $category->name }}</option>
												@endif
											@endforeach
										</select>
										<label for="categories">Categorias</label>
									</div>
									<div class="input-field col s12 m6 l6">
										<i class="material-icons prefix">tune</i>
										<select id="tags" class="icons" name="tags[]" multiple>
											<option value="" disabled selected>Selecciona el/los tags</option>
											@foreach($tags as $tag)
												@if(isset($article))
													<option value="{{ $tag->id }}" {{in_array($tag->id, $article->tags->pluck('id')->ToArray())?'selected=selected':''}}>{{ $tag->name }}</option>
												@else 
													<option value="{{ $tag->id }}">{{ $tag->name }}</option>
												@endif
											@endforeach
										</select>
										<label for="tags">Tags</label>
									</div>
								</div>
		                    	<div class="row"></div>
			                    <div class="buttonpanel-edit center-align">
			                        <a href="{{ route('articles.index') }}" class="btn waves-effect waves-light grey" onclick="return confirm('¿Desea cancelar la creación del Articulo?')" >Cancelar</a>              
			                      @if(isset($article))
			                        {!! Form::submit('Editar', ['class' => 'btn waves-effect btn-fgs-edit', 'type' => 'button']) !!}
			                      @else 
			                        {!! Form::submit('Crear', ['class' => 'btn waves-effect btn-fgs-edit', 'type' => 'button']) !!}
			                      @endif
			                    </div>
			                {!! Form::close() !!}              
			            </div>
			        </div>
				</div>
			</div>
        </div>
    </div>
@endsection()

@section('js')
	<script type="text/javascript">
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#image_container').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}	
		}

		$("#image").change(function() {
			readURL(this);
		});

    	$('.textArea_content').trumbowyg({
		    removeformatPasted: true
		});

    	$('#article_type_id').on('change', function(){
			if($('#article_type_id option:selected').val() == "3"){
				$('#event_options').toggle();
        		$('.timepicker').pickatime();
			}else if($('#article_type_id option:selected').val() != "3"){
				$('#event_options').hide();
			}
		});
	</script>						
@endsection