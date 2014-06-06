<?php
class AdminMarriagesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Marriage Model
	 * @var Marriage
	 */
	protected $marriage;

	/**
	 * Inject the models.
	 * @param Marriage $marriage
	 */
	public function __construct(User $user, Marriage $marriage)
	{
		parent::__construct();
		$this->user = $user;
		$this->marriage = $marriage;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/marriages/title.marriage_management');

	    // Grab all the marriage
	    $marriage = $this->marriage;

        // Show the page
        return View::make('admin/marriages/index', compact('marriage', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/marriages/title.marriage_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/marriages/create_edit', compact('user', 'title', 'mode'));
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
	        $this->marriage->name = Input::get( 'name' );
	        $this->marriage->published = Input::get( 'published' );

	        // Save if valid.
	        $this->marriage->save();

	        if( $this->marriage->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/marriages/' . $this->marriage->id . '/edit')->with('success', Lang::get('admin/marriages/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->marriage->errors()->all();
	            //return Redirect::to('admin/marriages/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/marriages/create')->with('error', Lang::get('admin/marriages/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $marriage
     * @return Response
     */
    public function getEdit($marriage)
    {
        if ($marriage->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/marriages/title.marriage_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/marriages/create_edit', compact('marriage', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/marriages')->with('error', Lang::get('admin/marriages/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $marriage
     * @return Response
     */
    public function postEdit($marriage)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $marriage->name = Input::get( 'name' );
	        $marriage->published = Input::get( 'published' );

            // Save if valid
	        $marriage->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/marriages/' . $marriage->id . '/edit')->with('success', Lang::get('admin/marriages/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/marriages/' . $marriage->id . '/edit')->with('error', Lang::get('admin/marriages/messages.edit.error'));
        }
    }

    /**
     * Remove marriage page.
     *
     * @param $marriage
     * @return Response
     */
    public function getDelete($marriage)
    {
        // Title
        $title = Lang::get('admin/marriages/title.marriage_delete');

        // Show the page
        return View::make('admin/marriages/delete', compact('marriage', 'title'));
    }

    /**
     * Remove the specified marriage from storage.
     *
     * @param $marriage
     * @return Response
     */
    public function postDelete($marriage)
    {
	    $marriage->delete();

        if (!empty($marriage) )
        {
            return Redirect::to('admin/marriages')->with('success', Lang::get('admin/marriages/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/marriages')->with('error', Lang::get('admin/marriages/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $marriage
	 * @return Response
	 */
	public function getShow($marriage)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the marriage formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $marriages = Marriage::select(array('published', 'id', 'name'));

        return Datatables::of($marriages)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/marriages/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/marriages/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
