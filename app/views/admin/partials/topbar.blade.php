<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
				<li class="dropdown{{ (Request::is('admin/employees*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-user"></span> Employees <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/employees*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/employees') }}}"><span class="glyphicon glyphicon-thumbs-up"></span> Employees</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-plane"></span> Leave<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-resize-full"></span> Leave Types</a></li>
						<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-envelope"></span> Leave Requests</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-time"></span> Time<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-list-alt"></span> Timesheets</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-screenshot"></span> Recruitment<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/recruitcandidates*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/recruitcandidates') }}}"><span class="glyphicon glyphicon-heart"></span> Candidates</a></li>
						<li{{ (Request::is('admin/recruitvacancies*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/recruitvacancies') }}}"><span class="glyphicon glyphicon-star"></span> Vacancies</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-bell"></span> Performance<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-tasks"></span> KPIs</a></li>
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-eye-open"></span> Review</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-stats"></span> Report<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Employees</a></li>
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-leaf"></span> Projects</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/countries*|admin/states*|nationalities*|languages*|currencies*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-wrench"></span> Admin<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/countries*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/countries') }}}"><span class="glyphicon glyphicon-map-marker"></span> Countries</a></li>
						<li{{ (Request::is('admin/states*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/states') }}}"><span class="glyphicon glyphicon-flag"></span> States</a></li>
						<li{{ (Request::is('admin/nationalities*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/nationalities') }}}"><span class="glyphicon glyphicon-globe"></span> Nationalities</a></li>
						<li{{ (Request::is('admin/languages*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/languages') }}}"><span class="glyphicon glyphicon-certificate"></span> Languages</a></li>
						<li{{ (Request::is('admin/currencies*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/currencies') }}}"><span class="glyphicon glyphicon-usd"></span> Currencies</a></li>
						<li{{ (Request::is('admin/educations*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/educations') }}}"><span class="glyphicon glyphicon-book"></span> Educations</a></li>
						<li{{ (Request::is('admin/skills*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/skills') }}}"><span class="glyphicon glyphicon-briefcase"></span> Skills</a></li>
						<li{{ (Request::is('admin/certifications*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/certifications') }}}"><span class="glyphicon glyphicon-star-empty"></span> Certifications</a></li>
						<li{{ (Request::is('admin/employmenttypes*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/employmenttypes') }}}"><span class="glyphicon glyphicon-subtitles"></span> Employment Types</a></li>
						<li{{ (Request::is('admin/marriages*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/marriages') }}}"><span class="glyphicon glyphicon-heart-empty"></span> Marriages</a></li>
						<li{{ (Request::is('admin/jobtitles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/jobtitles') }}}"><span class="glyphicon glyphicon-tree-deciduous"></span> Job Titles</a></li>
						<li{{ (Request::is('admin/recruitmentstatus*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/recruitmentstatus') }}}"><span class="glyphicon glyphicon-refresh"></span> Recruitment Status</a></li>
						<li{{ (Request::is('admin/paygrades*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/paygrades') }}}"><span class="glyphicon glyphicon-transfer"></span> Pay Grades</a></li>
						<li{{ (Request::is('admin/organizationtypes*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/organizationtypes') }}}"><span class="glyphicon glyphicon-th"></span> Organization Types</a></li>
						<li{{ (Request::is('admin/organizationstructures*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/organizationstructures') }}}"><span class="glyphicon glyphicon-list"></span> Organization Structures</a></li>
						<li{{ (Request::is('admin/dependents*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/dependents') }}}"><span class="glyphicon glyphicon-paperclip"></span> Dependents</a></li>
						<li{{ (Request::is('admin/payfrequencies*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/payfrequencies') }}}"><span class="glyphicon glyphicon-send"></span> Pay Frequencies</a></li>
					</ul>
				</li>
				<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-cog"></span> System<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
						<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-flash"></span> Roles</a></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown{{ (Request::is('admin/settings*|admin/logout*') ? ' active' : '') }}">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-user"></span><span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="{{{ URL::to('user/settings') }}}"><span class="glyphicon glyphicon-wrench"></span> Settings</a></li>
						<li class="divider"></li>
						<li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>