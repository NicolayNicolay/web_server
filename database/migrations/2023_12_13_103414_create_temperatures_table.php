<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temperatures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название');
            $table->double('bottom')->nullable()->default(0);
            $table->double('top')->nullable()->default(0);
            $table->double('value')->nullable()->default(0)->comment('Значение');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')->on('temperatures_categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temperatures');
    }
};
