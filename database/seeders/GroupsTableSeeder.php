<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;


class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            'Lavita',
            'Pfalsz'
        ];

        foreach ($groups as $group) {
            Group::create(['name' => $group]);
        }
    }
}
