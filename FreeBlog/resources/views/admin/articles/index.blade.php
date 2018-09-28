@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">	
                <div class="card-panel card-panel-search-fgs">	
					@include('admin.layouts.partials._messages')				
					{!! Form::open(['route' => 'articles.index', 'method' => 'GET'], ['class' => 's12 m12 l12']) !!}
						<div class="row row-search-fgs">
							<div class="file-field input-field col s12 m12 l9 input-search-fgs">
								<div class="file-path-wrapper path-wrapper-fgs center-text">
									<input id="search" type="text" class="validate" name="search">
									<label class="label-search-fgs" for="icon_prefix">Buscar articulo por titulo, nombre o email de autor</label>
								</div>
							</div>
		                    	{!! Form::submit('Buscar', ['class' => 'btn btn-search-fgs col s10 m11 l2 btn-fgs-edit']) !!}
							<div id="btn-filters" class="btn col s2 m1 l1 btn-fgs-filter center-align btn-fgs-edit waves-effect waves-light">
								<span class="center-align"><i class="material-icons icon-filter">keyboard_arrow_down</i></span>
							</div>
						</div>
						<div class="section section-form">
                        	<div class="row" id="panel-filters">
								<div class="input-field col s12 m6 l6">
									<i class="material-icons prefix">visibility_off</i>
									<select id="article_status_id" name="article_status_id">
										<option value="" disabled selected>Selecciona un estado</option>
										@foreach($articleStatuses as $status)
											<option value="{{ $status->id }}">{{ $status->name }}</option>
										@endforeach
									</select>
									<label for="article_status_id">Filtrar por Estado</label>
								</div>
								<div class="input-field col s12 m6 l6">
									<i class="material-icons prefix">content_paste</i>
									<select id="category_id" name="category_id">
										<option value="" disabled selected>Selecciona una categoria</option>
										@foreach($categories as $category)
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endforeach
									</select>
									<label for="category_id">Filtrar por categoria</label>
								</div>
								<div class="input-field col s12 m6 l6">
									<i class="material-icons prefix">visibility_off</i>
									<select id="tag_id" name="tag_id">
										<option value="" disabled selected>Selecciona un tag</option>
										@foreach($tags as $tag)
											<option value="{{ $tag->id }}">{{ $tag->name }}</option>
										@endforeach
									</select>
									<label for="tag_id">Filtrar por Tag</label>
								</div>								
                        	</div>
                        </div>
	                {!! Form::close() !!}
				</div>
				<div class="card-panel card-panel-table-factories">
					<div class="card-content">
						{!! Form::open(['route' => 'articles.multi_destroy', 'method' => 'POST'], ['class' => '']) !!}
						<div class="row row-delete-all">							
							<div class="btn red darken-3 right" id="multipleDelete" onclick="multiDelete()">Borrar Varios</div>							
							<div class="btn red darken-3 right cancel_multipleDelete" id="cancel_multipleDelete" onclick="cancel_multipleDelete()" style="display: none;"><i class="material-icons">clear</i></div>
							{!! Form::submit('Borrar', ['class' => 'btn red darken-3 right', 'onclick' => 'return confirm("¿Desea borrar los articulos seleccionados?")', 'id' => 'multiDeleteAction', 'style' => 'display: none;']) !!}	
						</div>
			     		<table class="highlight striped">
							<thead>
								<th>Titulo</th>
								<th>Estado</th>
								<th id="td-logo">Autor</th>
								<th class="center-align">Opciones</th>
							</thead>
							<tbody>
								@foreach($articles as $publication)
								<tr>									
									<td>{{ $publication->title }}</td>
									@if($publication->status->id == 1)
										<td id="td-sector" class="center-align">
											<span class="badge green badge-status-factory center-text">{{ $publication->status->name }}</span>
										</td>
									@elseif($publication->status->id == 2)
										<td id="td-sector" class="center-align">
											<span class="badge blue badge-status-factory center-text">{{ $publication->status->name }}</span>
										</td>
									@endif
									<td id="td-logo">{{ $publication->user->name }}</td>
									<td class="td-fgs center-align">
										<div class="btn multi_input_delete" style="display: none;">
											<input name="items_to_delete[]" type="checkbox" class="filled-in filled-in-fgs" id="input_{{$publication->id}}" value="{{$publication->id}}"/>
      										<label for="input_{{$publication->id}}"></label>
										</div>
	                					{!! Form::close() !!}
										<a href="{{ route('articles.destroy', $publication->id) }}" onclick="return confirm('¿Desea borrar la publicación?')" class="btn btn-fgs btn-fgs-delete red darken-3"><i class="material-icons">delete</i></a>
										<a href="{{ route('articles.edit', $publication->id) }}" class="btn btn-raised btn-primary btn-fgs btn-fgs-edit"><i class="material-icons">create</i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
			        </div>
				</div>
			</div>
        </div>
    </div>
	<?php $paginator = $articles;?>
    @include('admin.layouts.partials._paginator')
    @include('admin.layouts.partials._fixed_button_create')
@endsection()

@include('admin.layouts.partials._js_filters')