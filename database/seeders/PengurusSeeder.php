<?php

namespace Database\Seeders;

use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pengurus = new Pengurus();
        // $pengurus->id = 'P1';
        $array['name'] = 'Admin';
        $array['email'] = 'admin@mail.com';
        $array['password'] = bcrypt('12345678');
        $pengurus = Pengurus::create($array);
    }
}
