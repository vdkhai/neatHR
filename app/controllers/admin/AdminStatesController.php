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

	    // Get state list
	    $countries = Country::lists('name', 'id');

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/states/create_edit', compact('countries', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required'));

	    if($validator->passes())
	    {
		    $this->state->name = Input::get( 'name' );
		    $this->state->country_id = Input::get( 'country_id' );
		    $this->state->code = Input::get( 'code' );

		    // Save if valid.
		    $this->state->save();

		    if( $this->state->id )
		    {
			    // Redirect to the new state page
			    return Redirect::to('admin/states/' . $this->state->id . '/edit')->with('success', Lang::get('admin/states/messages.create.success'));
		    }
		    else
		    {
			    // Get validation errors (see Ardent package)
			    //$error = $this->state->errors()->all();
			    //return Redirect::to('admin/states/create')
				//    ->withInput(Input::except('password'))
				//    ->with( 'error', $error );
		    }
	    }
	    else
	    {
		    $error = $validator->messages();
		    return Redirect::to('admin/states/create')->with('error', Lang::get('admin/states/messages.create.error'));
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
            // Title
        	$title = Lang::get('admin/states/title.state_update');

	        $user = $this->user->currentUser();

	        // Get state list
	        $countries = Country::lists('name', 'id');

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/states/create_edit', compact('user', 'countries', 'state', 'title', 'mode'));
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
	    $validator = Validator::make(Input::all(), array('name' => 'required'));

	    if($validator->passes())
	    {
		    $state->name = Input::get( 'name' );
		    $state->country_id = Input::get( 'country_id' );
		    $state->code = Input::get( 'code' );

		    // Save if valid.
		    $state->save();

			// Redirect to the new state page
			return Redirect::to('admin/states/' . $state->id . '/edit')->with('success', Lang::get('admin/states/messages.create.success'));
	    }
	    else
	    {
		    $error = $validator->messages();
		    return Redirect::to('admin/states/create')->with('error', Lang::get('admin/states/messages.create.error'));
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
        // Title
        $title = Lang::get('admin/states/title.state_delete');

        // Show the page
        return View::make('admin/states/delete', compact('state', 'title'));
    }

    /**
     * Remove the specified state from storage.
     *
     * @param $states
     * @return Response
     */
    public function postDelete($states)
    {
	    $states->delete();

	    if (!empty($states) )
	    {
		    return Redirect::to('admin/states')->with('success', Lang::get('admin/states/messages.delete.success'));
	    }
	    else
	    {
		    // There was a problem deleting the user
		    return Redirect::to('admin/states')->with('error', Lang::get('admin/states/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/states/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/states/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
