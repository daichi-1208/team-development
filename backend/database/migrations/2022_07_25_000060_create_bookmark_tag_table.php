<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmark_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bookmark_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            // 外部キー制約
            $table->foreign('bookmark_id')
                ->references('id')
                ->on('bookmarks')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmark_tag');
    }
};
