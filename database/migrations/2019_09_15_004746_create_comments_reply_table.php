<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments_reply', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reviewer')->nullable()->comment('Name reviewer');
            $table->unsignedBigInteger ('comment_id')->comment('Comment id');
            $table->text('content');
            $table->enum('reaction', ['LIKE', 'HATE', 'DELETE'])->nullable()->comment('Reaction: [LIKE, HATE, DELETE]');
            $table->boolean('status')->default(true);
            $table->index(['comment_id']);
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
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
        Schema::dropIfExists('comments_reply');
    }
}
