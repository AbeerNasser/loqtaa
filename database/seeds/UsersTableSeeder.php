<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' =>'admin',
            'phone' =>'123',
            'city' =>'شربين',
            'password' => bcrypt('123456789')
        ]);
        $user->attachRole('super_admin');

    }//end of run

}//end of seeder
