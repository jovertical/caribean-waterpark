<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_days', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->integer('reservation_id');
            $table->date('date');
            $table->boolean('entered')->default(false);
            $table->boolean('exited')->default(false);
            $table->timestamp('entered_at')->nullable();
            $table->timestamp('exited_at')->nullable();
            $table->float('adult_rate')->default(0.00);
            $table->float('children_rate')->default(0.00);
            $table->integer('adult_quantity');
            $table->integer('children_quantity')->nullable();
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
        Schema::dropIfExists('reservation_days');
    }
}
