<?php
class AdminCountriesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Country Model
	 * @var Country
	 */
	protected $country;

	/**
	 * Inject the models.
	 * @param Country $country
	 */
	public function __construct(User $user, Country $country)
	{
		parent::__construct();
		$this->user = $user;
		$this->country = $country;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/countries/title.country_management');

	    // Grab all the country
	    $country = $this->country;

        // Show the page
        return View::make('admin/countries/index', compact('country', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/countries/title.country_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/countries/create_edit', compact('user', 'title', 'mode'));
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
	        $this->country->name = Input::get( 'name' );
	        $this->country->iso_code_2 = Input::get( 'iso_code_2' );
	        $this->country->iso_code_3 = Input::get( 'iso_code_3' );
	        $this->country->address_format = Input::get( 'address_format' );
	        $this->country->postcode_required = Input::get( 'postcode_required' );

	        // Save if valid.
	        $this->country->save();

	        if( $this->country->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/countries/' . $this->country->id . '/edit')->with('success', Lang::get('admin/countries/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->country->errors()->all();
	            //return Redirect::to('admin/countries/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/countries/create')->with('error', Lang::get('admin/countries/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $country
     * @return Response
     */
    public function getEdit($country)
    {
        if ($country->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/countries/title.country_update');
        	// Mode
        	$mode = 'edit';

        	return View::make('admin/countries/create_edit', compact('country', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/countries')->with('error', Lang::get('admin/countries/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $country
     * @return Response
     */
    public function postEdit($country)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $country->name = Input::get( 'name' );
	        $country->iso_code_2 = Input::get( 'iso_code_2' );
	        $country->iso_code_3 = Input::get( 'iso_code_3' );
	        $country->address_format = Input::get( 'address_format' );
	        $country->postcode_required = Input::get( 'postcode_required' );

            // Save if valid
	        $country->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/countries/' . $country->id . '/edit')->with('success', Lang::get('admin/countries/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/countries/' . $country->id . '/edit')->with('error', Lang::get('admin/countries/messages.edit.error'));
        }
    }

    /**
     * Remove country page.
     *
     * @param $country
     * @return Response
     */
    public function getDelete($country)
    {
        // Title
        $title = Lang::get('admin/countries/title.country_delete');

        // Show the page
        return View::make('admin/countries/delete', compact('country', 'title'));
    }

    /**
     * Remove the specified country from storage.
     *
     * @param $country
     * @return Response
     */
    public function postDelete($country)
    {
	    $country->delete();

        if (!empty($country) )
        {
            return Redirect::to('admin/countries')->with('success', Lang::get('admin/countries/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/countries')->with('error', Lang::get('admin/countries/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $country
	 * @return Response
	 */
	public function getShow($country)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the country formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $countries = Country::select(array('published', 'id', 'name', 'iso_code_2', 'iso_code_3'));

        return Datatables::of($countries)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/countries/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/countries/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
