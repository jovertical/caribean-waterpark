<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('reservation_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->float('price_taxable')->default(0.00);
            $table->float('price_subpayable')->default(0.00);
            $table->float('price_deductable')->default(0.00);
            $table->float('price_payable')->default(0.00);

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_items');
    }
}
