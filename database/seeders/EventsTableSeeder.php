<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mutable = Carbon::now();
        DB::table('events')->insert(
            [
                [
                    'id' => 1,
                    'text' => 'Event #1',
                    'color_id' => 1,
                    'start_date' => $mutable->toDateTimeString(),
                    'end_date' => $mutable->add(4, 'hours')->toDateTimeString()
                ],
                [
                    'id' => 2,
                    'text' => 'Event #2',
                    'color_id' => 1,
                    'start_date' => $mutable->add(1, 'day')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'day')->add(1, 'hour')->toDateTimeString()
                ],
                [
                    'id' => 3,
                    'text' => 'Event #3',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(12, 'hours')->toDateTimeString(),
                ],
                [
                    'id' => 4,
                    'text' => 'Event #4',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'days')->toDateTimeString(),
                    'end_date' => $mutable->add(4, 'days')->add(4, 'hours')->toDateTimeString(),
                ],
                [
                    'id' => 5,
                    'text' => 'Event #5',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                ],
                [
                    'id' => 6,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ],
                [
                    'id' => 7,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ],
                [
                    'id' => 8,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ],
                [
                    'id' => 9,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ],
                [
                    'id' => 10,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ],
                [
                    'id' => 11,
                    'text' => 'Event #6',
                    'color_id' => 1,
                    'start_date' => $mutable->add(4, 'hours')->toDateTimeString(),
                    'end_date' => $mutable->add(1, 'week')->toDateTimeString(),
                ]
            ]
        );
    }
}
