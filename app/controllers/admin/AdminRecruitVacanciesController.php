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
		return View::make('admin/recruitvacancies/create_edit', compact('user', 'jobtitles', 'employees', 'title', 'mode'));
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
	        // Save if valid.
	        $this->recruitvacancy->fill(Input::all())->save();

	        if( $this->recruitvacancy->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/recruitvacancies/' . $this->recruitvacancy->id . '/edit')->with('success', Lang::get('admin/recruitvacancies/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->recruitvacancy->errors()->all();
	            //return Redirect::to('admin/recruitvacancies/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/recruitvacancies/create')->with('error', Lang::get('admin/recruitvacancies/messages.create.error'));
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

        	return View::make('admin/recruitvacancies/create_edit', compact('recruitvacancy', 'user', 'jobtitles', 'employees', 'title', 'mode'));
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
            // Save if valid
	        $recruitvacancy->fill(Input::all())->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/recruitvacancies/' . $recruitvacancy->id . '/edit')->with('success', Lang::get('admin/recruitvacancies/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/recruitvacancies/' . $recruitvacancy->id . '/edit')->with('error', Lang::get('admin/recruitvacancies/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/recruitvacancies/title.recruitvacancy_delete');

        // Show the page
        return View::make('admin/recruitvacancies/delete', compact('recruitvacancy', 'title'));
    }

    /**
     * Remove the specified recruitvacancy from storage.
     *
     * @param $recruitvacancy
     * @return Response
     */
    public function postDelete($recruitvacancy)
    {
	    $recruitvacancy->delete();

        if (!empty($recruitvacancy) )
        {
            return Redirect::to('admin/recruitvacancies')->with('success', Lang::get('admin/recruitvacancies/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/recruitvacancies')->with('error', Lang::get('admin/recruitvacancies/messages.delete.error'));
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
	                        ->select(array('recruit_vacancies.id', 'recruit_vacancies.name', 'jt.name AS job_title', 'recruit_vacancies.amount', 'em.first_name', 'recruit_vacancies.published'));

        return Datatables::of($recruitVacancies)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/recruitvacancies/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/recruitvacancies/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
