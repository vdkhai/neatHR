<form id="country" name="country" class="form-horizontal" method="post" action="@if (isset($country)){{ URL::to('admin/countries/' . $country->id . '/edit') }} @else {{ URL::to('admin/countries/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="name">{{{ Lang::get('form.name') }}}</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($country) ? $country->name : null) }}}" />
				<span class="has-error" id="error-name"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="iso_code_2">ISO Code 2</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="iso_code_2" id="iso_code_2" value="{{{ Input::old('iso_code_2', isset($country) ? $country->iso_code_2 : null) }}}" />
				<span class="has-error" id="error-iso_code_2"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="iso_code_3">ISO Code 3</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="iso_code_3" id="iso_code_3" value="{{{ Input::old('iso_code_3', isset($country) ? $country->iso_code_3 : null) }}}" />
				<span class="has-error" id="error-iso_code_3"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="address_format">Address Format</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="address_format" id="address_format" value="{{{ Input::old('address_format', isset($country) ? $country->address_format : null) }}}" />
				<span class="has-error" id="error-address_format"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="postcode_required">Postcode Required</label>
			<div class="col-md-9">
				<input class="form-control" type="text" name="postcode_required" id="postcode_required" value="{{{ Input::old('postcode_required', isset($country) ? $country->postcode_required : null) }}}" />
				<span class="has-error" id="error-postcode_required"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label" for="confirm">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-9">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($country) ? $country->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($country) ? $country->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
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
		var url = '{{ URL::to("admin/countries/create") }}';
	@else
	var url = '{{ URL::to("admin/countries/" . $country->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#country')[0].reset();
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
			var form = $('form#country');
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
