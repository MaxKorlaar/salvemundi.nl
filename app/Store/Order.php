<?php

    namespace App\Store;

    use App\Transaction;
    use App\User;
    use App\Year;
    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Throwable;

    /**
 * App\Store\Order
 *
 * @mixin Eloquent
 * @property int                                                                  $id
 * @property int|null                                                             $user_id
 * @property int|null                                                             $transaction_id
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereTransactionId($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @property-read Collection|OrderItem[] $items
 * @property-read Transaction                                          $transaction
 * @property-read User                                                 $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @property string|null                                               $status
 * @method static Builder|Order whereStatus($value)
 * @property int|null                                                  $mollie_order_id
 * @method static Builder|Order whereMollieOrderId($value)
 */
    class Order extends Model {
        const STATUS_NONE = null, STATUS_FULFILLED = 'fulfilled', STATUS_OPEN = 'open', STATUS_SEE_TRANSACTION = 'see_transaction';
        protected $table = 'store_orders';

        /**
         * @return BelongsTo
         */
        public function user() {
            return $this->belongsTo(User::class);
        }

        /**
         * @return BelongsTo
         */
        public function transaction() {
            return $this->belongsTo(Transaction::class);
        }

        /**
         * @return HasMany
         */
        public function items() {
            return $this->hasMany(OrderItem::class, 'store_order_id');
        }

        /**
         * @return string
         * @throws Throwable
         */
        public function calculateInvoiceNumber() {
            return Year::getCurrentYear()->year . '-' . $this->id;
        }

        /**
         * @param bool $deleteOrder
         *
         * @throws Throwable
         */
        public function undoOrder($deleteOrder = false) {
            foreach ($this->items as $item) {
                $stock = $item->item;
                if ($stock !== null) {
                    $stock->in_stock = $stock->in_stock + $item->amount;
                    $stock->saveOrFail();
                }
                if ($deleteOrder) $item->delete();
            }
            if ($deleteOrder) $this->delete();
        }
    }
