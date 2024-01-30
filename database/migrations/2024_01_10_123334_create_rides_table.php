<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key column named `id`
            $table->dateTime('dep')->nullable(); // Defines a nullable datetime column for `dep`
            $table->dateTime('arrival')->nullable(); // Defines a nullable datetime column for `arrival`
            $table->string('start_point', 50)->nullable(); // Defines a nullable varchar column for `start-point`
            $table->string('end_point', 50)->nullable(); // Defines a nullable varchar column for `end-point`
            $table->unsignedBigInteger('driver_id')->nullable(); // Defines an unsigned bigint column for `driver-id`

            $table->decimal('costs', 8, 2)->nullable(); // 8 digits in total, 2 after the decimal point

            // Foreign key constraint
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
