<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('message');
            $table->enum('type', ['general', 'teacher', 'student', 'urgent'])->default('general');
            $table->string('target_audience')->nullable(); // all, teachers, students, specific class
            $table->foreignId('published_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('publish_date');
            $table->date('expiry_date')->nullable();
            $table->boolean('status')->default(true);
            $table->string('attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type', 'status']);
            $table->index('publish_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
