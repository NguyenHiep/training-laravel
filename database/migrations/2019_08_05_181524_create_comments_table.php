<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger ('company_id')->comment('Company id');
            $table->unsignedInteger ( 'parent_id')->default (0);
            $table->string('reviewer')->nullable ()->comment('Name reviewer');
            $table->string('position')->nullable ();
            $table->text ('content');
            $table->unsignedTinyInteger ('like')->default (0);
            $table->unsignedTinyInteger ('dislike')->default (0);
            $table->unsignedTinyInteger ('star')->default (3)->comment('Value [1,2,3,4,5]');;
            $table->boolean ('status')->default (true);
            $table->timestamps();
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
        Schema::dropIfExists('comments');
    }
}
