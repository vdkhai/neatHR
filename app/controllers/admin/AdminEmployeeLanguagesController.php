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
	    $view = View::make('admin/employeelanguages/create_edit', compact('user', 'employee', 'languages', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('language_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeelanguage->fill(Input::all())->save();

		    if( $this->employeelanguage->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeelanguages/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeelanguages/messages.create.error'));
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
     * @param $employeelanguage
     * @return Response
     */
    public function getEdit($employee, $employeelanguage)
    {
	    if ($employeelanguage->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeelanguages/title.employeelanguage_update');

		    $languages = Language::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeelanguages/create_edit',
			    compact('employee', 'employeelanguage', 'languages', 'user', 'title', 'mode'));

		    return Response::make($view);
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
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeelanguage->fill(Input::all())->save();

		    if( $employeelanguage->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeelanguages/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeelanguages/messages.edit.error'));
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
     * Remove employeelanguage page.
     *
     * @param $employeelanguage
     * @return Response
     */
    public function getDelete($employee, $employeelanguage)
    {
	    $employeelanguage->delete();

	    if (!empty($employeelanguage) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeelanguages/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeelanguages/messages.delete.error'));
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
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeelanguages/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeelanguages/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
