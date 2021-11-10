<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class LeaveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacadesDB::table('leave_details')->truncate();
        FacadesDB::table('leave_details')->insert([
            [   //Nurul Jannah Binti Muhamad Ali
                'user_id' => 2,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 10,
                'balance_leaves' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Abu Bakar Bin Katun
                'user_id' => 3,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 14,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Ahmad Hazimin Bin Md Jauhar
                'user_id' => 4,
                'annual_e' => 14,
                'carry_over' => 5,
                'total_leaves' => 19,
                'taken_so_far' => 8.5,
                'balance_leaves' => 10.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Mohd Faizal Bin Abd Razak
                'user_id' => 5,
                'annual_e' => 14,
                'carry_over' => 3,
                'total_leaves' => 17,
                'taken_so_far' => 11,
                'balance_leaves' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Hasan Bin Ahmad
                'user_id' => 6,
                'annual_e' => 12,
                'carry_over' => 0,
                'total_leaves' => 12,
                'taken_so_far' => 10,
                'balance_leaves' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Muhammad Faiz Bin Mohd Rosman
                'user_id' => 7,
                'annual_e' => 14,
                'carry_over' => 2,
                'total_leaves' => 16,
                'taken_so_far' => 5.5,
                'balance_leaves' => 10.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Siti Nurul Ain Binti Ismail
                'user_id' => 8,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 14,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Mohd Zaki Bin Mohd Zakaria
                'user_id' => 9,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 14,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Muhammad Amzari Bin Johari
                'user_id' => 10,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 11,
                'balance_leaves' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Mohammad Ariffin Bin Abdul Rahman
                'user_id' => 11,
                'annual_e' => 14,
                'carry_over' => 4,
                'total_leaves' => 18,
                'taken_so_far' => 17.5,
                'balance_leaves' => 0.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Mohd Ismarul Bin Mohd Nor
                'user_id' => 12,
                'annual_e' => 14,
                'carry_over' => 5,
                'total_leaves' => 19,
                'taken_so_far' => 19,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()

            ],
            [   //Mohd Nashoruddin Bin Jaafar
                'user_id' => 13,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 5,
                'balance_leaves' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Noor Amalina Binti Bukhori
                'user_id' => 14,
                'annual_e' => 14,
                'carry_over' => 0.5,
                'total_leaves' => 14.5,
                'taken_so_far' => 14.5,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Dalilah Binti Dahlan @ Mohd Shafie
                'user_id' => 15,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 11.5,
                'balance_leaves' => 2.5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Marwan Zaim Bin Mat Rawi
                'user_id' => 16,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 12,
                'balance_leaves' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Siti Muzliana Binti Jalal
                'user_id' => 17,
                'annual_e' => 14,
                'carry_over' => 2,
                'total_leaves' => 16,
                'taken_so_far' => 12,
                'balance_leaves' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Siti Aisyah Binti Abdul Hamid
                'user_id' => 18,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 13,
                'balance_leaves' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Raina Farrah Binti Muhamad Raside
                'user_id' => 19,
                'annual_e' => 14,
                'carry_over' => 0,
                'total_leaves' => 14,
                'taken_so_far' => 14,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Ahmad Khusairy Bin Zulkefli
                'user_id' => 20,
                'annual_e' => 13,
                'carry_over' => 0,
                'total_leaves' => 13,
                'taken_so_far' => 13,
                'balance_leaves' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Muhammad Aiman Bin Rusli
                'user_id' => 21,
                'annual_e' => 12,
                'carry_over' => 0,
                'total_leaves' => 12,
                'taken_so_far' => 9,
                'balance_leaves' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [   //Normans Anak Lewis
                'user_id' => 24,
                'annual_e' => 2,
                'carry_over' => 0,
                'total_leaves' => 2,
                'taken_so_far' => 0,
                'balance_leaves' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
          ]);

    }
}
