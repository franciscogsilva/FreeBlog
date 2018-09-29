@extends('admin.layouts.admin_layout')

@section('content')
	<div class="container container-fgs">
        <div class="row">	
			<div class="col s12 m12 l12">
				<div class="card-panel card-panel-table-factories">
			        <div class="head-edit">
			            <div class="section">              
							@if(isset($tag))
								<p class="caption-title center-align">Editar Tag</p>
							@else 
			               		<p class="caption-title center-align">Crear nuevo Tag</p>
							@endif
			            </div>
        				@include('admin.layouts.partials._messages')
			            <div class="section ">
			                @if(isset($tag))
			                    {!! Form::open(['route' => ['tags.update', $tag->id], 'method' => 'PUT', 'onsubmit' => 'preloader()']) !!}
			                @else 
			                    {!! Form::open(['route' => 'tags.store', 'method' => 'POST', 'onsubmit' => 'preloader()']) !!}
			                @endif
			                	<div class="row">
				                    <div class="input-field col s12 m12 l12">
				                        <i class="material-icons prefix">subject</i>
				                        {!! Form::text('name', isset($tag)?$tag->name:null, ['class' => '', 'required', 'id' => 'name']) !!}
				                        <label for="name">Nombre del Tag</label>
				                    </div>
				                </div>
			                    <div class="buttonpanel-edit center-align">
			                        <a href="{{ route('tags.index') }}" class="btn waves-effect waves-light grey" onclick="return confirm('¿Desea cancelar la creación del Tag?')">Cancelar</a>              
			                      @if(isset($tag))
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