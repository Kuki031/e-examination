<?php

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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique()->index();
            $table->text("description")->nullable();
            $table->boolean("is_quiz")->default(false);
            $table->integer("num_of_questions")->nullable();
            $table->integer("num_of_points")->nullable();
            $table->integer("required_for_pass")->nullable();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean("in_process")->default(false);
            $table->string("access_code")->nullable();
            $table->text('access_code_encrypted')->nullable();
            $table->integer("time_to_solve")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
