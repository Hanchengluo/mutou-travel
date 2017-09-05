<?php

namespace App\Http\Controllers\Dashboard;

use App\NavigationPositions;
use App\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NavigationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navigations = NavigationPositions::with(['nav'=>function ($query) {
            $query->orderBy('sort', 'asc')->where('parent_id', 0)->with(['child'=>function ($q) {
                $q->orderBy('sort', 'asc');
            }]);
        }])->get();

        return response()->json($navigations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'navigations.name' => 'required|unique:navigation_positions,name|max:255',
            'navigations.display_name' => 'required|max:255',
        ]);
        // return $request->input('navigations.nav');

        DB::transaction(function () use ($request) {
            $position = new NavigationPositions;
            $position->name = $request->input('navigations.name');
            $position->display_name = $request->input('navigations.display_name');
            $position->sort = $request->input('navigations.sort');
            $position->save();

            foreach ($request->input('navigations.nav') as $key => $value) {
                $navigation = new Navigation;
                $navigation->sort = $value['sort'];
                $navigation->name = $value['name'];
                $navigation->display_name = $value['display_name'];
                $navigation->target = $value['target'];
                $navigation->url = $value['url'];
                $navigation->icon = $value['icon'];
                $navigation->icon_type = $value['icon_type'];
                $navigation->display = $value['display'];
                $navigation->position_id = $position->id;
                $navigation->parent_id = 0;
                $navigation->save();
                if(count($value['child']) > 0){
                    foreach ($value['child'] as $k => $v) {
                        $navl2 = new Navigation;
                        $navl2->sort = $v['sort'];
                        $navl2->name = $v['name'];
                        $navl2->display_name = $v['display_name'];
                        $navl2->target = $v['target'];
                        $navl2->url = $v['url'];
                        $navl2->icon = $v['icon'];
                        $navl2->icon_type = $v['icon_type'];
                        $navl2->display = $v['display'];
                        $navl2->parent_id = $navigation->id;
                        $navl2->position_id = $position->id;
                        $navl2->save();
                        if (count($v['child']) > 0) {
                            foreach ($v['child'] as $i => $n) {
                                $navl3 = new Navigation;
                                $navl3->sort = $n['sort'];
                                $navl3->name = $n['name'];
                                $navl3->display_name = $n['display_name'];
                                $navl3->target = $n['target'];
                                $navl3->url = $n['url'];
                                $navl3->icon = $n['icon'];
                                $navl3->icon_type = $n['icon_type'];
                                $navl3->display = $n['display'];
                                $navl3->parent_id = $navl2->id;
                                $navl3->position_id = $position->id;
                                $navl3->save();
                            }
                        }
                    }
                }
            }
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $navigation = NavigationPositions::with(['nav'=>function ($query) {
            $query->orderBy('sort', 'asc')->where('parent_id', 0)->with(['child'=>function ($q) {
                $q->orderBy('sort', 'asc');
            }]);
        }])->where('id', $id)->first();

        return response()->json($navigation);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 验证导航标识
     *
     * 对应路由：api/dashboard/navigations/validata
     *
     * @param Request $request
     * @param string $type
     * @param string $name
     * @param intger $id
     * @return void
     */
    public function validata(Request $request, $type, $name, $id =0)
    {
        if ($type == 'pos') {
            $validate = NavigationPositions::where('name', $name);
            if ($id != 0) {
                $validate->where('id', '<>', $id);
            }
            $res =  $validate->first();
            if ($res) {
                return response()->json(['status'=>0,'message'=>'导航标识已存在']);
            } else {
                return response()->json(['status'=>1,'message'=>'导航标识可用']);
            }
        } else {
            $validate = Navigation::where('name', $name);
            if ($id != 0) {
                $validate->where('id', '<>', $id);
            }
            $res =  $validate->first();
            if ($res) {
                return response()->json(['status'=>0,'message'=>'导航标识已存在']);
            } else {
                return response()->json(['status'=>1,'message'=>'导航标识可用']);
            }
        }
    }
}
