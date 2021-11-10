<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class EmployeeDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacadesDB::table('employee_details')->truncate();

            //Employees
            FacadesDB::table('employee_details')->insert([
            [ //1 'name' => 'Nurul Jannah Binti Muhamad Ali',
                'user_id' => 2,
                'approver_id' =>  23,
                'ic' =>  '880423-05-5280',
                'gender_id' => 2,
                'phoneNum' =>  '+(60)17 692-7966',
                'date_joined' => Carbon::create('2018','08','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //2 'name' => 'Abu Bakar Bin Katun',
              'user_id' => 3,
              'approver_id' =>  22,
              'ic' =>  '590201-04-5321',
              'gender_id' =>  1,
              'phoneNum' =>  '+(60)12 247-1287',
              'date_joined' =>  Carbon::create('2019','01','15'),
              'last_carry_over' => Carbon::now()->year,
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ],
            [ //3  'name' => 'Ahmad Hazimin Bin Md Jauhar',
                'user_id' => 4,
                'approver_id' =>  23,
                'ic' =>  '771212-08-6025',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)12 321-2735',
                'date_joined' => Carbon::create('2016','11','15'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //4 'name' => 'Mohd Faizal Bin Abd Razak',
                'user_id' => 5,
                'approver_id' => 4,
                'ic' =>  '790501-01-6297',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)19 218-6321',
                'date_joined' =>  Carbon::create('2017','01','09'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//5 'name' => 'Hasan Bin Ahmad',
                'user_id' => 6,
                'approver_id' =>  4,
                'ic' =>  '870902-06-5209',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)19 263-8480',
                'date_joined' =>  Carbon::create('2017','01','09'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//6 'name' => 'Muhammad Faiz Bin Mohd Rosman',
                'user_id' => 7,
                'approver_id' =>  4,
                'ic' => '880820-14-5773',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)16 217-7427',
                'date_joined' =>  Carbon::create('2016','12','02'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//7 'name' => 'Siti Nurul Ain Binti Ismail',
                'user_id' => 8,
                'approver_id' =>  4,
                'ic' =>  '951112-03-5640',
                'gender_id' =>  2,
                'phoneNum' =>  '+(60)19 497-2734',
                'date_joined' => Carbon::create('2016','12','02'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//8 'name' => 'Mohd Zaki Bin Mohd Zakaria',
                'user_id' => 9,
                'approver_id' =>  4,
                'ic' =>  '860406-14-5075',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)19 430-3585',
                'date_joined' => Carbon::create('2017','06','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//9 'name' => 'Muhammad Amzari Bin Johari',
                'user_id' => 10,
                'approver_id' =>  4,
                'ic' =>  '930507-14-5729',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)11 2708-2043',
                'date_joined' => Carbon::create('2017','06','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//10 'name' => 'Mohammad Ariffin Bin Abdul Rahman',
                'user_id' => 11,
                'approver_id' =>  4,
                'ic' =>  '870814-11-5309',
                'gender_id' =>  1,
                'phoneNum' => '+(60)11 1785-7758',
                'date_joined' => Carbon::create('2017','06','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//11 'name' => 'Mohd Ismarul Bin Mohd Nor',
                'user_id' => 12,
                'approver_id' =>  13,
                'ic' => '860430-59-5447',
                'gender_id' => 1,
                'phoneNum' =>  '+(60)12 301-4854',
                'date_joined' => Carbon::create('2017','10','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//12 'name' => 'Mohd Nashoruddin Bin Jaafar',
                'user_id' => 13,
                'approver_id' =>  23,
                'ic' =>  '840828-08-5019',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)19 278-2644',
                'date_joined' => Carbon::create('2017','11','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//13 'name' => 'Noor Amalina Binti Bukhori',
                'user_id' => 14,
                'approver_id' =>  4,
                'ic' =>  '910914-11-5174',
                'gender_id' =>  2,
                'phoneNum' =>  '+(60)18 792-4526',
                'date_joined' => Carbon::create('2018','05','02'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//14 'name' => 'Dalilah Binti Dahlan @ Mohd Shafie',
                'user_id' => 15,
                'approver_id' =>  4,
                'ic' =>  '910704-11-5192',
                'gender_id' =>  2,
                'phoneNum' =>  '+(60)18 245-6110',
                'date_joined' => Carbon::create('2018','05','02'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//15 'name' => 'Marwan Zaim Bin Mat Rawi',
                'user_id' => 16,
                'approver_id' =>  4,
                'ic' =>  '920903-10-5543',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)18 202-0942',
                'date_joined' => Carbon::create('2019','05','02'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//16 'name' => 'Siti Muzliana Binti Jalal',
                'user_id' => 17,
                'approver_id' => 4,
                'ic' =>  '951106-10-5390',
                'gender_id' =>  2,
                'phoneNum' =>  '+(60)11 2410-5374',
                'date_joined' => Carbon::create('2019','05','06'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//17 'name' => 'Siti Aisyah Binti Abdul Hamid',
                'user_id' => 18,
                'approver_id' =>  4,
                'ic' =>  '950908-03-6038',
                'gender_id' =>  2,
                'phoneNum' => '+(60)18 325-0193',
                'date_joined' => Carbon::create('2019','06','17'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//18 'name' => 'Raina Farrah Binti Muhamad Raside',
                'user_id' => 19,
                'approver_id' =>  4,
                'ic' =>  '960111-14-5180',
                'gender_id' =>  2,
                'phoneNum' => '+(60)19 314-6296',
                'date_joined' => Carbon::create('2020','01','06'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//19 'name' => 'Ahmad Khusairy Bin Zulkefli',
                'user_id' => 20,
                'approver_id' =>  4,
                'ic' =>  '910224-03-5425',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)14 942-5521',
                'date_joined' => Carbon::create('2020','02','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//20 'name' => 'Muhammad Aiman Bin Rusli',
                'user_id' => 21,
                'approver_id' =>  4,
                'ic' =>  '960807-03-5465',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)14 848-7602',
                'date_joined' => Carbon::create('2020','02','17'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//21 'name' => 'Fareed Firdaus Bin Arund',
                'user_id' => 22,
                'approver_id' =>  null,
                'ic' =>  '760819-05-5491',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)19 212-1848',
                'date_joined' => Carbon::create('2013','02','01'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//22 'name' => 'Hafiz Faisal Bin Mohd Kalis',
                'user_id' => 23,
                'approver_id' =>  null,
                'ic' =>  '790809-01-5637',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)12 360-2595',
                'date_joined' => Carbon::create('2017','09','19'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [//23 'name' => 'Normans Anak Lewis',
                'user_id' => 24,
                'approver_id' =>  4,
                'ic' =>  '910117-13-6335',
                'gender_id' =>  1,
                'phoneNum' =>  '+(60)16 223-2526',
                'date_joined' => Carbon::create('2020','11','15'),
                'last_carry_over' => Carbon::now()->year,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}