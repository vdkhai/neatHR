@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
	<form class="form-horizontal" method="post" action="{{ URL::to('admin/employees/import') }}" autocomplete="off" enctype="multipart/form-data">
		<!-- CSRF Token -->
		<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
		<!-- ./ csrf token -->
		<span class="label label-info"><a href="{{ URL::to('admin/employees/template') }}">Get template file</a></span>
		<input type="file" class="" name="import" id="import">
		<!-- Form Actions -->
		<div class="form-group">
			<div class="col-md-offset-2 col-md-6">
				<button type="reset" class="btn btn-primary">Reset</button>
				<button type="submit" class="btn btn-success">OK</button>
			</div>
		</div>
		<!-- ./ form actions -->
	</form>
@stop
