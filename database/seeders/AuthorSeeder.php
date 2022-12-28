<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('authors')->insert([
            'name' => "jk rowling",
            'country' => "england",
            'birth_date' => "1980-10-10",
            'bio' => "lorem ipsum blalalalala",
            'photo' => "lorem.jpg"
        ]);
    }
}
