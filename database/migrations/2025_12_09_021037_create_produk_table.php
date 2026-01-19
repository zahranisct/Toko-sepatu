<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('produk', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('kategori_id');
        $table->string('nama_produk');
        $table->integer('stok')->default(0);
        $table->string('gambar')->nullable();
        $table->timestamps();

        $table->foreign('kategori_id')
              ->references('id')->on('kategori_produk')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
