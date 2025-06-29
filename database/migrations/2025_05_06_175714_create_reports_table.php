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
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('admin_id');
            $table->date('report_date');
            $table->enum('report_type', ['daily', 'monthly', 'custom']);
            $table->timestamp('startedAt')->nullable();
            $table->timestamp('endedAt')->nullable();
            $table->string('workspaceId')->nullable();
            $table->timestamps();
    
            $table->foreign('admin_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
