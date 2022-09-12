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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bookmark_id')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->string('comment')->comment('コメント本文');
            $table->boolean('is_publish')->default(true)->comment('公開・非公開');
            $table->timestamps();

            // 外部キー
            $table->foreign('bookmark_id')
                ->references('id')
                ->on('bookmarks')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
};
