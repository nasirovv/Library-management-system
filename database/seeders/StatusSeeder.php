<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'id' => 1,
            'message' => 'waiting',
        ]);

        DB::table('statuses')->insert([
            'id' => 2,
            'message' => 'denied',
        ]);

        DB::table('statuses')->insert([
            'id' => 3,
            'message' => 'onProcess',
        ]);

        DB::table('statuses')->insert([
            'id' => 4,
            'message' => 'finished',
        ]);

        DB::table('statuses')->insert([
            'id' => 5,
            'message' => 'inDebt',
        ]);

    }
}
