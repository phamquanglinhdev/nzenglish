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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer("origin");
            $table->string("name");
            $table->string("phone");
            $table->date("first");
            $table->date("start");
            $table->string("grade");
            $table->date("birthday");
            $table->longText("note")->nullable();
            $table->longText("avatar");
            $table->integer("days");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
