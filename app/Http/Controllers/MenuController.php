<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use Validator;

class MenuController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Menu',
            'content' => 'menu',
            'url' => 'config',
            'parent' => Menu::where('menuParent',0)->get()
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $menu = Menu::all();

        foreach($menu as $i => $v){
            $check = Menu::where('menuId',$v->menuParent)->first();
            if($check){
                $menuParent = $check->menuName;
            }else{
                $menuParent = '<b>is Parent</b>';
            }
            $response['data'][] = [
                ++$i,
                $v->menuName,
                $menuParent,
                $v->menuUrl,
                '
                <a href="javascript:void(0)" onclick="show('.$v->menuId.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
                <button  type="button" onclick="deleteData('.$v->menuId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Hapus</button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'menuName' => 'required',
            'menuUrl' => 'required',
            'menuParent' => 'required',
            'menuActiveParent' => 'required',
            'menuActiveUrl' => 'required',
            'menuIcon' => 'required',
        ]; 

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'menuName' => $request->input('menuName'),
                'menuUrl' => $request->input('menuUrl'),
                'menuParent' => $request->input('menuParent'),
                'menuActiveParent' => $request->input('menuActiveParent'),
                'menuActiveUrl' => $request->input('menuActiveUrl'),
                'menuIcon' => $request->input('menuIcon'),
                'menuCreate' => date('Y-m-d H:i:s'),
                'menuUpdate' => date('Y-m-d H:i:s'),
            ];

            $insert = Menu::insert($data);

            if($insert){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil menambahkan Menu baru!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal menambahkan Menu baru!'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        return response($menu);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'menuName' => 'required',
            'menuUrl' => 'required',
            'menuParent' => 'required',
            'menuActiveParent' => 'required',
            'menuActiveUrl' => 'required',
            'menuIcon' => 'required',
        ]; 

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' => 401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'menuName' => $request->input('menuName'),
                'menuUrl' => $request->input('menuUrl'),
                'menuParent' => $request->input('menuParent'),
                'menuActiveParent' => $request->input('menuActiveParent'),
                'menuActiveUrl' => $request->input('menuActiveUrl'),
                'menuIcon' => $request->input('menuIcon'),
                'menuUpdate' => date('Y-m-d H:i:s'),
            ];

            $update = Menu::where('menuId',$id)->update($data);

            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Menu!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Menu!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $delete = Menu::where('menuId',$id)->delete();

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus Menu!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus Menu!'
            ]);
        }
    }
}
