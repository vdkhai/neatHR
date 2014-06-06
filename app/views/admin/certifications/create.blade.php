<form id="formId" class="form-horizontal" method="post" action="{{ URL::to('admin/certifications/create') }}" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="smartHRModalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
			<!-- certifications.name -->
			<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
				<label class="col-md-4 control-label" for="name">Certification Name</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($certification) ? $certification->name : null) }}}" />
					{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ certifications.name -->

			<!-- certifications.description -->
			<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
				<label class="col-md-4 control-label" for="description">Description Certification Name</label>
				<div class="col-md-8">
					<input class="form-control" type="text" name="description" id="description" value="{{{ Input::old('description', isset($certification) ? $certification->description : null) }}}" />
					{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ certifications.description -->

			<!-- Activation Status -->
			<div class="form-group {{{ $errors->has('published') || $errors->has('published') ? 'error' : '' }}}">
				<label class="col-md-4 control-label" for="confirm">Published</label>
				<div class="col-md-8">
					<select class="form-control" name="published" id="published">
						<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
						<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
					</select>
					{{{ $errors->first('published', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ activation status -->
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" id="resetId">Reset</button>
		<button type="button" class="btn btn-primary" id="saveId">Save</button>
	</div>
<!-- ./ form actions -->
</form>
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#saveId').click(function(e){
			e.preventDefault();
			submitData();
		}
	});

	function submitData() {
		var data = $('formId').serialize();
		$.ajax({
			url: '{{ URL::to("admin/certifications/create") }}',
			data: data,
			dataType: 'json',
			method: 'POST',
			success: function(result) {
				if(result.errors){
					var x = 1;
				}else{
					var y = 2;
				}
			}
		});
	};
</script>
@section('scripts')
