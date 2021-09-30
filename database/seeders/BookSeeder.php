<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('books')->insert([
            'id' => 1,
            'name' => 'Book 1',
            'author' => 'sadnsdjabsdasd',
            'ISBN' => '23231312s',
            'description' => 'sadcsansdjabsdasd',
            'originalCount' => 123,
            'count' => 123,
            'publishedYear' => '2020',
        ]);

        DB::table('books')->insert([
            'id' => 2,
            'name' => 'Book 2',
            'author' => 'sadnssadjabsdasd',
            'ISBN' => '2323131da2s',
            'description' => 'sadcadsansdjabsdasd',
            'originalCount' => 123,
            'count' => 123,
            'publishedYear' => '2020',
        ]);

        DB::table('books')->insert([
            'id' => 3,
            'name' => 'Book 3',
            'author' => 'sadnsd33jabsdasd',
            'ISBN' => '2323131233s',
            'description' => 'sadcsa3nsdjabsdasd',
            'originalCount' => 123,
            'count' => 123,
            'publishedYear' => '2020',
        ]);
    }
}
