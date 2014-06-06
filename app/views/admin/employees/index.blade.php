@extends('admin.layouts.default')

{{-- Web site Title --}}
@section('title')
	{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
			<div class="pull-right">
				<a href="{{{ URL::to('admin/employees/export') }}}" class="btn btn-small btn-info"><span class="glyphicon glyphicon-export"></span> Export</a>
				<a href="{{{ URL::to('admin/employees/import') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-import"></span> Import</a>

				<!--<a href="{{{ URL::to('admin/employees/create') }}}" class="btn btn-small btn-info"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>--> <!--In case don't want to show in modal -->
				<a href="{{{ URL::to('admin/employees/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="employees" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.status') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.employee_code') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.employee_firstname') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.employee_lastname') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.employee_mobilephone') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/employees/table.employee_gender') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
				oTable = $('#employees').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/employees/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop