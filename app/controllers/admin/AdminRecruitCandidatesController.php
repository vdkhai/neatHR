<?php
class AdminRecruitCandidatesController extends AdminController
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
	protected $recruitcandidate;

	/**
	 * Inject the models.
	 * @param RecruitVacancy $recruitcandidate
	 */
	public function __construct(User $user, RecruitVacancy $recruitcandidate)
	{
		parent::__construct();
		$this->user = $user;
		$this->recruitcandidate = $recruitcandidate;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/recruitcandidates/title.recruitcandidate_management');

	    // Grab all the recruitcandidate
	    $recruitcandidate = $this->recruitcandidate;

        // Show the page
        return View::make('admin/recruitcandidates/index', compact('recruitcandidate', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/recruitcandidates/title.recruitcandidate_create');

	    $user = $this->user->currentUser();

	    $nationalities = Nationality::lists('name', 'id');

	    $recruitmentStatus = RecruitmentStatus::lists('name', 'id');

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/recruitcandidates/create_edit', compact('user', 'nationalities', 'recruitmentStatus', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('first_name' => 'required'));
	    if ($validator->passes())
	    {
	        // Save if valid.
	        $this->recruitcandidate->fill(Input::all())->save();

	        if( $this->recruitcandidate->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/recruitcandidates/' . $this->recruitcandidate->id . '/edit')->with('success', Lang::get('admin/recruitcandidates/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->recruitcandidate->errors()->all();
	            //return Redirect::to('admin/recruitcandidates/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/recruitcandidates/create')->with('error', Lang::get('admin/recruitcandidates/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $recruitcandidate
     * @return Response
     */
    public function getEdit($recruitcandidate)
    {
        if ($recruitcandidate->id)
        {
	        $user = $this->user->currentUser();

	        $nationalities = Nationality::lists('name', 'id');

	        $recruitmentStatus = RecruitmentStatus::lists('name', 'id');

            // Title
        	$title = Lang::get('admin/recruitcandidates/title.recruitcandidate_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/recruitcandidates/create_edit', compact('recruitcandidate', 'user', 'nationalities', 'recruitmentStatus', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/recruitcandidates')->with('error', Lang::get('admin/recruitcandidates/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $recruitcandidate
     * @return Response
     */
    public function postEdit($recruitcandidate)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('first_name' => 'required'));

        if ($validator->passes())
        {
            // Save if valid
	        $recruitcandidate->fill(Input::all())->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/recruitcandidates/' . $recruitcandidate->id . '/edit')->with('success', Lang::get('admin/recruitcandidates/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/recruitcandidates/' . $recruitcandidate->id . '/edit')->with('error', Lang::get('admin/recruitcandidates/messages.edit.error'));
        }
    }

    /**
     * Remove recruitcandidate page.
     *
     * @param $recruitcandidate
     * @return Response
     */
    public function getDelete($recruitcandidate)
    {
        // Title
        $title = Lang::get('admin/recruitcandidates/title.recruitcandidate_delete');

        // Show the page
        return View::make('admin/recruitcandidates/delete', compact('recruitcandidate', 'title'));
    }

    /**
     * Remove the specified recruitcandidate from storage.
     *
     * @param $recruitcandidate
     * @return Response
     */
    public function postDelete($recruitcandidate)
    {
	    $recruitcandidate->delete();

        if (!empty($recruitcandidate) )
        {
            return Redirect::to('admin/recruitcandidates')->with('success', Lang::get('admin/recruitcandidates/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/recruitcandidates')->with('error', Lang::get('admin/recruitcandidates/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($recruitcandidate)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the recruitcandidate formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $recruitCandidates = Recruitcandidate::leftjoin('employees AS em', 'em.id', '=', 'recruit_candidates.created_by')
	                        ->leftjoin('recruitment_status AS rs', 'rs.id', '=', 'recruit_candidates.recruitment_status_id')
	                        ->select(array('recruit_candidates.id', 'recruit_candidates.last_name', 'recruit_candidates.first_name', 'em.first_name AS contact_person', 'recruit_candidates.application_date', 'rs.name AS recruitment_status'));

        return Datatables::of($recruitCandidates)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/recruitcandidates/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/recruitcandidates/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
