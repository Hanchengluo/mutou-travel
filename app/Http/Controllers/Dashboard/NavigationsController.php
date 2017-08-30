<?php

namespace App\Http\Controllers\Dashboard;

use App\NavigationPositions;
use App\Navigation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavigationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $navigations = NavigationPositions::with(['nav'=>function($query){
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
        
        $position = new NavigationPositions;
        $position->name = $request->input('navigations.name');
        $position->display_name = $request->input('navigations.display_name');
        $position->sort = $request->input('navigations.sort');
        $position->save();

        $navigations = [];
        foreach ($request->input('navigations.nav') as $key => $value) {
            $navigations[] = new Navigation([
                'sort'=>$value['sort'],
                'name'=>$value['name'],
                'display_name'=>$value['display_name'],
                'target'=>$value['target'],
                'url'=>$value['url'],
                'icon'=>$value['icon'],
                'icon_type'=>$value['icon_type'],
                'display'=>$value['display']
            ]);
        }
        return $navigations;
        $position->nav()->saveMany();

        return $request->input('navigations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $navigation = NavigationPositions::with(['nav'=>function($query){
            $query->orderBy('sort', 'asc')->where('parent_id', 0)->with(['child'=>function ($q) {
                $q->orderBy('sort', 'asc');
            }]);
        }])->where('id',$id)->first();

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
}
