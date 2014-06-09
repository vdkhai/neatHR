<?php
class AdminStatesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * State Model
	 * @var State
	 */
	protected $state;

	/**
	 * Inject the models.
	 * @param State $state
	 */
	public function __construct(User $user, State $state)
	{
		parent::__construct();
		$this->user = $user;
		$this->state = $state;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/states/title.state_management');

	    // Grab all the state
	    $state = $this->state;

        // Show the page
        return View::make('admin/states/index', compact('state', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/states/title.state_create');

	    $user = $this->user->currentUser();

	    // Get state list
	    $countries = Country::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/states/create_edit', compact('user', 'countries', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->state->fill(Input::all())->save();

		    if( $this->state->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/states/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/states/messages.create.error'));
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
     * @param $state
     * @return Response
     */
    public function getEdit($state)
    {
	    if ($state->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/states/title.state_update');

		    // Get state list
		    $countries = Country::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/states/create_edit', compact('state', 'user', 'countries', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/states')->with('error', Lang::get('admin/states/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $state
     * @return Response
     */
    public function postEdit($state)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $state->fill(Input::all())->save();

		    if( $state->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/states/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/states/messages.edit.error'));
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
     * Remove $state page.
     *
     * @param $state
     * @return Response
     */
    public function getDelete($state)
    {
	    $state->delete();

	    if (!empty($state) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/states/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/states/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $state
	 * @return Response
	 */
	public function getShow($state)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the state formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $states = State::leftjoin('countries', 'countries.id', '=', 'states.country_id')
	                 ->select(array('states.published', 'states.id', 'countries.name as country_name', 'states.name', 'states.code'));

        return Datatables::of($states)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/states/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/states/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
