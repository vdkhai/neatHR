<?php
class AdminRecruitmentStatusController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * RecruitmentStatus Model
	 * @var RecruitmentStatus
	 */
	protected $recruitmentstatus;

	/**
	 * Inject the models.
	 * @param RecruitmentStatus $recruitmentstatus
	 */
	public function __construct(User $user, RecruitmentStatus $recruitmentstatus)
	{
		parent::__construct();
		$this->user = $user;
		$this->recruitmentstatus = $recruitmentstatus;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_management');

	    // Grab all the recruitmentstatus
	    $recruitmentstatus = $this->recruitmentstatus;

        // Show the page
        return View::make('admin/recruitmentstatus/index', compact('recruitmentstatus', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/recruitmentstatus/create_edit', compact('user', 'title', 'mode'));
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
	        $this->recruitmentstatus->name = Input::get( 'name' );
		    $this->recruitmentstatus->description = Input::get( 'description' );
	        $this->recruitmentstatus->published = Input::get( 'published' );

	        // Save if valid.
	        $this->recruitmentstatus->save();

	        if( $this->recruitmentstatus->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/recruitmentstatus/' . $this->recruitmentstatus->id . '/edit')->with('success', Lang::get('admin/recruitmentstatus/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->recruitmentstatus->errors()->all();
	            //return Redirect::to('admin/recruitmentstatus/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/recruitmentstatus/create')->with('error', Lang::get('admin/recruitmentstatus/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function getEdit($recruitmentstatus)
    {
        if ($recruitmentstatus->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/recruitmentstatus/create_edit', compact('recruitmentstatus', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/recruitmentstatus')->with('error', Lang::get('admin/recruitmentstatus/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function postEdit($recruitmentstatus)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $recruitmentstatus->name = Input::get( 'name' );
	        $recruitmentstatus->description = Input::get( 'description' );
	        $recruitmentstatus->published = Input::get( 'published' );

            // Save if valid
	        $recruitmentstatus->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/recruitmentstatus/' . $recruitmentstatus->id . '/edit')->with('success', Lang::get('admin/recruitmentstatus/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/recruitmentstatus/' . $recruitmentstatus->id . '/edit')->with('error', Lang::get('admin/recruitmentstatus/messages.edit.error'));
        }
    }

    /**
     * Remove recruitmentstatus page.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function getDelete($recruitmentstatus)
    {
        // Title
        $title = Lang::get('admin/recruitmentstatus/title.recruitmentstatus_delete');

        // Show the page
        return View::make('admin/recruitmentstatus/delete', compact('recruitmentstatus', 'title'));
    }

    /**
     * Remove the specified recruitmentstatus from storage.
     *
     * @param $recruitmentstatus
     * @return Response
     */
    public function postDelete($recruitmentstatus)
    {
	    $recruitmentstatus->delete();

        if (!empty($recruitmentstatus) )
        {
            return Redirect::to('admin/recruitmentstatus')->with('success', Lang::get('admin/recruitmentstatus/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/recruitmentstatus')->with('error', Lang::get('admin/recruitmentstatus/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($recruitmentstatus)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the recruitmentstatus formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $recruitmentStatus = RecruitmentStatus::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($recruitmentStatus)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/recruitmentstatus/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/recruitmentstatus/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
