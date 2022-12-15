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
        $min_date = strtotime("2021-01-01");
        $max_date = strtotime(date('Y-m-d'));
        for($i = 1; $i <= 2000; $i++){
            $member = new Member();
            // $member->NIK = strval($faker->unique()->numberBetween(1000000000000001, 1000000000000010);
            $new_nik = "1000000000000000";
            $counterlen = strlen((string)$i);
            $new_nik = substr_replace($new_nik, (string)$i, $counterlen * -1);
            $member->NIK = $new_nik;
            $member->Nama = $faker->unique()->name;
            $member->StatusMember = 'active';
            $member->NomorTelepon = strval($faker->unique()->numberBetween(100000000000000, 999999999999999));
            $member->Email = $faker->unique()->email;
            // Random Created Date
            $rand_date = rand($min_date, $max_date);
            $member->created_at = date('Y-m-d', $rand_date);

            $member->save();
        }
    }
}
