<?php

    namespace App;

    use App\Helpers\PaymentHelper;
    use Illuminate\Database\Eloquent\Model;

    /**
 * App\Transaction
 *
 * @mixin \Eloquent
 * @property int                          $id
 * @property int                          $member_id
 * @property string                       $transaction_id
 * @property string                       $transaction_status
 * @property float                        $transaction_amount
 * @property \Carbon\Carbon|null          $created_at
 * @property \Carbon\Carbon|null          $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @property-read \App\Member             $member
 * @property-read \App\Membership         $membership
 * @property-read \App\CampingApplication $campingApplication
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction query()
 */
    class Transaction extends Model {

        public $fillable = ['transaction_id', 'transaction_status', 'transaction_amount', 'member_id'];
        public $attributes = [
            'transaction_id'     => 'n/a',
            'transaction_status' => 'n/a',
            'transaction_amount' => 0
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function member() {
            return $this->belongsTo(Member::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function membership() {
            return $this->belongsTo(Membership::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function campingApplication() {
            return $this->belongsTo(CampingApplication::class);
        }

        /**
         * @throws \Mollie_API_Exception
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         */
        public function getMollieTransaction() {
            $mollie  = new PaymentHelper();
            $payment = $mollie->payments->get($this->transaction_id);
            return $payment;
        }

    }
