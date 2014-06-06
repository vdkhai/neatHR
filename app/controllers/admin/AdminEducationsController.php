<?php
class AdminEducationsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Education Model
	 * @var Education
	 */
	protected $education;

	/**
	 * Inject the models.
	 * @param Education $education
	 */
	public function __construct(User $user, Education $education)
	{
		parent::__construct();
		$this->user = $user;
		$this->education = $education;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/educations/title.education_management');

	    // Grab all the education
	    $education = $this->education;

        // Show the page
        return View::make('admin/educations/index', compact('education', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/educations/title.education_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/educations/create_edit', compact('user', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('short_name' => 'required', 'name' => 'required'));
	    if ($validator->passes())
	    {
		    $this->education->short_name = Input::get('short_name');
	        $this->education->name = Input::get('name');
	        $this->education->published = Input::get('published');

	        // Save if valid.
	        $this->education->save();

	        if( $this->education->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/educations/' . $this->education->id . '/edit')->with('success', Lang::get('admin/educations/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->education->errors()->all();
	            //return Redirect::to('admin/educations/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/educations/create')->with('error', Lang::get('admin/educations/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $education
     * @return Response
     */
    public function getEdit($education)
    {
        if ($education->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/educations/title.education_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/educations/create_edit', compact('education', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/educations')->with('error', Lang::get('admin/educations/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $education
     * @return Response
     */
    public function postEdit($education)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $education->name = Input::get( 'name' );
	        $education->published = Input::get( 'published' );

            // Save if valid
	        $education->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/educations/' . $education->id . '/edit')->with('success', Lang::get('admin/educations/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/educations/' . $education->id . '/edit')->with('error', Lang::get('admin/educations/messages.edit.error'));
        }
    }

    /**
     * Remove education page.
     *
     * @param $education
     * @return Response
     */
    public function getDelete($education)
    {
        // Title
        $title = Lang::get('admin/educations/title.education_delete');

        // Show the page
        return View::make('admin/educations/delete', compact('education', 'title'));
    }

    /**
     * Remove the specified education from storage.
     *
     * @param $education
     * @return Response
     */
    public function postDelete($education)
    {
	    $education->delete();

        if (!empty($education) )
        {
            return Redirect::to('admin/educations')->with('success', Lang::get('admin/educations/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/educations')->with('error', Lang::get('admin/educations/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $education
	 * @return Response
	 */
	public function getShow($education)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the education formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $educations = Education::select(array('published', 'id', 'short_name', 'name'));

        return Datatables::of($educations)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/educations/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/educations/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
