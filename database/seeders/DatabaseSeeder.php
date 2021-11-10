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
        $this->call(ReferenceTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(EmployeeDetailTableSeeder::class);
        $this->call(LeaveTableSeeder::class);
    }
}
