<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use Validator;

class ConfigController extends Controller
{
    public function index()
    {
        $data = [
            'title'   => 'Data Konfigurasi',
            'content' => 'config',
            'url'     => 'config',
            'config'  => Config::orderBy('configId','asc')->first()
        ];

        return view('layout.index',['data' =>  $data]);
    }

    public function doEdit(Request $request)
    {
        $data = Config::orderBy('configId','asc')->first();
        $id = $data->configId;
        
        $rules = [
            'cofigWebName' => 'required',
            'configTitle'  => 'required',
            'configOfficeHour' => 'required',
            'configPhone' => 'required',
            'configAddress' => 'required',
            'configEmail' => 'required'
        ];

        $isValid = Validator::make($request->all(), $rules);

        if($isValid->fails()){
            return redirect()->back()->withErrors($isValid->errors());
        }else{
            $data = [
                'configWebName' => $request->input('configWebName'),
                'configTitle' => $request->input('configTitle'),
                'configOfficeHour' => $request->input('configOfficeHour'),
                'configPhone' => $request->input('configPhone'),
                'configAddress' => $request->input('configAddress'),
                'configEmail' => $request->input('configEmail'),
                'configDescription' => $request->input('configDescription'),
                'configUpdate' => date('Y-m-d H:i:s')
            ];
        
            $update = Config::where('configId',$id)->update($data);

            if($update){
                return redirect()->back()->with('success','Config berhasil diperbarui');
            }else{
                return redirect()->back()->with('error','Terjadi kesalahan, config gagal diperbarui');
            }
        }
    }
}
