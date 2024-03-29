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
            $table->date("end")->nullable();
            $table->integer("first_reg")->default(1);
            $table->date("birthday");
            $table->longText("note")->nullable();
            $table->longText("avatar");
            $table->integer("old")->default(0);
            $table->softDeletesDatetime();
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
