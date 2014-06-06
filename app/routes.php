<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/** ------------------------------------------
 *  Route model binding
 *  ------------------------------------------
 */

# Master
Route::model('user', 'User');
Route::model('role', 'Role');
Route::model('country', 'Country');
Route::model('state', 'State');
Route::model('nationality', 'Nationality');
Route::model('language', 'Language');
Route::model('currency', 'Currency');
Route::model('education', 'Education');
Route::model('skill', 'Skill');
Route::model('certification', 'Certification');
Route::model('employmenttype', 'EmploymentType');
Route::model('marriage', 'Marriage');
Route::model('jobtitle', 'JobTitle');
Route::model('recruitmentstatus', 'RecruitmentStatus');
Route::model('paygrade', 'PayGrade');

Route::model('organizationtype', 'OrganizationType');
Route::model('organizationstructure', 'OrganizationStructure');
Route::model('dependent', 'Dependent');
Route::model('payfrequency', 'PayFrequency');

# ---------------
Route::model('employee', 'Employee');
Route::model('employeeemergencycontact', 'EmployeeEmergencyContact');
Route::model('employeedependent', 'EmployeeDependent');
Route::model('employeesalary', 'EmployeeSalary');
Route::model('employeeskill', 'EmployeeSkill');
Route::model('employeeeducation', 'EmployeeEducation');
Route::model('employeelanguage', 'EmployeeLanguage');
Route::model('employeecertification', 'EmployeeCertification');
Route::model('employeeexperience', 'EmployeeExperience');

# ---------------
Route::model('recruitvacancy', 'RecruitVacancy');
Route::model('recruitcandidate', 'RecruitCandidate');

/** ------------------------------------------
 *  Frontend Routes
 *  ------------------------------------------
 */
// Confide RESTful route
Route::get('user/confirm/{code}', 'UserController@getConfirm');
Route::get('user/reset/{token}', 'UserController@getReset');
Route::controller( 'user', 'UserController');

# Index Page - Last route, no matches
Route::get('/', array('before' => 'detectLang','uses' => 'UserController@getLogin'));


# Route to display image

Route::get('images/{medium}/{filename?}', 'AdminMediaController@image');

//Route::get('public/upload/images/{filename?}', [
//	'as'   => 'sidebar.view',
//	'uses' => 'AdminMediaController@image'
//]);

//Route::get('/{filename?}', [
//	'as'   => 'sidebar.view',
//	'uses' => 'AdminMediaController@image'
//]);

//Route::get('image/(:any)', array('after' => 'image', function($image)
//{
//	$image = File::get(path('public').'img/260x260.jpg');
//	return $image;
//}));

//Route::get('images/{file}', function($file)
//{
//	return asset('public/upload/images/' . $file );
//})->where(array('file' => '^[0-9][a-z]+'));

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
	# User Management
	Route::get('users/{user}/show', 'AdminUsersController@getShow');
	Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
	Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
	Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
	Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
	Route::controller('users', 'AdminUsersController');

	# User Role Management
	Route::get('roles/{role}/show', 'AdminRolesController@getShow');
	Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
	Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
	Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
	Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
	Route::controller('roles', 'AdminRolesController');

	# Countries Management
	Route::get('countries/{country}/show', 'AdminCountriesController@getShow');
	Route::get('countries/{country}/edit', 'AdminCountriesController@getEdit');
	Route::post('countries/{country}/edit', 'AdminCountriesController@postEdit');
	Route::get('countries/{country}/delete', 'AdminCountriesController@getDelete');
	Route::post('countries/{country}/delete', 'AdminCountriesController@postDelete');
	Route::controller('countries', 'AdminCountriesController');

	# States Management
	Route::get('states/{state}/show', 'AdminStatesController@getShow');
	Route::get('states/{state}/edit', 'AdminStatesController@getEdit');
	Route::post('states/{state}/edit', 'AdminStatesController@postEdit');
	Route::get('states/{state}/delete', 'AdminStatesController@getDelete');
	Route::post('states/{state}/delete', 'AdminStatesController@postDelete');
	Route::controller('states', 'AdminStatesController');

	# Nationalities Management
	Route::get('nationalities/{nationality}/show', 'AdminNationalitiesController@getShow');
	Route::get('nationalities/{nationality}/edit', 'AdminNationalitiesController@getEdit');
	Route::post('nationalities/{nationality}/edit', 'AdminNationalitiesController@postEdit');
	Route::get('nationalities/{nationality}/delete', 'AdminNationalitiesController@getDelete');
	Route::post('nationalities/{nationality}/delete', 'AdminNationalitiesController@postDelete');
	Route::controller('nationalities', 'AdminNationalitiesController');

	# Languages Management
	Route::get('languages/{language}/show', 'AdminLanguagesController@getShow');
	Route::get('languages/{language}/edit', 'AdminLanguagesController@getEdit');
	Route::post('languages/{language}/edit', 'AdminLanguagesController@postEdit');
	Route::get('languages/{language}/delete', 'AdminLanguagesController@getDelete');
	Route::post('languages/{language}/delete', 'AdminLanguagesController@postDelete');
	Route::controller('languages', 'AdminLanguagesController');

	# Currencies Management
	Route::get('currencies/{currency}/show', 'AdminCurrenciesController@getShow');
	Route::get('currencies/{currency}/edit', 'AdminCurrenciesController@getEdit');
	Route::post('currencies/{currency}/edit', 'AdminCurrenciesController@postEdit');
	Route::get('currencies/{currency}/delete', 'AdminCurrenciesController@getDelete');
	Route::post('currencies/{currency}/delete', 'AdminCurrenciesController@postDelete');
	Route::controller('currencies', 'AdminCurrenciesController');

	# Educations Management
	Route::get('educations/{education}/show', 'AdminEducationsController@getShow');
	Route::get('educations/{education}/edit', 'AdminEducationsController@getEdit');
	Route::post('educations/{education}/edit', 'AdminEducationsController@postEdit');
	Route::get('educations/{education}/delete', 'AdminEducationsController@getDelete');
	Route::post('educations/{education}/delete', 'AdminEducationsController@postDelete');
	Route::controller('educations', 'AdminEducationsController');

	# Skills Management
	Route::get('skills/{skill}/show', 'AdminSkillsController@getShow');
	Route::get('skills/{skill}/edit', 'AdminSkillsController@getEdit');
	Route::post('skills/{skill}/edit', 'AdminSkillsController@postEdit');
	Route::get('skills/{skill}/delete', 'AdminSkillsController@getDelete');
	Route::post('skills/{skill}/delete', 'AdminSkillsController@postDelete');
	Route::controller('skills', 'AdminSkillsController');

	# Certifications Management
	Route::get('certifications/{certification}/show', 'AdminCertificationsController@getShow');
	Route::get('certifications/{certification}/edit', 'AdminCertificationsController@getEdit');
	Route::post('certifications/{certification}/edit', 'AdminCertificationsController@postEdit');
	Route::get('certifications/{certification}/delete', 'AdminCertificationsController@getDelete');
	Route::post('certifications/{certification}/delete', 'AdminCertificationsController@postDelete');
	Route::controller('certifications', 'AdminCertificationsController');

	#----------------------------------------------------
	# Employment Types Management
	Route::get('employmenttypes/{employmenttype}/show', 'AdminEmploymentTypesController@getShow');
	Route::get('employmenttypes/{employmenttype}/edit', 'AdminEmploymentTypesController@getEdit');
	Route::post('employmenttypes/{employmenttype}/edit', 'AdminEmploymentTypesController@postEdit');
	Route::get('employmenttypes/{employmenttype}/delete', 'AdminEmploymentTypesController@getDelete');
	Route::post('employmenttypes/{employmenttype}/delete', 'AdminEmploymentTypesController@postDelete');
	Route::controller('employmenttypes', 'AdminEmploymentTypesController');

	# Marriages Management
	Route::get('marriages/{marriage}/show', 'AdminMarriagesController@getShow');
	Route::get('marriages/{marriage}/edit', 'AdminMarriagesController@getEdit');
	Route::post('marriages/{marriage}/edit', 'AdminMarriagesController@postEdit');
	Route::get('marriages/{marriage}/delete', 'AdminMarriagesController@getDelete');
	Route::post('marriages/{marriage}/delete', 'AdminMarriagesController@postDelete');
	Route::controller('marriages', 'AdminMarriagesController');

	#----------------------------------------------------
	# Job Titles Management
	Route::get('jobtitles/{jobtitle}/show', 'AdminJobTitlesController@getShow');
	Route::get('jobtitles/{jobtitle}/edit', 'AdminJobTitlesController@getEdit');
	Route::post('jobtitles/{jobtitle}/edit', 'AdminJobTitlesController@postEdit');
	Route::get('jobtitles/{jobtitle}/delete', 'AdminJobTitlesController@getDelete');
	Route::post('jobtitles/{jobtitle}/delete', 'AdminJobTitlesController@postDelete');
	Route::controller('jobtitles', 'AdminJobTitlesController');

	# Recruitment Status Management
	Route::get('recruitmentstatus/{recruitmentstatus}/show', 'AdminRecruitmentStatusController@getShow');
	Route::get('recruitmentstatus/{recruitmentstatus}/edit', 'AdminRecruitmentStatusController@getEdit');
	Route::post('recruitmentstatus/{recruitmentstatus}/edit', 'AdminRecruitmentStatusController@postEdit');
	Route::get('recruitmentstatus/{recruitmentstatus}/delete', 'AdminRecruitmentStatusController@getDelete');
	Route::post('recruitmentstatus/{recruitmentstatus}/delete', 'AdminRecruitmentStatusController@postDelete');
	Route::controller('recruitmentstatus', 'AdminRecruitmentStatusController');

	# Pay Grades Management
	Route::get('paygrades/{paygrade}/show', 'AdminPayGradesController@getShow');
	Route::get('paygrades/{paygrade}/edit', 'AdminPayGradesController@getEdit');
	Route::post('paygrades/{paygrade}/edit', 'AdminPayGradesController@postEdit');
	Route::get('paygrades/{paygrade}/delete', 'AdminPayGradesController@getDelete');
	Route::post('paygrades/{paygrade}/delete', 'AdminPayGradesController@postDelete');
	Route::controller('paygrades', 'AdminPayGradesController');

	# Organization Type Management
	Route::get('organizationtypes/{organizationtype}/show', 'AdminOrganizationTypesController@getShow');
	Route::get('organizationtypes/{organizationtype}/edit', 'AdminOrganizationTypesController@getEdit');
	Route::post('organizationtypes/{organizationtype}/edit', 'AdminOrganizationTypesController@postEdit');
	Route::get('organizationtypes/{organizationtype}/delete', 'AdminOrganizationTypesController@getDelete');
	Route::post('organizationtypes/{organizationtype}/delete', 'AdminOrganizationTypesController@postDelete');
	Route::controller('organizationtypes', 'AdminOrganizationTypesController');

	# Organization Structure Management
	Route::get('organizationstructures/{organizationstructure}/show', 'AdminOrganizationStructuresController@getShow');
	Route::get('organizationstructures/{organizationstructure}/edit', 'AdminOrganizationStructuresController@getEdit');
	Route::post('organizationstructures/{organizationstructure}/edit', 'AdminOrganizationStructuresController@postEdit');
	Route::get('organizationstructures/{organizationstructure}/delete', 'AdminOrganizationStructuresController@getDelete');
	Route::post('organizationstructures/{organizationstructure}/delete', 'AdminOrganizationStructuresController@postDelete');
	Route::controller('organizationstructures', 'AdminOrganizationStructuresController');

	# Dependent Management
	Route::get('dependents/{dependent}/show', 'AdminDependentsController@getShow');
	Route::get('dependents/{dependent}/edit', 'AdminDependentsController@getEdit');
	Route::post('dependents/{dependent}/edit', 'AdminDependentsController@postEdit');
	Route::get('dependents/{dependent}/delete', 'AdminDependentsController@getDelete');
	Route::post('dependents/{dependent}/delete', 'AdminDependentsController@postDelete');
	Route::controller('dependents', 'AdminDependentsController');

	# Pay Frequency Management
	Route::get('payfrequencies/{payfrequency}/show', 'AdminPayFrequenciesController@getShow');
	Route::get('payfrequencies/{payfrequency}/edit', 'AdminPayFrequenciesController@getEdit');
	Route::post('payfrequencies/{payfrequency}/edit', 'AdminPayFrequenciesController@postEdit');
	Route::get('payfrequencies/{payfrequency}/delete', 'AdminPayFrequenciesController@getDelete');
	Route::post('payfrequencies/{payfrequency}/delete', 'AdminPayFrequenciesController@postDelete');
	Route::controller('payfrequencies', 'AdminPayFrequenciesController');

	#----------------------------------------------------
	# Employees Management
	Route::get('employees/{employee}/show', 'AdminEmployeesController@getShow');
	Route::get('employees/{employee}/edit', 'AdminEmployeesController@getEdit');
	Route::post('employees/{employee}/edit', 'AdminEmployeesController@postEdit');
	Route::get('employees/{employee}/delete', 'AdminEmployeesController@getDelete');
	Route::post('employees/{employee}/delete', 'AdminEmployeesController@postDelete');
	Route::get('employees/import', 'AdminEmployeesController@getImport');
	Route::post('employees/import', 'AdminEmployeesController@postImport');
	Route::get('employees/template', 'AdminEmployeesController@getTemplate');
	Route::get('employees/export', 'AdminEmployeesController@getExport');
	Route::controller('employees', 'AdminEmployeesController');

	# Employee Emergency Contact Management
	Route::get('employeeemergencycontacts/{employee}/show', 'AdminEmployeeEmergencyContactsController@getShow');
	Route::get('employeeemergencycontacts/{employee}/data', 'AdminEmployeeEmergencyContactsController@getData');
	Route::get('employeeemergencycontacts/{employee}/create', 'AdminEmployeeEmergencyContactsController@getCreate');
	Route::post('employeeemergencycontacts/{employee}/create', 'AdminEmployeeEmergencyContactsController@postCreate');
	Route::get('employeeemergencycontacts/{employee}/edit/{employeeemergencycontact}', 'AdminEmployeeEmergencyContactsController@getEdit');
	Route::post('employeeemergencycontacts/{employee}/edit/{employeeemergencycontact}', 'AdminEmployeeEmergencyContactsController@postEdit');
	Route::get('employeeemergencycontacts/{employee}/delete/{employeeemergencycontact}', 'AdminEmployeeEmergencyContactsController@getDelete');
	Route::post('employeeemergencycontacts/{employee}/delete/{employeeemergencycontact}', 'AdminEmployeeEmergencyContactsController@postDelete');

	# Employee Dependent Management
	Route::get('employeedependents/{employee}/show', 'AdminEmployeeDependentsController@getShow');
	Route::get('employeedependents/{employee}/data', 'AdminEmployeeDependentsController@getData');
	Route::get('employeedependents/{employee}/create', 'AdminEmployeeDependentsController@getCreate');
	Route::post('employeedependents/{employee}/create', 'AdminEmployeeDependentsController@postCreate');
	Route::get('employeedependents/{employee}/edit/{employeedependent}', 'AdminEmployeeDependentsController@getEdit');
	Route::post('employeedependents/{employee}/edit/{employeedependent}', 'AdminEmployeeDependentsController@postEdit');
	Route::get('employeedependents/{employee}/delete/{employeedependent}', 'AdminEmployeeDependentsController@getDelete');
	Route::post('employeedependents/{employee}/delete/{employeedependent}', 'AdminEmployeeDependentsController@postDelete');

	# EmployeeSkills Management
	Route::get('employeeskills/{employee}/show', 'AdminEmployeeSkillsController@getShow');
	Route::get('employeeskills/{employee}/data', 'AdminEmployeeSkillsController@getData');
	Route::get('employeeskills/{employee}/create', 'AdminEmployeeSkillsController@getCreate');
	Route::post('employeeskills/{employee}/create', 'AdminEmployeeSkillsController@postCreate');
	Route::get('employeeskills/{employee}/edit/{employeeskill}', 'AdminEmployeeSkillsController@getEdit');
	Route::post('employeeskills/{employee}/edit/{employeeskill}', 'AdminEmployeeSkillsController@postEdit');
	Route::get('employeeskills/{employee}/delete/{employeeskill}', 'AdminEmployeeSkillsController@getDelete');
	Route::post('employeeskills/{employee}/delete/{employeeskill}', 'AdminEmployeeSkillsController@postDelete');

	# EmployeeEducations Management
	Route::get('employeeeducations/{employee}/show', 'AdminEmployeeEducationsController@getShow');
	Route::get('employeeeducations/{employee}/data', 'AdminEmployeeEducationsController@getData');
	Route::get('employeeeducations/{employee}/create', 'AdminEmployeeEducationsController@getCreate');
	Route::post('employeeeducations/{employee}/create', 'AdminEmployeeEducationsController@postCreate');
	Route::get('employeeeducations/{employee}/edit/{employeeeducation}', 'AdminEmployeeEducationsController@getEdit');
	Route::post('employeeeducations/{employee}/edit/{employeeeducation}', 'AdminEmployeeEducationsController@postEdit');
	Route::get('employeeeducations/{employee}/delete/{employeeeducation}', 'AdminEmployeeEducationsController@getDelete');
	Route::post('employeeeducations/{employee}/delete/{employeeeducation}', 'AdminEmployeeEducationsController@postDelete');

	# EmployeeLanguages Management
	Route::get('employeelanguages/{employee}/show', 'AdminEmployeeLanguagesController@getShow');
	Route::get('employeelanguages/{employee}/data', 'AdminEmployeeLanguagesController@getData');
	Route::get('employeelanguages/{employee}/create', 'AdminEmployeeLanguagesController@getCreate');
	Route::post('employeelanguages/{employee}/create', 'AdminEmployeeLanguagesController@postCreate');
	Route::get('employeelanguages/{employee}/edit/{employeelanguage}', 'AdminEmployeeLanguagesController@getEdit');
	Route::post('employeelanguages/{employee}/edit/{employeelanguage}', 'AdminEmployeeLanguagesController@postEdit');
	Route::get('employeelanguages/{employee}/delete/{employeelanguage}', 'AdminEmployeeLanguagesController@getDelete');
	Route::post('employeelanguages/{employee}/delete/{employeelanguage}', 'AdminEmployeeLanguagesController@postDelete');

	# Employee Certifications Management
	Route::get('employeecertifications/{employee}/show', 'AdminEmployeeCertificationsController@getShow');
	Route::get('employeecertifications/{employee}/data', 'AdminEmployeeCertificationsController@getData');
	Route::get('employeecertifications/{employee}/create', 'AdminEmployeeCertificationsController@getCreate');
	Route::post('employeecertifications/{employee}/create', 'AdminEmployeeCertificationsController@postCreate');
	Route::get('employeecertifications/{employee}/edit/{employeecertification}', 'AdminEmployeeCertificationsController@getEdit');
	Route::post('employeecertifications/{employee}/edit/{employeecertification}', 'AdminEmployeeCertificationsController@postEdit');
	Route::get('employeecertifications/{employee}/delete/{employeecertification}', 'AdminEmployeeCertificationsController@getDelete');
	Route::post('employeecertifications/{employee}/delete/{employeecertification}', 'AdminEmployeeCertificationsController@postDelete');

	# Employee Experiences Management
	Route::get('employeeexperiences/{employee}/show', 'AdminEmployeeExperiencesController@getShow');
	Route::get('employeeexperiences/{employee}/data', 'AdminEmployeeExperiencesController@getData');
	Route::get('employeeexperiences/{employee}/create', 'AdminEmployeeExperiencesController@getCreate');
	Route::post('employeeexperiences/{employee}/create', 'AdminEmployeeExperiencesController@postCreate');
	Route::get('employeeexperiences/{employee}/edit/{employeeexperience}', 'AdminEmployeeExperiencesController@getEdit');
	Route::post('employeeexperiences/{employee}/edit/{employeeexperience}', 'AdminEmployeeExperiencesController@postEdit');
	Route::get('employeeexperiences/{employee}/delete/{employeeexperience}', 'AdminEmployeeExperiencesController@getDelete');
	Route::post('employeeexperiences/{employee}/delete/{employeeexperience}', 'AdminEmployeeExperiencesController@postDelete');

	# Employee Salary Management
	Route::get('employeesalaries/{employee}/show', 'AdminEmployeeSalariesController@getShow');
	Route::get('employeesalaries/{employee}/data', 'AdminEmployeeSalariesController@getData');
	Route::get('employeesalaries/{employee}/create', 'AdminEmployeeSalariesController@getCreate');
	Route::post('employeesalaries/{employee}/create', 'AdminEmployeeSalariesController@postCreate');
	Route::get('employeesalaries/{employee}/edit/{employeesalary}', 'AdminEmployeeSalariesController@getEdit');
	Route::post('employeesalaries/{employee}/edit/{employeesalary}', 'AdminEmployeeSalariesController@postEdit');
	Route::get('employeesalaries/{employee}/delete/{employeesalary}', 'AdminEmployeeSalariesController@getDelete');
	Route::post('employeesalaries/{employee}/delete/{employeesalary}', 'AdminEmployeeSalariesController@postDelete');

	#----------------------------------------------------
	# Recruitment-Vacancies Management
	Route::get('recruitvacancies/{recruitvacancy}/show', 'AdminRecruitVacanciesController@getShow');
	Route::get('recruitvacancies/{recruitvacancy}/edit', 'AdminRecruitVacanciesController@getEdit');
	Route::post('recruitvacancies/{recruitvacancy}/edit', 'AdminRecruitVacanciesController@postEdit');
	Route::get('recruitvacancies/{recruitvacancy}/delete', 'AdminRecruitVacanciesController@getDelete');
	Route::post('recruitvacancies/{recruitvacancy}/delete', 'AdminRecruitVacanciesController@postDelete');
	Route::controller('recruitvacancies', 'AdminRecruitVacanciesController');

	# Recruitment-Candidates Management
	Route::get('recruitcandidates/{recruitcandidate}/show', 'AdminRecruitCandidatesController@getShow');
	Route::get('recruitcandidates/{recruitcandidate}/edit', 'AdminRecruitCandidatesController@getEdit');
	Route::post('recruitcandidates/{recruitcandidate}/edit', 'AdminRecruitCandidatesController@postEdit');
	Route::get('recruitcandidates/{recruitcandidate}/delete', 'AdminRecruitCandidatesController@getDelete');
	Route::post('recruitcandidates/{recruitcandidate}/delete', 'AdminRecruitCandidatesController@postDelete');
	Route::controller('recruitcandidates', 'AdminRecruitCandidatesController');

	# Admin Dashboard. Always need to be added last.
	Route::controller('/', 'AdminDashboardController');
});
