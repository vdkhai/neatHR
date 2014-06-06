<div class="page-header">
	<div class="panel panel-default">
		<div class="panel-heading panel-default">
			<h3 class="panel-title">
				<a href="{{{URL::to('admin/employees/' . $employee->id . '/show/')}}}">
					{{{$employee->first_name . ' ' .$employee->middle_name . ' ' . $employee->last_name }}}
				</a>
			</h3>
		</div>
		<div class="panel-collapse collapse in">
			<div class="panel-body">
				<a href="#" class="thumbnail">
					<img src="{{{URL::route('imagecache', ['template' => 'medium', 'filename' => 'az003.jpg'])}}}" alt="Atl image">
				</a>
			</div>
		</div>
	</div>
</div>
<div class="panel-group" id="accordion">
	<div class="panel panel-default">
		<div class="panel-heading panel-default">
			<h4 class="panel-title">
				<a href="{{{ URL::to('admin/employeeemergencycontacts/' . $employee->id . '/show/') }}}">
					Emergency Contact
				</a>
			</h4>
		</div>
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="{{{ URL::to('admin/employeedependents/' . $employee->id . '/show/') }}}">
					Dependents
				</a>
			</h4>
		</div>
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapseQualification">
					Qualifications
				</a>
			</h4>
		</div>
		<div id="collapseQualification" class="panel-collapse collapse">
			<div class="panel-body">
				<ul class="nav nav-sidebar">
					<li><a href="{{{ URL::to('admin/employeeskills/' . $employee->id . '/show/') }}}"><span class="glyphicon glyphicon-star"></span> Skills</a></li>
					<li><a href="{{{ URL::to('admin/employeeeducations/' . $employee->id . '/show/')}}}"><span class="glyphicon glyphicon-book"></span> Education</a></li>
					<li><a href="{{{ URL::to('admin/employeelanguages/' . $employee->id . '/show/') }}}"><span class="glyphicon glyphicon-globe"></span> Languages</a></li>
					<li><a href="{{{ URL::to('admin/employeecertifications/' . $employee->id . '/show/') }}}"><span class="glyphicon glyphicon-star-empty"></span> Certifications</a></li>
					<li><a href="{{{ URL::to('admin/employeeexperiences/' . $employee->id . '/show/') }}}"><span class="glyphicon glyphicon-filter"></span> Experiences</a></li>
				</ul>
			</div>
		</div>
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="{{{ URL::to('admin/employeesalaries/' . $employee->id . '/show/') }}}">
					Salary
				</a>
			</h4>
		</div>
	</div>
</div>