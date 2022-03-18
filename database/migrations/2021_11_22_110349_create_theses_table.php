<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theses', function (Blueprint $table) {
            $table->id();
            //REMOVE
            // $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            //Changed to dop
            $table->string('date_of_publication');
            $table->string('publisher')->default('New Era University');
            $table->text('citation');
            $table->text('abstract');
            //REMOVE
            // $table->boolean('verified')->default(0);
            $table->foreignId('file_id')->nullable()->constrained('files');
            $table->foreignId('program_id')->constrained('programs');
            //REMOVE
            // $table->softDeletes();
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
        Schema::dropIfExists('theses');
    }
}
