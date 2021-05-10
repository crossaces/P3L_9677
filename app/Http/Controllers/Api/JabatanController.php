<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jabatan;
use Validator,Redirect,Response,File;
use Illuminate\Support\Facades\DB;
class JabatanController extends Controller
{
    //
    public function show($id){
        $Jabatan = Jabatan::find($id);

        if(!is_null($Jabatan)){
            return response([
                'message' => 'Mengambil Data Jabatan Berhasil',
                'data' => $Jabatan
            ],200);
        }

        return response([
            'message' => 'Jabatan Tidak Ada',
            'data' => null
        ],404);

    }

    public function index(){
        $Jabatan = Jabatan::all();

        if(count($Jabatan)>0){
            return response([
                'message' => 'Mengambil Data Jabatan Berhasil',
                'data' => $Jabatan
            ],200);
        }

        return response([
            'message' => 'Kosong',
            'data' => null
        ],404);

    }
    
}
