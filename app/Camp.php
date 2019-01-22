<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    /**
 * Class Camp
 *
 * @package App
 * @property int                                                                     $id
 * @property int                                                                     $year_id
 * @property string                                                                  $signup_open
 * @property string                                                                  $signup_close
 * @property \Carbon\Carbon|null                                                     $created_at
 * @property \Carbon\Carbon|null                                                     $updated_at
 * @property float                                                                   $price
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereSignupClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereSignupOpen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Camp whereYearId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CampingApplication[] $applications
 * @property-read \App\Year                                                          $year
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Camp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Camp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Camp query()
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
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function applications() {
            return $this->hasMany(CampingApplication::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function year() {
            return $this->belongsTo(Year::class);
        }
    }
