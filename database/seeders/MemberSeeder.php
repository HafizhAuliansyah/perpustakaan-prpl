<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for($i = 1; $i <= 10; $i++){
            $member = new Member();
            // $member->NIK = strval($faker->unique()->numberBetween(1000000000000001, 1000000000000010);
            $member->NIK = strval(1000000000000000 + $i);
            $member->Nama = $faker->unique()->name;
            $member->StatusMember = 'active';
            $member->NomorTelepon = strval($faker->unique()->numberBetween(100000000000000, 999999999999999));
            $member->Email = $faker->unique()->email;
            $member->save();
        }
    }
}
