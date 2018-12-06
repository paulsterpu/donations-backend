<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDonationOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donation_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->date('data_publicare');
            $table->date('data_limita');
            $table->string('descriere', 2000);
            $table->string('titlu');
            $table->string('greutate')->nullable();
            $table->integer('nr_bucati')->nullable();
            $table->integer('user_id');
            $table->boolean('fulfilled');

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
        Schema::dropIfExists('donation_offers');
    }
}
