@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">	
                <div class="card-panel card-panel-search-fgs">	
					@include('admin.layouts.partials._messages')				
					{!! Form::open(['route' => 'users.index', 'method' => 'GET'], ['class' => 's12 m12 l12']) !!}
						<div class="row row-search-fgs">
							<div class="file-field input-field col s12 m12 l9 input-search-fgs">
								<div class="file-path-wrapper path-wrapper-fgs center-text">
									<input id="search" type="text" class="validate" name="search">
									<label class="label-search-fgs" for="icon_prefix">Buscar usuario por nombre o email</label>
								</div>
							</div>
		                    	{!! Form::submit('Buscar', ['class' => 'btn btn-search-fgs col s10 m11 l2 btn-fgs-edit']) !!}
							<div id="btn-filters" class="btn col s2 m1 l1 btn-fgs-filter center-align btn-fgs-edit waves-effect waves-light">
								<span class="center-align"><i class="material-icons icon-filter">keyboard_arrow_down</i></span>
							</div>
						</div>
						<div class="section section-form">
                        	<div class="row" id="panel-filters">
								<div class="input-field col s12 m6 l12">
									<i class="material-icons prefix">school</i>
									<select id="user_type_id" name="user_type_id">
										<option value="" disabled selected>Selecciona un tipo de Usuario</option>
										@foreach($userTypes as $type)
											<option value="{{ $type->id }}">{{ $type->name }}</option>
										@endforeach
									</select>
									<label for="user_type_id">Filtrar por Tipo de Usuario</label>
								</div>								
                        	</div>
                        </div>
	                {!! Form::close() !!}
	                <div class="row"></div>
				</div>
				<div class="card-panel card-panel-table-factories">
					<div class="card-content">
			     		<table class="highlight striped">
							<thead>
								<th id="td-logo"></th>
								<th>Nombre</th>
								<th>Tipo</th>
								<th>Opciones</th>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td id="td-logo">
										<img class="factory-logo-fgs responsive-img circle materialboxed" src="{{ $user->image }}">
									</td>									
									<td>{{ $user->name }}</td>									
									<td>
										@if($user->type->id == 1)
											<span class="badge red badge-status-factory center-text">
										@elseif($user->type->id == 2)
											<span class="badge blue badge-status-factory center-text">
										@endif
										{{ $user->type->name }}</span>
									</td>
									<td class="td-fgs center-align">
										<a href="{{ route('users.destroy', $user->id) }}" onclick="return confirm('¿Desea borrar el Usuario?')" class="btn btn-fgs btn-fgs-delete red darken-3"><i class="material-icons">delete</i></a>
										<a href="{{ route('users.edit', $user->id) }}" class="btn btn-raised btn-primary btn-fgs btn-fgs-edit"><i class="material-icons">create</i></a>
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
	<?php $paginator = $users; ?>
    @include('admin.layouts.partials._paginator')
    @include('admin.layouts.partials._fixed_button_create')
@endsection()

@include('admin.layouts.partials._js_filters')