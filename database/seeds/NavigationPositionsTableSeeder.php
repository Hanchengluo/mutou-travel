<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class NavigationPositionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('navigation_positions')->delete();
        
        DB::table('navigation_positions')->insert([
            'id' => 1,
            'name' => 'dashboard',
            'display_name' => '控制面板',
            'sort' => 0,
            'created_at' => NULL,
            'updated_at' => NULL,
        ]);
        
        
    }
}