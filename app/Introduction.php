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

        public $casts = [
            'allow_reservations_after_limit' => 'boolean'
        ];

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

        /**
         * @return int
         */
        public function getConfirmedReservationsAndSignups() {
            return $this->applications()->where('status', IntroApplication::STATUS_RESERVED)
                ->orWhere('status', IntroApplication::STATUS_SEE_TRANSACTION)
                ->orWhere('status', IntroApplication::STATUS_PAID)->count();
        }

        /**
         * @return int
         */
        public function getSignups() {
            return $this->applications()->where('status', IntroApplication::STATUS_PAID)
                ->orWhere('status', IntroApplication::STATUS_SEE_TRANSACTION)->count();
        }

        /**
         * @return int|null
         */
        public function getOpenSpots() {
            if ($this->max_signups === null) return null;
            return $this->max_signups - $this->getSignups();
        }

        /**
         * @return bool
         */
        public function allowSignups() {
            return $this->getOpenSpots() > 0;
        }

        /**
         * @return bool
         */
        public function allowReservations() {
            if ($this->getOpenSpots() <= 0) return $this->allow_reservations_after_limit;
            return true;
        }

        /**
         * Check of er alleen maar geanonimiseerde aanmeldingen bij deze introductie horen
         *
         * @return bool
         */
        public function isAnonymised() {
            return $this->applications()->where('type', '!=', IntroApplication::TYPE_ANONYMISED)->count() === 0;
        }

        /**
         * Delete the model from the database.
         *
         * @return bool|null
         *
         * @throws \Exception
         */
        public function delete() {
            foreach ($this->applications as $application) {
                if (!$application->delete()) {
                    throw new \Exception("Een of meerdere intro-aanmeldingen konden niet verwijderd worden");
                }
            }
            return parent::delete();
        }
    }
