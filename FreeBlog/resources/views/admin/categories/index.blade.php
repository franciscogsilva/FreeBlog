@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">	
                <div class="card-panel card-panel-search-fgs">	
					@include('admin.layouts.partials._messages')				
					{!! Form::open(['route' => 'categories.index', 'method' => 'GET'], ['class' => 's12 m12 l12']) !!}
						<div class="row row-search-fgs">
							<div class="file-field input-field col s12 m12 l9 input-search-fgs">
								<div class="file-path-wrapper path-wrapper-fgs center-text">
									<input id="name" type="text" class="validate" name="name">
									<label class="label-search-fgs" for="icon_prefix">Buscar categoria por nombre</label>
								</div>
							</div>
		                    	{!! Form::submit('Buscar', ['class' => 'btn btn-search-fgs col s10 m11 l2 btn-fgs-edit']) !!}
							<div id="btn-filters" class="btn col s2 m1 l1 btn-fgs-filter center-align btn-fgs-edit waves-effect waves-light">
								<span class="center-align"><i class="material-icons icon-filter">keyboard_arrow_down</i></span>
							</div>
						</div>
						<div class="section section-form">
                        	<div class="row" id="panel-filters">
								
                        	</div>
                        </div>
	                {!! Form::close() !!}
				</div>
				<div class="card-panel card-panel-table-factories">
					<div class="card-content">
						{!! Form::open(['route' => 'categories.multi_destroy', 'method' => 'POST'], ['class' => '']) !!}
						<div class="row row-delete-all">							
							<div class="btn red darken-3 right" id="multipleDelete" onclick="multiDelete()">Eliminar Varios</div>							
							<div class="btn red darken-3 right cancel_multipleDelete" id="cancel_multipleDelete" onclick="cancel_multipleDelete()" style="display: none;"><i class="material-icons">clear</i></div>
							{!! Form::submit('Eliminar', ['class' => 'btn red darken-3 right', 'onclick' => 'return confirm("¿Desea Eliminar las categorias seleccionados?")', 'id' => 'multiDeleteAction', 'style' => 'display: none;']) !!}	
						</div>
			     		<table class="highlight striped">
							<thead>
								<th>Nombre</th>
								<th># Articulos</th>
								<th class="center-align">Opciones</th>
							</thead>
							<tbody>
								@foreach($categories as $category)
									<tr>									
										<td>{{ $category->name }}</td>
										<td class="center-align">
											{{ count($category->articles) }}
										</td>
										<td class="td-fgs center-align">
											<div class="btn multi_input_delete" style="display: none;">
												<input name="items_to_delete[]" type="checkbox" class="filled-in filled-in-fgs" id="input_{{$category->id}}" value="{{$category->id}}"/>
	      										<label for="input_{{$category->id}}"></label>
											</div>
		                					{!! Form::close() !!}
											<a href="{{ route('categories.destroy', $category->id) }}" onclick="return confirm('¿Desea Eliminar la categoria?')" class="btn btn-fgs btn-fgs-delete red darken-3 {{ !Auth::user()->isAdmin()?'disabled':'' }}"><i class="material-icons">delete</i></a>
											<a href="{{ route('categories.edit', $category->id) }}" class="btn btn-raised btn-primary btn-fgs btn-fgs-edit {{ !Auth::user()->isAdmin()?'disabled':'' }}"><i class="material-icons">create</i></a>
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
	<?php $paginator = $categories;?>
    @include('admin.layouts.partials._paginator')
    @include('admin.layouts.partials._fixed_button_create')
@endsection()

@include('admin.layouts.partials._js_filters')