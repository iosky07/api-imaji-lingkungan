<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role')->default(4);
            $table->text('quotes')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->longText('address')->nullable();
            $table->string('master_name')->nullable();
            $table->string('no_customer')->nullable();
            $table->unsignedBigInteger('waste_bank_id')->nullable();
            $table->unsignedBigInteger('pickup_status_id')->nullable();
            $table->timestamps();


            $table->foreign('pickup_status_id')
                ->references('id')
                ->on('pickup_statuses')
                ->onDelete('restrict')
                ->cascadeOnUpdate();

            $table->foreign('waste_bank_id')
                ->references('id')
                ->on('waste_banks')
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
        Schema::dropIfExists('users');
    }
}
