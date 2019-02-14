<?php

    namespace App\Store;

    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    /**
     * Class OrderItem
     *
     * @package App\Store
     * @mixin Eloquent
     * @property int                        $id
     * @property int|null                   $store_order_id
     * @property int|null                   $store_stock_id
     * @property int                        $amount
     * @property float                      $price
     * @property Carbon|null        $created_at
     * @property Carbon|null $updated_at
     * @method static Builder|OrderItem whereAmount($value)
     * @method static Builder|OrderItem whereCreatedAt($value)
     * @method static Builder|OrderItem whereId($value)
     * @method static Builder|OrderItem wherePrice($value)
     * @method static Builder|OrderItem whereStoreOrderId($value)
     * @method static Builder|OrderItem whereStoreStockId($value)
     * @method static Builder|OrderItem whereUpdatedAt($value)
     * @property-read Stock|null     $item
     * @property-read Order          $order
     * @method static Builder|OrderItem newModelQuery()
     * @method static Builder|OrderItem newQuery()
     * @method static Builder|OrderItem query()
     */
    class OrderItem extends Model {
        protected $table = 'store_order_items';

        protected $fillable = ['amount', 'store_stock_id', 'price'];

        /**
         * @return HasOne
         */
        public function order() {
            return $this->hasOne(Order::class, 'store_order_id');
        }

        /**
         * @return BelongsTo
         */
        public function item() {
            return $this->belongsTo(Stock::class, 'store_stock_id');
        }
    }
