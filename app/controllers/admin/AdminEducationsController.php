<?php
class AdminEducationsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Education Model
	 * @var Education
	 */
	protected $education;

	/**
	 * Inject the models.
	 * @param Education $education
	 */
	public function __construct(User $user, Education $education)
	{
		parent::__construct();
		$this->user = $user;
		$this->education = $education;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/educations/title.education_management');

	    // Grab all the education
	    $education = $this->education;

        // Show the page
        return View::make('admin/educations/index', compact('education', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/educations/title.education_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/educations/create_edit', compact('user', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('short_name' => 'required', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->education->fill(Input::all())->save();

		    if( $this->education->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/educations/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/educations/messages.create.error'));
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
     * @param $education
     * @return Response
     */
    public function getEdit($education)
    {
	    if ($education->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/educations/title.education_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/educations/create_edit', compact('education', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/educations')->with('error', Lang::get('admin/educations/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $education
     * @return Response
     */
    public function postEdit($education)
    {
        // Validate the inputs
	    $validator = Validator::make(Input::all(), array('short_name' => 'required', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $education->fill(Input::all())->save();

		    if( $education->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/educations/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/educations/messages.edit.error'));
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
     * Remove education page.
     *
     * @param $education
     * @return Response
     */
    public function getDelete($education)
    {
	    $education->delete();

	    if (!empty($education) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/educations/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/educations/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $education
	 * @return Response
	 */
	public function getShow($education)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the education formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $educations = Education::select(array('published', 'id', 'short_name', 'name'));

        return Datatables::of($educations)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/educations/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/educations/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
