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
		return View::make('admin/currencies/create_edit', compact('user', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('code' => 'required|max:3', 'name' => 'required'));
	    if ($validator->passes())
	    {
	        $this->currency->code = Input::get( 'code' );
		    $this->currency->name = Input::get( 'name' );
		    $this->currency->symbol_left = Input::get( 'symbol_left' );
		    $this->currency->symbol_right = Input::get( 'symbol_right' );
		    $this->currency->description = Input::get( 'description' );
	        $this->currency->published = Input::get( 'published' );

	        // Save if valid.
	        $this->currency->save();

	        if( $this->currency->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/currencies/' . $this->currency->id . '/edit')->with('success', Lang::get('admin/currencies/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->currency->errors()->all();
	            //return Redirect::to('admin/currencies/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/currencies/create')->with('error', Lang::get('admin/currencies/messages.create.error'));
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

        	return View::make('admin/currencies/create_edit', compact('currency', 'user', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('code' => 'required|max:3', 'name' => 'required'));

        if ($validator->passes())
        {
	        $currency->code = Input::get( 'code' );
	        $currency->name = Input::get( 'name' );
	        $currency->symbol_left = Input::get( 'symbol_left' );
	        $currency->symbol_right = Input::get( 'symbol_right' );
	        $currency->description = Input::get( 'description' );
	        $currency->published = Input::get( 'published' );

            // Save if valid
	        $currency->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/currencies/' . $currency->id . '/edit')->with('success', Lang::get('admin/currencies/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/currencies/' . $currency->id . '/edit')->with('error', Lang::get('admin/currencies/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/currencies/title.currency_delete');

        // Show the page
        return View::make('admin/currencies/delete', compact('currency', 'title'));
    }

    /**
     * Remove the specified currency from storage.
     *
     * @param $currency
     * @return Response
     */
    public function postDelete($currency)
    {
	    $currency->delete();

        if (!empty($currency) )
        {
            return Redirect::to('admin/currencies')->with('success', Lang::get('admin/currencies/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/currencies')->with('error', Lang::get('admin/currencies/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/currencies/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/currencies/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
