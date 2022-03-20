<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('list_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->boolean('is_done')->default(false);
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('list_id')->references('id')->on('lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_list_id_foreign');
        });
        Schema::dropIfExists('items');
    }
}
