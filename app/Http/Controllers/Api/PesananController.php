<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Pesanan;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class PesananController extends Controller
{
    //
    public function index(){
        $Pesanan = Pesanan::all();

        if(count($Pesanan)>0){
            return response([
                'message' => 'Mengambil Data Pesanan Berhasil',
                'data' => $Pesanan
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Pesanan = Pesanan::find($id);

        if(!is_null($Pesanan)){
            return response([
                'message' => 'Mengambil Data Pesanan Berhasil',
                'data' => $Pesanan
            ],200);
        }

        return response([
            'message' => 'Pesanan Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_menu'  => 'required',
            'id_customer' => 'required',                                 
            'id_transaksi' => 'required',   
            'jml_pesanan' => 'required',  
            'total_pesanan' => 'required'                                                                                       
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $tempPesanan = DB::table('pesanans')       
        ->where('id_menu','=', $storeData['id_menu'])
        ->where('id_customer','=', $storeData['id_customer'])
        ->where('id_transaksi','=', null) ->select('id')->pluck('id')->first();

        $Pesanan = Pesanan::find($tempPesanan);   
        $Pesanan = Pesanan::create($storeData);

        if(!is_null($Pesanan)){
            $harga =$Pesanan->subtotalitem/$Pesanan->jml_pesanan;
            $Pesanan->subtotalitem = $harga * ($storeData['jml_pesanan']+$Pesanan->jml_pesanan);
            $Pesanan->jml_pesanan =  $Pesanan->jml_pesanan + $storeData['jml_pesanan'];
            if($Pesanan->save()){
                return response([
                    'message' => 'Tambah Pesanan Berhasil',
                    'data' => $Pesanan
                ],200);
            }
        }
        else{
            $PesananStore = Pesanan::create($storeData);
            return response([
                'message' => 'Tambah Pesanan Berhasil',
                'data' => $PesananStore,
            ],200);
        }
    }

    public function destroy($id){
        $Pesanan = Pesanan::find($id);
        if(is_null($Pesanan)){
            return response([
                'message' => 'Pesanan Tidak Ada',
                'data' => null
            ],404);
        }

        if($Pesanan->delete()){
            return response([
                'message' => 'Hapus Pesanan Berhasil',
                'data' => $Pesanan,
            ],200);
        }

        return response([
            'message' => 'Hapus Pesanan Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Pesanan =  Pesanan::find($id);
        if(is_null($Pesanan)){
            return response([
                'message' => 'Pesanan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[              
            'jml_pesanan'  => 'required',
            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        $Pesanan->subtotalitem =  $Pesanan->subtotalitem/ $Pesanan->jml_pesanan * $updateData['jml_pesanan'];
        $Pesanan->jml_pesanan = $updateData['jml_pesanan'];      
    

        if($Pesanan->save()){
            return response([
                'message' => 'Edit Pesanan Berhasil',
                'data' => $Pesanan,
            ],200);
        }

        return response([
            'message' => 'Edit Pesanan Gagal',
            'data' => null,    
            ],400);
        }

        public function updateStatus(Request $request, $id){
            $Pesanan =  Pesanan::find($id);
            if(is_null($Pesanan)){
                return response([
                    'message' => 'Pesanan Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'status' => 'required',    
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
          
            $Pesanan ->status = $updateData['status'];        
        
    
            if($Pesanan->save()){
                return response([
                    'message' => 'Edit Pesanan Berhasil',
                    'data' => $Pesanan,
                ],200);
            }
    
            return response([
                'message' => 'Edit Pesanan Gagal',
                'data' => null,    
                ],400);
            }
}
