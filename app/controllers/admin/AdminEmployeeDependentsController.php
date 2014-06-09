<?php
class AdminEmployeeDependentsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeDependent Model
	 * @var EmployeeDependent
	 */
	protected $employeedependent;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeDependent $employeedependent
	 */
	public function __construct(User $user, Employee $employee, EmployeeDependent $employeedependent)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeedependent = $employeedependent;

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
	    $title = Lang::get('admin/employeedependents/title.employeedependent_create');

	    $user = $this->user->currentUser();

	    $dependents = Dependent::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeedependents/create_edit', compact('user', 'employee', 'dependents', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate($employee)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeedependent->fill(Input::all())->save();

		    if( $this->employeedependent->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeedependents/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeedependents/messages.create.error'));
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
     * @param $employeedependent
     * @return Response
     */
    public function getEdit($employee, $employeedependent)
    {
	    if ($employeedependent->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeedependents/title.employeedependent_update');

		    $dependents = Dependent::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeedependents/create_edit',
			    compact('employee', 'employeedependent', 'dependents', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeedependents/' . $employee->id . '/show')->with('error', Lang::get('admin/employeedependents/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeedependent
     * @return Response
     */
    public function postEdit($employee, $employeedependent)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeedependent->fill(Input::all())->save();

		    if( $employeedependent->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeedependents/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeedependents/messages.edit.error'));
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
     * Remove employeedependent page.
     *
     * @param $employeedependent
     * @return Response
     */
    public function getDelete($employee, $employeedependent)
    {
	    $employeedependent->delete();

	    if (!empty($employeedependent) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeedependents/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeedependents/messages.delete.error'));
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
		$title = Lang::get('admin/employeedependents/title.employeedependent_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeedependents/index', compact('employee', 'employeedependent', 'title'));
	}

    /**
     * Show a list of all the employeedependent formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeDependents = EmployeeDependent::select(array('id', 'employee_id', 'published', 'name', 'note'))
	        ->where('employee_id', '=', $employee->id);

        return Datatables::of($employeeDependents)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeedependents/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeedependents/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
