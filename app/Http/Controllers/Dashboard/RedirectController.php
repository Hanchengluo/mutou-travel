<?php

namespace App\Http\Controllers\Dashboard;

use App\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class RedirectController extends Controller
{

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'url.required' => '访问网址不能为空',
            'url.unique' => '访问网址已存在',
            'url.max'=>'访问网址过长',
            'redirect.required'  => '重定向目标网址不能为空',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $input = $request->all();
        $keywords = empty($input['keywords']) ? '' : $input['keywords'];
        $codes = empty($input['codes']) ? '300,301,302,303,304,305,307' : $input['codes'];
        
        $codes = explode(',',$codes);
        $redirect = Redirect::where(function($query) use($codes,$keywords) {
            $query->whereIn('code',$codes);
            if ($keywords != '') {
                $query->where(function ($q) use ($keywords) {
                    $q->orWhere('url','like','%'.$keywords.'%');
                    $q->orWhere('redirect','like','%'.$keywords.'%');
                    $q->orWhere('description','like','%'.$keywords.'%');
                });
            }
        })->paginate(config('site.page_size'));

        $redirect->appends(['keywords' => $keywords,'codes'=>implode(',',$codes)])->links();
        
        return $redirect;
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
            'url'=>'bail|required|unique:redirects|max:255',
            'redirect'=>'required'
        ],$this->messages());

        $redirect = new Redirect;
        $redirect->url = $request->url;
        $redirect->redirect = $request->redirect;
        $redirect->description = $request->description;
        $redirect->code = $request->code;
        $redirect->save();

        Cache::forget('redirects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Redirect::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Redirect::find($id);
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
        $this->validate($request, [
            'url'=>[
                'bail',
                'required',
                'max:255',
                Rule::unique('redirects')->ignore($id),
            ],
            'redirect'=>'required'
        ],$this->messages());

        $redirect = Redirect::find($id);
        $redirect->url = $request->url;
        $redirect->redirect = $request->redirect;
        $redirect->description = $request->description;
        $redirect->code = $request->code;
        $redirect->save();

        Cache::forget('redirects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (strpos($id, ",") === false){

        }else{
            $id = explode(',',$id);
            $id = array_unique($id);
        }
        Redirect::destroy($id);
        Cache::forget('redirects');
    }

    public function validata(Request $request)
    {
        $this->validate($request, [
            'url'=>[
                'bail',
                'required',
                'max:255',
                Rule::unique('redirects')->ignore($request->id),
            ]
        ],$this->messages());
    }
}
