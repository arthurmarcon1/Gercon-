<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('document', 18)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->index(['slug', 'active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
