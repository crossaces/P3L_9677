<?php

use Illuminate\Database\Seeder;

class BahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Otot perut sapi',                      
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);                    
                     
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Dada ayam',               
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Daging cumi',                   
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);  
            
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Daging sapi empuk',          
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);   
            
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Nasi',           
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 
            
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Kimchi',                     
            'satuan' =>'gram',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 
        
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Saos',        
            'satuan' =>'ml',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 

        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Teh hijau',           
            'satuan' =>'ml',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 

        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Air putih',            
            'satuan' =>'ml',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 
        
        DB::table('bahans')
            ->insert(['stok'=>'1000',
            'nama_bahan' =>'Air jeruk',           
            'satuan' =>'ml',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 
       
    }
}
