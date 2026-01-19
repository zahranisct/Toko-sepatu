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
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // kasir
        $table->string('kode_transaksi')->unique();
        $table->integer('total_harga');
        $table->enum('metode_bayar', ['cash', 'qris']);
        $table->integer('uang_tunai')->nullable();
        $table->integer('kembalian')->nullable();
        $table->dateTime('tanggal_transaksi');
        $table->timestamps();

        $table->foreign('user_id')
              ->references('id')->on('user')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
