<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invoice_id');
            $table->text('description');
            $table->double('percentage', 6, 2); // Allows up to 999.99%
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tax_items');
    }
}
