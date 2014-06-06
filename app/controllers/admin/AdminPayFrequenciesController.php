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
		return View::make('admin/payfrequencies/create_edit', compact('user', 'title', 'mode'));
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
	        $this->payfrequency->name = Input::get( 'name' );
	        $this->payfrequency->published = Input::get( 'published' );

	        // Save if valid.
	        $this->payfrequency->save();

	        if( $this->payfrequency->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/payfrequencies/' . $this->payfrequency->id . '/edit')->with('success', Lang::get('admin/payfrequencies/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->payfrequency->errors()->all();
	            //return Redirect::to('admin/payfrequencies/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/payfrequencies/create')->with('error', Lang::get('admin/payfrequencies/messages.create.error'));
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

        	return View::make('admin/payfrequencies/create_edit', compact('payfrequency', 'user', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $payfrequency->name = Input::get( 'name' );
	        $payfrequency->published = Input::get( 'published' );

            // Save if valid
	        $payfrequency->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/payfrequencies/' . $payfrequency->id . '/edit')->with('success', Lang::get('admin/payfrequencies/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/payfrequencies/' . $payfrequency->id . '/edit')->with('error', Lang::get('admin/payfrequencies/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/payfrequencies/title.payfrequency_delete');

        // Show the page
        return View::make('admin/payfrequencies/delete', compact('payfrequency', 'title'));
    }

    /**
     * Remove the specified payfrequency from storage.
     *
     * @param $payfrequency
     * @return Response
     */
    public function postDelete($payfrequency)
    {
	    $payfrequency->delete();

        if (!empty($payfrequency) )
        {
            return Redirect::to('admin/payfrequencies')->with('success', Lang::get('admin/payfrequencies/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/payfrequencies')->with('error', Lang::get('admin/payfrequencies/messages.delete.error'));
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
        $payFrequencies = PayFrequency::select(array('published', 'id', 'name'));

        return Datatables::of($payFrequencies)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/payfrequencies/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/payfrequencies/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
