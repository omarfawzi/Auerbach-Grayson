<?php

use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'subscriptions',
            function (Blueprint $table) {
                $table->increments('id');
                $table->integer('relationId');
                $table->unsignedInteger('userId');
                $table->enum('type', Subscription::SUBSCRIPTION_TYPES);
                $table->foreign('userId')->references('id')->on('users');
                $table->timestamps();
            }
        );
    }
}
