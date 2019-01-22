<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    /**
 * Class Introduction
 *
 * @package App
 * @property int                                                                   $id
 * @property int                                                                   $year_id
 * @property string                                                                $reservations_open
 * @property string                                                                $signup_open
 * @property string                                                                $signup_close
 * @property string|null                                                           $mail_reservations_at
 * @property \Illuminate\Support\Carbon|null                                       $created_at
 * @property \Illuminate\Support\Carbon|null                                       $updated_at
 * @property float                                                                 $price
 * @property int                                                                   $max_signups
 * @property int                                                                   $allow_reservations_after_limit
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IntroApplication[] $applications
 * @property-read \App\Year                                                        $year
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereAllowReservationsAfterLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereMailReservationsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereMaxSignups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereReservationsOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereSignupClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereSignupOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Introduction whereYearId($value)
 * @mixin \Eloquent
 */
    class Introduction extends Model {
        public $fillable = ['year_id', 'reservations_open', 'signup_open', 'signup_close', 'price', 'max_signups', 'allow_reservations_after_limit'];


        /**
         * @return Introduction
         * @throws \Throwable
         */
        public static function getIntroductionForCurrentYear() {
            return self::where('year_id', Year::getCurrentYear()->id)->first();
        }

        /**
         * @return Introduction|Model|object|null
         */
        public static function getIntroductionWithOpenSignup() {
            return self::where('reservations_open', '<', Carbon::now())
                ->where('signup_close', '>', Carbon::now())->first();
        }

        /**
         * @return bool
         */
        public function reservationsAreOpen() {
            return $this->reservations_open < Carbon::now() && $this->signup_close > Carbon::now();
        }

        /**
         * @return bool
         */
        public function signupsAreOpen() {
            return $this->signup_open < Carbon::now() && $this->signup_close > Carbon::now();
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function applications() {
            return $this->hasMany(IntroApplication::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function year() {
            return $this->belongsTo(Year::class);
        }
    }
