<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    /**
     * Class AddStoreItemsOrders
     */
    class AddStoreItemsOrders extends Migration {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up() {
            Schema::create('store_items', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
            Schema::create('store_stock', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->unsignedDecimal('price');
                $table->unsignedInteger('in_stock')->default(0);
                $table->unsignedInteger('store_item_id')->index();
                $table->timestamps();
            });
            Schema::create('store_stock_images', function (Blueprint $table) {
                $table->increments('id');
                $table->string('image_name')->nullable();
                $table->unsignedInteger('store_stock_id')->index();
                $table->timestamps();
            });
            Schema::create('store_orders', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id')->index()->nullable();
                $table->unsignedInteger('transaction_id')->nullable();
                $table->timestamps();
            });
            Schema::create('store_order_items', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('store_order_id')->index()->nullable();
                $table->unsignedInteger('store_stock_id')->nullable();
                $table->unsignedInteger('amount')->default(1);
                $table->unsignedDecimal('price');
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down() {
            Schema::dropIfExists('store_items');
            Schema::dropIfExists('store_stock');
            Schema::dropIfExists('store_stock_images');
            Schema::dropIfExists('store_orders');
            Schema::dropIfExists('store_order_items');
        }
    }
