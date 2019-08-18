<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function ($table) {
            $table->enum('reaction', ['LIKE', 'HATE', 'DELETE'])
                ->after('content')->nullable()->comment('Reaction: [LIKE, HATE, DELETE]');
            $table->dropColumn('like');
            $table->dropColumn('dislike');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('reaction');
        });
    }
}
