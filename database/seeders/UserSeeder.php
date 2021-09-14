<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'fullName' => 'user 1',
            'username' => 'adasjdasgvdas',
            'email' => 'asljd@#adwld',
            'password' => bcrypt('aljdbsakdasd'),
            'active' => true
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'fullName' => 'user 2',
            'username' => 'adasjdasgvadas',
            'email' => 'asljd@#adwsld',
            'password' => bcrypt('aljadbsakdasd'),
            'active' => true
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'fullName' => 'user 3',
            'username' => 'adaadasjdasgvdas',
            'email' => 'asljd@#daadwld',
            'password' => bcrypt('aljaddbsakdasd'),
            'active' => false
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'fullName' => 'user 4',
            'username' => 'adasjdaadadasgvdas',
            'email' => 'asljd@#adwdadald',
            'password' => bcrypt('adaddadadad'),
            'active' => false
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'fullName' => 'user 5',
            'username' => 'adasjddadadadaadsgvdas',
            'email' => 'asljd@#adwldadadadad',
            'password' => bcrypt('aljadadadadadbsakdasd'),
            'active' => true
        ]);
    }
}
