<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Soher\Work\Domain\Status;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()
                ->constrained(table: 'users')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->string('title', 70);
            $table->string('location');
            $table->text('description');
            $table->text('skills');
            $table->integer('budget')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('status', array_column(Status::cases(), 'value'));
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('works');
    }
};
