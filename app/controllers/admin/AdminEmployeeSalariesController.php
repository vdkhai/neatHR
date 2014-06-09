<?php
class AdminEmployeeSalariesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeSalary Model
	 * @var EmployeeSalary
	 */
	protected $employeesalary;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeSalary $employeesalary
	 */
	public function __construct(User $user, Employee $employee, EmployeeSalary $employeesalary)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeesalary = $employeesalary;

		$this->employee = $employee;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate($employee)
	{
		// Title
		$title = Lang::get('admin/employeesalaries/title.employeesalary_create');

		$user = $this->user->currentUser();

		$currencies = Currency::lists('name', 'id');

		$payfrequencies = PayFrequency::lists('name', 'id');

		// Mode
		$mode = 'create';

		// Show the page
		$view = View::make('admin/employeesalaries/create_edit', compact('user', 'employee', 'currencies', 'payfrequencies', 'title', 'mode'));

		return Response::make($view);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate($employee)
	{
		// Validate the inputs
		$validator = Validator::make(Input::all(), array('amount' => 'required'));
		if ($validator->passes())
		{
			$result['failedValidate'] = false;

			Input::merge(array('employee_id' => $employee->id));

			$this->employeesalary->fill(Input::all())->save();

			if( $this->employeesalary->id )
			{
				$result['messages'] = array('success' => Lang::get('admin/employeesalaries/messages.create.success'));
				return Response::json(json_encode($result));
			}
			else
			{
				$result['messages'] = array('error' => Lang::get('admin/employeesalaries/messages.create.error'));
				return Response::json(json_encode($result));
			}
		}
		else
		{
			$result['failedValidate'] = true;
			$result['messages'] = $validator->messages()->toJson();
			return Response::json(json_encode($result));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $employeesalary
	 * @return Response
	 */
	public function getEdit($employee, $employeesalary)
	{
		if ($employeesalary->id)
		{
			$user = $this->user->currentUser();

			// Title
			$title = Lang::get('admin/employeesalaries/title.employeesalary_update');

			$currencies = Currency::lists('name', 'id');

			$payfrequencies = PayFrequency::lists('name', 'id');

			// Mode
			$mode = 'edit';

			// Show the page
			$view = View::make('admin/employeesalaries/create_edit',
				compact('employee', 'employeesalary', 'user', 'currencies', 'payfrequencies', 'title', 'mode'));

			return Response::make($view);
		}
		else
		{
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/show')->with('error', Lang::get('admin/employeesalaries/messages.does_not_exist'));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $employeesalary
	 * @return Response
	 */
	public function postEdit($employee, $employeesalary)
	{
		// Validate the inputs
		$validator = Validator::make(Input::all(), array('amount' => 'required'));
		if ($validator->passes())
		{
			$result['failedValidate'] = false;

			Input::merge(array('employee_id' => $employee->id));

			$employeesalary->fill(Input::all())->save();

			if( $employeesalary->id )
			{
				$result['messages'] = array('success' => Lang::get('admin/employeesalaries/messages.edit.success'));
				return Response::json(json_encode($result));
			}
			else
			{
				$result['messages'] = array('error' => Lang::get('admin/employeesalaries/messages.edit.error'));
				return Response::json(json_encode($result));
			}
		}
		else
		{
			$result['failedValidate'] = true;
			$result['messages'] = $validator->messages()->toJson();
			return Response::json(json_encode($result));
		}
	}

	/**
	 * Remove employeesalary page.
	 *
	 * @param $employeesalary
	 * @return Response
	 */
	public function getDelete($employee, $employeesalary)
	{
		$employeesalary->delete();

		if (!empty($employeesalary) )
		{
			$result['messages'] = array('success' => Lang::get('admin/employeesalaries/messages.delete.success'));
			return Response::json(json_encode($result));
		}
		else
		{
			$result['messages'] = array('error' => Lang::get('admin/employeesalaries/messages.delete.error'));
			return Response::json(json_encode($result));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($employee)
	{
		// Title
		$title = Lang::get('admin/employeesalaries/title.employeesalary_management');

		// Show the page
		return View::make('admin/employeesalaries/index', compact('employee', 'title'));
	}

	/**
	 * Show a list of all the employeesalary formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function getData($employee)
	{
		$employeeSalaries = EmployeeSalary::select(array('employee_salaries.id', 'employee_salaries.employee_id', 'employee_salaries.published', 'employee_salaries.amount', 'employee_salaries.detail'))
							->where('employee_id', '=', $employee->id);
		return Datatables::of($employeeSalaries)
			->add_column('actions', '<div class="btn-group">
										<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
										<ul class="dropdown-menu" role="menu">
											<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeesalaries/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
											<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeesalaries/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
										</ul>
									</div>'
						)
			->remove_column('id', 'employee_id')
			->make();
	}
}
