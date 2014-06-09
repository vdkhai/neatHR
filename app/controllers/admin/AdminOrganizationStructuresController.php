<?php
class AdminOrganizationStructuresController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * OrganizationStructure Model
	 * @var OrganizationStructure
	 */
	protected $organizationstructure;

	/**
	 * Inject the models.
	 * @param OrganizationStructure $organizationstructure
	 */
	public function __construct(User $user, OrganizationStructure $organizationstructure)
	{
		parent::__construct();
		$this->user = $user;
		$this->organizationstructure = $organizationstructure;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/organizationstructures/title.organizationstructure_management');

	    // Grab all the organizationstructure
	    $organizationstructure = $this->organizationstructure;

        // Show the page
        return View::make('admin/organizationstructures/index', compact('organizationstructure', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/organizationstructures/title.organizationstructure_create');

	    $user = $this->user->currentUser();

	    $organizationTypes = OrganizationType::lists('name', 'id');

	    $countries = Country::lists('name', 'id');

	    $organizationParents = OrganizationStructure::lists('title', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/organizationstructures/create_edit', compact('user', 'organizationTypes', 'countries', 'organizationParents', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('title' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->organizationstructure->fill(Input::all())->save();

		    if( $this->organizationstructure->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/organizationstructures/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/organizationstructures/messages.create.error'));
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
     * @param $organizationstructure
     * @return Response
     */
    public function getEdit($organizationstructure)
    {
	    if ($organizationstructure->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/organizationstructures/title.organizationstructure_update');

		    $organizationTypes = OrganizationType::lists('name', 'id');

		    $countries = Country::lists('name', 'id');

		    $organizationParents = OrganizationStructure::lists('title', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/organizationstructures/create_edit', compact('organizationstructure', 'user', 'organizationTypes', 'countries', 'organizationParents', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/organizationstructures')->with('error', Lang::get('admin/organizationstructures/messages.does_not_exist'));
	    }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param $organizationstructure
     * @return Response
     */
    public function postEdit($organizationstructure)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('title' => 'required'));

	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $organizationstructure->fill(Input::all())->save();

		    if( $organizationstructure->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/organizationstructures/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/organizationstructures/messages.edit.error'));
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
     * Remove organizationstructure page.
     *
     * @param $organizationstructure
     * @return Response
     */
    public function getDelete($organizationstructure)
    {
	    $organizationstructure->delete();

	    if (!empty($organizationstructure) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/organizationstructures/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/organizationstructures/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($organizationstructure)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the organizationstructure formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $organizationStructures = OrganizationStructure::leftjoin('countries', 'countries.id', '=', 'organization_structures.country_id')
            ->leftjoin('organization_types', 'organization_types.id', '=', 'organization_structures.organization_type_id')
	        ->select(array('organization_structures.published', 'organization_structures.id', 'organization_structures.title', 'organization_structures.description', 'organization_structures.address', 'organization_types.name AS type', 'countries.name'));

        return Datatables::of($organizationStructures)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/organizationstructures/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/organizationstructures/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		        )
                ->remove_column('id')
                ->make();
    }
}
