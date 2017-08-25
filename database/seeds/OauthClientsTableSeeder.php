<?php

use Illuminate\Database\Seeder;

class OauthClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('oauth_clients')->delete();
        
        \DB::table('oauth_clients')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => NULL,
                'name' => 'Laravel Personal Access Client',
                'secret' => 'dFNFlwhEYdwOtRUEEqqLC5O029j6BL2xT2pwL36V',
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => '2017-08-25 05:27:37',
                'updated_at' => '2017-08-25 05:27:37',
            ),
            1 => 
            array (
                'id' => 2,
                'user_id' => NULL,
                'name' => 'Laravel Password Grant Client',
                'secret' => 'djOwfADLpnCXxVcOF4Rn4a7wNNRc9JeCCeEsUss0',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => '2017-08-25 05:27:37',
                'updated_at' => '2017-08-25 05:27:37',
            ),
        ));
        
        
    }
}