<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->text('description');
            $table->date('due_date');
            $table->boolean('paid')->default(false);
            $table->decimal('total', 20, 2); // Needs to be big
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('template_id');
            $table->boolean('published')->default(false);
            $table->string('pdf_path');
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
        Schema::drop('invoices');
    }
}
