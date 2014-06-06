@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<!-- Tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		</ul>
	<!-- ./ tabs -->

	<form class="form-horizontal" method="post" action="@if (isset($organizationstructure)){{ URL::to('admin/organizationstructures/' . $organizationstructure->id . '/edit') }}@endif" autocomplete="off">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->

		<!-- Tabs Content -->
		<div class="tab-content">
			<!-- General tab -->
			<div class="tab-pane active" id="tab-general">
				<!-- organizationstructures.title -->
				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="title">Title</label>
					<div class="col-md-10">
						<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($organizationstructure) ? $organizationstructure->title : null) }}}" />
						{{{ $errors->first('title', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ organizationstructures.title -->

				<!-- organizationstructures.description -->
				<div class="form-group {{{ $errors->has('description') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="description">Detail</label>
					<div class="col-md-10">
						<textarea for="description" class="form-control" rows="3" name="description" id="description">{{{ Input::old('description', isset($organizationstructure) ? $organizationstructure->description : null) }}}</textarea>
						{{{ $errors->first('description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ organizationstructures.description -->

				<!-- organizationstructures.address -->
				<div class="form-group {{{ $errors->has('address') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="address">Address</label>
					<div class="col-md-10">
						<textarea for="address" class="form-control" rows="3" name="address" id="address">{{{ Input::old('address', isset($organizationstructure) ? $organizationstructure->address : null) }}}</textarea>
						{{{ $errors->first('address', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ organizationstructures.address -->

				<!-- Organization Type -->
				<div class="form-group {{{ $errors->has('organization_type_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="organization_type_id">Type</label>
					<div class="col-md-6">
						{{ Form::select('organization_type_id', $organizationTypes, Input::old('organization_type_id'), array('id' => 'organization_type_id', 'class' => 'form-control')) }}
						{{{ $errors->first('organization_type_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ organization type -->

				<!-- Country -->
				<div class="form-group {{{ $errors->has('country_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="country_id">Country</label>
					<div class="col-md-6">
						{{ Form::select('country_id', $countries, Input::old('country_id'), array('id' => 'country_id', 'class' => 'form-control')) }}
						{{{ $errors->first('country_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ country -->

				<!-- Orgazniation Parent ID -->
				<div class="form-group {{{ $errors->has('organization_parent_id') ? 'error' : '' }}}">
					<label class="col-md-2 control-label" for="organization_parent_id">Organization Parent</label>
					<div class="col-md-6">
						{{ Form::select('organization_parent_id', array_merge(array('0' => 'Please Select'), $organizationParents), Input::old('organization_parent_id'), array('id' => 'organization_parent_id', 'class' => 'form-control')) }}
						{{{ $errors->first('organization_parent_id', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>
				<!-- ./ Orgazniation Parent ID -->

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
@stop