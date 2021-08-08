<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisplayTypeToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->string('display_type');
            if (Schema::hasColumn('posts', 'is_main')) {
                $table->dropColumn('is_main');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'display_type')) {
                $table->dropColumn('display_type');
            }

            if (!Schema::hasColumn('posts', 'is_main')) {
                $table->boolean('is_main');
            }
        });
    }
}
