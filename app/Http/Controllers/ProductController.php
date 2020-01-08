<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use Validator;
use Str;

class ProductController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Produk',
            'content' => 'product.product',
            'url' => 'about',
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $product = Product::join('categories','categories.categoryId','=','products.categoryId')
                        ->where('productDelete',0)
                        ->get();
        foreach ($product as $i => $v) {
            $productImage = '<img src="'.asset('data/product/'.$v->productImage).'" style="width:100px">';
            $response['data'][] = [
                ++$i,
                $productImage,
                $v->categoryName,
                $v->productName,
                '
                <a href="'.url('admin/product/edit/'.$v->productId).'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" onclick="deleteData('.$v->productId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                '
            ];
        }

        return response($response);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'content' => 'product.product_create',
            'url' => 'about',
            'category' => Category::all()
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'productName' => 'required',
            'categoryId' => 'required',
            'productDescription' => 'required',
            'productImage' => 'required|image'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $img = $request->file('productImage');
            $productImage = Str::random(10).$img->getClientOriginalName();
            $img->move(public_path('data/product'),$productImage);

            $data = [
                'productName' => $request->input('productName'),
                'categoryId' => $request->input('categoryId'),
                'productDescription' => $request->input('productDescription'),
                'productImage' =>  $productImage
            ];

            $insert = Product::insert($data);

            if($insert){
                return redirect()->back()->with('success','Berhasil menambahkan Produk baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Produk baru!');
            }
        }
    }

    public function edit($id)
    {
        $product = Product::join('categories','categories.categoryId','=','products.categoryId')
                        ->where('productDelete',0)
                        ->where('productId',$id)
                        ->first();
        $data = [
            'title' => 'Edit Produk',
            'content' => 'product.product_edit',
            'url' => 'about',
            'product' => $product,
            'category' => Category::all()
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request,$id)
    {
        $product = Product::join('categories','categories.categoryId','=','products.categoryId')
                        ->where('productDelete',0)
                        ->where('productId',$id)
                        ->first();
        $rules = [
            'productName' => 'required',
            'categoryId' => 'required',
            'productDescription' => 'required',
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            if($request->has('productImage')){
                if(file_exists(public_path().'/data/product/'.$product->productImage)){
                    unlink(public_path().'/data/product/'.$product->productImage);
                }
                $img = $request->file('productImage');
                $productImage = Str::random(10).$img->getClientOriginalName();
                $img->move(public_path('data/product'),$productImage);

                $data = [
                    'productName' => $request->input('productName'),
                    'categoryId' => $request->input('categoryId'),
                    'productDescription' => $request->input('productDescription'),
                    'productImage' =>  $productImage
                ];
            }else{
                $data = [
                    'productName' => $request->input('productName'),
                    'categoryId' => $request->input('categoryId'),
                    'productDescription' => $request->input('productDescription'),
                ];
            }
            
            $update = Product::where('productId',$id)->update($data);

            if($update){
                return redirect()->back()->with('success','Berhasil memperbarui Produk!');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui Produk!');
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::join('categories','categories.categoryId','=','products.categoryId')
                        ->where('productDelete',0)
                        ->where('productId',$id)
                        ->first();
        if(file_exists(public_path().'/data/product/'.$product->productImage)){
            unlink(public_path().'/data/product/'.$product->productImage);
        }

        $delete = Product::where('productId',$id)->update([
            'productDelete' => 1
        ]);

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Produk!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Produk!'
            ]);
        }
    }
}
