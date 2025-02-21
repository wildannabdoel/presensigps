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
        Schema::create('pengajuan_izins', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->char('nik')->foreign('nik')->references('nik')->on('karyawans');
            $table->date('tgl_izin');
            $table->char('status');
            $table->string('keterangan');
            $table->char('status_approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_izins');
    }
};
