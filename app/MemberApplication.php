<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use Carbon\Carbon;
    use Eloquent;
    use Exception;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Intervention\Image\Facades\Image;
    use InvalidArgumentException;
    use Storage;

    /**
     * Class MemberApplication
     *
     * @package App
     * @property int         $id
     * @property string      $pcn
     * @property string      $first_name
     * @property string      $address
     * @property string      $city
     * @property string      $postal
     * @property Carbon      $birthday
     * @property string      $phone
     * @property string      $email
     * @property string      $status
     * @property string      $ip_address
     * @property string|null $email_confirmation_token
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property string      $picture_name
     * @property string      $last_name
     * @property string      $transaction_id
     * @property string      $transaction_status
     * @property float       $transaction_amount
     * @method static Builder|MemberApplication whereAddress($value)
     * @method static Builder|MemberApplication whereBirthday($value)
     * @method static Builder|MemberApplication whereCity($value)
     * @method static Builder|MemberApplication whereCreatedAt($value)
     * @method static Builder|MemberApplication whereEmail($value)
     * @method static Builder|MemberApplication whereEmailConfirmationToken($value)
     * @method static Builder|MemberApplication whereFirstName($value)
     * @method static Builder|MemberApplication whereId($value)
     * @method static Builder|MemberApplication whereIpAddress($value)
     * @method static Builder|MemberApplication whereLastName($value)
     * @method static Builder|MemberApplication wherePcn($value)
     * @method static Builder|MemberApplication wherePhone($value)
     * @method static Builder|MemberApplication wherePictureName($value)
     * @method static Builder|MemberApplication wherePostal($value)
     * @method static Builder|MemberApplication whereStatus($value)
     * @method static Builder|MemberApplication whereTransactionAmount($value)
     * @method static Builder|MemberApplication whereTransactionId($value)
     * @method static Builder|MemberApplication whereTransactionStatus($value)
     * @method static Builder|MemberApplication whereUpdatedAt($value)
     * @mixin Eloquent
     * @method static Builder|MemberApplication newModelQuery()
     * @method static Builder|MemberApplication newQuery()
     * @method static Builder|MemberApplication query()
     * @property string|null $country
     * @method static Builder|MemberApplication whereCountry($value)
     */
    class MemberApplication extends Model {

        use HasEncryptedAttributes;
        /**
         * Status is een enum. (['approved', 'on_hold', 'new', 'denied', 'under_review', 'blocked', 'email_unconfirmed'])
         * Blocked houdt in dat de PCN, het telefoonnummer en het email adres geblokkeerd worden bij nieuwe inschrijvingen
         */

        const STATUS_APPROVED = 'approved', STATUS_REFUNDED = 'on_hold',
            STATUS_NEW = 'new', STATUS_DENIED = 'denied',
            STATUS_UNDER_REVIEW = 'under_review', STATUS_BLOCKED = 'blocked',
            STATUS_EMAIL_UNCONFIRMED = 'email_unconfirmed';
        public $fillable = ['pcn', 'first_name', 'last_name', 'address', 'city', 'postal', 'country', 'birthday', 'phone', 'email'];
        protected $encrypted = ['pcn', 'first_name', 'last_name', 'address', 'city', 'postal', 'country', 'phone', 'email', 'ip_address', 'picture_name'];
        protected $attributes = [
            'status' => self::STATUS_EMAIL_UNCONFIRMED
        ];
        protected $casts = [
            'birthday' => 'date'
        ];

        protected $dates = [
            'birthday'
        ];

        /**
         * @param $birthday
         *
         * @return Carbon
         */
        public function setBirthdayAttribute($birthday) {
            try {
                return $this->attributes['birthday'] = Carbon::createFromTimestamp(strtotime($birthday));
            } catch (InvalidArgumentException $exception) {
                return $this->attributes['birthday'] = null;
            }
        }


        /**
         * Save the model to the database.
         *
         * @param array $options
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
            return Image::make($this->getImagePath())->response();
        }

        /**
         * @return string
         */
        public function getImagePath() {
            return storage_path('app/member_photos/' . $this->picture_name);
        }

        /**
         * @param bool $picture
         *
         * @return bool|null
         * @throws Exception
         */
        public function delete($picture = true) {
            if ($picture) {
                if (!Storage::delete('member_photos/' . $this->picture_name)) {
                    throw new Exception("Kon pasfoto niet verwijderen bij het verwijderen van een MemberApplication");
                }
            }

            return parent::delete();
        }
    }
