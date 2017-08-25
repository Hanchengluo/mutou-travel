<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionRoleTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('permission_role')->delete();
        
        DB::table('permission_role')->insert([
            [
                'permission_id' => 1,
                'role_id' => 1,
            ],[
                'permission_id' => 2,
                'role_id' => 1,
            ]
        ]);
        
        
    }
}