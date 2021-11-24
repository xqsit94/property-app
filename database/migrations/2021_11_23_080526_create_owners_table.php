<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("owners", function (Blueprint $table) {
            $table->unsignedBigInteger("property_id");
            $table->uuid("user_id");
            $table->boolean("main_owner")->default(false);

            $table
                ->foreign("property_id")
                ->references("id")
                ->on("properties")
                ->onDelete("cascade");
            $table
                ->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("owners");
    }
}
