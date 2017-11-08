<?php

    namespace App;

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
         * @property string              $birthday
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
         */
        class MemberApplication extends Model {
            //
        }
