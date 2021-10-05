<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->longText('address');
            $table->string('image');
            $table->string('status');
            $table->integer('paper');
            $table->timestamps();

            $table->foreign('waste_bank_id')
                ->references('id')
                ->on('waste_banks')
                ->onDelete('restrict')
                ->cascadeOnUpdate();
            $table->foreign('waste_detail_id')
                ->references('id')
                ->on('waste_details')
                ->onDelete('restrict')
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
