<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('role_user')->delete();
        
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
        
        
    }
}