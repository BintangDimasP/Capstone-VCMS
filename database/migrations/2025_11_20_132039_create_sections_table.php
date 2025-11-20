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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('section_key')->nullable();   // contoh: hero, header, footer
            $table->string('title')->nullable();
            $table->longText('content')->nullable();     // text HTML yang bisa di-edit
            $table->string('image')->nullable();         // optional jika ada gambar
            $table->integer('order')->default(0);        // urutan tampil
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
