<form id="organizationstructure" name="organizationstructure" class="form-horizontal" method="post" action="@if (isset($organizationstructure)){{ URL::to('admin/organizationstructures/' . $organizationstructure->id . '/edit') }} @else {{ URL::to('admin/organizationstructures/create') }} @endif " autocomplete="off">
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="modalLabel">{{{ $title }}}</h4>
	</div>
	<div class="modal-body">
		<div class="" id="notifyDiv"></div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="title">Title</label>
			<div class="col-md-10">
				<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($organizationstructure) ? $organizationstructure->title : null) }}}" />
				<span class="has-error" id="error-title"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="description">{{{ Lang::get('form.desc') }}}</label>
			<div class="col-md-10">
				<textarea class="form-control" rows="3" name="description" id="description">{{{ Input::old('description', isset($organizationstructure) ? $organizationstructure->description : null) }}}</textarea>
				<span class="has-error" id="error-description"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="address">Address</label>
			<div class="col-md-10">
				<textarea for="address" class="form-control" rows="3" name="address" id="address">{{{ Input::old('address', isset($organizationstructure) ? $organizationstructure->address : null) }}}</textarea>
				<span class="has-error" id="error-address"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="organization_type_id">Type</label>
			<div class="col-md-6">
				{{ Form::select('organization_type_id', $organizationTypes, Input::old('organization_type_id'), array('id' => 'organization_type_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-organization_type_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="country_id">Country</label>
			<div class="col-md-6">
				{{ Form::select('country_id', $countries, Input::old('country_id'), array('id' => 'country_id', 'class' => 'form-control')) }}
				<span class="has-error" id="error-country_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="organization_parent_id">Organization Parent</label>
			<div class="col-md-6">
				{{ Form::select('organization_parent_id', array_merge(array('0' => 'Please Select'), $organizationParents), Input::old('organization_parent_id'), array('id' => 'organization_parent_id', 'class' => 'form-control')) }}
				<span class="has-error" id="organization_parent_id"></span>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="published">{{{ Lang::get('form.published') }}}</label>
			<div class="col-md-10">
				<select class="form-control" name="published" id="published">
					<option value="1"{{{ (Input::old('published', isset($organizationstructure) ? $organizationstructure->published : 1) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('published', isset($organizationstructure) ? $organizationstructure->published : 1) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
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
		var url = '{{ URL::to("admin/organizationstructures/create") }}';
	@else
	var url = '{{ URL::to("admin/organizationstructures/" . $organizationstructure->id . "/edit") }}';
	@endif
	$(document).ready(function() {
		$('#resetId').click(function(e){
			e.preventDefault();

			// Reset notify message
			$('#notifyDiv').removeClass('alert').removeClass('alert-success').removeClass('alert-danger').html('');

			// Reset form data
			$('form#organizationstructure')[0].reset();
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
			var form = $('form#organizationstructure');
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
