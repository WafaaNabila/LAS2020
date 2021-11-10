<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacadesDB::table('users')->truncate();

        //Admin
        FacadesDB::table('users')->insert([
          'id' => 1,
          'name' => 'Admin',
          'email' => 'admin@igsprotech.com.my',
          'role_id' => 1,
          'emp_status_id' => 1,
          'password' => Hash::make('igsprotech2020'),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);

            //Employees
            FacadesDB::table('users')->insert([
            [ //1
                'id' => 2,
                'name' => 'Nurul Jannah Binti Muhamad Ali',
                'email' => 'jannah@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //2
              'id' => 3,
              'name' => 'Abu Bakar Bin Katun',
              'email' => 'abu@igsprotech.com.my',
              'password' => Hash::make('igsprotech2020'),
              'role_id' => 2,
              'emp_status_id' => 1,
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ],
            [ //3
                'id' => 4,
                'name' => 'Ahmad Hazimin Bin Md Jauhar',
                'email' => 'ahmadhazimin@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 3,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //4
                'id' => 5,
                'name' => 'Mohd Faizal Bin Abd Razak',
                'email' => 'faizal@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//5
                'id' => 6,
                'name' => 'Hasan Bin Ahmad',
                'email' => 'hasan@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//6
                'id' => 7,
                'name' => 'Muhammad Faiz Bin Mohd Rosman',
                'email' => 'faiz@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//7
                'id' => 8,
                'name' => 'Siti Nurul Ain Binti Ismail',
                'email' => 'nurulain@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//8
                'id' => 9,
                'name' => 'Mohd Zaki Bin Mohd Zakaria',
                'email' => 'zaki@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//9
                'id' => 10,
                'name' => 'Muhammad Amzari Bin Johari',
                'email' => 'amzari@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//10
                'id' => 11,
                'name' => 'Mohammad Ariffin Bin Abdul Rahman',
                'email' => 'ariffin@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//11
                'id' => 12,
                'name' => 'Mohd Ismarul Bin Mohd Nor',
                'email' => 'ismarul@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//12
                'id' => 13,
                'name' => 'Mohd Nashoruddin Bin Jaafar',
                'email' => 'nash@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 3,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//13
                'id' => 14,
                'name' => 'Noor Amalina Binti Bukhori',
                'email' => 'amalina@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//14
                'id' => 15,
                'name' => 'Dalilah Binti Dahlan @ Mohd Shafie',
                'email' => 'dalilah@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//15
                'id' => 16,
                'name' => 'Marwan Zaim Bin Mat Rawi',
                'email' => 'marwan@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//16
                'id' => 17,
                'name' => 'Siti Muzliana Binti Jalal',
                'email' => 'muzliana@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//17
                'id' => 18,
                'name' => 'Siti Aisyah Binti Abdul Hamid',
                'email' => 'aisyah@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//18
                'id' => 19,
                'name' => 'Raina Farrah Binti Muhamad Raside',
                'email' => 'farrah@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//19
                'id' => 20,
                'name' => 'Ahmad Khusairy Bin Zulkefli',
                'email' => 'khusyairy@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//20
                'id' => 21,
                'name' => 'Muhammad Aiman Bin Rusli',
                'email' => 'aiman@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//21
                'id' => 22,
                'name' => 'Fareed Firdaus Bin Arund',
                'email' => 'firdaus@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 3,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//22
                'id' => 23,
                'name' => 'Hafiz Faisal Bin Mohd Kalis',
                'email' => 'hafiz@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 3,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//23
                'id' => 24,
                'name' => 'Normans Anak Lewis',
                'email' => 'normans@igsprotech.com.my',
                'password' => Hash::make('igsprotech2020'),
                'role_id' => 2,
                'emp_status_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
