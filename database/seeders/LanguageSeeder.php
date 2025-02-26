<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\AppUser;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->truncate();

        $languages = [
            ['name' => 'English'],
            ['name' => 'Arabic'],
            ['name' => 'Hindi'],
            ['name' => 'Urdu'],
            ['name' => 'Spanish'],
            ['name' => 'Russian'],
            ['name' => 'Japanese'],
            ['name' => 'Chinese'],
            ['name' => 'Bengali'],
        ];

        DB::table('languages')->insert($languages);

    }
}