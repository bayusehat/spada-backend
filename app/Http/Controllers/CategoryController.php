<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Kategori',
            'content' => 'category',
            'url' => 'category'
        ];

        return view('layout.index', ['data' =>  $data]);
    }

    public function loadTable()
    {
        $category = Category::where('categoryDelete',0)->get();
        $response['data'] = [];

        foreach($category as $i => $c){
            $response['data'][] = [
                ++$i,
                $c->categoryName,
                '
                <a href="javasacript:void(0)" onclick="edit('.$c->categoryId.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" onclick="deleteData('.$c->categoryId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'categoryName' => 'required',
            'categoryDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' =>  401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'categoryName' =>  $request->input('categoryName'),
                'categoryDescription' => $request->input('categoryDescription'),
                'categoryCreate' => date('Y-m-d H:i:s'),
                'categoryUpdate' => date('Y-m-d H:i:s')
            ];

            $insert = Category::insert($data);

            if($insert){
                return response([
                    'status' => 200,
                    'result' => 'Kategori berhasil ditambahkan'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Terjadi kesalahan, kategori gagal ditambahkan'
                ]);
            }
        }
    }

    public function edit($id)
    {
        $category = Category::where('categoryId',$id)->first();
        return response($category);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'categoryName' => 'required',
            'categoryDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return response([
                'status' =>  401,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'categoryName' =>  $request->input('categoryName'),
                'categoryDescription' => $request->input('categoryDescription'),
                'categoryUpdate' => date('Y-m-d H:i:s')
            ];

            $update = Category::where('categoryId', $id)->update($data);

            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Kategori berhasil diperbarui'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Terjadi kesalahan, kategori gagal diperbarui'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $category = Category::where('categoryId',$id)->update([
            'categoryDelete' => 1
        ]);

        if($category){
            return response([
                'status' => 200,
                'result' => 'Kategori berhasil dihapus'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Terjadi kesalahan, kategori gagal dihapus'
            ]);
        }
    }
}
