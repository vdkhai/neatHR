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
	    $view = View::make('admin/marriages/create_edit', compact('user', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->marriage->fill(Input::all())->save();

		    if( $this->marriage->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/marriages/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/marriages/messages.create.error'));
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

		    // Show the page
		    $view = View::make('admin/marriages/create_edit', compact('marriage', 'user', 'title', 'mode'));

		    return Response::make($view);
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
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $marriage->fill(Input::all())->save();

		    if( $marriage->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/marriages/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/marriages/messages.edit.error'));
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
     * Remove marriage page.
     *
     * @param $marriage
     * @return Response
     */
    public function getDelete($marriage)
    {
	    $marriage->delete();

	    if (!empty($marriage) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/marriages/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/marriages/messages.delete.error'));
		    return Response::json(json_encode($result));
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
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/marriages/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/marriages/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		        )
                ->remove_column('id')
                ->make();
    }
}
