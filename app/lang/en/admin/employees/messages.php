<?php

return array(
	'does_not_exist'    => 'Employee does not exist.',

	'already_exists'    => 'Employee already exists!',

	'login_required'    => 'The login field is required',
	'password_required' => 'The password is required.',
	'password_does_not_match' => 'The passwords provided do not match.',

	'create' => array(
		'error'   => 'User was not created, please try again.',
		'success' => 'User created successfully.'
	),

    'edit' => array(
        'impossible' => 'You cannot edit yourself.',
        'error'      => 'There was an issue editing the user. Please try again.',
        'success'    => 'The user was edited successfully.'
    ),

    'delete' => array(
        'impossible' => 'You cannot delete yourself.',
        'error'      => 'There was an issue deleting the user. Please try again.',
        'success'    => 'The user was deleted successfully.'
    ),

    'import' => array(
	    'impossible' => 'You cannot import duplicated employees.',
	    'error'      => 'There was an issue importing the employee. Please try again.',
	    'success'    => 'Import employees successfully.'
    ),

    'export' => array(
	    'error'      => 'There was an issue exporting the employee. Please try again.',
	    'success'    => 'Export employees successfully.'
    )
);
