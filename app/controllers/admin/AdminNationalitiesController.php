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
		return View::make('admin/nationalities/create_edit', compact('user', 'title', 'mode'));
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
	        $this->nationality->name = Input::get( 'name' );
		    $this->nationality->description = Input::get( 'description' );
	        $this->nationality->published = Input::get( 'published' );

	        // Save if valid.
	        $this->nationality->save();

	        if( $this->nationality->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/nationalities/' . $this->nationality->id . '/edit')->with('success', Lang::get('admin/nationalities/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->nationality->errors()->all();
	            //return Redirect::to('admin/nationalities/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/nationalities/create')->with('error', Lang::get('admin/nationalities/messages.create.error'));
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

        	return View::make('admin/nationalities/create_edit', compact('nationality', 'user', 'title', 'mode'));
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
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $nationality->name = Input::get( 'name' );
	        $nationality->description = Input::get( 'description' );
	        $nationality->published = Input::get( 'published' );

            // Save if valid
	        $nationality->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/nationalities/' . $nationality->id . '/edit')->with('success', Lang::get('admin/nationalities/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/nationalities/' . $nationality->id . '/edit')->with('error', Lang::get('admin/nationalities/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/nationalities/title.nationality_delete');

        // Show the page
        return View::make('admin/nationalities/delete', compact('nationality', 'title'));
    }

    /**
     * Remove the specified nationality from storage.
     *
     * @param $nationality
     * @return Response
     */
    public function postDelete($nationality)
    {
	    $nationality->delete();

        if (!empty($nationality) )
        {
            return Redirect::to('admin/nationalities')->with('success', Lang::get('admin/nationalities/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/nationalities')->with('error', Lang::get('admin/nationalities/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/nationalities/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/nationalities/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
