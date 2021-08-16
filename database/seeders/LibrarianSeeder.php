<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibrarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('librarians')->insert([
            'id' => 1,
            'name' => 'librarian one',
            'username' => 'librarian1',
            'password' => bcrypt('asasasasasqw1'),
        ]);

        DB::table('librarians')->insert([
            'id' => 2,
            'name' => 'librarian two',
            'username' => 'librarian2',
            'password' => bcrypt('asasasasasqw2'),
        ]);

        DB::table('librarians')->insert([
            'id' => 3,
            'name' => 'librarian three',
            'username' => 'librarian3',
            'password' => bcrypt('asasasasasqw3'),
        ]);
    }
}
