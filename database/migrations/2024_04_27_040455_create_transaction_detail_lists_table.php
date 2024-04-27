<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail_lists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trx_id');
            $table->string('date');
            $table->time('start');
            $table->time('end');
            $table->string('who');
            $table->text('description');
            $table->float('cost',15,2);
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
        Schema::dropIfExists('transaction_detail_lists');
    }
}
