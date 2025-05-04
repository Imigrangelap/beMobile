<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes_travel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->string('Deskripsi_travel');
            $table->string('Nama_wisata');
            $table->string('foto_thumbnail');
            $table->string('tanggal_kunjungan');
            $table->integer('rating_travel');
            $table->integer('biaya_travel');
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_travel');
    }
};
