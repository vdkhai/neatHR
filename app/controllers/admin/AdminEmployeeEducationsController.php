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
		return View::make('admin/employeeeducations/create_edit', compact('user', 'employee', 'educations', 'title', 'mode'));
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
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeeeducation->fill(Input::all())->save();

		    if( $this->employeeeducation->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeeeducations/' . $employee->id . '/edit/' . $this->employeeeducation->id)->with('success', Lang::get('admin/employeeeducations/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeeeducation->errors()->all();
	            //return Redirect::to('admin/employeeeducations/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeeeducations/' . $employee->id . '/create')->with('error', Lang::get('admin/employeeeducations/messages.create.error'));
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
	        // Title
	        $title = Lang::get('admin/employeeeducations/title.employeeeducation_update');

	        $user = $this->user->currentUser();

	        $educations = Education::lists('name', 'id');

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/employeeeducations/create_edit',
		        compact('employee', 'educations', 'employeeeducation', 'user', 'title', 'mode'));
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
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeeeducation->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeeeducations/' . $employee->id . '/edit/' . $employeeeducation->id)->with('success', Lang::get('admin/employeeeducations/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeeeducations/' . $employee->id . '/edit/' . $employeeeducation->id)->with('error', Lang::get('admin/employeeeducations/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeeeducations/title.employeeeducation_delete');

        // Show the page
        return View::make('admin/employeeeducations/delete', compact('employee', 'employeeeducation', 'title'));
    }

    /**
     * Remove the specified employeeeducation from storage.
     *
     * @param $employeeeducation
     * @return Response
     */
    public function postDelete($employee, $employeeeducation)
    {
	    $employeeeducation->delete();

        if (!empty($employeeeducation) )
        {
            return Redirect::to('admin/employeeeducations/' . $employee->id . '/show')->with('success', Lang::get('admin/employeeeducations/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeeeducations/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeeducations/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeeeducations/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeeeducations/\' . $employee_id . \'/delete/\' . $id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
