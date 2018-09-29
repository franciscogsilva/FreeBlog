@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">
				<div class="card-panel card-panel-table-factories">
			        <div class="head-edit">
			            <div class="section">              
							@if(isset($category))
								<p class="caption-title center-align">Editar Categoria</p>
							@else 
			               		<p class="caption-title center-align">Crear nueva Categoria</p>
							@endif
			            </div>
        				@include('admin.layouts.partials._messages')
			            <div class="section ">
			                @if(isset($category))
			                    {!! Form::open(['route' => ['categories.update', $category->id], 'method' => 'PUT', 'onsubmit' => 'preloader()']) !!}
			                @else 
			                    {!! Form::open(['route' => 'categories.store', 'method' => 'POST', 'onsubmit' => 'preloader()']) !!}
			                @endif
			                	<div class="row">
				                    <div class="input-field col s12 m12 l12">
				                        <i class="material-icons prefix">subject</i>
				                        {!! Form::text('name', isset($category)?$category->name:null, ['class' => '', 'required', 'id' => 'name']) !!}
				                        <label for="name">Nombre de la Categoria</label>
				                    </div>
				                </div>
			                    <div class="buttonpanel-edit center-align">
			                        <a href="{{ route('categories.index') }}" class="btn waves-effect waves-light grey" onclick="return confirm('¿Desea cancelar la creación la Categoria?')">Cancelar</a>              
			                      @if(isset($category))
			                        {!! Form::submit('Editar', ['class' => 'btn waves-effect btn-fgs-edit postulation-btn', 'id' => 'postulation-btn']) !!}
			                      @else 
			                        {!! Form::submit('Crear', ['class' => 'btn waves-effect btn-fgs-edit postulation-btn', 'id' => 'postulation-btn']) !!}
			                      @endif
									<div class="postulate-preloader" id="postulate-preloader" style="display: none;">
										<div class="preloader-wrapper big active">
											<div class="spinner-layer spinner-red-only">
												<div class="circle-clipper left">
													<div class="circle"></div>
												</div>
												<div class="gap-patch">
													<div class="circle"></div>
												</div>
												<div class="circle-clipper right">
													<div class="circle"></div>
												</div>
											</div>
										</div>	
									</div>
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
		function preloader(){
			Materialize.toast('Cargando recursos, este proceso puede tardar un poco', 2000, 'orange darken-1');
			$('#postulation-btn').hide();
			$('.postulation-btn').hide();
			$('#postulate-preloader').show();
		}
	</script>						
@endsection