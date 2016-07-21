<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cmsify_categoryables', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('categoryable_id');
            $table->string('categoryable_type');
            $table->index(['categoryable_id', 'categoryable_type']);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('cmsify_categories')
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
        Schema::drop('cmsify_categoryables');
    }
}
