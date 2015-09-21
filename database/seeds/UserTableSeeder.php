<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // dd(getenv('ADMIN_PASSWORD'));
        App\User::create([
            'name' => 'Willem Ellis',
            'email' => 'willem.ellis@gmail.com',
            'password' => bcrypt(getenv('ADMIN_PASSWORD')),
            'is_admin' => true
        ]);
    }
}
