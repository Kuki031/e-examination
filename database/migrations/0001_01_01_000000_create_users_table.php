<?php

use App\Enums\Gender;
use App\Enums\RegistrationType;
use App\Enums\Status;
use App\Enums\Pin;
use App\Enums\Role;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->index();
            $table->enum("pin", array_column(Pin::cases(), 'value'));
            $table->string("pin_value")->unique()->index();
            $table->string("full_name")->index();
            $table->enum("gender", array_column(Gender::cases(), 'value'));
            $table->enum("status", array_column(Status::cases(), 'value'));
            $table->enum("registration_type", array_column(RegistrationType::cases(), 'value'));
            $table->enum("role", array_column(Role::cases(), 'value'));
            $table->string("profile_picture")->nullable();
            $table->string('password');
            $table->boolean("is_allowed")->default(false);
            $table->boolean('is_in_pending_status')->default(true);
            $table->boolean("is_in_exam")->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
