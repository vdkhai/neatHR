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

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/certifications/create_edit', compact('user', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
	        $this->certification->fill(Input::all())->save();

	        if( $this->certification->id )
	        {
		        $result['messages'] = array('success' => Lang::get('admin/certifications/messages.create.success'));
		        return Response::json(json_encode($result));
	        }
	        else
	        {
		        $result['messages'] = array('error' => Lang::get('admin/certifications/messages.create.error'));
		        return Response::json(json_encode($result));
	        }
	    }
	    else
	    {
			$result['failedValidate'] = true;
		    $result['messages'] = $validator->messages()->toJson();
		    return Response::json(json_encode($result));
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

	        // Show the page
	        $view = View::make('admin/certifications/create_edit', compact('certification', 'user', 'title', 'mode'));

	        return Response::make($view);
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
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $certification->fill(Input::all())->save();

		    if( $certification->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/certifications/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/certifications/messages.edit.error'));
			    return Response::json(json_encode($result));
		    }
	    }
	    else
	    {
		    $result['failedValidate'] = true;
		    $result['messages'] = $validator->messages()->toJson();
		    return Response::json(json_encode($result));
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
	    $certification->delete();

	    if (!empty($certification) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/certifications/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/certifications/messages.delete.error'));
		    return Response::json(json_encode($result));
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
                ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/certifications/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/certifications/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
							)
                ->remove_column('id')
                ->make();
    }
}
