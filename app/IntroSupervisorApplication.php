<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use Illuminate\Database\Eloquent\Model;

    /**
     * Class IntroSupervisorApplication
     *
     * @package App
     * @property int                             $id
     * @property string                          $member_id
     * @property string                          $age_at_intro
     * @property string                          $shirt_size
     * @property string|null                     $preferred_partner_id
     * @property string                          $route_type
     * @property bool                            $remain_sober
     * @property bool                            $drivers_license
     * @property bool                            $first_aid_license
     * @property bool                            $company_first_response_license
     * @property string|null                     $remarks
     * @property string                          $ip_address
     * @property string|null                     $email_confirmation_token
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null                        $introduction_id
     * @property string                          $status
     * @property string|null                     $type
     * @property-read \App\Introduction|null     $introduction
     * @property-read \App\Member                $member
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication query()
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereAgeAtIntro($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereCompanyFirstResponseLicense($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereDriversLicense($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereEmailConfirmationToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereFirstAidLicense($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereIntroductionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereIpAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereMemberId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication wherePreferredPartnerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereRemainSober($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereRemarks($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereRouteType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereShirtSize($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|IntroSupervisorApplication whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    class IntroSupervisorApplication extends Model {
        use HasEncryptedAttributes;
        const STATUS_SIGNED_UP = 'signed_up',
            STATUS_EMAIL_UNCONFIRMED = 'email_unconfirmed';
        const TYPE_SIGNUP = 'signup', TYPE_ANONYMISED = 'anonymised';
        public $fillable = ['age_at_intro', 'shirt_size', 'route_type', 'preferred_partner_id', 'remain_sober',
                            'drivers_license', 'first_aid_license', 'company_first_response_license', 'remarks'];
        protected $encrypted = ['age_at_intro', 'shirt_size', 'ip_address', 'remarks'];
        protected $attributes = [
            'status' => self::STATUS_EMAIL_UNCONFIRMED
        ];
        protected $casts = [
            'remain_sober'                   => 'boolean',
            'drivers_license'                => 'boolean',
            'first_aid_license'              => 'boolean',
            'company_first_response_license' => 'boolean',
        ];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function introduction() {
            return $this->belongsTo(Introduction::class);
        }

        /**
         * @return bool
         * @throws \Throwable
         */
        public function anonymise() {
            $this->type = self::TYPE_ANONYMISED;
            $this->member()->dissociate();
            $anonymiseFields = [
                'preferred_partner_id', 'remarks', 'ip_address'
            ];
            foreach ($anonymiseFields as $field) {
                $this[$field] = '***';
            }
            return $this->saveOrFail();
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function member() {
            return $this->belongsTo(Member::class);
        }

        /**
         * @return bool
         */
        public function isAnonymised() {
            return $this->type === self::TYPE_ANONYMISED;
        }

    }
