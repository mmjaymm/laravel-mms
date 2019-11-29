<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Hris;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        
        //getting man power of MIT in HRIS
        $hris = new Hris;
        $where = [
            ['section_code', 'MIT'],
            ['emp_system_status', 'ACTIVE']
        ];
        $man_power_result = $hris->man_power($where);
        $users = [];

        foreach ($man_power_result as $key => $user) {
            $first_name = str_replace(" ", "", strtolower($user->emp_first_name));
            $last_name = str_replace(" ", "", strtolower($user->emp_last_name));

            array_push($users, [
                'employee_number' => $user->emp_pms_id,
                'email' => "{$first_name}.{$last_name}@ph.fujitsu.com",
                'password' => Hash::make('fp'.$user->emp_pms_id),
                'roles_id' => 1,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
        
        User::insert($users);
    }
}
