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
        $pengurus->name = 'Admin';
        $pengurus->email = 'admin@mail.com';
        $pengurus->password = bcrypt('12345678');
        $pengurus->save();
    }
}
