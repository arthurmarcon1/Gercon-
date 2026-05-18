<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('condominium_id')->constrained('condominiums')->cascadeOnDelete();
            $table->foreignId('block_id')->nullable()->constrained()->nullOnDelete();
            $table->string('number');
            $table->integer('floor')->nullable();
            $table->timestamps();

            $table->index('condominium_id');
            $table->index('block_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
