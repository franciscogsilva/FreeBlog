	<?php
		$route = "";
		switch ($menu_item) {
		    case 2:
		    	$route = route('users.create');
		        break;
		}
	?>
	<div class="fixed-action-btn">
		<a class="waves-effect waves-light btn-floating btn-large teal z-depth-3 create-new-fgs pulse tooltipped" data-position="left" data-delay="50" data-tooltip="Crear Nuevo" href="{{ $route }}">
			<i class="large material-icons">add</i>
		</a>		
	</div>