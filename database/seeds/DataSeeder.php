<?php

use Illuminate\Database\Seeder;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('jabatans')
            ->insert(['nama_jabatan'=>'Owner','created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);                    
                     
        DB::table('jabatans')
            ->insert(['nama_jabatan'=>'Operational Manager','created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);

        DB::table('jabatans')
            ->insert(['nama_jabatan'=>'Chef','created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('jabatans')
            ->insert(['nama_jabatan'=>'Waiter','created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);

        DB::table('jabatans')
            ->insert(['nama_jabatan'=>'Cashier','created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);


    
    }
}
