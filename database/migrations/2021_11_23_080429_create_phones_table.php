<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Phone;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("phones", function (Blueprint $table) {
            $table->id();
            $table->uuid("user_id");
            $table->string("number", 20);
            $table->enum("type", Phone::PHONE_TYPE);
            $table->timestamps();

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
        Schema::dropIfExists("phones");
    }
}
