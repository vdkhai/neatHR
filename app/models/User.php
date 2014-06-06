<?php
use Zizaco\Confide\ConfideUser;
use Zizaco\Entrust\HasRole;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;

class User extends ConfideUser {
	use HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Ardent validation rules
	 *
	 * @var array
	 */
	public static $rules = array(
		'username' => 'required|alpha_dash|unique:users',
		'email' => 'required|email|unique:users',
		'password' => 'required|min:4|confirmed',
		'password_confirmation' => 'min:4',
	);

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

	/**
	 * Save roles inputted from multiselect
	 * @param $inputRoles
	 */
	public function saveRoles($inputRoles)
	{
		if(! empty($inputRoles)) {
			$this->roles()->sync($inputRoles);
		} else {
			$this->roles()->detach();
		}
	}

	/**
	 * Returns user's current role ids only.
	 * @return array|bool
	 */
	public function currentRoleIds()
	{
		$roles = $this->roles;
		$roleIds = false;
		if( !empty( $roles ) ) {
			$roleIds = array();
			foreach( $roles as &$role )
			{
				$roleIds[] = $role->id;
			}
		}
		return $roleIds;
	}

	/**
	 * Redirect after auth.
	 * If ifValid is set to true it will redirect a logged in user.
	 * @param $redirect
	 * @param bool $ifValid
	 * @return mixed
	 */
	public static function checkAuthAndRedirect($redirect, $ifValid=false)
	{
		// Get the user information
		$user = Auth::user();
		$redirectTo = false;

		if(empty($user->id) && ! $ifValid) // Not logged in redirect, set session.
		{
			Session::put('loginRedirect', $redirect);
			$redirectTo = Redirect::to('user/login')
				->with( 'notice', Lang::get('user/user.login_first') );
		}
		elseif(!empty($user->id) && $ifValid) // Valid user, we want to redirect.
		{
			$redirectTo = Redirect::to($redirect);
		}

		return array($user, $redirectTo);
	}

	public function currentUser()
	{
		return (new Confide(new ConfideEloquentRepository()))->user();
	}
}