<?php

    namespace App;

        use App\Helpers\HasEncryptedAttributes;
        use Illuminate\Database\Eloquent\Model;

        /**
 * Class MemberApplication
 *
 * @package App
 * @mixin \Eloquent
 * @property int                 $id
 * @property int                 $pcn
 * @property string              $name
 * @property string              $address
 * @property string              $city
 * @property string              $postal
 * @property \Carbon\Carbon      $birthday
 * @property string              $phone
 * @property string              $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication wherePcn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereUpdatedAt($value)
 * @property string              $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereStatus($value)
 * @property string              $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereIpAddress($value)
 * @property string              $application_hash
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereApplicationHash($value)
 * @property string $email_confirmation_token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberApplication whereEmailConfirmationToken($value)
 */
        class MemberApplication extends Model {

            use HasEncryptedAttributes;
            protected $encrypted = ['pcn', 'name', 'address', 'city', 'postal', 'phone', 'email', 'ip_address'];

            /**
             * Status is een enum. (['approved', 'on_hold', 'new', 'denied', 'under_review', 'blocked', 'email_unconfirmed'])
             * Blocked houdt in dat de PCN, het telefoonnummer en het email adres geblokkeerd worden bij nieuwe inschrijvingen
             */

            const STATUS_APPROVED = 'approved', STATUS_ON_HOLD = 'on_hold',
                STATUS_NEW = 'new', STATUS_DENIED = 'denied',
                STATUS_UNDER_REVIEW = 'under_review', STATUS_BLOCKED = 'blocked',
                STATUS_EMAIL_UNCONFIRMED = 'email_unconfirmed';

            public $fillable = ['pcn', 'name', 'address', 'city', 'postal', 'birthday', 'phone', 'email'];
            protected $attributes = [
                'status' => self::STATUS_EMAIL_UNCONFIRMED
            ];
            protected $casts = [
                'birthday' => 'date',
                'pcn'      => 'integer'
            ];

            /**
             * Save the model to the database.
             *
             * @param  array $options
             *
             * @return bool
             */
            public function save(array $options = []) {
                $this->application_hash = $this->getApplicationHash();
                return parent::save($options);
            }

            /**
             * @return int
             */
            public function getApplicationHash() {
                return crc32($this->pcn);
            }
        }
