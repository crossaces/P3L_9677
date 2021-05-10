<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kartu;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class KartuController extends Controller
{
    //
    public function index(){
        $Kartu = Kartu::all();

        if(count($Kartu)>0){
            return response([
                'message' => 'Mengambil Data Kartu Berhasil',
                'data' => $Kartu
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Kartu = Kartu::find($id);

        if(!is_null($Kartu)){
            return response([
                'message' => 'Mengambil Data Kartu Berhasil',
                'data' => $Kartu
            ],200);
        }

        return response([
            'message' => 'Kartu Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_transaksi'  => 'required',
            'tipe_kartu' => 'required',           
            'nama_pemilik' => 'required',
            'nomor_kartu' => 'required'                 
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $Kartu = Kartu::create($storeData);
        return response([
            'message' => 'Tambah Kartu Berhasil',
            'data' => $Kartu,
        ],200);
    }

    public function destroy($id){
        $Kartu = Kartu::find($id);
        if(is_null($Kartu)){
            return response([
                'message' => 'Kartu Tidak Ada',
                'data' => null
            ],404);
        }

        if($Kartu->delete()){
            return response([
                'message' => 'Hapus Kartu Berhasil',
                'data' => $Kartu,
            ],200);
        }

        return response([
            'message' => 'Hapus Kartu Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Kartu =  Kartu::find($id);
        if(is_null($Kartu)){
            return response([
                'message' => 'Kartu Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[              
            'tipe_kartu' => 'required',           
            'nama_pemilik' => 'required',
            'nomor_kartu' => 'required'             
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        $Kartu ->nama_Kartu = $updateData['nama_Kartu'];
        $Kartu ->email_Kartu = $updateData['email_Kartu'];
        $Kartu ->telp_Kartu = $updateData['telp_Kartu'];        
    

        if($Kartu->save()){
            return response([
                'message' => 'Edit Kartu Berhasil',
                'data' => $Kartu,
            ],200);
        }

        return response([
            'message' => 'Edit Kartu Gagal',
            'data' => null,    
            ],400);
        }
}
