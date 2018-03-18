<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('user_id');
            $table->string('name')->unique();
            $table->date('checkin_date');
            $table->date('checkout_date');
            $table->enum('status', ['pending', 'reserved', 'paid', 'cancelled', 'waiting', 'void'])->default('pending');
            $table->integer('days_refundable')->nullable();
            $table->float('price_refundable')->default(0.00);
            $table->float('price_partial_payable')->default(0.00);
            $table->float('price_taxable')->default(0.00);
            $table->float('price_subpayable')->default(0.00);
            $table->float('price_deductable')->default(0.00);
            $table->float('price_payable')->default(0.00);
            $table->float('price_paid')->default(0.00);
            $table->enum('source', ['front', 'root']);
            $table->text('note')->nullable();

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
        Schema::dropIfExists('reservations');
    }
}
