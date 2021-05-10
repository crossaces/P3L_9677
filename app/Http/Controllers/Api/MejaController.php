<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meja;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class MejaController extends Controller
{
    //
    public function index(){
        $Meja = DB::table('mejas')       
        ->select('*',DB::raw('cast(nomor_meja AS CHAR) as nomor'))
        ->where('is_delete','=','available')->get();
       
        if(count($Meja)>0){
            return response([
                'message' => 'Mengambil Data Meja Berhasil',
                'data' => $Meja
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Meja = Meja::find($id);

        if(!is_null($Meja)){
            return response([
                'message' => 'Mengambil Data Meja Berhasil',
                'data' => $Meja
            ],200);
        }

        return response([
            'message' => 'Meja Tidak Ada',
            'data' => null
        ],404);

    }



    public function store(Request $request){
        $storeData = $request->all();
        $Meja = DB::table('mejas')       
        ->select('*')
        ->where('nomor_meja','=',$storeData['nomor_meja'])
        ->where('is_delete','=','deleted')->get();

        if(count($Meja)>0){
            $Meja = Meja::find($storeData['nomor_meja']);
            $Meja ->is_delete = "available"; 
            if($Meja->save()){
                return response([
                    'message' => 'Tambah Meja Berhasil',
                    'data' => $Meja,
                ],200);
            }
        }else{
            $validate = Validator::make($storeData,[
                'nomor_meja'  => 'required|unique:mejas',                                        
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
    
            $Meja = Meja::create($storeData);
            return response([
                'message' => 'Tambah Meja Berhasil',
                'data' => $Meja,
            ],200);
        }
        
    }

    public function getMeja(Request $request){
        $get = $request->all();
        $Meja = DB::table('mejas')       
        ->whereNotIn(
            'mejas.nomor_meja',
            fn ($query) =>
            $query->select('mejas.nomor_meja')
            ->from('mejas')
            ->join('reservasis','reservasis.nomor_meja','=','mejas.nomor_meja')
            ->where('reservasis.tgl_reservasi','=',$get['tgl_reservasi'])            
            ->where('reservasis.sesi_reservasi','=',$get['sesi_reservasi'])
            ->where('reservasis.is_delete','=','available')
        )->where('mejas.is_delete','=','available')->orderBy('mejas.nomor_meja','asc')
        ->get();

        if(!is_null($Meja)){
            return response([
                'message' => 'Mengambil Data Meja Berhasil',
                'data' => $Meja
            ],200);
        }

        return response([
            'message' => 'Meja Tidak Ada',
            'data' => null
        ],404);
        
    }

    public function destroy($id){
        $Meja = Meja::find($id);
        if(is_null($Meja)){
            return response([
                'message' => 'Meja Tidak Ada',
                'data' => null
            ],404);
        }

        if($Meja->delete()){
            return response([
                'message' => 'Hapus Meja Berhasil',
                'data' => $Meja,
            ],200);
        }

        return response([
            'message' => 'Hapus Meja Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Meja =  Meja::find($id);
        if(is_null($Meja)){
            return response([
                'message' => 'Meja Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
    

        if($Meja->nomor_meja == $updateData['nomor_meja']){
            $validate = Validator::make($updateData,[              
                'nomor_meja'  => 'required',
                'status' => 'required',    
            ]);
        }
        else{
            $validate = Validator::make($updateData,[              
                'nomor_meja'  => 'required|unique:mejas',
                'status' => 'required',    
            ]);              
        }

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        $Meja ->nomor_meja = $updateData['nomor_meja'];
        $Meja ->status = $updateData['status'];              
    

        if($Meja->save()){
            return response([
                'message' => 'Edit Meja Berhasil',
                'data' => $Meja,
            ],200);
        }

        return response([
            'message' => 'Edit Meja Gagal',
            'data' => null,    
            ],400);
        }

        public function updateStatus(Request $request, $id){
            $Meja =  Meja::find($id);
            if(is_null($Meja)){
                return response([
                    'message' => 'Meja Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'status' => 'required',    
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
          
            $Meja ->status = $updateData['status'];        
        
    
            if($Meja->save()){
                return response([
                    'message' => 'Edit Meja Berhasil',
                    'data' => $Meja,
                ],200);
            }
    
            return response([
                'message' => 'Edit Meja Gagal',
                'data' => null,    
                ],400);
        }

        public function hapus(Request $request, $id){
            $Meja =  Meja::find($id);
            if(is_null($Meja)){
                return response([
                    'message' => 'Meja Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'deleted' => 'required',    
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
          
            $Meja ->is_delete = $updateData['deleted'];        
        
    
            if($Meja->save()){
                return response([
                    'message' => 'Hapus Meja Berhasil',
                    'data' => $Meja,
                ],200);
            }
    
            return response([
                'message' => 'Hapus Meja Gagal',
                'data' => null,    
                ],400);
        }
}
