<?php
class AdminDependentsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Dependent Model
	 * @var Dependent
	 */
	protected $dependent;

	/**
	 * Inject the models.
	 * @param Dependent $dependent
	 */
	public function __construct(User $user, Dependent $dependent)
	{
		parent::__construct();
		$this->user = $user;
		$this->dependent = $dependent;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/dependents/title.dependent_management');

	    // Grab all the dependent
	    $dependent = $this->dependent;

        // Show the page
        return View::make('admin/dependents/index', compact('dependent', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/dependents/title.dependent_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/dependents/create_edit', compact('user', 'title', 'mode'));
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
	        $this->dependent->name = Input::get( 'name' );
	        $this->dependent->published = Input::get( 'published' );

	        // Save if valid.
	        $this->dependent->save();

	        if( $this->dependent->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/dependents/' . $this->dependent->id . '/edit')->with('success', Lang::get('admin/dependents/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->dependent->errors()->all();
	            //return Redirect::to('admin/dependents/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/dependents/create')->with('error', Lang::get('admin/dependents/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $dependent
     * @return Response
     */
    public function getEdit($dependent)
    {
        if ($dependent->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/dependents/title.dependent_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/dependents/create_edit', compact('dependent', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/dependents')->with('error', Lang::get('admin/dependents/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $dependent
     * @return Response
     */
    public function postEdit($dependent)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $dependent->name = Input::get( 'name' );
	        $dependent->published = Input::get( 'published' );

            // Save if valid
	        $dependent->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/dependents/' . $dependent->id . '/edit')->with('success', Lang::get('admin/dependents/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/dependents/' . $dependent->id . '/edit')->with('error', Lang::get('admin/dependents/messages.edit.error'));
        }
    }

    /**
     * Remove dependent page.
     *
     * @param $dependent
     * @return Response
     */
    public function getDelete($dependent)
    {
        // Title
        $title = Lang::get('admin/dependents/title.dependent_delete');

        // Show the page
        return View::make('admin/dependents/delete', compact('dependent', 'title'));
    }

    /**
     * Remove the specified dependent from storage.
     *
     * @param $dependent
     * @return Response
     */
    public function postDelete($dependent)
    {
	    $dependent->delete();

        if (!empty($dependent) )
        {
            return Redirect::to('admin/dependents')->with('success', Lang::get('admin/dependents/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/dependents')->with('error', Lang::get('admin/dependents/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $dependent
	 * @return Response
	 */
	public function getShow($dependent)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the dependent formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $dependents = Dependent::select(array('published', 'id', 'name'));

        return Datatables::of($dependents)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/dependents/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/dependents/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
