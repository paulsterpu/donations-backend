<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryDonationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_donation_request', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('donation_request_id');
            $table->timestamps();

            $table->primary(['category_id', 'donation_request_id'], 'id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_donation_request');
    }
}
