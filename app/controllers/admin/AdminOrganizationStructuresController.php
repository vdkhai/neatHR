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
		return View::make('admin/organizationstructures/create_edit', compact('user', 'organizationTypes', 'countries', 'organizationParents', 'title', 'mode'));
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
	        $this->organizationstructure->title = Input::get( 'title' );
		    $this->organizationstructure->description = Input::get( 'description' );
		    $this->organizationstructure->address = Input::get( 'address' );
		    $this->organizationstructure->organization_type_id = Input::get( 'organization_type_id' );
		    $this->organizationstructure->country_id = Input::get( 'country_id' );
		    $this->organizationstructure->organization_parent_id = Input::get( 'organization_parent_id' );
	        $this->organizationstructure->published = Input::get( 'published' );

	        // Save if valid.
	        $this->organizationstructure->save();

	        if( $this->organizationstructure->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/organizationstructures/' . $this->organizationstructure->id . '/edit')->with('success', Lang::get('admin/organizationstructures/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->organizationstructure->errors()->all();
	            //return Redirect::to('admin/organizationstructures/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/organizationstructures/create')->with('error', Lang::get('admin/organizationstructures/messages.create.error'));
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

        	return View::make('admin/organizationstructures/create_edit', compact('organizationstructure', 'user', 'organizationTypes', 'countries', 'organizationParents', 'title', 'mode'));
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
	        $organizationstructure->title = Input::get( 'title' );
	        $organizationstructure->description = Input::get( 'description' );
	        $organizationstructure->address = Input::get( 'address' );
	        $organizationstructure->organization_type_id = Input::get( 'organization_type_id' );
	        $organizationstructure->country_id = Input::get( 'country_id' );
	        $organizationstructure->organization_parent_id = Input::get( 'organization_parent_id' );
	        $organizationstructure->published = Input::get( 'published' );

            // Save if valid
	        $organizationstructure->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/organizationstructures/' . $organizationstructure->id . '/edit')->with('success', Lang::get('admin/organizationstructures/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/organizationstructures/' . $organizationstructure->id . '/edit')->with('error', Lang::get('admin/organizationstructures/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/organizationstructures/title.organizationstructure_delete');

        // Show the page
        return View::make('admin/organizationstructures/delete', compact('organizationstructure', 'title'));
    }

    /**
     * Remove the specified organizationstructure from storage.
     *
     * @param $organizationstructure
     * @return Response
     */
    public function postDelete($organizationstructure)
    {
	    $organizationstructure->delete();

        if (!empty($organizationstructure) )
        {
            return Redirect::to('admin/organizationstructures')->with('success', Lang::get('admin/organizationstructures/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/organizationstructures')->with('error', Lang::get('admin/organizationstructures/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/organizationstructures/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/organizationstructures/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
