<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('menus')
            ->insert(['id_bahan'=>'1',
            'nama_menu' =>'Beef Short Plate',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Makanan Utama',   
            'serving_size' =>'50',   
            'tipe_saji' => 'Plate',
            'gambar_menu' =>'defaultmenu.jpg',
            'harga_menu' =>'20000',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]); 
            
        DB::table('menus')
            ->insert(['id_bahan'=>'2',
            'nama_menu' =>'Chiken Slice',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Makanan Utama',     
            'serving_size' =>'50',   
            'tipe_saji' => 'Plate',
            'harga_menu' =>'15000',   
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);  

        DB::table('menus')
            ->insert(['id_bahan'=>'3',
            'nama_menu' =>'Squid',
            'harga_menu' =>'20000',
            'serving_size' =>'50',   
            'tipe_saji' => 'Plate',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Makanan Utama',          
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('menus')
            ->insert(['id_bahan'=>'4',
            'nama_menu' =>'Tendorin',
            'harga_menu' =>'22000',
            'serving_size' =>'50',   
            'tipe_saji' => 'Plate',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Makanan Utama',          
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);

        
        DB::table('menus')
            ->insert(['id_bahan'=>'5',
            'nama_menu' =>'Nasi',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Makanan Utama',        
            'serving_size' =>'125',   
            'tipe_saji' => 'Bowl',
            'harga_menu' =>'4000',  
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);
        
        DB::table('menus')
            ->insert(['id_bahan'=>'6',
            'nama_menu' =>'Kimchi',
            'serving_size' =>'15',   
            'tipe_saji' => 'Plate',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Side Dish',          
            'harga_menu' =>'5000',
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);
     
        
        DB::table('menus')
            ->insert(['id_bahan'=>'7',
            'nama_menu' =>'Saos',
            'serving_size' =>'20',   
            'tipe_saji' => 'Mini Bowl',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Side Dish',      
            'harga_menu' =>'0',    
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);

        
        DB::table('menus')
            ->insert(['id_bahan'=>'8',
            'nama_menu' =>'Ocha',
            'serving_size' =>'200',   
            'tipe_saji' => 'Gelas',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Minuman',          
            'gambar_menu' =>'defaultmenu.jpg',
            'harga_menu' =>'5000',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);

        DB::table('menus')
            ->insert(['id_bahan'=>'9',
            'nama_menu' =>'Air Mineral',
            'serving_size' =>'600',   
            'tipe_saji' => 'Botol',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Minuman',          
            'gambar_menu' =>'defaultmenu.jpg',
            'harga_menu' =>'6000',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);

        DB::table('menus')
            ->insert(['id_bahan'=>'10',
            'nama_menu' =>'Jus Jeruk',
            'serving_size' =>'200',   
            'tipe_saji' => 'Gelas',
            'deskripsi_menu' =>'Menu sangat luar biasa merupakan menu andalan kami, Silahkan dinikmati',
            'tipe_menu' =>'Minuman',          
            'harga_menu' =>'6000',
            'gambar_menu' =>'defaultmenu.jpg',
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);
    }
}
