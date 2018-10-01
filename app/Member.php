<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Carbon;
    use Intervention\Image\Constraint;
    use Intervention\Image\Facades\Image;

    /**
     * Class Member
     *
     * @package App
     * @property int                                                                     $id
     * @property string                                                                  $pcn
     * @property string                                                                  $first_name
     * @property string                                                                  $last_name
     * @property string                                                                  $address
     * @property string                                                                  $city
     * @property string                                                                  $postal
     * @property string                                                                  $birthday
     * @property string                                                                  $phone
     * @property string                                                                  $email
     * @property string|null                                                             $status
     * @property string                                                                  $ip_address
     * @property string                                                                  $picture_name
     * @property string                                                                  $transaction_id
     * @property string                                                                  $transaction_status
     * @property float                                                                   $transaction_amount
     * @property \Carbon\Carbon|null                                                     $created_at
     * @property \Carbon\Carbon|null                                                     $updated_at
     * @method static Builder|Member whereAddress($value)
     * @method static Builder|Member whereBirthday($value)
     * @method static Builder|Member whereCity($value)
     * @method static Builder|Member whereCreatedAt($value)
     * @method static Builder|Member whereEmail($value)
     * @method static Builder|Member whereFirstName($value)
     * @method static Builder|Member whereId($value)
     * @method static Builder|Member whereIpAddress($value)
     * @method static Builder|Member whereLastName($value)
     * @method static Builder|Member wherePcn($value)
     * @method static Builder|Member wherePhone($value)
     * @method static Builder|Member wherePictureName($value)
     * @method static Builder|Member wherePostal($value)
     * @method static Builder|Member whereStatus($value)
     * @method static Builder|Member whereTransactionAmount($value)
     * @method static Builder|Member whereTransactionId($value)
     * @method static Builder|Member whereTransactionStatus($value)
     * @method static Builder|Member whereUpdatedAt($value)
     * @mixin \Eloquent
     * @property string                                                                  $member_id
     * @method static Builder|Member whereMemberId($value)
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[]        $transactions
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Membership[]         $memberships
     * @property-read \App\User                                                          $user
     * @property string                                                                  $card_status
     * @property string|null                                                             $card_id
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereCardId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereCardStatus($value)
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\CampingApplication[] $campingApplications
     */
    class Member extends Model {

        const CARD_UNPROCESSED = 'unprocessed', CARD_PROCESSED = 'processed', CARD_RECEIVED = 'received', CARD_NOT_PICKED_UP = 'not_picked_up', NO_CARD = 'no_card';

        use HasEncryptedAttributes;

        public $fillable = ['pcn', 'member_id', 'first_name', 'last_name', 'address', 'city', 'postal', 'birthday', 'phone', 'email', 'card_status', 'card_id'];
        protected $encrypted = ['first_name', 'last_name', 'address', 'city', 'postal', 'phone', 'email', 'ip_address', 'picture_name'];
        protected $casts = [
            'birthday' => 'date'
        ];

        protected $dates = [
            'birthday'
        ];

        /**
         * @param MemberApplication $application
         *
         * @return Member
         * @throws \Throwable
         */
        public static function createFromApplication(MemberApplication $application) {
            $member                     = new Member();
            $member->created_at         = $application->created_at;
            $member->pcn                = $application->pcn;
            $member->first_name         = $application->first_name;
            $member->last_name          = $application->last_name;
            $member->address            = $application->address;
            $member->city               = $application->city;
            $member->postal             = $application->postal;
            $member->birthday           = $application->birthday;
            $member->phone              = $application->phone;
            $member->email              = $application->email;
            $member->status             = $application->status;
            $member->ip_address         = $application->ip_address;
            $member->picture_name       = $application->picture_name;
            $member->transaction_id     = $application->transaction_id;
            $member->transaction_amount = $application->transaction_amount;
            $member->transaction_status = $application->transaction_status;
            $year                       = Year::getCurrentYear();
            $member->member_id          = $year->getNewMemberID();
            $member->saveOrFail();

            return $member;
        }

        /**
         * @param $birthday
         *
         * @return \Carbon\Carbon
         */
        public function setBirthdayAttribute($birthday) {
            try {
                return $this->attributes['birthday'] = Carbon::createFromTimestamp(strtotime($birthday));

            } catch (\InvalidArgumentException $exception) {
                return $this->attributes['birthday'] = null;
            }
        }

        /**
         * Save the model to the database.
         *
         * @param  array $options
         *
         * @return bool
         */
        public function save(array $options = []) {
            return parent::save($options);
        }

        /**
         * @return mixed
         */
        public function getPicture() {
            return $this->getImageObject()->response();
        }

        /**
         * @return \Intervention\Image\Image
         */
        public function getImageObject() {
            ini_set('memory_limit', '256M');
            return Image::make($this->getImagePath());
        }

        /**
         * @return string
         */
        public function getImagePath() {
            return storage_path('app/member_photos/' . $this->picture_name);
        }

        /**
         * @param      $width
         * @param null $height
         * @param bool $returnObj
         *
         * @return \Image|\Intervention\Image\Image
         */
        public function getResizedCachedImage($width = null, $height = null, $returnObj = false) {
            ini_set('memory_limit', '256M');
            return Image::cache(function ($image) use ($height, $width) {
                /** @var \Intervention\Image\Image $image */
                $image->make($this->getImagePath());
                $image->resize($width, $height, function (Constraint $constraint) {
                    $constraint->aspectRatio();
                });
            }, null, $returnObj);
        }

        /**
         * @param bool $returnObj
         *
         * @return \Image|\Intervention\Image\Image
         */
        public function getCachedImage($returnObj = false) {
            ini_set('memory_limit', '256M');
            return Image::cache(function ($image) {
                /** @var \Intervention\Image\Image $image */
                $image->make($this->getImagePath());
            }, null, $returnObj);
        }

        /**
         * @return bool|null
         * @throws \Exception
         */
        public function delete() {
            $this->deletePicture();
            if ($this->user !== null) {
                $this->user->delete();
            }
            return parent::delete();
        }

        /**
         * @throws \Exception
         */
        public function deletePicture() {

            if (\Storage::exists('member_photos/' . $this->picture_name) && !\Storage::delete('member_photos/' . $this->picture_name)) {
                throw new \Exception("Kon pasfoto niet verwijderen bij het verwijderen van een Member");
            }

        }

        /**
         * @return bool
         */
        public function hasPicture() {
            return \Storage::exists('member_photos/' . $this->picture_name);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasOne
         */
        public function user() {
            return $this->hasOne(User::class);
        }

        /**
         * @return bool
         */
        public function isCurrentlyMember() {
            return $this->memberships()->where('valid_from', '<=', Carbon::today())->where('valid_until', '>=', Carbon::today())->count() > 0;
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function memberships() {
            return $this->hasMany(Membership::class);
        }

        /**
         * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|null
         */
        public function getCurrentMembership() {
            return $this->memberships()->where('valid_from', '<', Carbon::today())->where('valid_until', '>', Carbon::today())->first();
        }

        /**
         * @param \Mollie_API_Object_Payment $molliePayment
         *
         * @return false|Transaction
         */
        public function addTransaction(\Mollie_API_Object_Payment $molliePayment) {
            $transaction = new Transaction([
                'transaction_id'     => $molliePayment->id,
                'transaction_status' => $molliePayment->status,
                'transaction_amount' => $molliePayment->amount
            ]);
            return $this->transactions()->save($transaction);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function transactions() {
            return $this->hasMany(Transaction::class);
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function campingApplications() {
            return $this->hasMany(CampingApplication::class);
        }
    }
