<?php
class AdminEmployeeCertificationsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeCertification Model
	 * @var EmployeeCertification
	 */
	protected $employeecertification;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeCertification $employeecertification
	 */
	public function __construct(User $user, Employee $employee, EmployeeCertification $employeecertification)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeecertification = $employeecertification;

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
	    $title = Lang::get('admin/employeecertifications/title.employeecertification_create');

	    $user = $this->user->currentUser();

	    $certifications = Certification::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeecertifications/create_edit', compact('user', 'employee', 'certifications', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('certification_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeecertification->fill(Input::all())->save();

		    if( $this->employeecertification->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeecertifications/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeecertifications/messages.create.error'));
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
     * @param $employeecertification
     * @return Response
     */
    public function getEdit($employee, $employeecertification)
    {
	    if ($employeecertification->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeecertifications/title.employeecertification_update');

		    $certifications = Certification::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeecertifications/create_edit',
			    compact('employee', 'employeecertification', 'certifications', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeecertifications/' . $employee->id . '/show')->with('error', Lang::get('admin/employeecertifications/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeecertification
     * @return Response
     */
    public function postEdit($employee, $employeecertification)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('certification_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeecertification->fill(Input::all())->save();

		    if( $employeecertification->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeecertifications/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeecertifications/messages.edit.error'));
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
     * Remove employeecertification page.
     *
     * @param $employeecertification
     * @return Response
     */
    public function getDelete($employee, $employeecertification)
    {
	    $employeecertification->delete();

	    if (!empty($employeecertification) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeecertifications/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeecertifications/messages.delete.error'));
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
		$title = Lang::get('admin/employeecertifications/title.employeecertification_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeecertifications/index', compact('employee', 'employeecertification', 'title'));
	}

    /**
     * Show a list of all the employeecertification formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeCertifications = EmployeeCertification::leftjoin('certifications', 'certifications.id', '=', 'employee_certifications.certification_id')
	        ->select(array('employee_certifications.id', 'employee_certifications.employee_id', 'employee_certifications.published', 'certifications.name', 'employee_certifications.note'))
	        ->where('employee_certifications.employee_id', '=', $employee->id);

        return Datatables::of($employeeCertifications)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeecertifications/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeecertifications/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
