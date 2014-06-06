<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		// Add calls to Seeders here
		//$this->call('UsersTableSeeder');
		//$this->call('RolesTableSeeder');
		//$this->call('PermissionsTableSeeder');
	}

}