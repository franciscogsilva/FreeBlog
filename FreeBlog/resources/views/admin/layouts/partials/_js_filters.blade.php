@section('js')
	<script>
		$("#btn-filters").click(function(event){
			$("#panel-filters").toggle();
			if($("#panel-filters").is(':visible')){
				$(".icon-filter").html("keyboard_arrow_up");				
			}else{
				$(".icon-filter").html("keyboard_arrow_down");				
			}
		});
	</script>
@endsection