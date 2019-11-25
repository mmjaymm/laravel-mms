<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

use App\Hris;
use App\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->unsignedBigInteger('roles_id');
            $table->foreign('roles_id')->references('id')->on('roles');
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}