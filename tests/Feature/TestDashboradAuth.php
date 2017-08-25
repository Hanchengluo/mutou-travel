<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;

class TestDashboradAuth extends TestCase
{
    protected static $token;

    public function testLogin(){
        $response = $this->post('api/dashboard/login',['username'=>'mutou','password'=>'mutou.io']);
        $content = $response->getContent();
        self::$token = json_decode($response->getContent(),true);;
        $response->assertStatus(200)->assertJsonStructure(['token_type','expires_in','access_token','refresh_token']);
    }

    public function testUnlock(){
        $response = $this->post('api/dashboard/unlock',['id'=>1,'password'=>'mutou.io','refresh_token'=>self::$token['refresh_token']]);
        self::$token = json_decode($response->getContent(),true);
        $response->assertStatus(200)->assertJsonStructure(['token_type','expires_in','access_token','refresh_token']);
    }

    public function testRefresh(){
        $response = $this->post('api/dashboard/refresh',['refresh_token'=>self::$token['refresh_token']]);
        self::$token = json_decode($response->getContent(),true);
        $response->assertStatus(200)->assertJsonStructure(['token_type','expires_in','access_token','refresh_token']);
    }
}
