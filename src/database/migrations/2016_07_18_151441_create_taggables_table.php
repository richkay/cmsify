<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaggablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmsify_taggables', function (Blueprint $table)
        {
            $table->integer('tag_id')->unsigned();
            $table->integer('taggable_id');
            $table->string('taggable_type');
            $table->index(['taggable_id', 'taggable_type']);
            $table->timestamps();

            $table->foreign('tag_id')->references('id')->on('cmsify_tags')
                ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cmsify_taggables');
    }
}
