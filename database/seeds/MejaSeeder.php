<?php

use Illuminate\Database\Seeder;

class MejaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mejas')
            ->insert(['nomor_meja'=>'1',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);

        DB::table('mejas')
            ->insert(['nomor_meja'=>'2',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('mejas')
            ->insert(['nomor_meja'=>'3',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('mejas')
            ->insert(['nomor_meja'=>'4',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('mejas')
            ->insert(['nomor_meja'=>'5',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);

        DB::table('mejas')
            ->insert(['nomor_meja'=>'6',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('mejas')
            ->insert(['nomor_meja'=>'7',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('mejas')
            ->insert(['nomor_meja'=>'8',
            'created_at'=>Carbon\Carbon::now(),'updated_at'=>Carbon\Carbon::now()]);
    }
}
