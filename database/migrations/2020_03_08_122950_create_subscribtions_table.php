<?php

use App\Models\Subscribtion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribtionsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribtions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'subscribtions',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('relationId');
                $table->enum('type', Subscribtion::SUBSCRIPTION_TYPES);
                $table->timestamps();
            }
        );
    }
}
