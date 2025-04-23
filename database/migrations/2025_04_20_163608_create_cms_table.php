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
        Schema::create('cms', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->string('logo');
            $table->string('hero_text');
            $table->string('description_text');
            $table->string('hero_text2');
            $table->string('description_text2');
            $table->string('img_text2');
            $table->string('hero_text3');
            $table->string('description_text3');
            $table->string('img_text3');
            $table->string('hero_text4');
            $table->string('description_text4');
            $table->string('img_text4');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cms');
    }
};


