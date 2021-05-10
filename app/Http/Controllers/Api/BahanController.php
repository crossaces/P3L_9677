<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bahan;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class BahanController extends Controller
{
    //
    public function index(){
        $Bahan = DB::table('bahans')       
        ->select('*',DB::raw('CONCAT(id, "-", nama_bahan) as list_bahan'))
        ->where('is_delete','=','available')->get();  
        if(count($Bahan)>0){
            return response([
                'message' => 'Mengambil Data Bahan Berhasil',
                'data' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function cekbahan(){
        $Bahan = DB::table('bahans')       
        ->leftjoin('menus','menus.id_bahan','=','bahans.id')    
        ->select('bahans.*',DB::raw('CONCAT(bahans.stok-menus.serving_size) as status'))
        ->where('bahans.is_delete','=','available')->get();  
        if(count($Bahan)>0){
            return response([
                'message' => 'Mengambil Data Bahan Berhasil',
                'data' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }


    public function untukmenu(){
        $Bahan = DB::table('bahans')       
        ->whereNotIn(
            'bahans.id',
            fn ($query) =>
            $query->select('bahans.id')
            ->from('bahans')
            ->join('menus','menus.id_bahan','=','bahans.id')            
            ->where('menus.is_delete','=','available')
        )->select('*',DB::raw('CONCAT(id, "-", nama_bahan) as list_bahan'))
        ->where('bahans.is_delete','=','available')
        ->get();
        if(count($Bahan)>0){
            return response([
                'message' => 'Mengambil Data Bahan Berhasil',
                'data' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    

    public function show($id){
        $Bahan = DB::table('bahans')       
        ->select('*',DB::raw('CONCAT(id, "-", nama_bahan) as list_bahan'))     
        ->where('id','=',$id)->get();  

        if(count($Bahan)>0){
            return response([
                'message' => 'Mengambil Data Bahan Berhasil',
                'data' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Bahan Tidak Ada',
            'data' => null
        ],404);

    }


    public function showtable($id){
        $Bahan = Bahan::find($id);

        if(!is_null($Bahan)){
            return response([
                'message' => 'Mengambil Data Bahan Berhasil',
                'data' => $Bahan
            ],200);
        }

        return response([
            'message' => 'Bahan Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData,[            
            'nama_bahan' => 'required',
            'satuan' => 'required',            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $Bahan = Bahan::create($storeData);
        return response([
            'message' => 'Tambah Bahan Berhasil',
            'data' => $Bahan,
        ],200);
    }

    public function destroy($id){
        $Bahan = Bahan::find($id);
        if(is_null($Bahan)){
            return response([
                'message' => 'Bahan Tidak Ada',
                'data' => null
            ],404);
        }

        if($Bahan->delete()){
            return response([
                'message' => 'Hapus Bahan Berhasil',
                'data' => $Bahan,
            ],200);
        }

        return response([
            'message' => 'Hapus Bahan Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Bahan =  Bahan::find($id);
        if(is_null($Bahan)){
            return response([
                'message' => 'Bahan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[              
            'nama_bahan' => 'required',
            'satuan' => 'required',      
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
           
        $Bahan ->nama_bahan = $updateData['nama_bahan'];      
        $Bahan ->satuan = $updateData['satuan'];

        if($Bahan->save()){
            return response([
                'message' => 'Edit Bahan Berhasil',
                'data' => $Bahan,
            ],200);
        }

        return response([
            'message' => 'Edit Bahan Gagal',
            'data' => null,    
            ],400);
        }

        public function delete(Request $request, $id){
            $Bahan =  Bahan::find($id);
            if(is_null($Bahan)){
                return response([
                    'message' => 'Bahan Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'delete'  => 'required',            
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
            $Bahan ->is_delete = $updateData['delete'];   
            if($Bahan->save()){
                return response([
                    'message' => 'Hapus Bahan Berhasil',
                    'data' => $Bahan,
                ],200);
            }
                
    
            return response([
                'message' => 'Hapus Bahan Gagal',
                'data' => null,    
                ],400);
        }
}
