<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel">Modal title</h4>
</div>
<div class="modal-body">
	<!-- Content -->
	@yield('content')
	<!-- ./ content -->
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary">Save changes</button>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('.close_popup').click(function () {
			parent.oTable.fnReloadAjax();
			parent.jQuery.fn.colorbox.close();
			return false;
		});
		$('#deleteForm').submit(function (event) {
			var form = $(this);
			$.ajax({
				type: form.attr('method'),
				url : form.attr('action'),
				data: form.serialize()
			}).done(function () {
					parent.jQuery.colorbox.close();
					parent.oTable.fnReloadAjax();
				}).fail(function () {
				});
			event.preventDefault();
		});
	});
	$('.wysihtml5').wysihtml5();
	$(prettyPrint)
</script>


