<form id="state" name="state" class="form-horizontal" method="post" action="@if (isset($state)){{ URL::to('admin/states/' . $state->id . '/edit') }} @else {{ URL::to('admin/states/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="country_id">Country</label>
			<div class="col-md-6">
				{{ Form::select('country_id', $countries, Input::old('country_id'), array('id' => 'country_id', 'class' => 'form-control')) }}
				{{{ $errors->first('country_id', '<span class="help-inline">:message</span>') }}}
				<span class="has-error" id="error-country_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="name">{{{ Lang::get('form.name') }}}</label>
			<div class="col-md-10">
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($state) ? $state->name : null) }}}" />
				<span class="has-error" id="error-name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="code">Code</label>
			<div class="col-md-10">
				<input class="form-control" type="text" name="code" id="code" value="{{{ Input::old('code', isset($state) ? $state->code : null) }}}" />
				<span class="has-error" id="error-code"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-10">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($state) ? $state->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($state) ? $state->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
				</select>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">{{{ Lang::get('button.close') }}}</button>
		<button type="button" class="btn btn-primary" id="resetId">{{{ Lang::get('button.reset') }}}</button>
		<button type="button" class="btn btn-primary" id="saveId">{{{ Lang::get('button.save') }}}</button>
	</div>
</form>
@section('scripts')
<script type="text/javascript">
	var reload = false;
	@if ($mode == 'create')
		var url = '{{ URL::to("admin/states/create") }}';
	@else
	var url = '{{ URL::to("admin/states/" . $state->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#state')[0].reset();
			$(this).closest('form').find('span').each(function(){
				if($(this).hasClass('has-error'))
					$(this).html('');
			});
		});

		$('#saveId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset from data
			var form = $('form#state');
			var data = $(form).serialize();
			$(form.find('span')).each(function(){
				if($(this).hasClass('has-error'))
					$(this).html('');
			});

			$.ajax({
				url: url,
				data: data,
				dataType: 'json',
				method: 'POST',
				success: function(returnData) {
					var returnObj = $.parseJSON(returnData);
					if(returnObj.failedValidate){
						$($.parseJSON(returnObj.messages)).each(function(i, val){
							$.each(val, function(k, v){
								$('#error-'+k).html(v);
							});
						});
					}else{
						$(returnObj.messages).each(function(i, val){
							$.each(val, function(k, v){
								if(k == 'success'){
									$('#notifyDiv').html(v + '<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-success');
									reload = true;
								} else {
									$('#notifyDiv').html(v + '<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-danger');
								}

							});
						});

						if(reload == true){
							parent.oTable.fnReloadAjax();
						}
					}
				},
				error: function(){
					$('#notifyDiv').html('Save fail<a class="close" data-dismiss="alert" href="#">&times;</a>').addClass('alert').addClass('alert-danger');
				}
			});
		});
	});
</script>
@section('scripts')
