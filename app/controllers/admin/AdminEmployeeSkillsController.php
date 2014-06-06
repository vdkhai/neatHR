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

		// Show the page
		return View::make('admin/employeeskills/create', compact('user', 'employee', 'skills', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate($employee)
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('skill_id' => 'required'));
	    if ($validator->passes())
	    {
		    // Add employee id
		    Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
		    $this->employeeskill->fill(Input::all())->save();

		    if( $this->employeeskill->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employeeskills/' . $employee->id . '/edit/' . $this->employeeskill->id)->with('success', Lang::get('admin/employeeskills/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employeeskill->errors()->all();
	            //return Redirect::to('admin/employeeskills/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employeeskills/' . $employee->id . '/create')->with('error', Lang::get('admin/employeeskills/messages.create.error'));
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
            // Title
        	$title = Lang::get('admin/employeeskills/title.employeeskill_update');

	        $user = $this->user->currentUser();

	        $skills = Skill::lists('name', 'id');

        	return View::make('admin/employeeskills/edit',
		        compact('employee', 'employeeskill', 'user', 'skills', 'title'));
        }
        else
        {
            return Redirect::to('admin/employeeskills')->with('error', Lang::get('admin/employeeskills/messages.does_not_exist'));
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
	        // Add employee id
	        Input::merge(array('employee_id' => $employee->id));

	        // Save if valid. Bind data from the form into model before save.
	        $employeeskill->fill(Input::all())->save();

			// Redirect to the new user page
	        return Redirect::to('admin/employeeskills/' . $employee->id . '/edit/' . $employeeskill->id)->with('success', Lang::get('admin/employeeskills/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employeeskills/' . $employee->id . '/edit/' . $employeeskill->id)->with('error', Lang::get('admin/employeeskills/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/employeeskills/title.employeeskill_delete');

        // Show the page
        return View::make('admin/employeeskills/delete', compact('employee', 'employeeskill', 'title'));
    }

    /**
     * Remove the specified employeeskill from storage.
     *
     * @param $employeeskill
     * @return Response
     */
    public function postDelete($employee, $employeeskill)
    {
	    $employeeskill->delete();

        if (!empty($employeeskill) )
        {
            return Redirect::to('admin/employeeskills/' . $employee->id . '/show')->with('success', Lang::get('admin/employeeskills/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employeeskills/' . $employee->id . '/show')->with('error', Lang::get('admin/employeeskills/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employeeskills/\' . $employee_id . \'/edit/\' . $id) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employeeskills/\' . $employee_id . \'/delete/\' . $id) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></span></a>')
                ->remove_column('id', 'employee_id')
                ->make();
    }
}
