<?php

    namespace App\Store;

    use App\Transaction;
    use App\User;
    use App\Year;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Log;

    /**
     * App\Store\Order
     *
     * @mixin \Eloquent
     * @property int                                                                  $id
     * @property int|null                                                             $user_id
     * @property int|null                                                             $transaction_id
     * @property \Carbon\Carbon|null                                                  $created_at
     * @property \Carbon\Carbon|null                                                  $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Store\OrderItem[] $items
     * @property-read \App\Transaction                                                $transaction
     * @property-read \App\User                                                       $user
     * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Order query()
     * @property string|null                                                          $status
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
     * @property int|null                                                             $mollie_order_id
     * @method static \Illuminate\Database\Eloquent\Builder|Order whereMollieOrderId($value)
     */
    class Order extends Model {
        const STATUS_NONE = null, STATUS_FULFILLED = 'fulfilled', STATUS_OPEN = 'open', STATUS_SEE_TRANSACTION = 'see_transaction';
        protected $table = 'store_orders';

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user() {
            return $this->belongsTo(User::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function transaction() {
            return $this->belongsTo(Transaction::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function items() {
            return $this->hasMany(OrderItem::class, 'store_order_id');
        }

        /**
         * @return string
         * @throws \Throwable
         */
        public function calculateInvoiceNumber() {
            return Year::getCurrentYear()->year . '-' . $this->id;
        }

        /**
         * @param bool $deleteOrder
         *
         * @throws \Throwable
         */
        public function undoOrder($deleteOrder = false) {
            foreach ($this->items as $item) {
                $stock = $item->item;
                if($stock !== null) {
                    $stock->in_stock = $stock->in_stock + $item->amount;
                    $stock->saveOrFail();
                }
                if($deleteOrder) $item->delete();
            }
            if($deleteOrder) $this->delete();
        }
    }
