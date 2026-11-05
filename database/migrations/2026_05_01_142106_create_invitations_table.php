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
            Schema::create('invitations', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('template_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('event_category_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->string('slug')->unique();

                $table->string('title')->nullable();
                $table->string('event_name')->nullable();
                $table->string('host_name')->nullable();

                $table->text('description')->nullable();

                $table->date('event_date')->nullable();
                $table->string('event_time')->nullable();

                $table->string('location_name')->nullable();
                $table->text('address')->nullable();
                $table->text('maps_url')->nullable();

                $table->string('cover_image')->nullable();
                $table->string('music_url')->nullable();

                $table->string('status')->default('draft');
                $table->timestamp('expired_at')->nullable();

                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
