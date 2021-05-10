<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class MenuController extends Controller
{
    //
    public function index(){      
        $Menu = DB::table('menus')
        ->join('bahans','menus.id_bahan','=','bahans.id')
        ->select('menus.*','bahans.nama_bahan')
        ->where('menus.is_delete','=','available')
        ->orderBy('tipe_menu')->get();  

        if(count($Menu)>0){
            return response([
                'message' => 'Mengambil Data Menu Berhasil',
                'data' => $Menu
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Menu = Menu::find($id);

        if(!is_null($Menu)){
            return response([
                'message' => 'Mengambil Data Menu Berhasil',
                'data' => $Menu
            ],200);
        }

        return response([
            'message' => 'Menu Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();
        $Menus = DB::table('menus')       
        ->select('id')
        ->where('nama_menu','=',$storeData['nama_menu'])
        ->where('is_delete','=','deleted')->first();                
        if(!is_null($Menus)){    
            $id=$Menus->id;            
            $Menu = Menu::find($id);
            
                if ($files = $request->file('gambar_menu')) {
                    $imageName = time() . '.' . $request->gambar_menu->extension();
                    $request->gambar_menu->move(public_path('image'), $imageName);
                    $Menu ->id_bahan = $storeData['id_bahan'];
                    $Menu ->nama_menu = $storeData['nama_menu'];   
                    $Menu ->tipe_menu = $storeData['tipe_menu'];   
                    $Menu ->gambar_menu = $imageName;
                    $Menu ->deskripsi_menu = $storeData['deskripsi_menu'];              
                    $Menu ->serving_size = $storeData['serving_size'];         
                    $Menu ->tipe_saji = $storeData['tipe_saji'];         
                    $Menu ->harga_menu = $storeData['harga_menu'];  
                    $Menu ->is_delete = "available";  
                    if($Menu->save()){
                        return response([
                            'message' => 'Tambah Menu Berhasil',
                            'data' => $Menu,
                        ],200);
                    }           
                }
                else{
                    $Menu ->id_bahan = $storeData['id_bahan'];
                    $Menu ->nama_menu = $storeData['nama_menu'];   
                    $Menu ->tipe_menu = $storeData['tipe_menu'];        
                    $Menu ->gambar_menu = "defaultmenu.jpg";     
                    $Menu ->serving_size = $storeData['serving_size'];         
                    $Menu ->tipe_saji = $storeData['tipe_saji'];         
                    $Menu ->deskripsi_menu = $storeData['deskripsi_menu'];              
                    $Menu ->harga_menu = $storeData['harga_menu'];  
                    $Menu ->is_delete = "available";  
                    if($Menu->save()){
                        return response([
                            'message' => 'Tambah Menu Berhasil',
                            'data' => $Menu,
                        ],200);
                    }
                }
            if($Menu->save()){
                return response([
                    'message' => 'Tambah Menu Berhasil',
                    'data' => $Menu,
                ],200);
            }
        }else{
            if($files = $request->file('gambar_menu')){           
                $validate = Validator::make($storeData,[
                    'id_bahan'  => 'required',
                    'nama_menu' => 'required|unique:menus',    
                    'deskripsi_menu' => 'required',    
                    'tipe_menu' => 'required',     
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required',
                    'gambar_menu' => 'required|image|mimes:jpeg,png,jpg|max:10048',
                    'harga_menu' => 'required', 
                ]);
            }     
            else{
                $validate = Validator::make($storeData,[
                    'id_bahan'  => 'required',               
                    'nama_menu' => 'required|unique:menus',    
                    'deskripsi_menu' => 'required',    
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required',
                    'tipe_menu' => 'required',                            
                    'harga_menu' => 'required', 
                ]);
            }       

            if($validate->fails())              
                return response(['message' => $validate->errors()],400);

                if ($files = $request->file('gambar_menu')) {
                    $imageName = time() . '.' . $request->gambar_menu->extension();
                    $request->gambar_menu->move(public_path('image'), $imageName);
                    $Menu = Menu::create(
                        [
                            'id_bahan'  => $request->id_bahan,
                            'nama_menu' => $request->nama_menu, 
                            'deskripsi_menu' => $request->deskripsi_menu,
                            'tipe_menu' => $request->tipe_menu,        
                            'tipe_saji' => $request->tipe_saji,      
                            'serving_size' =>  $request->serving_size,         
                            'gambar_menu' => $imageName,
                            'harga_menu' => $request->harga_menu,
                        ]
                    );
                    return response([
                        'message' => 'Tambah Menu Berhasil',
                        'data' => $Menu
                    ],200);
                }else{
                    $Menu = Menu::create(
                        [
                            'id_bahan'  => $request->id_bahan,
                            'nama_menu' => $request->nama_menu, 
                            'deskripsi_menu' => $request->deskripsi_menu,
                            'tipe_menu' => $request->tipe_menu,           
                            'tipe_saji' => $request->tipe_saji,      
                            'serving_size' =>  $request->serving_size,                                      
                            'harga_menu' => $request->harga_menu,
                        ]
                    );
                    return response([
                        'message' => 'Tambah Menu Berhasil',
                        'data' => $Menu
                    ],200);
                }


                return response([
                    'message' => 'Tambah Menu Gagal',
                    'data' => null,
                ],400);

        }
    }

    public function destroy($id){
        $Menu = Menu::find($id);        
        if(is_null($Menu)){
            return response([
                'message' => 'Menu Tidak Ada',
                'data' => null
            ],404);
        }

        if($Menu->delete()){
            return response([
                'message' => 'Hapus Menu Berhasil',
                'data' => $Menu,
            ],200);
        }

        return response([
            'message' => 'Hapus Menu Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Menu =  Menu::find($id);
        if(is_null($Menu)){
            return response([
                'message' => 'Menu Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        if($Menu->nama_menu == $updateData['nama_menu']){
            if ($files = $request->file('gambar_menu')){
                $validate = Validator::make($updateData,[
                    'id_bahan'  => 'required',
                    'nama_menu' => 'required',    
                    'deskripsi_menu' => 'required',    
                    'tipe_menu' => 'required',         
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required',   
                    'gambar_menu' => 'required|image|mimes:jpeg,png,jpg|max:10048',
                    'harga_menu' => 'required', 
                ]);
            }
            else{
                $validate = Validator::make($updateData,[
                    'id_bahan'  => 'required',
                    'nama_menu' => 'required',    
                    'deskripsi_menu' => 'required',    
                    'tipe_menu' => 'required',    
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required',                            
                    'harga_menu' => 'required', 
                ]);
            }
           
    
        }     
        else{
            if ($files = $request->file('gambar_menu')){
                $validate = Validator::make($updateData,[
                    'id_bahan'  => 'required',
                    'nama_menu' => 'required|unique:menus',    
                    'deskripsi_menu' => 'required',    
                    'tipe_menu' => 'required',           
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required', 
                    'gambar_menu' => 'required|image|mimes:jpeg,png,jpg|max:10048',
                    'harga_menu' => 'required', 
                ]);
            }
            else{
                $validate = Validator::make($updateData,[
                    'id_bahan'  => 'required',
                    'nama_menu' => 'required|unique:menus',    
                    'deskripsi_menu' => 'required',    
                    'tipe_saji' => 'required',      
                    'serving_size' => 'required',
                    'tipe_menu' => 'required',                              
                    'harga_menu' => 'required', 
                ]);
            }
           
        }
        

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
            if ($files = $request->file('gambar_menu')) {
                $imageName = time() . '.' . $request->gambar_menu->extension();
                $request->gambar_menu->move(public_path('image'), $imageName);
                $Menu ->id_bahan = $updateData['id_bahan'];
                $Menu ->nama_menu = $updateData['nama_menu'];   
                $Menu ->tipe_menu = $updateData['tipe_menu'];   
                $Menu ->gambar_menu = $imageName;
                $Menu ->serving_size = $updateData['serving_size'];         
                $Menu ->tipe_saji = $updateData['tipe_saji'];         
                $Menu ->deskripsi_menu = $updateData['deskripsi_menu'];              
                $Menu ->harga_menu = $updateData['harga_menu'];   
                if($Menu->save()){
                    return response([
                        'message' => 'Edit Menu Berhasil',
                        'data' => $Menu,
                    ],200);
                }           
            }
            else{
                $Menu ->id_bahan = $updateData['id_bahan'];
                $Menu ->nama_menu = $updateData['nama_menu'];   
                $Menu ->serving_size = $updateData['serving_size'];         
                $Menu ->tipe_saji = $updateData['tipe_saji'];         
                $Menu ->tipe_menu = $updateData['tipe_menu'];               
                $Menu ->deskripsi_menu = $updateData['deskripsi_menu'];               
                $Menu ->harga_menu = $updateData['harga_menu'];   
                if($Menu->save()){
                    return response([
                        'message' => 'Edit Menu Berhasil',
                        'data' => $Menu,
                    ],200);
                }
            }

        return response([
            'message' => 'Edit Menu Gagal',
            'data' => null,    
            ],400);
    }


    public function delete(Request $request, $id){
        $Menu =  Menu::find($id);
        if(is_null($Menu)){
            return response([
                'message' => 'Menu Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[              
            'delete'  => 'required',            
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        $Menu ->is_delete = $updateData['delete'];   
        if($Menu->save()){
            return response([
                'message' => 'Hapus Menu Berhasil',
                'data' => $Menu,
            ],200);
        }
            

        return response([
            'message' => 'Hapus Menu Gagal',
            'data' => null,    
            ],400);
    }

}
