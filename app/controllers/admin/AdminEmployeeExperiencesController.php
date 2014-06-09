<?php
class AdminEmployeeExperiencesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeExperience Model
	 * @var EmployeeExperience
	 */
	protected $employeeexperience;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeExperience $employeeexperience
	 */
	public function __construct(User $user, Employee $employee, EmployeeExperience $employeeexperience)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeeexperience = $employeeexperience;

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
	    $title = Lang::get('admin/employeeexperiences/title.employeeexperience_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeeexperiences/create_edit', compact('user', 'employee', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('company_name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeeexperience->fill(Input::all())->save();

		    if( $this->employeeexperience->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeexperiences/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeexperiences/messages.create.error'));
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
     * @param $employeeexperience
     * @return Response
     */
    public function getEdit($employee, $employeeexperience)
    {
	    if ($employeeexperience->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeeexperiences/title.employeeexperience_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeeexperiences/create_edit',
			    compact('employee', 'employeeexperience', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeeexperiences/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeexperiences/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeeexperience
     * @return Response
     */
    public function postEdit($employee, $employeeexperience)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('company_name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeeexperience->fill(Input::all())->save();

		    if( $employeeexperience->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeexperiences/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeexperiences/messages.edit.error'));
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
     * Remove employeeexperience page.
     *
     * @param $employeeexperience
     * @return Response
     */
    public function getDelete($employee, $employeeexperience)
    {
	    $employeeexperience->delete();

	    if (!empty($employeeexperience) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeeexperiences/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeeexperiences/messages.delete.error'));
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
		$title = Lang::get('admin/employeeexperiences/title.employeeexperience_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeeexperiences/index', compact('employee', 'employeeexperience', 'title'));
	}

    /**
     * Show a list of all the employeeexperience formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeExperiences = EmployeeExperience::select(array('id', 'employee_id', 'published', 'start_date', 'note'))
                               ->where('employee_id', '=', $employee->id);
        return Datatables::of($employeeExperiences)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeeexperiences/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeeexperiences/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
