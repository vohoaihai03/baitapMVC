<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable()->zerofill();
            $table->string('email')->nullable();
            $table->tinyInteger('type_address')->default(1);
            $table->integer('business_model')->default(1)->comment('table business_model');
            $table->integer('status')->default(1)->comment('review_address_status');
            $table->string('name_hotel');
            $table->string('tel_hotel', 20)->default('0');
            $table->text('address');
            $table->string('full_address')->default('0');
            $table->string('city', 50);
            $table->string('zipcode', 500)->default('0');
            $table->string('city_search', 50)->default('0');
            $table->string('district', 50);
            $table->string('district_search', 50)->default('0');
            $table->string('ward', 50);
            $table->string('ward_search', 50)->default('0');
            $table->string('country_code', 50)->default('0');
            $table->string('summary')->nullable();
            $table->string('phone_2', 20)->nullable();
            $table->string('image_url')->nullable();
            $table->string('website')->default('0');
            $table->string('coordinates')->default('0');
            $table->string('place_id')->default('0');
            $table->text('services')->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('ratings_and_comments', 50)->default('5')->comment('table ratings_and_comments');
            $table->string('average_price', 50)->nullable();
            $table->text('intro_text')->nullable();
            $table->text('google_map');
            $table->timestamps();
            $table->index(['district', 'city', 'ward']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
