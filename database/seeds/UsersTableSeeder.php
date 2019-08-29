<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'Hiep Nguyen',
            'email'    => 'minhhiep.q@gmail.com',
            'password' => bcrypt('Demo@admin.com'),
        ]);
    }
}
