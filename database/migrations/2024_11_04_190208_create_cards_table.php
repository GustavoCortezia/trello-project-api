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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('date')->nullable();
            $table->unsignedBigInteger('environmentId')->nullable(false);
            $table->foreign('environmentId')->references('id')->on('environments')->onDelete('cascade');
            $table->unsignedBigInteger('sectionId')->nullable(false);
            $table->foreign('sectionId')->references('id')->on('sections')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
