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
				<a href="{{{ URL::to('admin/countries/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<div class="modal fade" id="smartHRModal" tabindex="-1" role="dialog" aria-labelledby="smartHRModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" id="replaceableContent">
			</div>
		</div>
	</div>

	<table id="countries" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/countries/table.status') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/countries/table.country_name') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/countries/table.iso_code2') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/countries/table.iso_code3') }}}</th>
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
				oTable = $('#countries').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/countries/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop