<?php
class AdminOrganizationTypesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * OrganizationType Model
	 * @var OrganizationType
	 */
	protected $organizationtype;

	/**
	 * Inject the models.
	 * @param OrganizationType $organizationtype
	 */
	public function __construct(User $user, OrganizationType $organizationtype)
	{
		parent::__construct();
		$this->user = $user;
		$this->organizationtype = $organizationtype;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/organizationtypes/title.organizationtype_management');

	    // Grab all the organizationtype
	    $organizationtype = $this->organizationtype;

        // Show the page
        return View::make('admin/organizationtypes/index', compact('organizationtype', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/organizationtypes/title.organizationtype_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/organizationtypes/create_edit', compact('user', 'title', 'mode'));

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
		    $this->organizationtype->fill(Input::all())->save();

		    if( $this->organizationtype->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/organizationtypes/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/organizationtypes/messages.create.error'));
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
     * @param $organizationtype
     * @return Response
     */
    public function getEdit($organizationtype)
    {
	    if ($organizationtype->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/organizationtypes/title.organizationtype_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/organizationtypes/create_edit', compact('organizationtype', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/organizationtypes')->with('error', Lang::get('admin/organizationtypes/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $organizationtype
     * @return Response
     */
    public function postEdit($organizationtype)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $organizationtype->fill(Input::all())->save();

		    if( $organizationtype->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/organizationtypes/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/organizationtypes/messages.edit.error'));
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
     * Remove organizationtype page.
     *
     * @param $organizationtype
     * @return Response
     */
    public function getDelete($organizationtype)
    {
	    $organizationtype->delete();

	    if (!empty($organizationtype) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/organizationtypes/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/organizationtypes/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($organizationtype)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the organizationtype formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $organizationtypes = OrganizationType::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($organizationtypes)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/organizationtypes/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/organizationtypes/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
