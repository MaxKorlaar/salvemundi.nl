<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use Eloquent;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Support\Carbon;
    use Throwable;

    /**
     * App\IntroSupervisorApplication
     *
     * @property int                             $id
     * @property int|null                        $member_id
     * @property string                          $age_at_intro
     * @property string                          $shirt_size
     * @property string|null                     $preferred_partner_id
     * @property string                          $route_type
     * @property bool                            $remain_sober
     * @property bool                            $drivers_license
     * @property string                          $first_aid_license
     * @property string                          $company_first_response_license
     * @property string|null                     $remarks
     * @property string                          $ip_address
     * @property string|null                     $email_confirmation_token
     * @property Carbon|null $created_at
     * @property Carbon|null $updated_at
     * @property int|null                        $introduction_id
     * @property string                          $status
     * @property string|null                     $type
     * @property string                          $motivation
     * @property string                          $previously_participated_as
     * @property string                          $active_in_association
     * @property-read Introduction|null          $introduction
     * @property-read Member|null                $member
     * @method static Builder|IntroSupervisorApplication newModelQuery()
     * @method static Builder|IntroSupervisorApplication newQuery()
     * @method static Builder|IntroSupervisorApplication query()
     * @method static Builder|IntroSupervisorApplication whereActiveInAssociation($value)
     * @method static Builder|IntroSupervisorApplication whereAgeAtIntro($value)
     * @method static Builder|IntroSupervisorApplication whereCompanyFirstResponseLicense($value)
     * @method static Builder|IntroSupervisorApplication whereCreatedAt($value)
     * @method static Builder|IntroSupervisorApplication whereDriversLicense($value)
     * @method static Builder|IntroSupervisorApplication whereEmailConfirmationToken($value)
     * @method static Builder|IntroSupervisorApplication whereFirstAidLicense($value)
     * @method static Builder|IntroSupervisorApplication whereId($value)
     * @method static Builder|IntroSupervisorApplication whereIntroductionId($value)
     * @method static Builder|IntroSupervisorApplication whereIpAddress($value)
     * @method static Builder|IntroSupervisorApplication whereMemberId($value)
     * @method static Builder|IntroSupervisorApplication whereMotivation($value)
     * @method static Builder|IntroSupervisorApplication wherePreferredPartnerId($value)
     * @method static Builder|IntroSupervisorApplication wherePreviouslyParticipatedAs($value)
     * @method static Builder|IntroSupervisorApplication whereRemainSober($value)
     * @method static Builder|IntroSupervisorApplication whereRemarks($value)
     * @method static Builder|IntroSupervisorApplication whereRouteType($value)
     * @method static Builder|IntroSupervisorApplication whereShirtSize($value)
     * @method static Builder|IntroSupervisorApplication whereStatus($value)
     * @method static Builder|IntroSupervisorApplication whereType($value)
     * @method static Builder|IntroSupervisorApplication whereUpdatedAt($value)
     * @mixin Eloquent
     * @property string                          $gender
     * @method static Builder|IntroSupervisorApplication whereGender($value)
     */
    class IntroSupervisorApplication extends Model {
        use HasEncryptedAttributes;
        const STATUS_SIGNED_UP = 'signed_up',
            STATUS_EMAIL_UNCONFIRMED = 'email_unconfirmed';
        const TYPE_SIGNUP = 'signup', TYPE_ANONYMISED = 'anonymised';
        public $fillable = ['age_at_intro', 'shirt_size', 'route_type', 'preferred_partner_id', 'remain_sober',
                            'drivers_license', 'first_aid_license', 'company_first_response_license', 'remarks',
                            'previously_participated_as', 'motivation', 'active_in_association', 'gender'];
        protected $encrypted = ['age_at_intro', 'shirt_size', 'ip_address', 'remarks', 'motivation', 'gender'];
        protected $attributes = [
            'status' => self::STATUS_EMAIL_UNCONFIRMED
        ];
        protected $casts = [
            'remain_sober'    => 'boolean',
            'drivers_license' => 'boolean'
        ];

        /**
         * @return BelongsTo
         */
        public function introduction() {
            return $this->belongsTo(Introduction::class);
        }

        /**
         * @return bool
         * @throws Throwable
         */
        public function anonymise() {
            $this->type = self::TYPE_ANONYMISED;
            $this->member()->dissociate();
            $anonymiseFields = [
                'preferred_partner_id', 'remarks', 'ip_address', 'motivation'
            ];
            foreach ($anonymiseFields as $field) {
                $this[$field] = '***';
            }
            return $this->saveOrFail();
        }

        /**
         * @return BelongsTo
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
