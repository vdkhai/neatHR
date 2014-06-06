<?php
class AdminEmployeeLanguagesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeLanguage Model
	 * @var EmployeeLanguage
	 */
	protected $employeelanguage;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeLanguage $employeelanguage
	 */
	public function __construct(User $user, Employee $employee, EmployeeLanguage $employeelanguage)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeelanguage = $employeelanguage;

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
		$title = Lang::get('admin/employeelanguages/title.employeelanguage_create');

	    $user = $this->user->currentUser();

	    $languages = Language::lists('name', 'id');

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/employeelanguages/create_edit', compact('user', 'languages', 'employee', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate($employee)
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('language_id' => 'required'));
	    if ($validator->passes())
	    {
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeelanguage->fill(Input::all())->save();

		    if( $this->employeelanguage->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeelanguages/' . $employee->id . '/edit/' . $this->employeelanguage->id)->with('success', Lang::get('admin/employeelanguages/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeelanguage->errors()->all();
	            //return Redirect::to('admin/employeelanguages/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeelanguages/' . $employee->id. '/create')->with('error', Lang::get('admin/employeelanguages/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $employeelanguage
     * @return Response
     */
    public function getEdit($employee, $employeelanguage)
    {
        if ($employeelanguage->id)
        {
            // Title
        	$title = Lang::get('admin/employeelanguages/title.employeelanguage_update');

	        $user = $this->user->currentUser();

	        $languages = Language::lists('name', 'id');

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/employeelanguages/create_edit',
		        compact('employee', 'employeelanguage', 'languages', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/employeelanguages/' . $employee->id . '/show')->with('error', Lang::get('admin/employeelanguages/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeelanguage
     * @return Response
     */
    public function postEdit($employee, $employeelanguage)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('language_id' => 'required'));

        if ($validator->passes())
        {
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeelanguage->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeelanguages/' . $employee->id . '/edit/' . $employeelanguage->id)->with('success', Lang::get('admin/employeelanguages/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeelanguages/' . $employee->id . '/edit/' . $employeelanguage->id)->with('error', Lang::get('admin/employeelanguages/messages.edit.error'));
        }
    }

    /**
     * Remove employeelanguage page.
     *
     * @param $employeelanguage
     * @return Response
     */
    public function getDelete($employee, $employeelanguage)
    {
        // Title
        $title = Lang::get('admin/employeelanguages/title.employeelanguage_delete');

        // Show the page
        return View::make('admin/employeelanguages/delete', compact('employee', 'employeelanguage', 'title'));
    }

    /**
     * Remove the specified employeelanguage from storage.
     *
     * @param $employeelanguage
     * @return Response
     */
    public function postDelete($employee, $employeelanguage)
    {
	    $employeelanguage->delete();

        if (!empty($employeelanguage) )
        {
            return Redirect::to('admin/employeelanguages/' . $employee->id . '/show')->with('success', Lang::get('admin/employeelanguages/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeelanguages/' . $employee->id . '/show')->with('error', Lang::get('admin/employeelanguages/messages.delete.error'));
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
		$title = Lang::get('admin/employeelanguages/title.employeelanguage_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeelanguages/index', compact('employee', 'title'));
	}

    /**
     * Show a list of all the employeelanguage formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeLanguages = EmployeeLanguage::leftjoin('languages', 'languages.id', '=', 'employee_languages.language_id')
	        ->select(array('employee_languages.id', 'employee_languages.employee_id', 'employee_languages.published', 'languages.name', 'employee_languages.note'))
	        ->where('employee_languages.employee_id', '=', $employee->id);;

        return Datatables::of($employeeLanguages)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeelanguages/\' . $employee_id . \'/edit/\' . $id ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeelanguages/\' . $employee_id . \'/delete/\' . $id ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
