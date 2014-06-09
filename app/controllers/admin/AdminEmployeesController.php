<?php
class AdminEmployeesController extends AdminController
{
	/**
	 * User Model
	 * @var User
	 */
	protected $user;

	/**
	 * Employee Model
	 * @var Employee
	 */
	protected $employee;

	/**
	 * Inject the models.
	 * @param Employee $employee
	 */
	public function __construct(User $user, Employee $employee)
	{
		parent::__construct();
		$this->user = $user;
		$this->employee = $employee;
	}

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/employees/title.employee_management');

	    // Grab all the employee
	    $employee = $this->employee;

        // Show the page
        return View::make('admin/employees/index', compact('employee', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
		// Title
		$title = Lang::get('admin/employees/title.employee_create');

	    $user = $this->user->currentUser();

	    $genders = Gender::lists('name', 'id');

	    $nationalities = Nationality::lists('name', 'id');

	    $marriages = Marriage::lists('name', 'id');

	    $employmentTypes = EmploymentType::lists('name', 'id');

	    $jobTitles = JobTitle::lists('name', 'id');

	    $payGrades = PayGrade::lists('name', 'id');

	    $countries = Country::lists('name', 'id');

	    $states = State::lists('name', 'id');

	    $departments = OrganizationStructure::lists('title', 'id');

	    $supervisors = Employee::lists('first_name', 'id');

		// Mode
		$mode = 'create';

	    // Show the page
	    $view = View::make('admin/employees/create_edit', compact('user', 'genders', 'nationalities', 'marriages', 'employmentTypes', 'jobTitles', 'payGrades', 'countries', 'states', 'departments', 'supervisors', 'title', 'mode'));

	    return Response::make($view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate()
    {
	    $validator = Validator::make(Input::all(), array('employee_number' => 'required'));
	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $this->employee->fill(Input::all())->save();

		    // Save the employee picture into the media table
		    if (Input::hasFile('picture') && !is_null($this->employee->id))
		    {
			    $picture = Input::file('picture');

			    if($picture->isValid())
			    {
				    $extension = $picture->getClientOriginalExtension();

				    $path = public_path() . '/upload/images';
				    $fileName = strtolower(Input::get('employee_code') . '.' . $extension);

				    $pictureData = array(
					    'employee_id' => $this->employee->id,
					    'media_type' => 'picture',
					    'data' => '',
					    'file_path' => $path,
					    'file_name' => $fileName,
					    'file_origin_name' => $picture->getClientOriginalName(),
					    'file_size' => $picture->getSize(),
					    'file_extension' => $extension,
					    'file_mime_type' => $picture->getMimeType(),
				    );

				    // Storage the persional picture
				    $picture->move($path, $fileName);

				    // Get last insert id from employee
				    $employeeMedia = new EmployeeMedia();
				    $employeeMedia->fill($pictureData)->save();
			    }
		    }

		    if( $this->employee->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employees/messages.create.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employees/messages.create.error'));
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
     * @param $employee
     * @return Response
     */
    public function getEdit($employee)
    {
	    if ($employee->id)
	    {
		    $user = $this->user->currentUser();

		    // Title
		    $title = Lang::get('admin/employees/title.employee_update');

		    $genders = Gender::lists('name', 'id');

		    $nationalities = Nationality::lists('name', 'id');

		    $marriages = Marriage::lists('name', 'id');

		    $employmentTypes = EmploymentType::lists('name', 'id');

		    $jobTitles = JobTitle::lists('name', 'id');

		    $payGrades = PayGrade::lists('name', 'id');

		    $countries = Country::lists('name', 'id');

		    $states = State::lists('name', 'id');

		    $departments = OrganizationStructure::lists('title', 'id');

		    $supervisors = Employee::lists('first_name', 'id');

		    // Mode
		    $mode = 'edit';
		    // Show the page
		    $view = View::make('admin/employees/create_edit',
			    compact('employee', 'user', 'genders', 'nationalities', 'marriages', 'employmentTypes', 'jobTitles', 'payGrades', 'countries', 'states', 'departments', 'supervisors', 'title', 'mode'));

		    return Response::make($view);
	    }
	    else
	    {
		    return Redirect::to('admin/employees')->with('error', Lang::get('admin/employees/messages.does_not_exist'));
	    }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $employee
     * @return Response
     */
    public function postEdit($employee)
    {
        // Validate the inputs
	    $validator = Validator::make(Input::all(), array('employee_number' => 'required'));

	    if ($validator->passes())
	    {
		    $result['failedValidate'] = false;
		    $employee->fill(Input::all())->save();

		    if (Input::hasFile('picture') && !is_null($employee->id))
		    {
			    $picture = Input::file('picture');

			    if($picture->isValid())
			    {
				    $extension = $picture->getClientOriginalExtension();

				    $path = public_path() . '/upload/images';
				    $fileName = strtolower(Input::get('employee_code') . '.' . $extension);

				    $pictureData = array(
					    'employee_id' => $employee->id,
					    'media_type' => 'picture',
					    'data' => '',
					    'file_path' => $path,
					    'file_name' => $fileName,
					    'file_origin_name' => $picture->getClientOriginalName(),
					    'file_size' => $picture->getSize(),
					    'file_extension' => $extension,
					    'file_mime_type' => $picture->getMimeType(),
				    );

				    // Storage the persional picture
				    $picture->move($path, $fileName);

				    // Get last insert id from employee
				    $employeeMedia = new EmployeeMedia();
				    $employeeMedia->fill($pictureData)->save();
			    }
		    }

		    if( $employee->id )
		    {
			    $result['messages'] = array('success' => Lang::get('admin/employees/messages.edit.success'));
			    return Response::json(json_encode($result));
		    }
		    else
		    {
			    $result['messages'] = array('error' => Lang::get('admin/employees/messages.edit.error'));
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
     * Remove employee page.
     *
     * @param $employee
     * @return Response
     */
    public function getDelete($employee)
    {
	    $employee->delete();

	    if (!empty($employee) )
	    {
		    $result['messages'] = array('success' => Lang::get('admin/employees/messages.delete.success'));
		    return Response::json(json_encode($result));
	    }
	    else
	    {
		    $result['messages'] = array('error' => Lang::get('admin/employees/messages.delete.error'));
		    return Response::json(json_encode($result));
	    }
    }

	/**
	 * Display the specified resource.
	 *
	 * @param $user
	 * @return Response
	 */
	public function getShow($employee)
	{
		// Title
		$title = Lang::get('admin/employees/title.employee_management');

		$user = $this->user->currentUser();

		$gender = Gender::find($employee->gender_id);

		$nationality = Nationality::find($employee->nationality_id);

		$marriage = Marriage::find($employee->marriage_id);

		$jobTitle = JobTitle::find($employee->job_title_id);

		$employmentType = EmploymentType::find($employee->employee_type_id);

		$payGrade = PayGrade::find($employee->pay_grade_id);

		$department = OrganizationStructure::find($employee->department);

		$supervisor = Employee::find($employee->supervisor);

		$country = Country::find($employee->country_id);

		// Show the page
		return View::make('admin/employees/detail', compact('employee', 'user', 'gender', 'nationality', 'marriage', 'jobTitle', 'employmentType', 'payGrade', 'department', 'supervisor', 'country', 'state', 'title'));
	}

    /**
     * Show a list of all the employee formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $employees = Employee::leftjoin('genders', 'genders.id', '=', 'employees.gender_id')
	        ->select(array('employees.published', 'employees.id', 'employees.employee_code', 'employees.first_name', 'employees.last_name', 'employees.mobile_phone', 'genders.name as gender'));

        return Datatables::of($employees)
                ->edit_column('employee_code', '<a href="{{{ URL::to(\'admin/employees/\' . $id . \'/show\' ) }}}"> {{{$employee_code}}}</a>')
		        ->add_column('actions', '<div class="btn-group">
											<button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">{{{ Lang::get(\'general.action\') }}} <span class="caret"></span></button>
											<ul class="dropdown-menu" role="menu">
												<li><a href="{{{ URL::to(\'admin/employees/\' . $id . \'/show\' ) }}}">{{{ Lang::get(\'button.show\') }}}</a></li>
												<li><a href="#" onclick="getEdit(\'{{{ URL::to(\'admin/employees/\' . $id . \'/edit\' ) }}}\');">{{{ Lang::get(\'button.edit\') }}}</a></li>
												<li><a href="#" onclick="getDelete(\'{{{ URL::to(\'admin/employees/\' . $id . \'/delete\' ) }}}\');">{{{ Lang::get(\'button.delete\') }}}</a></li>
											</ul>
										</div>'
		                    )
                ->remove_column('id')
                ->make();
    }

	/**
	 * Import employee page.
	 *
	 * @return Response
	 */
	public function getImport()
	{
		// Title
		$title = Lang::get('admin/employees/title.employee_import');

		// Show the page
		return View::make('admin/employees/import', compact('title'));
	}

	/**
	 * Get template before import.
	 *
	 * @return Response
	 */
	public function getTemplate()
	{
		// Export process

		/* Set the export filename */
		$exportFileName = 'employee_list_template.csv';

//		/* Start output to the browser */
//		if (preg_match('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
//		{
//			$userBrowser = "Opera";
//		}
//		elseif (preg_match('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
//		{
//			$userBrowser = "IE";
//		}
//		else
//		{
//			$userBrowser = '';
//		}
//
//		$mimeType = ($userBrowser == 'IE' || $userBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';

		/* Clean the buffer */
		ob_clean();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Encoding: UTF-8');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

//		if ($userBrowser == 'IE')
//		{
//			header('Content-Disposition: inline; filename="' . $exportFileName . '"');
//			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//			header('Pragma: public');
//		}
//		else
//		{
		header('Content-Disposition: attachment; filename="' . $exportFileName . '"');
		header('Pragma: no-cache');
//		}

		echo 'abc test';

		exit();
	}

	/**
	 * Import the specified employee from storage.
	 *
	 * @return Response
	 */
	public function postImport()
	{
		// Import process

		if (!empty($employee) )
		{
			return Redirect::to('admin/employees')->with('success', Lang::get('admin/employees/messages.import.success'));
		}
		else
		{
			// There was a problem deleting the user
			return Redirect::to('admin/employees')->with('error', Lang::get('admin/employees/messages.import.error'));
		}
	}

	/**
	 * Export employee page.
	 *
	 * @return Response
	 */
	public function getExport()
	{
		// Export process

		/* Set the export filename */
		$exportFileName = 'employee_list.csv';

//		/* Start output to the browser */
//		if (preg_match('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
//		{
//			$userBrowser = "Opera";
//		}
//		elseif (preg_match('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT']))
//		{
//			$userBrowser = "IE";
//		}
//		else
//		{
//			$userBrowser = '';
//		}
//
//		$mimeType = ($userBrowser == 'IE' || $userBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';

		/* Clean the buffer */
		ob_clean();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Encoding: UTF-8');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');

//		if ($userBrowser == 'IE')
//		{
//			header('Content-Disposition: inline; filename="' . $exportFileName . '"');
//			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//			header('Pragma: public');
//		}
//		else
//		{
		header('Content-Disposition: attachment; filename="' . $exportFileName . '"');
		header('Pragma: no-cache');
//		}

		echo 'abc test';

		exit();
	}
}
