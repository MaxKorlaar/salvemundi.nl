<?php

    namespace App;

    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * Class Camp
     *
     * @package App
     * @property int                                  $id
     * @property int                                  $year_id
     * @property string                               $signup_open
     * @property string                               $signup_close
     * @property Carbon|null                          $created_at
     * @property Carbon|null                          $updated_at
     * @property float                                $price
     * @method static Builder|Camp whereCreatedAt($value)
     * @method static Builder|Camp whereId($value)
     * @method static Builder|Camp wherePrice($value)
     * @method static Builder|Camp whereSignupClose($value)
     * @method static Builder|Camp whereSignupOpen($value)
     * @method static Builder|Camp whereUpdatedAt($value)
     * @method static Builder|Camp whereYearId($value)
     * @mixin Eloquent
     * @property-read Collection|CampingApplication[] $applications
     * @property-read Year                            $year
     * @method static Builder|Camp newModelQuery()
     * @method static Builder|Camp newQuery()
     * @method static Builder|Camp query()
     */
    class Camp extends Model {
        public $fillable = ['year_id', 'signup_open', 'signup_close', 'price'];

        /**
         * @return Camp
         */
        public static function getCampWithOpenSignup() {
            return self::where('signup_open', '<', Carbon::now())
                ->where('signup_close', '>', Carbon::now())->first();
        }

        /**
         * @return HasMany
         */
        public function applications() {
            return $this->hasMany(CampingApplication::class);
        }

        /**
         * @return BelongsTo
         */
        public function year() {
            return $this->belongsTo(Year::class);
        }
    }
