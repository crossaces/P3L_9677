<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Transaksi;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class TransaksiController extends Controller
{
    //
    public function index(){
        $Transaksi = Transaksi::all();

        if(count($Transaksi)>0){
            return response([
                'message' => 'Mengambil Data Transaksi Berhasil',
                'data' => $Transaksi
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Transaksi = Transaksi::find($id);

        if(!is_null($Transaksi)){
            return response([
                'message' => 'Mengambil Data Transaksi Berhasil',
                'data' => $Transaksi
            ],200);
        }

        return response([
            'message' => 'Transaksi Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_karyawan'  => 'required',
            'no_transaksi'  => 'required',    
            'metode_pembayaran'  => 'required',
            'tgl_transkasi'  => 'required',
            'subtotal'  => 'required',
            'total'  => 'required',
            'kode_etc'  => 'required',
            'status'  => 'required',
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $Transaksi = Transaksi::create($storeData);
        return response([
            'message' => 'Tambah Transaksi Berhasil',
            'data' => $Transaksi,
        ],200);
    }

    public function destroy($id){
        $Transaksi = Transaksi::find($id);
        if(is_null($Transaksi)){
            return response([
                'message' => 'Transaksi Tidak Ada',
                'data' => null
            ],404);
        }

        if($Transaksi->delete()){
            return response([
                'message' => 'Hapus Transaksi Berhasil',
                'data' => $Transaksi,
            ],200);
        }

        return response([
            'message' => 'Hapus Transaksi Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Transaksi =  Transaksi::find($id);
        if(is_null($Transaksi)){
            return response([
                'message' => 'Transaksi Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[  
            'name'  => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email:rfc,dns|unique:users',           
            'telp_Transaksi' => 'required|digits_between:10,13|numeric|starts_with:08'           
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
    
        $Transaksi ->nama_Transaksi = $updateData['nama_Transaksi'];
        $Transaksi ->email_Transaksi = $updateData['email_Transaksi'];
        $Transaksi ->telp_Transaksi = $updateData['telp_Transaksi'];        
    

        if($Transaksi->save()){
            return response([
                'message' => 'Edit Transaksi Berhasil',
                'data' => $Transaksi,
            ],200);
        }

        return response([
            'message' => 'Edit Transaksi Gagal',
            'data' => null,    
            ],400);
        }
}
