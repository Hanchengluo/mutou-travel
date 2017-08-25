<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'name' => 'admin',
                'display_name' => '管理员',
                'description' => '管理员用户组',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}