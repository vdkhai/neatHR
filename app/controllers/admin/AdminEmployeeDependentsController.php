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
		return View::make('admin/employeedependents/create_edit', compact('user', 'employee', 'dependents', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate($employee)
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('name' => 'required'));
	    if ($validator->passes())
	    {
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeedependent->fill(Input::all())->save();

		    if( $this->employeedependent->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeedependents/' . $employee->id . '/edit/' . $this->employeedependent->id)->with('success', Lang::get('admin/employeedependents/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeedependent->errors()->all();
	            //return Redirect::to('admin/employeedependents/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeedependents/' . $employee->id . '/create')->with('error', Lang::get('admin/employeedependents/messages.create.error'));
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

        	return View::make('admin/employeedependents/create_edit',
		        compact('employee', 'employeedependent', 'user', 'dependents', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeedependent->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeedependents/' . $employee->id . '/edit/' . $employeedependent->id)->with('success', Lang::get('admin/employeedependents/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeedependents/' . $employee->id . '/edit/' . $employeedependent->id)->with('error', Lang::get('admin/employeedependents/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeedependents/title.employeedependent_delete');

        // Show the page
        return View::make('admin/employeedependents/delete', compact('employee', 'employeedependent', 'title'));
    }

    /**
     * Remove the specified employeedependent from storage.
     *
     * @param $employeedependent
     * @return Response
     */
    public function postDelete($employee, $employeedependent)
    {
	    $employeedependent->delete();

        if (!empty($employeedependent) )
        {
            return Redirect::to('admin/employeedependents/' . $employee->id . '/show')->with('success', Lang::get('admin/employeedependents/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeedependents/' . $employee->id . '/show')->with('error', Lang::get('admin/employeedependents/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeedependents/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeedependents/\' . $employee_id . \'/delete/\' .$id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
