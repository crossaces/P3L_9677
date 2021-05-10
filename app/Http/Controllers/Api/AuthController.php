<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{
    //
    Public function register(Request $request){
        $registrationData = $request->All();
        $validate = Validator::make($registrationData,[
            'name'  => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required',
            'id_jabatan'  => 'required',
            'no_telp' => 'required|digits_between:10,13|numeric|starts_with:08',
            'tgl_bergabung' => 'required|date_format:Y-m-d',
            'jKelamin' => 'required',
            'cpassword' =>'required',        
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);
        
        if($registrationData['password']===$registrationData['cpassword']){
            $registrationData['password'] = bcrypt($request->password);
            $user = User::create($registrationData);
            return response([
                'message' => 'Success Terdaftar',
                'user' => $user,
            ],200);
        }
        else if($registrationData['password']!==$registrationData['cpassword']){
            return response([
                'message' => 'Password dan Confirm Password Tidak Sama',                
            ],400);
        }

        return response([
            'message' => 'Gagal Terdaftar',                
        ],400);
       
    }

    public function update(Request $request, $id){
        $User =  User::find($id);
        if(is_null($User)){
            return response([
                'message' => 'Karyawan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();

        if($User->email == $updateData['email']){
            $validate = Validator::make($updateData,[
                'name'  => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email:rfc,dns',        
                'id_jabatan'  => 'required',
                'no_telp' => 'required|digits_between:10,13|numeric|starts_with:08',
                'tgl_bergabung' => 'required|date_format:Y-m-d',
                'jKelamin' => 'required',               
            ]);
    
        }
        else{
            $validate = Validator::make($updateData,[
                'name'  => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email:rfc,dns|unique:users',    
                'no_telp' => 'required|digits_between:10,13|numeric|starts_with:08',    
                'id_jabatan'  => 'required',
                'tgl_bergabung' => 'required|date_format:Y-m-d',
                'jKelamin' => 'required',               
            ]);
        }

      

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        
        $User ->name = $updateData['name'];    
        $User ->email = $updateData['email'];
        $User ->id_jabatan = $updateData['id_jabatan'];
        $User ->no_telp = $updateData['no_telp'];
        $User ->tgl_bergabung = $updateData['tgl_bergabung'];
        $User ->jKelamin = $updateData['jKelamin'];
        
        if($User->save()){
            return response([
                'message' => 'Edit Karyawan Success',
                'data' => $User,
            ],200);
        }

        return response([
            'message' => 'Update Karyawan Failed',
            'data' => null,    
            ],400);
    }

    public function changePassword(Request $request, $id){
        $User =  User::find($id);
        if(is_null($User)){
            return response([
                'message' => 'Karyawan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'lastpassword'  => 'required',
            'newpassword' => 'required',        
            'cpassword'  => 'required',                 
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);

        if(Hash::check($updateData['lastpassword'], $User->password) ){
            if($updateData['newpassword']===$updateData['cpassword'])
                $User ->password  = bcrypt($request->newpassword);
            else{
                return response([
                    'message' => 'Password Baru dan Confirm Password tidak sesuai',               
                ],400);
            }
        }else{
            return response([
                'message' => 'Password Lama Salah',               
            ],400);
        }

        
        if($User->save()){
            return response([
                'message' => 'Ganti Password Berhasil',
                'data' => $User,
            ],200);
        }

        return response([
            'message' => 'Edit Karyawan Gagal',
            'data' => null,    
            ],400);
    }


    public function updatePic(Request $request, $id){
        $User =  User::find($id);
        if(is_null($User)){
            return response([
                'message' => 'Karyawan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[            
            'image' => 'sometimes|image|mimes:jpeg,png,jpg|max:10048'
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        

        if ($files = $request->file('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('image'), $imageName);           
            $User ->image = $imageName;
            if($User->save()){
                return response([
                    'message' => 'Edit Karyawan Berhasil',
                    'data' => $User,
                ],200);
            }           
              
        };
        return response([
            'message' => 'Edit Karyawan Gagal',
            'data' => null,    
            ],400);
      
        
    }

    public function show($id){
        $User = User::find($id);

        if(!is_null($User)){
            return response([
                'message' => 'Mengambil Data User Berhasil',
                'data' => $User
            ],200);
        }

        return response([
            'message' => 'User Tidak Ada',
            'data' => null
        ],404);

    }


    public function updateStatus(Request $request, $id){
        $User =  User::find($id);
        if(is_null($User)){
            return response([
                'message' => 'Karyawan Tidak Ada',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[            
            'status' => 'required'
        ]);

        if($validate->fails())              
            return response(['message' => $validate->errors()],400);
        

        $User ->status = $updateData['status'];
        
      

        if($User->save()){
            if($updateData['status'] == 'Aktif'){
                $message="Aktif Karyawan Berhasil";
            }
            else{
                $message="Nonaktif Karyawan Berhasil";
            }
            return response([
                'message' => $message,
                'data' => $User,
            ],200);
        }   
        else{
            if($updateData['status'] == 'Aktif'){
                $message="Aktif Karyawan Gagal";
            }
            else{
                $message="Nonaktif Karyawan Gagal";
            }
            return response([
                'message' => $message,
                'data' => null,    
                ],400);
        }       
     
        
      
        
    }


    public function index(){
        $User = DB::table('users')
        ->join('jabatans','users.id_jabatan','=','jabatans.id')
        ->select('users.*','jabatans.nama_jabatan')->get();       
        if(!is_null($User)){
            return response([         
                'message' => 'Retrieve All Success',
                'data' => $User
            ],200);
        }

        return response([
            'data' => null
        ],404);

    }
  

    public function login(Request $request){
        $loginData = $request->all();
        $validate = Validator::make($loginData,[
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        
        if(!Auth::attempt($loginData))
            return response(['message' => 'Login Gagal'],401);

        $user = Auth::user();
        if($user->status != "Aktif"){
            return response([
                'message' => 'Akun Disable',                
            ],401);
        }else{
            $token = $user->createToken('Authentication Token')->accessToken;
            return response([
                'message' => 'Login Berhasil',
                'user' => $user,
                'token_type' => 'Bearer',
                'access_token' => $token
            ]);
        }
    }
}
