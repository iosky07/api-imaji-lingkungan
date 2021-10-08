<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_deposit_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_deposit_id');
            $table->unsignedBigInteger('waste_type_id');
            $table->double('amount')->default(0);
            $table->double('price')->default(0);
            $table->timestamps();

            $table->foreign('waste_deposit_id')
                ->references('id')
                ->on('waste_deposits')
                ->restrictOnDelete()
                ->cascadeOnUpdate();
            $table->foreign('waste_type_id')
                ->references('id')
                ->on('waste_types')
                ->restrictOnDelete()
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
        Schema::dropIfExists('waste_details');
    }
}
