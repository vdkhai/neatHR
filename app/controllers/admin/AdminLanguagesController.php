<?php
class AdminLanguagesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Language Model
	 * @var Language
	 */
	protected $language;

	/**
	 * Inject the models.
	 * @param Language $language
	 */
	public function __construct(User $user, Language $language)
	{
		parent::__construct();
		$this->user = $user;
		$this->language = $language;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/languages/title.language_management');

	    // Grab all the language
	    $language = $this->language;

        // Show the page
        return View::make('admin/languages/index', compact('language', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/languages/title.language_create');

	    $user = $this->user->currentUser();

		// Mode
		$mode = 'create';

		// Show the page
		return View::make('admin/languages/create_edit', compact('user', 'title', 'mode'));
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
	        $this->language->name = Input::get( 'name' );
		    $this->language->description = Input::get( 'description' );
	        $this->language->published = Input::get( 'published' );

	        // Save if valid.
	        $this->language->save();

	        if( $this->language->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/languages/' . $this->language->id . '/edit')->with('success', Lang::get('admin/languages/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->language->errors()->all();
	            //return Redirect::to('admin/languages/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
		    $error = $validator->messages();
			return Redirect::to('admin/languages/create')->with('error', Lang::get('admin/languages/messages.create.error'));
	    }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param $language
     * @return Response
     */
    public function getEdit($language)
    {
        if ($language->id)
        {
	        $user = $this->user->currentUser();

            // Title
        	$title = Lang::get('admin/languages/title.language_update');

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/languages/create_edit', compact('language', 'user', 'title', 'mode'));
        }
        else
        {
            return Redirect::to('admin/languages')->with('error', Lang::get('admin/languages/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $language
     * @return Response
     */
    public function postEdit($language)
    {
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $language->name = Input::get( 'name' );
	        $language->description = Input::get( 'description' );
	        $language->published = Input::get( 'published' );

            // Save if valid
	        $language->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/languages/' . $language->id . '/edit')->with('success', Lang::get('admin/languages/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/languages/' . $language->id . '/edit')->with('error', Lang::get('admin/languages/messages.edit.error'));
        }
    }

    /**
     * Remove language page.
     *
     * @param $language
     * @return Response
     */
    public function getDelete($language)
    {
        // Title
        $title = Lang::get('admin/languages/title.language_delete');

        // Show the page
        return View::make('admin/languages/delete', compact('language', 'title'));
    }

    /**
     * Remove the specified language from storage.
     *
     * @param $language
     * @return Response
     */
    public function postDelete($language)
    {
	    $language->delete();

        if (!empty($language) )
        {
            return Redirect::to('admin/languages')->with('success', Lang::get('admin/languages/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/languages')->with('error', Lang::get('admin/languages/messages.delete.error'));
        }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $language
	 * @return Response
	 */
	public function getShow($language)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the language formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $languages = Language::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($languages)
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/languages/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/languages/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
