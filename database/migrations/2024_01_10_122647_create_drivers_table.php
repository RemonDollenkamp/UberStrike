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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id(); // This will create an auto-incrementing primary key column named `id`
            $table->string('fullname', 50)->nullable(false); 
            $table->unsignedBigInteger('car')->nullable(false);        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
