<form class="form-horizontal" method="post" action="@if (isset($certification)){{ URL::to('admin/certifications/' . $certification->id . '/edit') }}@endif" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->

	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<!-- certifications.name -->
			<div class="form-group {{{ $errors->has('name') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="name">Certification Name</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($certification) ? $certification->name : null) }}}" />
					{{{ $errors->first('name', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ certifications.name -->

			<!-- certifications.description -->
			<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="description">Description Certification Name</label>
				<div class="col-md-10">
					<input class="form-control" type="text" name="description" id="description" value="{{{ Input::old('description', isset($certification) ? $certification->description : null) }}}" />
					{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ certifications.description -->

			<!-- Activation Status -->
			<div class="form-group {{{ $errors->has('published') || $errors->has('published') ? 'error' : '' }}}">
				<label class="col-md-2 control-label" for="confirm">Published</label>
				<div class="col-md-6">
					@if ($mode == 'create')
					<select class="form-control" name="published" id="published">
						<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
						<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
					</select>
					@else
					<select class="form-control" name="published" id="published">
						<option value="1"{{{ (Input::old('published', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
						<option value="0"{{{ (Input::old('published', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
					</select>
					@endif
					{{{ $errors->first('published', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>
			<!-- ./ activation status -->
		</div>
		<!-- ./ general tab -->
	</div>
	<!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<element class="btn-cancel close_popup">Cancel</element>
			<button type="reset" class="btn btn-default">Reset</button>
			<button type="submit" class="btn btn-success">OK</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
