<?php

    namespace App;

    use App\Helpers\HasEncryptedAttributes;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    /**
 * Class IntroSupervisorApplication
 *
 * @package App
 * @property int                 $id
 * @property string              $member_id
 * @property string              $first_name
 * @property string              $last_name
 * @property string              $phone
 * @property string              $email
 * @property string              $age_at_intro
 * @property string              $shirt_size
 * @property string              $preferred_partner_id
 * @property int                 $remain_sober
 * @property int                 $drivers_license
 * @property int                 $first_aid_license
 * @property int                 $company_first_response_license
 * @property string|null         $remarks
 * @property string              $status
 * @property string              $ip_address
 * @property string|null         $email_confirmation_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-write mixed         $birthday
 * @method static Builder|IntroSupervisorApplication whereAgeAtIntro($value)
 * @method static Builder|IntroSupervisorApplication whereCompanyFirstResponseLicense($value)
 * @method static Builder|IntroSupervisorApplication whereCreatedAt($value)
 * @method static Builder|IntroSupervisorApplication whereDriversLicense($value)
 * @method static Builder|IntroSupervisorApplication whereEmail($value)
 * @method static Builder|IntroSupervisorApplication whereEmailConfirmationToken($value)
 * @method static Builder|IntroSupervisorApplication whereFirstAidLicense($value)
 * @method static Builder|IntroSupervisorApplication whereFirstName($value)
 * @method static Builder|IntroSupervisorApplication whereId($value)
 * @method static Builder|IntroSupervisorApplication whereIpAddress($value)
 * @method static Builder|IntroSupervisorApplication whereLastName($value)
 * @method static Builder|IntroSupervisorApplication whereMemberId($value)
 * @method static Builder|IntroSupervisorApplication wherePhone($value)
 * @method static Builder|IntroSupervisorApplication wherePreferredPartnerId($value)
 * @method static Builder|IntroSupervisorApplication whereRemainSober($value)
 * @method static Builder|IntroSupervisorApplication whereRemarks($value)
 * @method static Builder|IntroSupervisorApplication whereShirtSize($value)
 * @method static Builder|IntroSupervisorApplication whereStatus($value)
 * @method static Builder|IntroSupervisorApplication whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $route_type
 * @method static Builder|IntroSupervisorApplication whereRouteType($value)
 */
    class IntroSupervisorApplication extends Model {
        use HasEncryptedAttributes;
        const STATUS_APPROVED = 'approved', STATUS_ON_HOLD = 'on_hold',
            STATUS_NEW = 'new', STATUS_DENIED = 'denied',
            STATUS_UNDER_REVIEW = 'under_review', STATUS_BLOCKED = 'blocked',
            STATUS_EMAIL_UNCONFIRMED = 'email_unconfirmed';
        public $fillable = ['member_id', 'first_name', 'last_name', 'phone', 'email', 'age_at_intro', 'shirt_size', 'route_type', 'preferred_partner_id', 'remain_sober',
                            'drivers_license', 'first_aid_license', 'company_first_response_license', 'remarks'];
        protected $encrypted = ['first_name', 'last_name', 'phone', 'email', 'age_at_intro', 'shirt_size', 'ip_address', 'remarks'];
        protected $attributes = [
            'status' => self::STATUS_EMAIL_UNCONFIRMED
        ];
        protected $casts = [
            'birthday'                       => 'date',
            'remain_sober'                   => 'boolean',
            'drivers_license'                => 'boolean',
            'first_aid_license'              => 'boolean',
            'company_first_response_license' => 'boolean',
        ];

        protected $dates = [
            'birthday'
        ];

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
    }
