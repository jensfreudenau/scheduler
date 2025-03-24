<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ColorsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(PermissionsDemoSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(EventsTableSeeder::class);
    }
}
