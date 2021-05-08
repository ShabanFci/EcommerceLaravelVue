<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateOrdersTable extends Migration
    {
        public function up()
        {
            Schema::create('orders', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('product_id')->unsigned()->index();
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->bigInteger('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('quantity')->default(1);
                $table->string('address')->nullable();
                $table->boolean('is_delivered')->default(false);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        public function down()
        {
            Schema::dropIfExists('orders');
        }
    }