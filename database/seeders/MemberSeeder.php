<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member = new Member();
        $member->NIK = 12345678;
        $member->Nama = 'Haidar Ali';
        $member->StatusMember = 'active';
        $member->NomorTelepon = 12345678;
        $member->Email = 'haidarali@gmail.com';
        $member->save();
    }
}
