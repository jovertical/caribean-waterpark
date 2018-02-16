<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('applicable_type', ['per_item', 'per_reservation']);
            $table->enum('deductable_type', ['percent', 'amount']);
            $table->float('amount_deductable');
            $table->date('valid_from');
            $table->date('valid_until');
            $table->boolean('reuseable')->default(false);
            $table->boolean('active')->default(true);

            $table->text('file_path')->nullable();
            $table->text('file_directory')->nullable();
            $table->string('file_name')->nullable();

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
        Schema::dropIfExists('coupons');
    }
}
