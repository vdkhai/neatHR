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
			<a data-toggle="modal" data-target="#modal" id="create" href="#" class="btn btn-small btn-info"><span class="glyphicon glyphicon-plus-sign"></span> {{{ Lang::get('button.create') }}}</a>
		</div>
	</h3>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="replaceableContent">
		</div>
	</div>
</div>

<table id="recruitvacancies" class="table table-striped table-hover">
	<thead>
	<tr>
		<th class="col-md-1">{{{ Lang::get('table.status') }}}</th>
		<th class="col-md-4">{{{ Lang::get('admin/recruitvacancies/table.recruitvacancy_name') }}}</th>
		<th class="col-md-3">{{{ Lang::get('admin/recruitvacancies/table.recruitvacancy_jobtitle') }}}</th>
		<th class="col-md-1">{{{ Lang::get('admin/recruitvacancies/table.recruitvacancy_amount') }}}</th>
		<th class="col-md-2">{{{ Lang::get('admin/recruitvacancies/table.recruitvacancy_contactperson') }}}</th>
		<th class="col-md-1">{{{ Lang::get('table.actions') }}}</th>
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
		oTable = $('#recruitvacancies').dataTable( {
			"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			},
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "{{ URL::to('admin/recruitvacancies/data') }}",
			"fnDrawCallback": function ( oSettings ) {
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			}
		});
	});

	$(document).ready(function() {
		// Open modal to create
		$('#create').click(function(e){
			e.preventDefault();
			getAjaxContent("{{ URL::to('admin/recruitvacancies/create') }}");
			$('#modal').modal();
		});
	});

	// Open modal to edit
	function getEdit(url){
		getAjaxContent(url);
		$('#modal').modal();
	}

	function getDelete(url){
		ajaxDelete(url);
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
				}
			}
		});
	}

	function ajaxDelete(url){
		$.ajax({
			url: url,
			success: function(returnData) {
				var returnObj = $.parseJSON(returnData);
				oTable.fnReloadAjax();
				return false;
			},
			error: function(){
				alert('Delete fail');
				return false;
			}
		});
	}
</script>
@stop
