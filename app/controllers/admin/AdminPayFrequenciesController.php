<?php
class AdminPayFrequenciesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * PayFrequency Model
	 * @var PayFrequency
	 */
	protected $payfrequency;

	/**
	 * Inject the models.
	 * @param PayFrequency $payfrequency
	 */
	public function __construct(User $user, PayFrequency $payfrequency)
	{
		parent::__construct();
		$this->user = $user;
		$this->payfrequency = $payfrequency;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/payfrequencies/title.payfrequency_management');

	    // Grab all the payfrequency
	    $payfrequency = $this->payfrequency;

        // Show the page
        return View::make('admin/payfrequencies/index', compact('payfrequency', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/payfrequencies/title.payfrequency_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/payfrequencies/create_edit', compact('user', 'title', 'mode'));

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
		    $this->payfrequency->fill(Input::all())->save();

		    if( $this->payfrequency->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/payfrequencies/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/payfrequencies/messages.create.error'));
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
     * @param $payfrequency
     * @return Response
     */
    public function getEdit($payfrequency)
    {
	    if ($payfrequency->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/payfrequencies/title.payfrequency_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/payfrequencies/create_edit', compact('payfrequency', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/payfrequencies')->with('error', Lang::get('admin/payfrequencies/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $payfrequency
     * @return Response
     */
    public function postEdit($payfrequency)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $payfrequency->fill(Input::all())->save();

		    if( $payfrequency->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/payfrequencies/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/payfrequencies/messages.edit.error'));
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
     * Remove payfrequency page.
     *
     * @param $payfrequency
     * @return Response
     */
    public function getDelete($payfrequency)
    {
	    $payfrequency->delete();

	    if (!empty($payfrequency) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/payfrequencies/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/payfrequencies/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $payfrequency
	 * @return Response
	 */
	public function getShow($payfrequency)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the payfrequency formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $payFrequencies = PayFrequency::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($payFrequencies)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/payfrequencies/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/payfrequencies/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
	                        )
                ->remove_column('id')
                ->make();
    }
}
