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
        Schema::create('visits_urls', function (Blueprint $table) {
            $table->uuid("uuid")->primary();
            $table->uuid("url_id");
            $table->string("user_ip");
            $table->string("user_agent");
            $table->foreign("url_id")->references("uuid")->on("urls");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits_urls');
    }
};
