<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Validator;
use Hash;
use Str;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');

    }

    public function doLogin(Request $request)
    {
        $username = $request->input('adminUsername');
        $password = $request->input('adminPassword');

        $rules = [
            'adminUsername' => 'required',
            'adminPassword' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return redirect()->back()->withErorrs($isValid->errors());
        }else{
            $check = Admin::where('adminUsername', $username);
            if($check->count() > 0){
                $data = $check->first();
                if(Hash::check($password, $data->adminPassword)){
                    $session = [
                        'adminName' => $data->adminName,
                        'adminId'   => $data->adminId,
                        'roleId'    => $data->roleId,
                        'token'     => Str::random(60)
                    ];
                    session($session);
                    return redirect('admin/dashboard');
                }else{
                    return redirect()->back()->with('error','Password yang anda masukan salah!');
                }
            }else{
                return redirect()->back()->with('error','user tidak ditemukan!');
            }
        }
    }

    public function doLogout()
    {
        session()->flush();
        redirect('login');
    }
}
