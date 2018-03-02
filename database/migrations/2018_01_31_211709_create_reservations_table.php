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
            $table->date('checkin');
            $table->date('checkout');
            $table->enum('status', ['pending', 'paid', 'reserved', 'cancelled', 'waiting', 'void']);
            $table->float('price_taxable')->nullable();
            $table->float('price_deductable')->nullable();
            $table->float('price_payable');
            $table->float('price_paid')->nullable();
            $table->enum('source', ['frontend', 'root']);
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
