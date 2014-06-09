<?php
class AdminRecruitCandidatesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * recruitcandidate Model
	 * @var recruitcandidate
	 */
	protected $recruitcandidate;

	/**
	 * Inject the models.
	 * @param recruitcandidate $recruitcandidate
	 */
	public function __construct(User $user, RecruitCandidate $recruitcandidate)
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
	    $view = View::make('admin/recruitcandidates/create_edit',
		    compact('user', 'nationalities', 'recruitmentStatus', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('first_name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->recruitcandidate->fill(Input::all())->save();

		    if( $this->recruitcandidate->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitcandidates/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitcandidates/messages.create.error'));
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

		    // Show the page
		    $view = View::make('admin/recruitcandidates/create_edit',
			    compact('recruitcandidate', 'user', 'nationalities', 'recruitmentStatus', 'title', 'mode'));

		    return Response::make($view);
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
		    $result['failedValidate'] = false;
		    $recruitcandidate->fill(Input::all())->save();

		    if( $recruitcandidate->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitcandidates/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitcandidates/messages.edit.error'));
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
     * Remove recruitcandidate page.
     *
     * @param $recruitcandidate
     * @return Response
     */
    public function getDelete($recruitcandidate)
    {
	    $recruitcandidate->delete();

	    if (!empty($recruitcandidate) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/recruitcandidates/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/recruitcandidates/messages.delete.error'));
		    return Response::json(json_encode($result));
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
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/recruitcandidates/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/recruitcandidates/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
