<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Kartu extends Model
{
    //
    protected $fillable = [
        'id_transaksi', 'debit', 'nama_pemilik','nomor_kartu'
       
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
}
