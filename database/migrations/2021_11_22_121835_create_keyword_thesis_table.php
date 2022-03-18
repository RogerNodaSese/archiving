<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeywordThesisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //REMOVE
    public function up()
    {
        Schema::create('keyword_thesis', function (Blueprint $table) {
            $table->foreignId('thesis_id')->constrained('theses')->onDelete('cascade');
            $table->foreignId('keyword_id')->constrained('keywords')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword_thesis');
    }
}
