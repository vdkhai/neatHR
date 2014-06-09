<?php
class AdminNationalitiesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Nationality Model
	 * @var Nationality
	 */
	protected $nationality;

	/**
	 * Inject the models.
	 * @param Nationality $nationality
	 */
	public function __construct(User $user, Nationality $nationality)
	{
		parent::__construct();
		$this->user = $user;
		$this->nationality = $nationality;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/nationalities/title.nationality_management');

	    // Grab all the nationality
	    $nationality = $this->nationality;

        // Show the page
        return View::make('admin/nationalities/index', compact('nationality', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/nationalities/title.nationality_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/nationalities/create_edit', compact('user', 'title', 'mode'));

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
		    $this->nationality->fill(Input::all())->save();

		    if( $this->nationality->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/nationalities/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/nationalities/messages.create.error'));
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
     * @param $nationality
     * @return Response
     */
    public function getEdit($nationality)
    {
	    if ($nationality->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/nationalities/title.nationality_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/nationalities/create_edit', compact('nationality', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/nationalities')->with('error', Lang::get('admin/nationalities/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $nationality
     * @return Response
     */
    public function postEdit($nationality)
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $nationality->fill(Input::all())->save();

		    if( $nationality->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/nationalities/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/nationalities/messages.edit.error'));
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
     * Remove nationality page.
     *
     * @param $nationality
     * @return Response
     */
    public function getDelete($nationality)
    {
	    $nationality->delete();

	    if (!empty($nationality) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/nationalities/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/nationalities/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $nationality
	 * @return Response
	 */
	public function getShow($nationality)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the nationality formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $nationalities = Nationality::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($nationalities)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/nationalities/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/nationalities/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
