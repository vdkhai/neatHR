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
		return View::make('admin/employeecertifications/create_edit', compact('user', 'employee', 'certifications', 'title', 'mode'));
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
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeecertification->fill(Input::all())->save();

		    if( $this->employeecertification->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeecertifications/' . $employee->id . '/edit/' . $this->employeecertification->id)->with('success', Lang::get('admin/employeecertifications/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeecertification->errors()->all();
	            //return Redirect::to('admin/employeecertifications/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeecertifications/' . $employee->id . '/create')->with('error', Lang::get('admin/employeecertifications/messages.create.error'));
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

        	return View::make('admin/employeecertifications/create_edit',
		        compact('employee', 'employeecertification', 'user', 'certifications', 'title', 'mode'));
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
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeecertification->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeecertifications/' . $employee->id . '/edit/' . $employeecertification->id)->with('success', Lang::get('admin/employeecertifications/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeecertifications/' . $employee->id . '/edit/' . $employeecertification->id)->with('error', Lang::get('admin/employeecertifications/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeecertifications/title.employeecertification_delete');

        // Show the page
        return View::make('admin/employeecertifications/delete', compact('employee', 'employeecertification', 'title'));
    }

    /**
     * Remove the specified employeecertification from storage.
     *
     * @param $employeecertification
     * @return Response
     */
    public function postDelete($employee, $employeecertification)
    {
	    $employeecertification->delete();

        if (!empty($employeecertification) )
        {
            return Redirect::to('admin/employeecertifications/' . $employee->id . '/show')->with('success', Lang::get('admin/employeecertifications/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeecertifications/' . $employee->id . '/show')->with('error', Lang::get('admin/employeecertifications/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeecertifications/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeecertifications/\' . $employee_id . \'/delete/\' .$id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
