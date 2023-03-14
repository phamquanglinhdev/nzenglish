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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("staff_id");
            $table->foreign("staff_id")->references("id")->on("users");
            $table->unsignedBigInteger("student_id");
            $table->foreign("student_id")->references("id")->on("students");
            $table->string("name");
            $table->string("code");
            $table->unsignedBigInteger("pack_id")->nullable();
            $table->foreign("pack_id")->references("id")->on("packs");
            $table->string("method");
            $table->integer("value");
            $table->longText("image")->nullable();
            $table->longText("note")->nullable();
            $table->integer("confirm")->default(0);
            $table->integer("origin")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
