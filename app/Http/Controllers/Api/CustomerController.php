<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class CustomerController extends Controller
{
    //
    public function index(){
        $Customer = DB::table('customers')       
        ->select('*',DB::raw('CONCAT(id, " - ", nama_customer) as list_customer'))
        ->where('is_delete','=','available')->get();  

        if(count($Customer)>0){
            return response([
                'message' => 'Mengambil Data Customer Berhasil',
                'data' => $Customer
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }

    public function show($id){
        $Customer = Customer::find($id);

        if(!is_null($Customer)){
            return response([
                'message' => 'Mengambil Data Customer Berhasil',
                'data' => $Customer
            ],200);
        }

        return response([
            'message' => 'Customer Tidak Ada',
            'data' => null
        ],404);

    }

    public function store(Request $request){
        $storeData = $request->all();

        if($storeData['telp_customer']==null&&$storeData['email_customer']==null){
            $validate = Validator::make($storeData,[
                'nama_customer'  => 'required',                                                         
            ]);
        }
        else if($storeData['email_customer']==null){
            $validate = Validator::make($storeData,[
                'nama_customer'  => 'required',                
                'telp_customer' => 'required|digits_between:10,13|numeric|starts_with:08'             
            ]);
        }       
        else if($storeData['telp_customer']==null){
            $validate = Validator::make($storeData,[
                'nama_customer'  => 'required', 
                'email_customer' => 'required|email:rfc,dns',                                    
            ]);
        }
        else if($storeData['telp_customer']!=null&&$storeData['email_customer']!=null){
            $validate = Validator::make($storeData,[
                'nama_customer'  => 'required',  
                'email_customer' => 'required|email:rfc,dns',    
                'telp_customer' => 'required|digits_between:10,13|numeric|starts_with:08'                                                 
            ]);
        }

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        $Customer = Customer::create($storeData);
        return response([
            'message' => 'Tambah Customer Berhasil',
            'data' => $Customer,
        ],200);
    }

    public function destroy($id){
        $Customer = Customer::find($id);
        if(is_null($Customer)){
            return response([
                'message' => 'Customer Tidak Ada',
                'data' => null
            ],404);
        }

        if($Customer->delete()){
            return response([
                'message' => 'Hapus Customer Berhasil',
                'data' => $Customer,
            ],200);
        }

        return response([
            'message' => 'Hapus Customer Gagal',
            'data' => null,
        ],400);

    }


    public function update(Request $request, $id){
        $Customer =  Customer::find($id);
        if(is_null($Customer)){
            return response([
                'message' => 'Customer Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        if($updateData['telp_customer']==null&&$updateData['email_customer']==null){
            $validate = Validator::make($updateData,[
                'nama_customer'  => 'required',                                                         
            ]);
        }
        else if($updateData['email_customer']==null){
            $validate = Validator::make($updateData,[
                'nama_customer'  => 'required',                
                'telp_customer' => 'required|digits_between:10,13|numeric|starts_with:08'             
            ]);
        }       
        else if($updateData['telp_customer']==null){
            $validate = Validator::make($updateData,[
                'nama_customer'  => 'required', 
                'email_customer' => 'required|email:rfc,dns',                                    
            ]);
        }
        else if($updateData['telp_customer']!=null&&$updateData['email_customer']!=null){
            $validate = Validator::make($updateData,[
                'nama_customer'  => 'required',  
                'email_customer' => 'required|email:rfc,dns',    
                'telp_customer' => 'required|digits_between:10,13|numeric|starts_with:08'                                                 
            ]);
        }

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
    
        $Customer ->nama_customer = $updateData['nama_customer'];
        $Customer ->email_customer = $updateData['email_customer'];
        $Customer ->telp_customer = $updateData['telp_customer'];        
    

        if($Customer->save()){
            return response([
                'message' => 'Edit Customer Berhasil',
                'data' => $Customer,
            ],200);
        }

        return response([
            'message' => 'Edit Customer Gagal',
            'data' => null,    
            ],400);
        }

        public function delete(Request $request, $id){
            $Customer =  Customer::find($id);
            if(is_null($Customer)){
                return response([
                    'message' => 'Customer Tidak Ada',
                    'data' => null
                ],404);
            }
    
            $updateData = $request->all();
            $validate = Validator::make($updateData,[              
                'delete'  => 'required',            
            ]);
    
            if($validate->fails())              
                return response(['message' => $validate->errors()],400);
            
            $Customer ->is_delete = $updateData['delete'];   
            if($Customer->save()){
                return response([
                    'message' => 'Hapus Customer Berhasil',
                    'data' => $Customer,
                ],200);
            }
                
    
            return response([
                'message' => 'Hapus Customer Gagal',
                'data' => null,    
                ],400);
        }
}
