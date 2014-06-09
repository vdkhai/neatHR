<?php
class AdminRecruitmentStatusController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * RecruitmentStatus Model
	 * @var RecruitmentStatus
	 */
	protected $recruitmentstatus;

	/**
	 * Inject the models.
	 * @param RecruitmentStatus $recruitmentstatus
	 */
	public function __construct(User $user, RecruitmentStatus $recruitmentstatus)
	{
		parent::__construct();
		$this->user = $user;
		$this->recruitmentstatus = $recruitmentstatus;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_management');

	    // Grab all the recruitmentstatus
	    $recruitmentstatus = $this->recruitmentstatus;

        // Show the page
        return View::make('admin/recruitmentstatus/index', compact('recruitmentstatus', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/recruitmentstatus/create_edit', compact('user', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->recruitmentstatus->fill(Input::all())->save();

		    if( $this->recruitmentstatus->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitmentstatus/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitmentstatus/messages.create.error'));
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
     * @param $recruitmentstatus
     * @return Response
     */
    public function getEdit($recruitmentstatus)
    {
	    if ($recruitmentstatus->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/recruitmentstatus/create_edit', compact('recruitmentstatus', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/recruitmentstatus')->with('error', Lang::get('admin/recruitmentstatus/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function postEdit($recruitmentstatus)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $recruitmentstatus->fill(Input::all())->save();

		    if( $recruitmentstatus->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/recruitmentstatus/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/recruitmentstatus/messages.edit.error'));
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
     * Remove recruitmentstatus page.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function getDelete($recruitmentstatus)
    {
	    $recruitmentstatus->delete();

	    if (!empty($recruitmentstatus) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/recruitmentstatus/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/recruitmentstatus/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($recruitmentstatus)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the recruitmentstatus formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $recruitmentStatus = RecruitmentStatus::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($recruitmentStatus)
		        ->add_column('actions', '<div class="btn-group">
												<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/recruitmentstatus/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
													<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/recruitmentstatus/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
												</ul>
											</div>'
		        )
                ->remove_column('id')
                ->make();
    }
}
