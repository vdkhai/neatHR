<?php
class AdminSkillsController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Skill Model
	 * @var Skill
	 */
	protected $skill;

	/**
	 * Inject the models.
	 * @param Skill $skill
	 */
	public function __construct(User $user, Skill $skill)
	{
		parent::__construct();
		$this->user = $user;
		$this->skill = $skill;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/skills/title.skill_management');

	    // Grab all the skill
	    $skill = $this->skill;

        // Show the page
        return View::make('admin/skills/index', compact('skill', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
	    // Title
	    $title = Lang::get('admin/skills/title.skill_create');

	    $user = $this->user->currentUser();

	    // Mode
	    $mode = 'create';

	    // Show the page
	    $view = View::make('admin/skills/create_edit', compact('user', 'title', 'mode'));

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
		    $this->skill->fill(Input::all())->save();

		    if( $this->skill->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/skills/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/skills/messages.create.error'));
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
     * @param $skill
     * @return Response
     */
    public function getEdit($skill)
    {
	    if ($skill->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/skills/title.skill_update');

		    // Mode
		    $mode = 'edit';

		    // Show the page
		    $view = View::make('admin/skills/create_edit', compact('skill', 'user', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/skills')->with('error', Lang::get('admin/skills/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $skill
     * @return Response
     */
    public function postEdit($skill)
    {
	    $validator = Validator::make(Input::all(), array('name' => 'required|min:3', 'description' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $skill->fill(Input::all())->save();

		    if( $skill->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/skills/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/skills/messages.edit.error'));
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
     * Remove skill page.
     *
     * @param $skill
     * @return Response
     */
    public function getDelete($skill)
    {
	    $skill->delete();

	    if (!empty($skill) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/skills/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/skills/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $skill
	 * @return Response
	 */
	public function getShow($skill)
	{
		// redirect to the frontend
	}

    /**
     * Show a list of all the skill formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $skills = Skill::select(array('published', 'id', 'name', 'description'));

        return Datatables::of($skills)
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/skills/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/skills/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }
}
