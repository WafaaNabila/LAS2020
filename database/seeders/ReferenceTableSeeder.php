<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class ReferenceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Reference Roles
        FacadesDB::table('ref_roles')->truncate();
        FacadesDB::table('ref_roles')->insert([
          ['id' => 1,
          'role_name' => 'Admin',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 2,
          'role_name' => 'Employee',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 3,
          'role_name' => 'Approver',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ]
        ]);

        //Reference Employee Status
        FacadesDB::table('ref_emp_statuses')->truncate();
        FacadesDB::table('ref_emp_statuses')->insert([
          ['id' => 1,
          'emp_status_name' => 'Working',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 2,
          'emp_status_name' => 'Resigned',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 3,
          'emp_status_name' => 'Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 4,
          'emp_status_name' => 'Long Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ]
        ]);

        //Reference Application Status
        FacadesDB::table('ref_application_statuses')->truncate();
        FacadesDB::table('ref_application_statuses')->insert([
          ['id' => 1,
          'application_status_name' => 'Pending',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 2,
          'application_status_name' => 'Approved',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 3,
          'application_status_name' => 'Rejected',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
        ]);

        //Reference Leave Types
        FacadesDB::table('ref_leave_types')->truncate();
        FacadesDB::table('ref_leave_types')->insert([
          ['id' => 1,
          'leave_type_name' => 'Annual Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 2,
          'leave_type_name' => 'Medical Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 3,
          'leave_type_name' => 'Emergency Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 4,
          'leave_type_name' => 'Unrecorded Leave',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ]
        ]);

        //Reference Gender
        FacadesDB::table('ref_genders')->truncate();
        FacadesDB::table('ref_genders')->insert([
          ['id' => 1,
          'gender_name' => 'Male',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ],
          ['id' => 2,
          'gender_name' => 'Female',
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
          ]
        ]);

      }
}
