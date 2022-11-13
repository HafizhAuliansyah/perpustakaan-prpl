<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $array['name'] = 'Admin';
        $array['email'] = 'admin@mail.com';
        $array['password'] = '12345678';
        $array['password'] = bcrypt($array['password']);
        $user = User::create($array);
    }
}
