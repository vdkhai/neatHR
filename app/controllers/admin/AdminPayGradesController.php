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
		return View::make('admin/paygrades/create_edit', compact('user', 'currencies', 'title', 'mode'));
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
		    $this->paygrade->currency_id = Input::get( 'currency_id' );
	        $this->paygrade->name = Input::get( 'name' );
		    $this->paygrade->description = Input::get( 'description' );
		    $this->paygrade->min_salary = Input::get( 'min_salary' );
		    $this->paygrade->max_salary = Input::get( 'max_salary' );
	        $this->paygrade->published = Input::get( 'published' );

	        // Save if valid.
	        $this->paygrade->save();

	        if( $this->paygrade->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/paygrades/' . $this->paygrade->id . '/edit')->with('success', Lang::get('admin/paygrades/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->paygrade->errors()->all();
	            //return Redirect::to('admin/paygrades/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/paygrades/create')->with('error', Lang::get('admin/paygrades/messages.create.error'));
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

        	return View::make('admin/paygrades/create_edit', compact('paygrade', 'user', 'currencies', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $paygrade->currency_id = Input::get( 'currency_id' );
	        $paygrade->name = Input::get( 'name' );
	        $paygrade->description = Input::get( 'description' );
	        $paygrade->min_salary = Input::get( 'min_salary' );
	        $paygrade->max_salary = Input::get( 'max_salary' );
	        $paygrade->published = Input::get( 'published' );

            // Save if valid
	        $paygrade->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/paygrades/' . $paygrade->id . '/edit')->with('success', Lang::get('admin/paygrades/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/paygrades/' . $paygrade->id . '/edit')->with('error', Lang::get('admin/paygrades/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/paygrades/title.paygrade_delete');

        // Show the page
        return View::make('admin/paygrades/delete', compact('paygrade', 'title'));
    }

    /**
     * Remove the specified paygrade from storage.
     *
     * @param $paygrade
     * @return Response
     */
    public function postDelete($paygrade)
    {
	    $paygrade->delete();

        if (!empty($paygrade) )
        {
            return Redirect::to('admin/paygrades')->with('success', Lang::get('admin/paygrades/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/paygrades')->with('error', Lang::get('admin/paygrades/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/paygrades/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/paygrades/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
