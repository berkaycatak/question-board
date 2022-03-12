<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class QuestionsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->longText('question');
            $table->bigInteger('event_id');
            $table->bigInteger('created_user_id')->nullable()->default(null);
            $table->tinyInteger('is_anonim')->default(1);
            $table->tinyInteger('is_answered')->default(0);
            $table->tinyInteger('is_live')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
