<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservasi;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class ReservasiController extends Controller
{
    //
    public function index(){
        $Reservasi = DB::table('reservasis')       
        ->join('customers','reservasis.id_customer','=','customers.id')
        ->join('users','reservasis.id_karyawan','=','users.id')
        ->select('reservasis.*','users.name','customers.nama_customer')        
        ->where('reservasis.is_delete','=','available')
        ->orderBy('reservasis.tgl_reservasi','asc')->get();  

        if(count($Reservasi)>0){
            return response([
                'message' => 'Mengambil Data Reservasi Berhasil',
                'data' => $Reservasi
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Reservasi = Reservasi::find($id);

        if(!is_null($Reservasi)){
            return response([
                'message' => 'Mengambil Data Reservasi Berhasil',
                'data' => $Reservasi
            ],200);
        }

        return response([
            'message' => 'Reservasi Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_customer' =>'required',
            'nomor_meja' => 'required',
            'id_karyawan' => 'required',
            'sesi_reservasi' => 'required',
            'tgl_reservasi' => 'required|date_format:Y-m-d',            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $Reservasi = Reservasi::create($storeData);
        return response([
            'message' => 'Tambah Reservasi Berhasil',
            'data' => $Reservasi,
        ],200);
    }

    public function destroy($id){
        $Reservasi = Reservasi::find($id);
        if(is_null($Reservasi)){
            return response([
                'message' => 'Reservasi Tidak Ada',
                'data' => null
            ],404);
        }

        if($Reservasi->delete()){
            return response([
                'message' => 'Hapus Reservasi Berhasil',
                'data' => $Reservasi,
            ],200);
        }

        return response([
            'message' => 'Hapus Reservasi Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Reservasi =  Reservasi::find($id);
        if(is_null($Reservasi)){
            return response([
                'message' => 'Reservasi Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[  
            'id_customer' =>'required',
            'nomor_meja' => 'required',           
            'sesi_reservasi' => 'required',
            'tgl_reservasi' => 'required|date_format:Y-m-d',    
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
    
        $Reservasi ->id_customer = $updateData['id_customer'];
        $Reservasi ->nomor_meja = $updateData['nomor_meja'];
        $Reservasi ->sesi_reservasi = $updateData['sesi_reservasi'];
        $Reservasi ->tgl_reservasi = $updateData['tgl_reservasi'];        

        if($Reservasi->save()){
            return response([
                'message' => 'Edit Reservasi Berhasil',
                'data' => $Reservasi,
            ],200);
        }

        return response([
            'message' => 'Edit Reservasi Gagal',
            'data' => null,    
            ],400);
        }

        public function delete(Request $request, $id){
            $Reservasi =  Reservasi::find($id);
            if(is_null($Reservasi)){
                return response([
                    'message' => 'Reservasi Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'delete'  => 'required',            
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
            $Reservasi ->is_delete = $updateData['delete'];   
            if($Reservasi->save()){
                return response([
                    'message' => 'Hapus Reservasi Berhasil',
                    'data' => $Reservasi,
                ],200);
            }
                
    
            return response([
                'message' => 'Hapus Reservasi Gagal',
                'data' => null,    
                ],400);
        }
}
