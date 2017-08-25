<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\NavigationPositions;

class InitController extends Controller
{
    public function inital(Request $request)
    {
        // 当前用户信息
        $user = $request->user();
        $user->roles;
        $perms = [];
        if ($user->roles) {
            foreach ($user->roles as $role) {
                if ($role) {
                    foreach ($role->perms as $perm) {
                        array_push($perms, $perm->name);
                    }
                }
            }
        }
        $perms = array_unique($perms);
        $user->perms = $perms;
        $data['user'] = $user;

        // 导航栏信息
        $navpos = NavigationPositions::with(['nav'=> function ($query) use ($perms) {
            $query->orderBy('sort', 'asc')->whereIn('name', $perms)->where('parent_id', 0)->with(['child'=>function ($q) use ($perms) {
                $q->orderBy('sort', 'asc')->whereIn('name', $perms);
            }]);
        }])->where('name', 'dashboard')->first();
        $data['nav'] = $navpos->nav;

        return response()->json($data);
    }
}
