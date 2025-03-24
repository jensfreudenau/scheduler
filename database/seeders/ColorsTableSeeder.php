<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert(
            [
                [
                    'id' => 1,
                    'text' => '#111222',
                    'description' => 'farbe1',
                ],
                [
                    'id' => 2,
                    'text' => '#113322',
                    'description' => 'farbe2',
                ],
                [
                    'id' => 3,
                    'text' => '#114422',
                    'description' => 'farbe3',
                ],
                [
                    'id' => 4,
                    'text' => '#115522',
                    'description' => 'farbe4',
                ],
            ]
        );
    }
}
