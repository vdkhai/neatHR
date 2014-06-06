<?php
class AdminJobTitlesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * JobTitle Model
	 * @var JobTitle
	 */
	protected $jobtitle;

	/**
	 * Inject the models.
	 * @param JobTitle $jobtitle
	 */
	public function __construct(User $user, JobTitle $jobtitle)
	{
		parent::__construct();
		$this->user = $user;
		$this->jobtitle = $jobtitle;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/jobtitles/title.jobtitle_management');

	    // Grab all the jobtitle
	    $jobtitle = $this->jobtitle;

        // Show the page
        return View::make('admin/jobtitles/index', compact('jobtitle', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/jobtitles/title.jobtitle_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/jobtitles/create_edit', compact('user', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('code' => 'required', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $this->jobtitle->code = Input::get( 'code' );
	        $this->jobtitle->name = Input::get( 'name' );
		    $this->jobtitle->description = Input::get( 'description' );
		    $this->jobtitle->specification = Input::get( 'specification' );
	        $this->jobtitle->published = Input::get( 'published' );

	        // Save if valid.
	        $this->jobtitle->save();

	        if( $this->jobtitle->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/jobtitles/' . $this->jobtitle->id . '/edit')->with('success', Lang::get('admin/jobtitles/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->jobtitle->errors()->all();
	            //return Redirect::to('admin/jobtitles/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/jobtitles/create')->with('error', Lang::get('admin/jobtitles/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $jobtitle
     * @return Response
     */
    public function getEdit($jobtitle)
    {
        if ($jobtitle->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/jobtitles/title.jobtitle_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/jobtitles/create_edit', compact('jobtitle', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/jobtitles')->with('error', Lang::get('admin/jobtitles/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $jobtitle
     * @return Response
     */
    public function postEdit($jobtitle)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('code' => 'required', 'name' => 'required'));

        if ($validator->passes())
        {
	        $jobtitle->code = Input::get( 'code' );
	        $jobtitle->name = Input::get( 'name' );
	        $jobtitle->description = Input::get( 'description' );
	        $jobtitle->specification = Input::get( 'specification' );
	        $jobtitle->published = Input::get( 'published' );

            // Save if valid
	        $jobtitle->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/jobtitles/' . $jobtitle->id . '/edit')->with('success', Lang::get('admin/jobtitles/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/jobtitles/' . $jobtitle->id . '/edit')->with('error', Lang::get('admin/jobtitles/messages.edit.error'));
        }
    }

    /**
     * Remove jobtitle page.
     *
     * @param $jobtitle
     * @return Response
     */
    public function getDelete($jobtitle)
    {
        // Title
        $title = Lang::get('admin/jobtitles/title.jobtitle_delete');

        // Show the page
        return View::make('admin/jobtitles/delete', compact('jobtitle', 'title'));
    }

    /**
     * Remove the specified jobtitle from storage.
     *
     * @param $jobtitle
     * @return Response
     */
    public function postDelete($jobtitle)
    {
	    $jobtitle->delete();

        if (!empty($jobtitle) )
        {
            return Redirect::to('admin/jobtitles')->with('success', Lang::get('admin/jobtitles/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/jobtitles')->with('error', Lang::get('admin/jobtitles/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($jobtitle)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the jobtitle formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $jobtitles = JobTitle::select(array('published', 'id', 'code', 'name', 'description', 'specification'));

        return Datatables::of($jobtitles)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/jobtitles/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/jobtitles/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
