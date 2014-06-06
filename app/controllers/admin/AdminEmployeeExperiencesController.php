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
		return View::make('admin/employeeexperiences/create_edit', compact('user', 'employee', 'title', 'mode'));
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
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeeexperience->fill(Input::all())->save();

		    if( $this->employeeexperience->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeeexperiences/' . $employee->id . '/edit/' . $this->employeeexperience->id)->with('success', Lang::get('admin/employeeexperiences/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeeexperience->errors()->all();
	            //return Redirect::to('admin/employeeexperiences/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeeexperiences/' . $employee->id . '/create')->with('error', Lang::get('admin/employeeexperiences/messages.create.error'));
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

        	return View::make('admin/employeeexperiences/create_edit', compact('employee', 'employeeexperience', 'user', 'title', 'mode'));
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
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeeexperience->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeeexperiences/' . $employee->id . '/edit/' . $employeeexperience->id)->with('success', Lang::get('admin/employeeexperiences/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeeexperiences/' . $employee->id . '/edit/' . $employeeexperience->id)->with('error', Lang::get('admin/employeeexperiences/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeeexperiences/title.employeeexperience_delete');

        // Show the page
        return View::make('admin/employeeexperiences/delete', compact('employee', 'employeeexperience', 'title'));
    }

    /**
     * Remove the specified employeeexperience from storage.
     *
     * @param $employeeexperience
     * @return Response
     */
    public function postDelete($employee, $employeeexperience)
    {
	    $employeeexperience->delete();

        if (!empty($employeeexperience) )
        {
            return Redirect::to('admin/employeeexperiences/' . $employee->id . '/show')->with('success', Lang::get('admin/employeeexperiences/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeeexperiences/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeexperiences/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeeexperiences/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeeexperiences/\' . $employee_id . \'/delete/\' . $id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
