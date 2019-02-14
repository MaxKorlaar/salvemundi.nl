<?php

    namespace App;

    use App\Helpers\PaymentHelper;
    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Mollie\Api\Exceptions\ApiException;
    use Mollie\Api\Exceptions\IncompatiblePlatform;
    use Mollie\Api\Resources\Payment;

    /**
     * App\Transaction
     *
     * @mixin Eloquent
     * @property int                          $id
     * @property int                          $member_id
     * @property string                       $transaction_id
     * @property string                       $transaction_status
     * @property float                        $transaction_amount
     * @property Carbon|null          $created_at
     * @property Carbon|null     $updated_at
     * @method static Builder|Transaction whereCreatedAt($value)
     * @method static Builder|Transaction whereId($value)
     * @method static Builder|Transaction whereMemberId($value)
     * @method static Builder|Transaction whereTransactionAmount($value)
     * @method static Builder|Transaction whereTransactionId($value)
     * @method static Builder|Transaction whereTransactionStatus($value)
     * @method static Builder|Transaction whereUpdatedAt($value)
     * @property-read Member             $member
     * @property-read Membership         $membership
     * @property-read CampingApplication $campingApplication
     * @method static Builder|Transaction newModelQuery()
     * @method static Builder|Transaction newQuery()
     * @method static Builder|Transaction query()
     */
    class Transaction extends Model {

        public $fillable = ['transaction_id', 'transaction_status', 'transaction_amount', 'member_id'];
        public $attributes = [
            'transaction_id'     => 'n/a',
            'transaction_status' => 'n/a',
            'transaction_amount' => 0
        ];

        /**
         * @return BelongsTo
         */
        public function member() {
            return $this->belongsTo(Member::class);
        }

        /**
         * @return BelongsTo
         */
        public function membership() {
            return $this->belongsTo(Membership::class);
        }

        /**
         * @return BelongsTo
         */
        public function campingApplication() {
            return $this->belongsTo(CampingApplication::class);
        }


        /**
         * @return Payment
         * @throws ApiException
         * @throws IncompatiblePlatform
         */
        public function getMollieTransaction() {
            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->get($this->transaction_id);
            return $payment;
        }
    }
