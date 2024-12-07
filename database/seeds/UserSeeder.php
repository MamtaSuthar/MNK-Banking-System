<?php

use Illuminate\Database\Seeder;
use App\User; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::where('is_admin', true)->doesntExist()) {
            User::create([
                'first_name' => 'Super', 
                'last_name' => 'Admin',
                'dob' => now(),
                'address' => 'Admin Address',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678'), 
                'is_admin' => true,
            ]);
        }
    }
}
