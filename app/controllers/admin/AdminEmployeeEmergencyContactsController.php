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
		return View::make('admin/employeeemergencycontacts/create_edit', compact('user', 'employee', 'title', 'mode'));
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
		    $this->employeeemergencycontact->fill(Input::all())->save();

		    if( $this->employeeemergencycontact->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/edit/' . $this->employeeemergencycontact->id)->with('success', Lang::get('admin/employeeemergencycontacts/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeeemergencycontact->errors()->all();
	            //return Redirect::to('admin/employeeemergencycontacts/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/create')->with('error', Lang::get('admin/employeeemergencycontacts/messages.create.error'));
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

        	return View::make('admin/employeeemergencycontacts/create_edit',
		        compact('employee', 'employeeemergencycontact', 'user', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeeemergencycontact->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/edit/' . $employeeemergencycontact->id)->with('success', Lang::get('admin/employeeemergencycontacts/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/edit/' . $employeeemergencycontact->id)->with('error', Lang::get('admin/employeeemergencycontacts/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeeemergencycontacts/title.employeeemergencycontact_delete');

        // Show the page
        return View::make('admin/employeeemergencycontacts/delete', compact('employee', 'employeeemergencycontact', 'title'));
    }

    /**
     * Remove the specified employeeemergencycontact from storage.
     *
     * @param $employeeemergencycontact
     * @return Response
     */
    public function postDelete($employee, $employeeemergencycontact)
    {
	    $employeeemergencycontact->delete();

        if (!empty($employeeemergencycontact) )
        {
            return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/show')->with('success', Lang::get('admin/employeeemergencycontacts/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeeemergencycontacts/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeemergencycontacts/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeeemergencycontacts/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeeemergencycontacts/\' . $employee_id . \'/delete/\' .$id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
