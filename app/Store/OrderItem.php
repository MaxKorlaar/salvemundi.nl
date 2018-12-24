<?php

    namespace App\Store;

    use Illuminate\Database\Eloquent\Model;

    /**
     * Class OrderItem
     *
     * @package App\Store
     * @mixin \Eloquent
     * @property int                        $id
     * @property int|null                   $store_order_id
     * @property int|null                   $store_stock_id
     * @property int                        $amount
     * @property float                      $price
     * @property \Carbon\Carbon|null        $created_at
     * @property \Carbon\Carbon|null        $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereStoreOrderId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereStoreStockId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem whereUpdatedAt($value)
     * @property-read \App\Store\Stock|null $item
     * @property-read \App\Store\Order      $order
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|OrderItem query()
     */
    class OrderItem extends Model {
        protected $table = 'store_order_items';

        protected $fillable = ['amount', 'store_stock_id', 'price'];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function order() {
            return $this->hasOne(Order::class, 'store_order_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function item() {
            return $this->belongsTo(Stock::class, 'store_stock_id');
        }
    }
