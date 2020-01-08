<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Validator;
use Str;

class ServiceController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Service',
            'content' => 'service',
            'url' => 'about'
        ];

        return view('layout.index',['data' => $data]);
    }

    public function loadData()
    {
        $response['data'] = [];
        $service = Service::where('serviceDelete',0)->get();

        foreach ($service as $i => $v) {
            $response['data'][] = [
                ++$i,
                $v->serviceName,
                $v->serviceDescription,
                '
                <a href="javascript:void(0)" onclick="show('.$v->serviceId.')" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <button type="button" onclick="deleteData('.$v->serviceId.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                '
            ];
        }

        return response($response);
    }

    public function insert(Request $request)
    {
        $rules = [
            'serviceName' => 'required',
            'serviceDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 200,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'serviceName' => $request->input('serviceName'),
                'serviceImage' => $request->input('serviceImage'),
                'serviceDescription' => $request->input('serviceDescription')
            ];

            $insert = Service::insert($data);

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
        $service = Service::find($id);
        return response($service);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'serviceName' => 'required',
            'serviceDescription' => 'required'
        ];

        $isValid = Validator::make($request->all(),$rules);

        if($isValid->fails()){
            return response([
                'status' => 200,
                'errors' => $isValid->errors()
            ]);
        }else{
            $data = [
                'serviceName' => $request->input('serviceName'),
                'serviceImage' => $request->input('serviceImage'),
                'serviceDescription' => $request->input('serviceDescription')
            ];

            $update = Service::where('serviceId',$id)->update($data);

            if($update){
                return response([
                    'status' => 200,
                    'result' => 'Berhasil memperbarui Service!'
                ]);
            }else{
                return response([
                    'status' => 500,
                    'result' => 'Gagal memperbarui Service!'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $service = Service::where('serviceId',$id)->update([
            'serviceDelete' => 1
        ]);

        if($service){
            return response([
                'status' => 200,
                'result' => 'Berhasil mmenghapus data Service!'
            ]);
        }else{
            return response([
                'status' => 500,
                'result' => 'Gagal menghapus data Service!'
            ]);
        }
    }
}
