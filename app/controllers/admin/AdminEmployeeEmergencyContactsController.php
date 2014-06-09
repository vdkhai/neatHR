<?php
class AdminEmployeeEmergencyContactsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeEmergencyContact Model
	 * @var EmployeeEmergencyContact
	 */
	protected $employeeemergencycontact;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeEmergencyContact $employeeemergencycontact
	 */
	public function __construct(User $user, Employee $employee, EmployeeEmergencyContact $employeeemergencycontact)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeeemergencycontact = $employeeemergencycontact;

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
	    $title = Lang::get('admin/employeeemergencycontacts/title.employeeemergencycontact_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeeemergencycontacts/create_edit', compact('user', 'employee', 'title', 'mode'));

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

		    $this->employeeemergencycontact->fill(Input::all())->save();

		    if( $this->employeeemergencycontact->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeemergencycontacts/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeemergencycontacts/messages.create.error'));
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
     * @param $employeeemergencycontact
     * @return Response
     */
    public function getEdit($employee, $employeeemergencycontact)
    {
	    if ($employeeemergencycontact->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeeemergencycontacts/title.employeeemergencycontact_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeeemergencycontacts/create_edit',
			    compact('employee', 'employeeemergencycontact', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeemergencycontacts/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeeemergencycontact
     * @return Response
     */
    public function postEdit($employee, $employeeemergencycontact)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeeemergencycontact->fill(Input::all())->save();

		    if( $employeeemergencycontact->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeemergencycontacts/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeemergencycontacts/messages.edit.error'));
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
     * Remove employeeemergencycontact page.
     *
     * @param $employeeemergencycontact
     * @return Response
     */
    public function getDelete($employee, $employeeemergencycontact)
    {
	    $employeeemergencycontact->delete();

	    if (!empty($employeeemergencycontact) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeeemergencycontacts/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeeemergencycontacts/messages.delete.error'));
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
		$title = Lang::get('admin/employeeemergencycontacts/title.employeeemergencycontact_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeeemergencycontacts/index', compact('employee', 'employeeemergencycontact', 'title'));
	}

    /**
     * Show a list of all the employeeemergencycontact formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeEmergencyContacts = EmployeeEmergencyContact::select(array('id', 'employee_id', 'published', 'name', 'note'))
	        ->where('employee_id', '=', $employee->id);

        return Datatables::of($employeeEmergencyContacts)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeeemergencycontacts/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeeemergencycontacts/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
