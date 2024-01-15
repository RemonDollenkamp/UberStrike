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
        Schema::create('ride_break', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing primary key column named `id`
            $table->unsignedBigInteger('ride_id'); // Defines an unsigned bigint column for `ride-id`
            $table->string('address', 50); // Defines a varchar column for `address`
            $table->unsignedSmallInteger('time'); // Defines an unsigned smallint column for `time`

            // Foreign key constraint
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('NO ACTION')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
