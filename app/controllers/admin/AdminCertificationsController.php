<?php
class AdminCertificationsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Certification Model
	 * @var Certification
	 */
	protected $certification;

	/**
	 * Inject the models.
	 * @param Certification $certification
	 */
	public function __construct(User $user, Certification $certification)
	{
		parent::__construct();
		$this->user = $user;
		$this->certification = $certification;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/certifications/title.certification_management');

	    // Grab all the certification
	    $certification = $this->certification;

        // Show the page
        return View::make('admin/certifications/index', compact('certification', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/certifications/title.certification_create');

	    $user = $this->user->currentUser();

	    // Show the page
	    $view = View::make('admin/certifications/create', compact('user', 'title'));

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
	    $validator = Validator::make(Input::all(), array('name' => 'required'));
	    if ($validator->passes())
	    {
	        // Save if valid.
	        $this->certification->fill(Input::all())->save();

	        if( $this->certification->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/certifications/' . $this->certification->id . '/edit')->with('success', Lang::get('admin/certifications/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->certification->errors()->all();
	            //return Redirect::to('admin/certifications/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $input = Input::all();
		    $input['openModal'] = true;
			//return Redirect::to('admin/certifications/create')->withErrors($validator)->withInput($input);

		    return Response::json(array('result' => $input));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $certification
     * @return Response
     */
    public function getEdit($certification)
    {
        if ($certification->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/certifications/title.certification_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/certifications/create_edit', compact('certification', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/certifications')->with('error', Lang::get('admin/certifications/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $certification
     * @return Response
     */
    public function postEdit($certification)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $certification->name = Input::get( 'name' );
	        $certification->description = Input::get( 'description' );
	        $certification->published = Input::get( 'published' );

            // Save if valid
	        $certification->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/certifications/' . $certification->id . '/edit')->with('success', Lang::get('admin/certifications/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/certifications/' . $certification->id . '/edit')->with('error', Lang::get('admin/certifications/messages.edit.error'));
        }
    }

    /**
     * Remove certification page.
     *
     * @param $certification
     * @return Response
     */
    public function getDelete($certification)
    {
        // Title
        $title = Lang::get('admin/certifications/title.certification_delete');

        // Show the page
        return View::make('admin/certifications/delete', compact('certification', 'title'));
    }

    /**
     * Remove the specified certification from storage.
     *
     * @param $certification
     * @return Response
     */
    public function postDelete($certification)
    {
	    $certification->delete();

        if (!empty($certification) )
        {
            return Redirect::to('admin/certifications')->with('success', Lang::get('admin/certifications/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/certifications')->with('error', Lang::get('admin/certifications/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($certification)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the certification formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $certifications = Certification::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($certifications)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/certifications/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/certifications/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
