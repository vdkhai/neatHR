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
				<a data-toggle="modal" data-target="#smartHRModal" id="createId" href="{{{ URL::to('admin/certifications/create') }}}" class="btn btn-small btn-info"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<div class="modal fade" id="smartHRModal" tabindex="-1" role="dialog" aria-labelledby="smartHRModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" id="replaceableContent">
			</div>
		</div>
	</div>

	<table id="certifications" class="table table-striped table-hover">
		<thead>
			<tr>
				<th class="col-md-2">{{{ Lang::get('admin/certifications/table.status') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/certifications/table.certification_name') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/certifications/table.certification_desc') }}}</th>
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

		$(document).ready(function() {
			initReplaceContent("{{ URL::to('admin/certifications/create') }}");
		});

		function initReplaceContent(url){
			$('#createId').click(function(e){
				e.preventDefault();
				getAjaxContent(url);
				$('#smartHRModal').modal();
			});
		}

		function getAjaxContent(url){
			$.ajax({
				url: url,
				data: '',
				dataType: 'html',
				tryCount:0,     //current retry count
				retryLimit:3,   //number of retries on fail
				timeout: 5000,  //time before retry on fail
				success: function(returnedData) {
					var divContent = $('#replaceableContent');
					divContent.html(returnedData);
				},
				error: function(xhr, textStatus, errorThrown) {
					if (textStatus == 'timeout') { //if error is 'timeout'
						this.tryCount++;
						if (this.tryCount < this.retryLimit) {
							$.ajax(this);
							return;
						}
					}//try 3 times to get a response from server
				}
			});
		}

		var oTable;
		$(document).ready(function() {
				oTable = $('#certifications').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/certifications/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop