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
		return View::make('admin/organizationtypes/create_edit', compact('user', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('name' => 'required'));
	    if ($validator->passes())
	    {
	        $this->organizationtype->name = Input::get( 'name' );
		    $this->organizationtype->description = Input::get( 'description' );
	        $this->organizationtype->published = Input::get( 'published' );

	        // Save if valid.
	        $this->organizationtype->save();

	        if( $this->organizationtype->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/organizationtypes/' . $this->organizationtype->id . '/edit')->with('success', Lang::get('admin/organizationtypes/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->organizationtype->errors()->all();
	            //return Redirect::to('admin/organizationtypes/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/organizationtypes/create')->with('error', Lang::get('admin/organizationtypes/messages.create.error'));
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

        	return View::make('admin/organizationtypes/create_edit', compact('organizationtype', 'user', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $organizationtype->name = Input::get( 'name' );
	        $organizationtype->description = Input::get( 'description' );
	        $organizationtype->published = Input::get( 'published' );

            // Save if valid
	        $organizationtype->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/organizationtypes/' . $organizationtype->id . '/edit')->with('success', Lang::get('admin/organizationtypes/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/organizationtypes/' . $organizationtype->id . '/edit')->with('error', Lang::get('admin/organizationtypes/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/organizationtypes/title.organizationtype_delete');

        // Show the page
        return View::make('admin/organizationtypes/delete', compact('organizationtype', 'title'));
    }

    /**
     * Remove the specified organizationtype from storage.
     *
     * @param $organizationtype
     * @return Response
     */
    public function postDelete($organizationtype)
    {
	    $organizationtype->delete();

        if (!empty($organizationtype) )
        {
            return Redirect::to('admin/organizationtypes')->with('success', Lang::get('admin/organizationtypes/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/organizationtypes')->with('error', Lang::get('admin/organizationtypes/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/organizationtypes/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/organizationtypes/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
