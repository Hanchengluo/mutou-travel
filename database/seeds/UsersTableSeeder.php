<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('users')->delete();
        
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'mutou',
            'phone' => NULL,
            'email' => 'admin@mutou.io',
            'password' => bcrypt('mutou.io'),
            'avatar' => NULL,
            'status' => 1,
            'is_admin' => 1,
            'remember_token' => 'pEQHJzdB8wv6S8gVjwwvjavMnjfpgCPRCG8ovb6y9iu72PImtFGKQoCym852',
            'created_at' => '2017-08-25 04:41:27',
            'updated_at' => '2017-08-25 04:41:27',
        ]);
        
        
    }
}