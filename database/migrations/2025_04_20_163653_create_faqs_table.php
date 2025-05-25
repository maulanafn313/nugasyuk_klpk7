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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // User yang mengajukan pertanyaan
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->string('question');
            $table->string('answer')->nullable(); // Jawaban admin
            $table->unsignedBigInteger('answered_by')->nullable(); // Admin yang menjawab
            $table->foreign('answered_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamp('answered_at')->nullable(); // Waktu jawaban diberikan
            $table->timestamps();
        });
    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};


