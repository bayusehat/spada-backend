<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Role;
use Validator;
use Str;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Admin',
            'content' => 'admin',
            'url' => 'setting',
            'role' => Role::where('roleDelete',0)->get()
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $admin = Admin::join('roles','roles.roleId','=','admins.roleId')->get();

        foreach ($admin as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->adminName,
                $v->adminUsername,
                $v->roleName,
                '
                <a href="javascript:void(0)" onclick="show('.$v->adminId.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button type="button" onclick="deleteData('.$v->adminId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'adminName' => 'required',
            'adminUsername' => 'required',
            'adminPassword' => 'required|min:8',
            'roleId' => 'required',
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'adminName' =>  $request->input('adminName'),
                'adminUsername' => $request->input('adminUsername'),
                'adminPassword' => Hash::make($request->input('adminPassword')),
                'roleId' => $request->input('roleId'),
                'adminCreate' => date('Y-m-d H:i:s'),
                'adminUpdate' => date('Y-m-d H:i:s')
            ];

            $insert = Admin::insert($data);

            if($insert){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Admin baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahlan Admin baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $admin = Admin::join('roles','roles.roleId','=','admins.roleId')->where('adminId',$id)->first();
        return response($admin);
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'adminName' => 'required',
            'adminUsername' => 'required',
            'roleId' => 'required',
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'adminName' =>  $request->input('adminName'),
                'adminUsername' => $request->input('adminUsername'),
                'roleId' => $request->input('roleId'),
                'adminCreate' => date('Y-m-d H:i:s'),
                'adminUpdate' => date('Y-m-d H:i:s')
            ];

            $update = Admin::where('adminId',$id)->update($data);

            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Admin!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Admin!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $delete = Admin::where('adminId',$id)->delete();
        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Admin!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Admin!'
            ]);
        }
    }
}
