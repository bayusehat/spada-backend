<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Str;
use App\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Banner',
            'content' => 'banner.banner',
            'url' => 'about'
        ];

        return view('layout.index', ['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $banner = Banner::where('bannerDelete',0)->get();

        foreach ($banner as $i => $v) {
            $bannerImage = '<img src="'.asset('data/banner/'.$v->bannerImage).'" style="width:100px">';
            $response['data'][] = [
                ++$i,
                $bannerImage,
                $v->bannerTitle,
                '
                <a href="'.url('admin/banner/edit/'.$v->bannerId).'" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" onclick="deleteData('.$v->bannerId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                '
            ];
        }

        return response($response);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Banner',
            'content' => 'banner.banner_create',
            'url' => 'about'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function insert(Request $request)
    {
        $rules = [
            'bannerTitle' => 'required',
            'bannerImage' => 'required',
            'bannerDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $img = $request->file('bannerImage');
            $bannerImage = Str::random(10).$img->getClientOriginalName();
            $img->move(public_path('/data/banner'),$bannerImage);

            $data = [
                'bannerTitle' => $request->input('bannerTitle'),
                'bannerImage' => $bannerImage,
                'bannerDescription' => $request->input('bannerDescription'),
                'bannerCreate' => date('Y-m-d H:i:s'),
                'bannerUpdate' => date('Y-m-d H:i:s')
            ];

            $insert = Banner::insert($data);

            if($insert){
                return redirect()->back()->with('success','Berhasil menambahkan Banner baru!');
            }else{
                return redirect()->back()->with('error','Gagal menambahkan Banner baru!');
            }
        }
    }

    public function edit($id)
    {
        $banner = Banner::find($id);

        $data = [
            'title' => 'Edit Banner',
            'content' => 'banner.banner_edit',
            'url' => 'about',
            'banner' => $banner
        ];

        return view('layout.index',['data' => $data]);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);
        $rules = [
            'bannerTitle' => 'required',
            'bannerDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{ 
            if($request->has('bannerImage')){
                if(file_exists(public_path().'/data/banner/'.$banner->bannerImage)){
                    unlink(public_path().'/data/banner/'.$banner->bannerImage);
                }
                $img = $request->file('bannerImage');
                $bannerImage = Str::random(10).$img->getClientOriginalName();
                $img->move(public_path('/data/banner'),$bannerImage);

                $data = [
                    'bannerTitle' => $request->input('bannerTitle'),
                    'bannerImage' => $bannerImage,
                    'bannerDescription' => $request->input('bannerDescription'),
                    'bannerUpdate' => date('Y-m-d H:i:s')
                ];
            }else{
                $data = [
                    'bannerTitle' => $request->input('bannerTitle'),
                    'bannerDescription' => $request->input('bannerDescription'),
                    'bannerUpdate' => date('Y-m-d H:i:s')
                ];
            }
        
            $update = Banner::where('bannerId',$id)->update($data);

            if($update){
                return redirect()->back()->with('success','Berhasil memperbarui Banner!');
            }else{
                return redirect()->back()->with('error','Gagal memperbarui Banner!');
            }
        }
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        if(file_exists(public_path().'/data/banner/'.$banner->bannerImage)){
            unlink(public_path().'/data/banner/'.$banner->bannerImage);
        }

        $delete = Banner::where('bannerId',$id)->delete();

        if($delete){
            return response([
                'status' => 200,
                'result' => 'Berhasil menghapus data Banner!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Banner!'
            ]);
        }
    }
}
