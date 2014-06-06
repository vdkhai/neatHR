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
		return View::make('admin/employeesalaries/create_edit', compact('user', 'employee', 'currencies', 'payfrequencies', 'title', 'mode'));
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
			Input::merge(array('employee_id' => $employee->id));

			// Save if valid. Bind data from the form into model before save.
			$this->employeesalary->fill(Input::all())->save();

			if( $this->employeesalary->id )
			{
				// Redirect to the new contry page
				return Redirect::to('admin/employeesalaries/' . $employee->id . '/edit/' . $this->employeesalary->id)->with('success', Lang::get('admin/employeesalaries/messages.create.success'));
			}
			else
			{
				// Get validation errors (see Ardent package)
				//$error = $this->employeesalary->errors()->all();
				//return Redirect::to('admin/employeesalaries/create')
				//    ->withInput(Input::except('password'))
				//    ->with( 'error', $error );
			}
		}
		else
		{
			$error = $validator->messages();
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/create')->with('error', Lang::get('admin/employeesalaries/messages.create.error'));
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

			return View::make('admin/employeesalaries/create_edit',
				compact('employee', 'employeesalary', 'user', 'currencies', 'payfrequencies', 'title', 'mode'));
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
			Input::merge(array('employee_id' => $employee->id));

			// Save if valid. Bind data from the form into model before save.
			$employeesalary->fill(Input::all())->save();

			// Redirect to the new user page
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/edit/' . $employeesalary->id)->with('success', Lang::get('admin/employeesalaries/messages.edit.success'));
		}
		else
		{
			$error = $validator->messages();
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/edit/' . $employeesalary->id)->with('error', Lang::get('admin/employeesalaries/messages.edit.error'));
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
		// Title
		$title = Lang::get('admin/employeesalaries/title.employeesalary_delete');

		// Show the page
		return View::make('admin/employeesalaries/delete', compact('employee', 'employeesalary', 'title'));
	}

	/**
	 * Remove the specified employeesalary from storage.
	 *
	 * @param $employeesalary
	 * @return Response
	 */
	public function postDelete($employee, $employeesalary)
	{
		$employeesalary->delete();

		if (!empty($employeesalary) )
		{
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/show')->with('success', Lang::get('admin/employeesalaries/messages.delete.success'));
		}
		else
		{
			// There was a problem deleting the user
			return Redirect::to('admin/employeesalaries/' . $employee->id . '/show')->with('error', Lang::get('admin/employeesalaries/messages.delete.error'));
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
			->add_column('actions', '<a href="{{{ URL::to(\'admin/employeesalaries/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeesalaries/\' . $employee_id . \'/delete/\' . $id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
			->remove_column('id', 'employee_id')
			->make();
	}
}
