<?php
class AdminCurrenciesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Currency Model
	 * @var currency
	 */
	protected $currency;

	/**
	 * Inject the models.
	 * @param Currency $currency
	 */
	public function __construct(User $user, Currency $currency)
	{
		parent::__construct();
		$this->user = $user;
		$this->currency = $currency;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/currencies/title.currency_management');

	    // Grab all the currency
	    $currency = $this->currency;

        // Show the page
        return View::make('admin/currencies/index', compact('currency', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/currencies/title.currency_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

	    // Show the page
	    $view = View::make('admin/currencies/create_edit', compact('user', 'title', 'mode'));

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
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'code' => 'required|min:3|max:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->currency->fill(Input::all())->save();

		    if( $this->currency->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/currencies/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/currencies/messages.create.error'));
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
     * @param $currency
     * @return Response
     */
    public function getEdit($currency)
    {
	    if ($currency->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/currencies/title.currency_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/currencies/create_edit', compact('currency', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/currencies')->with('error', Lang::get('admin/currencies/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $currency
     * @return Response
     */
    public function postEdit($currency)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'code' => 'required|min:3|max:3'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $currency->fill(Input::all())->save();

		    if( $currency->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/currencies/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/currencies/messages.edit.error'));
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
     * Remove currency page.
     *
     * @param $currency
     * @return Response
     */
    public function getDelete($currency)
    {
	    $currency->delete();

	    if (!empty($currency) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/currencies/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/currencies/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $currency
	 * @return Response
	 */
	public function getShow($currency)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the currency formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $currencies = Currency::select(array('published', 'id', 'code', 'name', 'symbol_left', 'symbol_right', 'description'));

        return Datatables::of($currencies)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/currencies/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/currencies/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
