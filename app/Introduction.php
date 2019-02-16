<?php

    namespace App;

    use Carbon\Carbon;
    use Eloquent;
    use Exception;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;
    use Throwable;

    /**
     * Class Introduction
     *
     * @package App
     * @property int                                                                             $id
     * @property int                                                                             $year_id
     * @property string                                                                          $reservations_open
     * @property string                                                                          $signup_open
     * @property string                                                                          $signup_close
     * @property string|null                        $mail_reservations_at
     * @property \Illuminate\Support\Carbon|null    $created_at
     * @property \Illuminate\Support\Carbon|null    $updated_at
     * @property float                              $price
     * @property int                                $max_signups
     * @property int                                $allow_reservations_after_limit
     * @property-read Collection|IntroApplication[] $applications
     * @property-read Year                          $year
     * @method static Builder|Introduction newModelQuery()
     * @method static Builder|Introduction newQuery()
     * @method static Builder|Introduction query()
     * @method static Builder|Introduction whereAllowReservationsAfterLimit($value)
     * @method static Builder|Introduction whereCreatedAt($value)
     * @method static Builder|Introduction whereId($value)
     * @method static Builder|Introduction whereMailReservationsAt($value)
     * @method static Builder|Introduction whereMaxSignups($value)
     * @method static Builder|Introduction wherePrice($value)
     * @method static Builder|Introduction whereReservationsOpen($value)
     * @method static Builder|Introduction whereSignupClose($value)
     * @method static Builder|Introduction whereSignupOpen($value)
     * @method static Builder|Introduction whereUpdatedAt($value)
     * @method static Builder|Introduction whereYearId($value)
     * @mixin Eloquent
     * @property-read Collection|IntroSupervisorApplication[] $supervisorApplications
     */
    class Introduction extends Model {
        public $fillable = ['year_id', 'reservations_open', 'signup_open', 'signup_close', 'price', 'max_signups', 'allow_reservations_after_limit'];

        public $casts = [
            'allow_reservations_after_limit' => 'boolean'
        ];

        /**
         * @return Introduction
         * @throws Throwable
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
         * @return BelongsTo
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
         * @return HasMany
         */
        public function applications() {
            return $this->hasMany(IntroApplication::class);
        }

        /**
         * @return HasMany
         */
        public function supervisorApplications() {
            return $this->hasMany(IntroSupervisorApplication::class);
        }

        /**
         * @return bool
         */
        public function allowSignups() {
            return $this->getOpenSpots() > 0;
        }

        /**
         * @return int|null
         */
        public function getOpenSpots() {
            if ($this->max_signups === null) return null;
            return $this->max_signups - $this->getSignups();
        }

        /**
         * @return int
         */
        public function getSignups() {
            return $this->applications()->where('status', IntroApplication::STATUS_PAID)
                ->orWhere('status', IntroApplication::STATUS_SEE_TRANSACTION)->count();
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
         * @throws Exception
         */
        public function delete() {
            foreach ($this->applications as $application) {
                if (!$application->delete()) {
                    throw new Exception("Een of meerdere intro-aanmeldingen konden niet verwijderd worden");
                }
            }
            foreach ($this->supervisorApplications as $application) {
                if (!$application->delete()) {
                    throw new Exception("Een of meerdere intro-ouder-aanmeldingen konden niet verwijderd worden");
                }
            }
            return parent::delete();
        }

        /**
         * @return array
         */
        public function getApplicationsJSON() {
            $jsonApplications = [];
            $this->applications->each(function ($item) use (&$jsonApplications) {
                /** @var IntroApplication $item */
                $jsonApplications[] = $item->getJSON();
            });
            return $jsonApplications;
        }
    }
