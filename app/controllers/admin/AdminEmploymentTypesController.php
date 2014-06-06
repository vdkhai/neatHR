<?php
class AdminEmploymentTypesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * EmploymentType Model
	 * @var EmploymentType
	 */
	protected $employmenttype;

	/**
	 * Inject the models.
	 * @param EmploymentType $employmenttype
	 */
	public function __construct(User $user, EmploymentType $employmenttype)
	{
		parent::__construct();
		$this->user = $user;
		$this->employmenttype = $employmenttype;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/employmenttypes/title.employmenttype_management');

	    // Grab all the employmenttype
	    $employmenttype = $this->employmenttype;

        // Show the page
        return View::make('admin/employmenttypes/index', compact('employmenttype', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/employmenttypes/title.employmenttype_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/employmenttypes/create_edit', compact('user', 'title', 'mode'));
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
	        $this->employmenttype->name = Input::get( 'name' );
		    $this->employmenttype->description = Input::get( 'description' );
	        $this->employmenttype->published = Input::get( 'published' );

	        // Save if valid.
	        $this->employmenttype->save();

	        if( $this->employmenttype->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/employmenttypes/' . $this->employmenttype->id . '/edit')->with('success', Lang::get('admin/employmenttypes/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->employmenttype->errors()->all();
	            //return Redirect::to('admin/employmenttypes/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/employmenttypes/create')->with('error', Lang::get('admin/employmenttypes/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $employmenttype
     * @return Response
     */
    public function getEdit($employmenttype)
    {
        if ($employmenttype->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/employmenttypes/title.employmenttype_update');

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/employmenttypes/create_edit', compact('employmenttype', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/employmenttypes')->with('error', Lang::get('admin/employmenttypes/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employmenttype
     * @return Response
     */
    public function postEdit($employmenttype)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $employmenttype->name = Input::get( 'name' );
	        $employmenttype->description = Input::get( 'description' );
	        $employmenttype->published = Input::get( 'published' );

            // Save if valid
	        $employmenttype->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/employmenttypes/' . $employmenttype->id . '/edit')->with('success', Lang::get('admin/employmenttypes/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/employmenttypes/' . $employmenttype->id . '/edit')->with('error', Lang::get('admin/employmenttypes/messages.edit.error'));
        }
    }

    /**
     * Remove employmenttype page.
     *
     * @param $employmenttype
     * @return Response
     */
    public function getDelete($employmenttype)
    {
        // Title
        $title = Lang::get('admin/employmenttypes/title.employmenttype_delete');

        // Show the page
        return View::make('admin/employmenttypes/delete', compact('employmenttype', 'title'));
    }

    /**
     * Remove the specified employmenttype from storage.
     *
     * @param $employmenttype
     * @return Response
     */
    public function postDelete($employmenttype)
    {
	    $employmenttype->delete();

        if (!empty($employmenttype) )
        {
            return Redirect::to('admin/employmenttypes')->with('success', Lang::get('admin/employmenttypes/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/employmenttypes')->with('error', Lang::get('admin/employmenttypes/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $employmenttype
	 * @return Response
	 */
	public function getShow($employmenttype)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the employmenttype formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $employmenttypes = EmploymentType::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($employmenttypes)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/employmenttypes/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/employmenttypes/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
