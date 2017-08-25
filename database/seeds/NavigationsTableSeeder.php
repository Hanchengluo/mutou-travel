<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NavigationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('navigations')->delete();
        
        DB::table('navigations')->insert([
            [
                'id' => 1,
                'parent_id' => 0,
                'position_id' => 1,
                'sort' => 0,
                'name' => 'dashboard-home',
                'display_name' => '控制面板',
                'target' => '_self',
                'url' => 'dashboard/home',
                'icon' => 'home.svg',
                'icon_type' => 1,
                'display' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ],[
                'id' => 2,
                'parent_id' => 0,
                'position_id' => 1,
                'sort' => 1,
                'name' => 'navigations',
                'display_name' => '导航管理',
                'target' => '_self',
                'url' => 'dashboard/navigations',
                'icon' => 'ios-grid-view-outline',
                'icon_type' => 0,
                'display' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ]
        ]);
        
        
    }
}