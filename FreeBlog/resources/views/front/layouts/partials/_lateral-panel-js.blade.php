	<script type="text/javascript">
		$(document).ready(function(){
			$('.tooltipped').tooltip({delay: 50});
		});

		function setCategoryIdValue(id){
			$('#category_id').val(id);
			$('#form-category-id').submit();
		}

		function setTagIdValue(id){
			$('#tag_id').val(id);
			$('#form-tag-id').submit();
		}
	</script>