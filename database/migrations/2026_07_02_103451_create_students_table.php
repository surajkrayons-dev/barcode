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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // Basic Details
            $table->string('student_id')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('full_name');

            // Contact Details
            $table->string('email')->unique();
            $table->string('mobile', 15)->unique();

            // Personal Details
            $table->date('date_of_birth');
            $table->enum('gender', ['Male', 'Female', 'Other']);

            // Academic Details
            $table->string('course');
            $table->string('department')->nullable();
            $table->string('semester')->nullable();
            $table->string('roll_number')->unique();

            // Address
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('India');
            $table->string('pincode', 10)->nullable();

            // Additional Info
            $table->string('profile_image')->nullable();
            $table->date('admission_date');
            $table->decimal('fees', 10, 2)->default(0);

            // Status
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
