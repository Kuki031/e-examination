<?php

use App\Models\Exam;
use App\Models\ExamAttempt;
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
        Schema::create('conducted_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Exam::class);
            $table->integer("num_of_participants")->default(0);
            $table->integer("time_to_solve")->nullable();
            $table->integer("required_for_pass")->nullable();
            $table->timestamp("start_time")->nullable();
            $table->timestamp("end_time")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conducted_exams');
    }
};
