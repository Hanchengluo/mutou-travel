<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('permissions')->delete();
        
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'name' => 'dashboard-home',
                'display_name' => '控制面板',
                'description' => '控制面板首页',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],[
                'id' => 2,
                'parent_id' => 0,
                'name' => 'navigations',
                'display_name' => '导航管理',
                'description' => '导航管理页面',
                'created_at' => NULL,
                'updated_at' => NULL,
            ]
        ]);
        
        
    }
}