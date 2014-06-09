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
	    $view = View::make('admin/employmenttypes/create_edit', compact('user', 'title', 'mode'));

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
		    $this->employmenttype->fill(Input::all())->save();

		    if( $this->employmenttype->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employmenttypes/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employmenttypes/messages.create.error'));
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

		    // Show the page
		    $view = View::make('admin/employmenttypes/create_edit', compact('employmenttype', 'user', 'title', 'mode'));

		    return Response::make($view);
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
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $employmenttype->fill(Input::all())->save();

		    if( $employmenttype->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employmenttypes/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employmenttypes/messages.edit.error'));
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
     * Remove employmenttype page.
     *
     * @param $employmenttype
     * @return Response
     */
    public function getDelete($employmenttype)
    {
	    $employmenttype->delete();

	    if (!empty($employmenttype) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employmenttypes/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employmenttypes/messages.delete.error'));
		    return Response::json(json_encode($result));
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
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employmenttypes/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employmenttypes/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
