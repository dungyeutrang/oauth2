<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

            User::truncate();
            User::create(['username'=>'demo',
                'password'=>'123456'
                ]);
	}

}
