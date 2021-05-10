<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BahanK;
use App\Bahan;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class BahanKController extends Controller
{
    //
    public function index(){
        $BahanK = DB::table('bahan_k_s')
        ->join('bahans','bahan_k_s.id_bahan','=','bahans.id')
        ->select('bahan_k_s.*','bahans.nama_bahan')
        ->where('bahan_k_s.is_delete','=','available')->orderBy('bahan_k_s.tgl_keluar','desc')->get();   

        if(count($BahanK)>0){
            return response([
                'message' => 'Mengambil Data Bahan Keluar Berhasil',
                'data' => $BahanK
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $BahanK = BahanK::find($id);
        $Bahan = Bahan::find($BahanK->id_bahan);


        if(!is_null($BahanK)){
            return response([
                'message' => 'Mengambil Data Bahan Keluar Berhasil',
                'data' => $BahanK,
                'bahan' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Bahan Keluar Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_bahan' =>'required',
            'stok_keluar' => 'required',
            'tgl_keluar' => 'required|date_format:Y-m-d',
            'status' => 'required',            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

       
        $Bahan = Bahan::find($storeData['id_bahan']);   
        $cek = DB::table('bahans')       
        ->select('stok')
        ->where('id','=',$storeData['id_bahan'])->first();        
        $stok=$cek->stok;  

        if($Bahan->stok - $storeData['stok_keluar']<0){
            return response([
                'message' => 'Maksimal Buang ',
                'data' => $stok,
            ],400);
        }
        else{
            $BahanK = BahanK::create($storeData);
            $Bahan->stok = $Bahan->stok - $storeData['stok_keluar'];
            if($Bahan->save()){
                return response([
                    'message' => 'Buang Bahan Berhasil',
                    'data' => $BahanK,
                ],200);
            }
        }

       
     
    }

    public function destroy($id){
        $BahanK = BahanK::find($id);
        if(is_null($BahanK)){
            return response([
                'message' => 'Bahan Keluar Tidak Ada',
                'data' => null
            ],404);
        }

        if($BahanK->delete()){
            return response([
                'message' => 'Hapus Bahan Keluar Berhasil',
                'data' => $BahanK,
            ],200);
        }

        return response([
            'message' => 'Hapus Bahan Keluar Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $BahanK =  BahanK::find($id);
        if(is_null($BahanK)){
            return response([
                'message' => 'Bahan Keluar Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[  
            'id_bahan' =>'required',
            'stok_keluar' => 'required',            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
            if($updateData['cek']=="kemarin"){           
                $BahanK ->stok_keluar = $updateData['stok_keluar'];                 
                if($BahanK->save()){
                    return response([
                        'message' => 'Edit Bahan Keluar Berhasil',
                        'data' => $BahanK,
                    ],200);
                }    
            }
            else{
            if($BahanK->id_bahan==$updateData['id_bahan']){
                if($updateData['edit']=="plus"){
                    $BahanK ->id_bahan = $updateData['id_bahan'];
                    $BahanK ->stok_keluar = $updateData['stok_keluar'];                    
                    $Bahan = Bahan::find($updateData['id_bahan']);       
                    $Bahan->stok = $Bahan->stok + $updateData['temp'];
                    if($BahanK->save()&&$Bahan->save()){
                        return response([
                            'message' => 'Edit Bahan Keluar Berhasil',
                            'data' => $BahanK,
                        ],200);
                    }
            
                }
                else{
                    $Bahan = Bahan::find($updateData['id_bahan']);   
                    $cek = DB::table('bahans')       
                    ->select('stok')
                    ->where('id','=',$updateData['id_bahan'])->first();        
                    $stok=$cek->stok;  
            
                    if($Bahan->stok - $updateData['stok_keluar']<0){
                        return response([
                            'message' => 'Maksimal Buang ',
                            'data' => $stok,
                        ],400);
                    }
                    else{
                        $BahanK ->id_bahan = $updateData['id_bahan'];
                        $BahanK ->stok_keluar = $updateData['stok_keluar'];     
                        $Bahan = Bahan::find($updateData['id_bahan']);       
                        $Bahan->stok = $Bahan->stok - $updateData['temp'];
                        if($BahanK->save()&&$Bahan->save()){
                            return response([
                                'message' => 'Edit Bahan Keluar Berhasil',
                                'data' => $BahanK,
                            ],200);
                        }    
                    }                                       
                }
            }else{
                 $Bahan = Bahan::find($updateData['id_bahan']);   
                    $cek = DB::table('bahans')       
                    ->select('stok')
                    ->where('id','=',$updateData['id_bahan'])->first();        
                    $stok=$cek->stok;  
            
                    if($Bahan->stok - $updateData['stok_keluar']<0){
                        return response([
                            'message' => 'Maksimal Buang ',
                            'data' => $stok,
                        ],400);
                    }
                    else{
                        
                        $Bahan = Bahan::find($BahanK->id_bahan);  
                        $Bahan->stok = $Bahan->stok + $updateData['stokseb'];
                        $BahanK ->id_bahan = $updateData['id_bahan'];
                        $BahanK ->stok_keluar = $updateData['stok_keluar'];               
                        $BahanE = Bahan::find($updateData['id_bahan']);       
                        $BahanE->stok = $BahanE->stok - $updateData['stok_keluar'];
                        if($BahanK->save()&&$Bahan->save()&&$BahanE->save()){
                            return response([
                                'message' => 'Edit Bahan Keluar Berhasil',
                                'data' => $BahanK,
                            ],200);
                    }
                }
            
            }        
    
       

        return response([
            'message' => 'Edit Bahan Keluar Gagal',
            'data' => null,    
            ],400);
        }
    }


        public function delete(Request $request, $id){
            $Bahan =  BahanK::find($id);
            if(is_null($Bahan)){
                return response([
                    'message' => 'Bahan Keluar Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'delete'  => 'required',  
                'cek'  => 'required',           
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
            if($updateData['cek']=="Kemarin")   {
                $Bahan ->is_delete = $updateData['delete'];   
                if($Bahan->save()){
                    return response([
                        'message' => 'Hapus Bahan Keluar Berhasil',
                        'data' => $Bahan,
                    ],200);
                }
            } 
            else{
                $BahanE = Bahan::find($Bahan->id_bahan);                    
                $BahanE->stok = $BahanE->stok + $Bahan->stok_keluar;  
                if($Bahan->delete()&&$BahanE->save()){
                    return response([
                        'message' => 'Hapus Bahan Keluar Berhasil',
                        'data' => $Bahan,
                    ],200);
                }
            }
            
           
                
    
            return response([
                'message' => 'Hapus Bahan Keluar Gagal',
                'data' => null,    
                ],400);
        }
}
