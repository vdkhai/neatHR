<?php
class AdminEmployeeSkillsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmployeeSkill Model
	 * @var EmployeeSkill
	 */
	protected $employeeskill;

	protected $employee;

	/**
	 * Inject the models.
	 * @param EmployeeSkill $employeeskill
	 */
	public function __construct(User $user, Employee $employee, EmployeeSkill $employeeskill)
	{
		parent::__construct();
		$this->user = $user;
		$this->employeeskill = $employeeskill;

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
	    $title = Lang::get('admin/employeeskills/title.employeeskill_create');

	    $user = $this->user->currentUser();

	    $skills = Skill::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/employeeskills/create_edit', compact('user', 'employee', 'skills', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate($employee)
    {
	    $validator = Validator::make(Input::all(), array('skill_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $this->employeeskill->fill(Input::all())->save();

		    if( $this->employeeskill->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeskills/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeskills/messages.create.error'));
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
     * @param $employeeskill
     * @return Response
     */
    public function getEdit($employee, $employeeskill)
    {
	    if ($employeeskill->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employeeskills/title.employeeskill_update');

		    $skills = Skill::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/employeeskills/create_edit',
			    compact('employee', 'employeeskill', 'skills', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employeeskills/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeskills/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employeeskill
     * @return Response
     */
    public function postEdit($employee, $employeeskill)
    {
        // Validate the inputs
	    $validator = Validator::make(Input::all(), array('skill_id' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;

		    Input::merge(array('employee_id' => $employee->id));

		    $employeeskill->fill(Input::all())->save();

		    if( $employeeskill->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employeeskills/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employeeskills/messages.edit.error'));
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
     * Remove employeeskill page.
     *
     * @param $employeeskill
     * @return Response
     */
    public function getDelete($employee, $employeeskill)
    {
	    $employeeskill->delete();

	    if (!empty($employeeskill) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employeeskills/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employeeskills/messages.delete.error'));
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
		$title = Lang::get('admin/employeeskills/title.employeeskill_management');

		$this->employee = $employee;

		// Show the page
		return View::make('admin/employeeskills/index', compact('employeeskill', 'employee', 'title'));
	}

    /**
     * Show a list of all the employeeskill formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData($employee)
    {
        $employeeskills = EmployeeSkill::leftjoin('skills', 'skills.id', '=', 'employee_skills.skill_id')
	        ->select(array('employee_skills.id', 'employee_skills.employee_id', 'employee_skills.published', 'skills.name', 'employee_skills.note'))
            ->where('employee_skills.employee_id',  '=', $employee->id);

        return Datatables::of($employeeskills)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employeeskills/\' . $employee_id . \'/edit/\'. $id ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employeeskills/\' . $employee_id . \'/delete/\'. $id ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
