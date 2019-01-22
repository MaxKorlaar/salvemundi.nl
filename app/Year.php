<?php

    namespace App;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    /**
 * App\Year
 *
 * @mixin \Eloquent
 * @property int                 $id
 * @property int                 $year
 * @property int                 $last_member_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereLastMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Year whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Year query()
 */
    class Year extends Model {
        //
        /**
         * @throws \Throwable
         */
        public static function getCurrentYear() {
            $currentYear = Carbon::now()->year;
            return self::getYear($currentYear);
        }

        /**
         * @param $year
         *
         * @return Year|Model|null
         * @throws \Throwable
         */
        public static function getYear($requestedYear) {
            $year = Year::where('year', $requestedYear)->first();
            if ($year === null) {
                $year       = new Year();
                $year->year = $requestedYear;
                $year->saveOrFail();
            }
            return $year;
        }

        /**
         * @return string
         * @throws \Throwable
         */
        public function getNewMemberID() {
            return substr($this->year, -2) . sprintf('%03d', $this->incrementMemberID());
        }

        /**
         * @throws \Throwable
         */
        public function incrementMemberID() {
            $this->last_member_id++;
            $this->saveOrFail();
            return $this->last_member_id;
        }
    }
