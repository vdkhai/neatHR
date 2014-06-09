<?php
class AdminCountriesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Country Model
	 * @var Country
	 */
	protected $country;

	/**
	 * Inject the models.
	 * @param Country $country
	 */
	public function __construct(User $user, Country $country)
	{
		parent::__construct();
		$this->user = $user;
		$this->country = $country;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/countries/title.country_management');

	    // Grab all the country
	    $country = $this->country;

        // Show the page
        return View::make('admin/countries/index', compact('country', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/countries/title.country_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

	    // Show the page
	    $view = View::make('admin/countries/create_edit', compact('user', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'iso_code_2' => 'required|min:2|max:2', 'iso_code_3' => 'required|min:3|max:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->country->fill(Input::all())->save();

		    if( $this->country->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/countries/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/countries/messages.create.error'));
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
     * @param $country
     * @return Response
     */
    public function getEdit($country)
    {
	    if ($country->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/countries/title.country_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/countries/create_edit', compact('country', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/countries')->with('error', Lang::get('admin/countries/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $country
     * @return Response
     */
    public function postEdit($country)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'iso_code_2' => 'required|min:2|max:2', 'iso_code_3' => 'required|min:3|max:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $country->fill(Input::all())->save();

		    if( $country->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/countries/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/countries/messages.edit.error'));
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
     * Remove country page.
     *
     * @param $country
     * @return Response
     */
    public function getDelete($country)
    {
	    $country->delete();

	    if (!empty($country) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/countries/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/countries/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $country
	 * @return Response
	 */
	public function getShow($country)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the country formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $countries = Country::select(array('published', 'id', 'name', 'iso_code_2', 'iso_code_3'));

        return Datatables::of($countries)
		        ->add_column('actions', '<div class="btn-group">
												<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
												<ul class="dropdown-menu" role="menu">
													<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/countries/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
													<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/countries/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
												</ul>
											</div>'
		        )
                ->remove_column('id')
                ->make();
    }
}
