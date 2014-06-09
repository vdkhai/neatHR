<?php
class AdminJobTitlesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * JobTitle Model
	 * @var JobTitle
	 */
	protected $jobtitle;

	/**
	 * Inject the models.
	 * @param JobTitle $jobtitle
	 */
	public function __construct(User $user, JobTitle $jobtitle)
	{
		parent::__construct();
		$this->user = $user;
		$this->jobtitle = $jobtitle;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/jobtitles/title.jobtitle_management');

	    // Grab all the jobtitle
	    $jobtitle = $this->jobtitle;

        // Show the page
        return View::make('admin/jobtitles/index', compact('jobtitle', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/jobtitles/title.jobtitle_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/jobtitles/create_edit', compact('user', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('code' => 'required|min:3', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->jobtitle->fill(Input::all())->save();

		    if( $this->jobtitle->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/jobtitles/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/jobtitles/messages.create.error'));
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
     * @param $jobtitle
     * @return Response
     */
    public function getEdit($jobtitle)
    {
	    if ($jobtitle->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/jobtitles/title.jobtitle_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/jobtitles/create_edit', compact('jobtitle', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/jobtitles')->with('error', Lang::get('admin/jobtitles/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $jobtitle
     * @return Response
     */
    public function postEdit($jobtitle)
    {
        // Validate the inputs
	    $validator = Validator::make(Input::all(), array('code' => 'required|min:3', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $jobtitle->fill(Input::all())->save();

		    if( $jobtitle->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/jobtitles/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/jobtitles/messages.edit.error'));
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
     * Remove jobtitle page.
     *
     * @param $jobtitle
     * @return Response
     */
    public function getDelete($jobtitle)
    {
	    $jobtitle->delete();

	    if (!empty($jobtitle) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/jobtitles/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/jobtitles/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($jobtitle)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the jobtitle formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $jobtitles = JobTitle::select(array('published', 'id', 'code', 'name', 'description', 'specification'));

        return Datatables::of($jobtitles)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/jobtitles/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/jobtitles/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
