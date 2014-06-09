<?php
class AdminEmployeeEducationsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeEducation Model
	 * @var EmployeeEducation
	 */
	protected $employeeeducation;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeEducation $employeeeducation
	 */
	public function __construct(User $user, Employee $employee, EmployeeEducation $employeeeducation)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeeeducation = $employeeeducation;

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
	    $title = Lang::get('admin/employeeeducations/title.employeeeducation_create');

	    $user = $this->user->currentUser();

	    $educations = Education::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeeeducations/create_edit', compact('user', 'employee', 'educations', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('education_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeeeducation->fill(Input::all())->save();

		    if( $this->employeeeducation->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeeducations/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeeducations/messages.create.error'));
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
     * @param $employeeeducation
     * @return Response
     */
    public function getEdit($employee, $employeeeducation)
    {
	    if ($employeeeducation->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeeeducations/title.employeeeducation_update');

		    $educations = Education::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeeeducations/create_edit',
			    compact('employee', 'employeeeducation', 'educations', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeeeducations/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeeducations/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeeeducation
     * @return Response
     */
    public function postEdit($employee, $employeeeducation)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('education_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeeeducation->fill(Input::all())->save();

		    if( $employeeeducation->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeeducations/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeeducations/messages.edit.error'));
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
     * Remove employeeeducation page.
     *
     * @param $employeeeducation
     * @return Response
     */
    public function getDelete($employee, $employeeeducation)
    {
	    $employeeeducation->delete();

	    if (!empty($employeeeducation) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeeeducations/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeeeducations/messages.delete.error'));
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
		$title = Lang::get('admin/employeeeducations/title.employeeeducation_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeeeducations/index', compact('employee', 'employeeeducation', 'title'));
	}

    /**
     * Show a list of all the employeeeducation formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeEducations = EmployeeEducation::leftjoin('educations', 'educations.id', '=', 'employee_education.education_id')
	        ->select(array('employee_education.id', 'employee_education.employee_id', 'employee_education.published', 'educations.name', 'employee_education.note'))
            ->where('employee_education.employee_id', '=', $employee->id);

        return Datatables::of($employeeEducations)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeeeducations/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeeeducations/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
