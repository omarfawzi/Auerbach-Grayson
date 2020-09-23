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
                $table->integer('subscribable_id');
                $table->enum('subscribable_type', Subscription::SUBSCRIPTION_TYPES);
                $table->unsignedInteger('user_id');
                $table->unique(['subscribable_id','subscribable_type', 'user_id']);
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            }
        );
    }
}
