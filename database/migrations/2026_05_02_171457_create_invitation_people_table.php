<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitation_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->string('name')->nullable();
            $table->string('subtitle')->nullable(); // misal: Putri / Putra / Keluarga
            $table->string('family_name')->nullable(); // misal: bapak abdul
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_people');
    }
};
