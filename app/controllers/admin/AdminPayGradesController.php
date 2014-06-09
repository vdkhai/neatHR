<?php
class AdminPayGradesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * PayGrade Model
	 * @var PayGrade
	 */
	protected $paygrade;

	/**
	 * Inject the models.
	 * @param PayGrade $paygrade
	 */
	public function __construct(User $user, PayGrade $paygrade)
	{
		parent::__construct();
		$this->user = $user;
		$this->paygrade = $paygrade;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/paygrades/title.paygrade_management');

	    // Grab all the paygrade
	    $paygrade = $this->paygrade;

        // Show the page
        return View::make('admin/paygrades/index', compact('paygrade', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/paygrades/title.paygrade_create');

	    $user = $this->user->currentUser();

	    $currencies = Currency::lists('name', 'id');

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/paygrades/create_edit', compact('user', 'currencies', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:2', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->paygrade->fill(Input::all())->save();

		    if( $this->paygrade->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/paygrades/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/paygrades/messages.create.error'));
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
     * @param $paygrade
     * @return Response
     */
    public function getEdit($paygrade)
    {
	    if ($paygrade->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/paygrades/title.paygrade_update');

	        $currencies = Currency::lists('name', 'id');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/paygrades/create_edit', compact('paygrade', 'user', 'currencies', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/paygrades')->with('error', Lang::get('admin/paygrades/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $paygrade
     * @return Response
     */
    public function postEdit($paygrade)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:2', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $paygrade->fill(Input::all())->save();

		    if( $paygrade->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/paygrades/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/paygrades/messages.edit.error'));
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
     * Remove paygrade page.
     *
     * @param $paygrade
     * @return Response
     */
    public function getDelete($paygrade)
    {
	    $paygrade->delete();

	    if (!empty($paygrade) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/paygrades/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/paygrades/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($paygrade)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the paygrade formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $paygrades = PayGrade::leftjoin('currencies', 'currencies.id', '=', 'pay_grades.currency_id')
	        ->select(array('pay_grades.published', 'pay_grades.id', 'currencies.name AS currency_name', 'pay_grades.name', 'pay_grades.description', 'pay_grades.min_salary', 'pay_grades.max_salary'));

        return Datatables::of($paygrades)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/paygrades/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/paygrades/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
