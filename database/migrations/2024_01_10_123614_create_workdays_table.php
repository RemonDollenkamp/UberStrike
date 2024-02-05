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
        Schema::create('workdays', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key column named `id`
            $table->unsignedBigInteger('driver_id'); // Defines an unsigned bigint column for `driver-id`
            $table->tinyInteger('day_of_the_week'); // Defines a tinyint column for `day-of-the-week`
            $table->time('shift_start'); // Defines a time column for `shift-start`
            $table->time('shift_end'); // Defines a time column for `shift-end`
            $table->integer('break_time');
            $table->tinyInteger('status'); // Defines a tinyint column for `status`

            // Foreign key constraint
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workdays');
    }
};
