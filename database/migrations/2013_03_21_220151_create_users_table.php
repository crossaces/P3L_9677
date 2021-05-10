<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('jKelamin');
            $table->string('no_telp');
            $table->date('tgl_bergabung');
            $table->unsignedBigInteger('id_jabatan');          
            $table->foreign('id_jabatan')->references('id')->on('jabatans');        
            $table->string('status')->default('Aktif');
            $table->string('image')->default('default.png');      
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
