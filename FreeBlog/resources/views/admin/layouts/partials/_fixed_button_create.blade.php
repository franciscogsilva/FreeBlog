	<?php
		$route = "";
		switch ($menu_item) {
		    case 1:
		    	$route = route('articles.create');
		        break;
		    case 2:
		    	$route = route('users.create');
		        break;
		    case 3:
		    	$route = route('categories.create');
		        break;
		    case 4:
		    	$route = route('tags.create');
		        break;
		}
	?>
	<div class="fixed-action-btn">
		<a class="waves-effect waves-light btn-floating btn-large teal z-depth-3 create-new-fgs pulse tooltipped" data-position="left" data-delay="50" data-tooltip="Crear Nuevo" href="{{ $route }}">
			<i class="large material-icons">add</i>
		</a>		
	</div>