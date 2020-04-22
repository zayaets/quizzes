<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIsRightColumnToIsCorrectInAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
//            $table->boolean('is_correct')->default(false)->change();
            $table->renameColumn('is_right', 'is_correct');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->renameColumn('is_correct', 'is_right');
//            $table->boolean('is_right')->default(false)->change();
        });
    }
}
