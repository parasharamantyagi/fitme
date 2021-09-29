<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		User::insert([
            'name' => 'admin',
            'phone' => '99999',
            'dob' => '2021-03-16',
            'gender' => 'male',
            'status' => '1',
            'roll_id' => '1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);
		
        // $this->call(UsersTableSeeder::class);
    }
}
