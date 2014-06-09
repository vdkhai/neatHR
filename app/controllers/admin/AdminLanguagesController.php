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
	    $view = View::make('admin/languages/create_edit', compact('user', 'title', 'mode'));

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
		    $this->language->fill(Input::all())->save();

		    if( $this->language->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/languages/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/languages/messages.create.error'));
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

		    // Show the page
		    $view = View::make('admin/languages/create_edit', compact('language', 'user', 'title', 'mode'));

		    return Response::make($view);
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
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $language->fill(Input::all())->save();

		    if( $language->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/languages/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/languages/messages.edit.error'));
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
     * Remove language page.
     *
     * @param $language
     * @return Response
     */
    public function getDelete($language)
    {
	    $language->delete();

	    if (!empty($language) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/languages/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/languages/messages.delete.error'));
		    return Response::json(json_encode($result));
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
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/languages/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/languages/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
