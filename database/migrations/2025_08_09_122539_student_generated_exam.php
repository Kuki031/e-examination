<?php

use App\Models\Exam;
use App\Models\User;
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
            Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Exam::class);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->json('questions');
            $table->integer('score')->default(0);
            $table->enum('status', ['in_process', 'finished'])->default('in_process');
            $table->json("state")->nullable();
            $table->json("stored_answers")->nullable();
            $table->boolean("has_passed")->default(false);
            $table->enum("note", ["Nije predano" ,"Uredno predano", "Ispit zaustavljen - Nije bio prisutan"])->default("Nije predano");
            $table->json("actions")->nullable();
            $table->ipAddress()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
