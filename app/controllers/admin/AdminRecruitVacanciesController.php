<?php
class AdminRecruitVacanciesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * RecruitVacancy Model
	 * @var RecruitVacancy
	 */
	protected $recruitvacancy;

	/**
	 * Inject the models.
	 * @param RecruitVacancy $recruitvacancy
	 */
	public function __construct(User $user, RecruitVacancy $recruitvacancy)
	{
		parent::__construct();
		$this->user = $user;
		$this->recruitvacancy = $recruitvacancy;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/recruitvacancies/title.recruitvacancy_management');

	    // Grab all the recruitvacancy
	    $recruitvacancy = $this->recruitvacancy;

        // Show the page
        return View::make('admin/recruitvacancies/index', compact('recruitvacancy', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/recruitvacancies/title.recruitvacancy_create');

	    $user = $this->user->currentUser();

	    $jobtitles = JobTitle::lists('name', 'id');

	    $employees = Employee::lists('first_name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/recruitvacancies/create_edit',
		    compact('user', 'jobtitles', 'employees', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->recruitvacancy->fill(Input::all())->save();

		    if( $this->recruitvacancy->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitvacancies/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitvacancies/messages.create.error'));
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
     * @param $recruitvacancy
     * @return Response
     */
    public function getEdit($recruitvacancy)
    {
	    if ($recruitvacancy->id)
	    {
		    $user = $this->user->currentUser();

		    $jobtitles = JobTitle::lists('name', 'id');

		    $employees = Employee::lists('first_name', 'id');

		    // Title
		    $title = Lang::get('admin/recruitvacancies/title.recruitvacancy_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/recruitvacancies/create_edit',
			    compact('recruitvacancy', 'user', 'jobtitles', 'employees', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/recruitvacancies')->with('error', Lang::get('admin/recruitvacancies/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $recruitvacancy
     * @return Response
     */
    public function postEdit($recruitvacancy)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $recruitvacancy->fill(Input::all())->save();

		    if( $recruitvacancy->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitvacancies/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitvacancies/messages.edit.error'));
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
     * Remove recruitvacancy page.
     *
     * @param $recruitvacancy
     * @return Response
     */
    public function getDelete($recruitvacancy)
    {
	    $recruitvacancy->delete();

	    if (!empty($recruitvacancy) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/recruitvacancies/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/recruitvacancies/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($recruitvacancy)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the recruitvacancy formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $recruitVacancies = RecruitVacancy::leftjoin('job_titles AS jt', 'jt.id', '=', 'recruit_vacancies.job_title_id')
                            ->leftjoin('employees AS em', 'em.id', '=', 'recruit_vacancies.contact_person_id')
	                        ->select(array('recruit_vacancies.id', 'recruit_vacancies.published', 'recruit_vacancies.name', 'jt.name AS job_title', 'recruit_vacancies.amount', 'em.first_name'));

        return Datatables::of($recruitVacancies)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/recruitvacancies/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/recruitvacancies/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
