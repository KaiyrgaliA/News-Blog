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
        Schema::create('news_rubrics', function (Blueprint $table) {
            $table->bigInteger('news_id')->unsigned();
            $table->bigInteger('rubric_id')->unsigned();

            $table->primary(['news_id', 'rubric_id']);

            $table->foreign('news_id', 'news_rubrics_news_id_fk')
            ->references('id')
            ->on('news');

            $table->foreign('rubric_id', 'news_rubrics_rubric_id_fk')
                ->references('id')
                ->on('rubrics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_rubrics');
    }
};
