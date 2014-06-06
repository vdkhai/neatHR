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
		return View::make('admin/skills/create_edit', compact('user', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    // Validate the inputs
	    $validator = Validator::make(Input::all(), array('name' => 'required', 'description' => 'required'));
	    if ($validator->passes())
	    {
	        // Save if valid. We can use fill method to bind data from to form into model
	        $this->skill->fill(Input::all())->save();

	        if( $this->skill->id )
	        {
	            // Redirect to the new contry page
	            return Redirect::to('admin/skills/' . $this->skill->id . '/edit')->with('success', Lang::get('admin/skills/messages.create.success'));
	        }
	        else
	        {
	            // Get validation errors (see Ardent package)
	            //$error = $this->skill->errors()->all();
	            //return Redirect::to('admin/skills/create')
	            //    ->withInput(Input::except('password'))
	            //    ->with( 'error', $error );
	        }
	    }
	    else
	    {
			return Redirect::to('admin/skills/create')->withErrors($validator);
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

        	return View::make('admin/skills/create_edit', compact('skill', 'user', 'title', 'mode'));
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
        // Validate the inputs
        $validator = Validator::make(Input::all(), array('name' => 'required'));

        if ($validator->passes())
        {
	        $skill->name = Input::get( 'name' );
	        $skill->description = Input::get( 'description' );
	        $skill->published = Input::get( 'published' );

            // Save if valid
	        $skill->save();

	        // Redirect to the new user page
	        return Redirect::to('admin/skills/' . $skill->id . '/edit')->with('success', Lang::get('admin/skills/messages.edit.success'));
        }
        else
        {
	        $error = $validator->messages();
            return Redirect::to('admin/skills/' . $skill->id . '/edit')->with('error', Lang::get('admin/skills/messages.edit.error'));
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
        // Title
        $title = Lang::get('admin/skills/title.skill_delete');

        // Show the page
        return View::make('admin/skills/delete', compact('skill', 'title'));
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param $skill
     * @return Response
     */
    public function postDelete($skill)
    {
	    $skill->delete();

        if (!empty($skill) )
        {
            return Redirect::to('admin/skills')->with('success', Lang::get('admin/skills/messages.delete.success'));
        }
        else
        {
            // There was a problem deleting the user
            return Redirect::to('admin/skills')->with('error', Lang::get('admin/skills/messages.delete.error'));
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
                ->add_column('actions', '<a href="{{{ URL::to(\'admin/skills/\' . $id . \'/edit\' ) }}}" class="iframe btn btn-xs btn-info"><span class="glyphicon glyphicon-edit"></span></a>
										<a href="{{{ URL::to(\'admin/skills/\' . $id . \'/delete\' ) }}}" class="iframe btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove"></a>')
                ->remove_column('id')
                ->make();
    }
}
