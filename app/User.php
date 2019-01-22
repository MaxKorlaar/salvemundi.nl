<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use App\Store\Order;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    /**
 * App\User
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $name
 * @property string                                                                                                         $email
 * @property string                                                                                                         $password
 * @property string|null                                                                                                    $remember_token
 * @property \Carbon\Carbon|null                                                                                            $created_at
 * @property \Carbon\Carbon|null                                                                                            $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string                                                                                                         $username
 * @property string                                                                                                         $family_name
 * @property string                                                                                                         $given_name
 * @property string                                                                                                         $official_name
 * @method static Builder|User whereFamilyName($value)
 * @method static Builder|User whereGivenName($value)
 * @method static Builder|User whereOfficialName($value)
 * @method static Builder|User whereUsername($value)
 * @property int|null                                                                                                       $member_id
 * @method static Builder|User whereMemberId($value)
 * @property string|null                                                                                                    $rank
 * @property-read \App\Member|null                                                                                          $member
 * @method static Builder|User whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Store\Order[] $orders
 */
    class User extends Authenticatable {
        use Notifiable, HasEncryptedAttributes;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'email', 'password',
        ];

        protected $encrypted = ['email', 'family_name', 'given_name', 'official_name'];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token',
        ];

        /**
         * @param Member $member
         *
         * @param        $fontysData
         *
         * @return User
         * @throws \Throwable
         */
        public static function createFromMember(Member $member, $fontysData) {
            $user = new User();
            $user->member()->associate($member);
            $user->updateFontysData($fontysData);
            return $user;
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function member() {
            return $this->belongsTo('App\Member', 'member_id');
        }

        /**
         * @param $fontysData
         *
         * @throws \Throwable
         */
        public function updateFontysData($fontysData) {
            $this->username      = $fontysData->preferred_username;
            $this->email         = $fontysData->email;
            $this->family_name   = $fontysData->family_name;
            $this->given_name    = $fontysData->given_name;
            $this->official_name = $fontysData->name;
            $this->saveOrFail();
        }

        /**
         * @return bool
         */
        public function isAdministrationMember() {
            return $this->rank === 'admin';
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function orders() {
            return $this->hasMany(Order::class);
        }
    }
