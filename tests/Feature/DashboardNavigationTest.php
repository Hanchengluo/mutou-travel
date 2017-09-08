<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp\Client;
use App\User;
use App\NavigationPositions;
use App\Navigation;

class DashboardNavigationTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();
        $this->user = User::find(1);
    }

    // 测试导航列表
    public function testLists()
    {
        $response = $this->actingAs($this->user, 'api')->json('GET', 'api/dashboard/navigations');
        $response->assertStatus(200);
    }

    // 测试新增导航
    public function testCreate()
    {
        $response = $this->actingAs($this->user, 'api')->json('POST', 'api/dashboard/navigations', [
            'navigations'=>[
                'name'=>'testCase',
                'display_name'=>'unit测试',
                'sort'=>0,
                'nav'=>[
                    [
                        'display'=>true,
                        'display_name'=>'测试导航',
                        'name'=>'testnav',
                        'icon'=>"ios-grid-view-outline",
                        'icon_type'=>0,
                        'parent_id'=>0,
                        'sort'=>0,
                        'target'=>'_self',
                        'url'=>'test',
                        'child'=>[]
                    ],
                    [
                        'display'=>true,
                        'display_name'=>'测试导航2',
                        'name'=>'testnav22',
                        'icon'=>"ios-grid-view-outline",
                        'icon_type'=>0,
                        'parent_id'=>0,
                        'sort'=>0,
                        'target'=>'_self',
                        'url'=>'test',
                        'child'=>[]
                    ]
                ]
            ]
        ]);
        // dump($response->getContent());
        $response->assertStatus(200);
    }

    // 测试更新导航
    public function testUpdate(){
        $position = NavigationPositions::where('name','testCase')->first();
        $response = $this->actingAs($this->user, 'api')->json('PUT', 'api/dashboard/navigations/'.$position->id, [
            'navigations'=>[
                'id'=>$position->id,
                'name'=>'testCase',
                'display_name'=>'unit测试',
                'sort'=>0,
                'nav'=>[
                    [
                        'display'=>true,
                        'display_name'=>'测试导航2',
                        'name'=>'testnav2',
                        'icon'=>"ios-grid-view-outline",
                        'icon_type'=>0,
                        'parent_id'=>0,
                        'sort'=>0,
                        'target'=>'_self',
                        'url'=>'test',
                        'child'=>[]
                    ]
                ]
            ]
        ]);
        // dump($response->getContent());
        $response->assertStatus(200);
    }

    // 测试删除单个导航
    public function testDistoryNavigation(){
        $nav = Navigation::where('name','testnav')->first();
        $response = $this->actingAs($this->user, 'api')->json('DELETE', 'api/dashboard/navigations/'.$nav->id.'/1');
        $response->assertStatus(200);
    }

    // 测试删除导航位置
    public function testDistoryNavigationPosition(){
        $position = NavigationPositions::where('name','testCase')->first();
        $response = $this->actingAs($this->user, 'api')->json('DELETE', 'api/dashboard/navigations/'.$position->id.'/0');
        $response->assertStatus(200);
    }
}
