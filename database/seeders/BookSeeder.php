<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'title' => "harry potter",
            'id_authors' => 1,
            'id_categories' => 1,
            'publisher' => "erlangga",
            'released_date' => "2020-10-30",
            'print_date' => "2020-11-30",
            'pages_number' => 500,
            'rating' => 4.5,
            'picture' => "lorem.jpg",
            'sinopsis' => "lorem ipsum blablabla"
        ]);
    }
}
