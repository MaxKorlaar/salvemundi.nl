<?php

    namespace App;

    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * App\Membership
     *
     * @mixin Eloquent
     * @property int         $id
     * @property int         $year_id
     * @property int|null    $member_id
     * @property int|null    $transaction_id
     * @property string      $valid_from
     * @property string      $valid_until
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static Builder|Membership whereCreatedAt($value)
     * @method static Builder|Membership whereId($value)
     * @method static Builder|Membership whereMemberId($value)
     * @method static Builder|Membership whereTransactionId($value)
     * @method static Builder|Membership whereUpdatedAt($value)
     * @method static Builder|Membership whereValidFrom($value)
     * @method static Builder|Membership whereValidUntil($value)
     * @method static Builder|Membership whereYearId($value)
     * @property-read Member|null $member
     * @property-read Transaction $transaction
     * @property-read Year        $year
     * @method static Builder|Membership newModelQuery()
     * @method static Builder|Membership newQuery()
     * @method static Builder|Membership query()
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
         * @return BelongsTo
         */
        public function member() {
            return $this->belongsTo(Member::class);
        }

        /**
         * @return BelongsTo
         */
        public function year() {
            return $this->belongsTo(Year::class);
        }

        /**
         * @return BelongsTo
         */
        public function transaction() {
            return $this->belongsTo(Transaction::class);
        }
    }
