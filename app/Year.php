<?php

    namespace App;

    use Carbon\Carbon;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Throwable;

    /**
     * App\Year
     *
     * @mixin Eloquent
     * @property int         $id
     * @property int         $year
     * @property int         $last_member_id
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @method static Builder|Year whereCreatedAt($value)
     * @method static Builder|Year whereId($value)
     * @method static Builder|Year whereLastMemberId($value)
     * @method static Builder|Year whereUpdatedAt($value)
     * @method static Builder|Year whereYear($value)
     * @method static Builder|Year newModelQuery()
     * @method static Builder|Year newQuery()
     * @method static Builder|Year query()
     */
    class Year extends Model {
        //
        /**
         * @throws Throwable
         */
        public static function getCurrentYear() {
            $currentYear = Carbon::now()->year;
            return self::getYear($currentYear);
        }

        /**
         * @param $requestedYear
         *
         * @return Year|Model|null
         * @throws Throwable
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
         * @throws Throwable
         */
        public function getNewMemberID() {
            return substr($this->year, -2) . sprintf('%03d', $this->incrementMemberID());
        }

        /**
         * @throws Throwable
         */
        public function incrementMemberID() {
            $this->last_member_id++;
            $this->saveOrFail();
            return $this->last_member_id;
        }
    }
