<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')
        ->insert([
            'name'=>'Nana Kartika Putri',
            'email' =>'lourensiusw@gmail.com',
            'password'=>'$2b$10$8eF6sPnBAtoiQZ5KYYiau.nUDi5IPNxAeVvKktXYqVGCl5mvpz3Fi',
            'jKelamin' => 'Perempuan',
            'no_telp' =>'08994953788',
            'tgl_bergabung'=>'2020-03-21',
            'id_jabatan' =>'1',            
            'created_at'=>Carbon\Carbon::now(),
            'updated_at'=>Carbon\Carbon::now()]);

        DB::table('users')
        ->insert([
                'name'=>'William Lourensius',
                'email' =>'wlourensius@gmail.com',
                'no_telp' =>'081346800553',
                'password'=>'$2b$10$8eF6sPnBAtoiQZ5KYYiau.nUDi5IPNxAeVvKktXYqVGCl5mvpz3Fi',
                'jKelamin' => 'Laki-laki',
                'tgl_bergabung'=>'2020-03-21',
                'id_jabatan' =>'2',            
                'created_at'=>Carbon\Carbon::now(),
                'updated_at'=>Carbon\Carbon::now()]);
    }
}
