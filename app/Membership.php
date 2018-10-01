<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    /**
     * App\Membership
     *
     * @mixin \Eloquent
     * @property int                   $id
     * @property int                   $year_id
     * @property int|null              $member_id
     * @property int|null              $transaction_id
     * @property string                $valid_from
     * @property string                $valid_until
     * @property \Carbon\Carbon|null   $created_at
     * @property \Carbon\Carbon|null   $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereMemberId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereTransactionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereValidFrom($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereValidUntil($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Membership whereYearId($value)
     * @property-read \App\Member|null $member
     * @property-read \App\Transaction $transaction
     * @property-read \App\Year        $year
     */
    class Membership extends Model {

        public $fillable = ['valid_from', 'valid_until'];

        /**
         * @return Membership
         */
        public static function createNewMembership() {
            $membership              = new self;
            $membership->valid_from  = self::calculateFiscalYearStart();
            $membership->valid_until = self::calculateFiscalYearEnd();
            return $membership;
        }

        /**
         * @param null $now
         *
         * @return Carbon
         */
        public static function calculateFiscalYearStart($now = null) {
            $now = $now ?? Carbon::now();
            if ($now->month < 2 || $now->month > 7) {
                // Als het lidmaatschap ingaat vanaf augustus en vóór februari (septemberinstroom)
                if ($now->month < 2) {
                    $begin = $now->subYear();
                    $begin = $begin->month(8)->firstOfMonth();
                } else {
                    $begin = $now->month(8)->firstOfMonth();
                }
                return $begin;
            } else {
                // Februari-instroom
                $begin = $now->month(2)->firstOfMonth();
                return $begin;
            }
        }

        /**
         * @param null $now
         *
         * @return Carbon
         */
        public static function calculateFiscalYearEnd($now = null) {
            $now = $now ?? Carbon::now();
            if ($now->month < 2 || $now->month > 7) {
                // Als het lidmaatschap eindigt op 31 juli
                if ($now->month < 2) {
                    $begin = $now->month(7)->lastOfMonth();
                } else {
                    $begin = $now->addYear();
                    $begin = $begin->month(7)->lastOfMonth();
                }
                return $begin;
            } else {
                // als het lidmaatschap eindigt in februari
                $begin = $now->addYear();
                $begin = $begin->month(1)->endOfMonth();
                return $begin;
            }
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function member() {
            return $this->belongsTo(Member::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function year() {
            return $this->belongsTo(Year::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function transaction() {
            return $this->belongsTo(Transaction::class);
        }

    }
