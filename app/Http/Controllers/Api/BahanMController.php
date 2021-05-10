<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BahanM;
use App\Bahan;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class BahanMController extends Controller
{
    //
    public function index(){
        $BahanM = DB::table('bahan_m_s')
        ->join('bahans','bahan_m_s.id_bahan','=','bahans.id')
        ->select('bahan_m_s.*','bahans.nama_bahan')
        ->where('bahan_m_s.is_delete','=','available')->orderBy('bahan_m_s.tgl_masuk','desc')->get();    
       
        if(count($BahanM)>0){
            return response([
                'message' => 'Mengambil Data Bahan Masuk Berhasil',
                'data' => $BahanM
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $BahanM = BahanM::find($id);

        if(!is_null($BahanM)){
            return response([
                'message' => 'Mengambil Data Bahan Masuk Berhasil',
                'data' => $BahanM
            ],200);
        }

        return response([
            'message' => 'Bahan Masuk Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'id_bahan' =>'required',
            'stok_masuk' => 'required',
            'tgl_masuk' => 'required|date_format:Y-m-d',
            'harga' => 'required',            
        ]);       

       

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $BahanM = BahanM::create($storeData);
        $Bahan = Bahan::find($storeData['id_bahan']);       
        $Bahan->stok = $Bahan->stok +  $storeData['stok_masuk'];

        if($Bahan->save()){
            return response([
                'message' => 'Tambah Bahan Masuk Berhasil',
                'data' => $BahanM,
            ],200);
        }
       

        return response([
            'message' => 'Tambah Bahan Masuk Gagal',
            'data' => null,
        ],400);
    }

    public function destroy($id){
        $BahanM = BahanM::find($id);
        if(is_null($BahanM)){
            return response([
                'message' => 'Bahan Masuk Tidak Ada',
                'data' => null
            ],404);
        }

        if($BahanM->delete()){
            return response([
                'message' => 'Hapus Bahan Masuk Berhasil',
                'data' => $BahanM,
            ],200);
        }

        return response([
            'message' => 'Hapus Bahan Masuk Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $BahanM =  BahanM::find($id);
        if(is_null($BahanM)){
            return response([
                'message' => 'Bahan Masuk Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[  
            'id_bahan' =>'required',
            'stok_masuk' => 'required',           
            'harga' => 'required',
            'cek' => 'required',
            'stokseb' => 'required',
            'edit' => 'required',              
            'temp' => 'required',     
        ]);


        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        if($updateData['cek']=="kemarin"){           
            $BahanM ->stok_masuk = $updateData['stok_masuk'];     
            $BahanM ->harga = $updateData['harga'];
            if($BahanM->save()){
                return response([
                    'message' => 'Edit Bahan Masuk Berhasil',
                    'data' => $BahanM,
                ],200);
            }    
        }
        else{
            if($BahanM->id_bahan==$updateData['id_bahan']){
                if($updateData['edit']=="plus"){
                    $BahanM ->id_bahan = $updateData['id_bahan'];
                    $BahanM ->stok_masuk = $updateData['stok_masuk'];     
                    $BahanM ->harga = $updateData['harga'];
                    $Bahan = Bahan::find($updateData['id_bahan']);       
                    $Bahan->stok = $Bahan->stok + $updateData['temp'];
                    if($BahanM->save()&&$Bahan->save()){
                        return response([
                            'message' => 'Edit Bahan Masuk Berhasil',
                            'data' => $BahanM,
                        ],200);
                    }
            
                }
                else{
                    $BahanM ->id_bahan = $updateData['id_bahan'];
                    $BahanM ->stok_masuk = $updateData['stok_masuk'];     
                    $BahanM ->harga = $updateData['harga'];
                    $Bahan = Bahan::find($updateData['id_bahan']);       
                    $Bahan->stok = $Bahan->stok - $updateData['temp'];
                    if($BahanM->save()&&$Bahan->save()){
                        return response([
                            'message' => 'Edit Bahan Masuk Berhasil',
                            'data' => $BahanM,
                        ],200);
                    }    
                    
                }
            }else{
                $Bahan = Bahan::find($BahanM->id_bahan);  
                $Bahan->stok = $Bahan->stok - $updateData['stokseb'];
                $BahanM ->id_bahan = $updateData['id_bahan'];
                $BahanM ->stok_masuk = $updateData['stok_masuk'];     
                $BahanM ->harga = $updateData['harga'];                
                $BahanE = Bahan::find($updateData['id_bahan']);       
                $BahanE->stok = $BahanE->stok + $updateData['stok_masuk'];
                if($BahanM->save()&&$Bahan->save()&&$BahanE->save()){
                    return response([
                        'message' => 'Edit Bahan Masuk Berhasil',
                        'data' => $BahanM,
                    ],200);
                }



            }

            return response([
            'message' => 'Edit Bahan Masuk Gagal',
            'data' => null,    
            ],400);                           
        }

       }
        

        public function delete(Request $request, $id){
            $Bahan =  BahanM::find($id);
            if(is_null($Bahan)){
                return response([
                    'message' => 'Bahan Masuk Tidak Ada',
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
                        'message' => 'Hapus Bahan Masuk Berhasil',
                        'data' => $Bahan,
                    ],200);
                }
            } 
            else{
                $BahanE = Bahan::find($Bahan->id_bahan);                    
                $BahanE->stok = $BahanE->stok - $Bahan->stok_masuk;  
                if($Bahan->delete()&&$BahanE->save()){
                    return response([
                        'message' => 'Hapus Bahan Masuk Berhasil',
                        'data' => $Bahan,
                    ],200);
                }
            }
            
           
                
    
            return response([
                'message' => 'Hapus Bahan Masuk Gagal',
                'data' => null,    
                ],400);
        }
}
