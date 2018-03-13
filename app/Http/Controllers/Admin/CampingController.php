<?php

    namespace App\Http\Controllers\Admin;

    use App\CampingApplication;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    /**
     * Class CampingController
     *
     * @package App\Http\Controllers\Admin
     */
    class CampingController extends Controller {
        /**
         * @param Request $request
         *
         * @return array
         */
        public function getSignups(Request $request) {
            abort(404);
            $return = [];
            CampingApplication::each(function (CampingApplication $application) use (&$return) {
                $return[] = [
                    trans('camping.signup.id')                 => $application->id,
                    trans('camping.signup.member_id')          => $application->member_id,
                    trans('camping.signup.first_name')         => $application->first_name,
                    trans('camping.signup.last_name')          => $application->last_name,
                    trans('camping.signup.phone')              => $application->phone,
                    trans('camping.signup.email')              => $application->email,
                    trans('camping.signup.address')            => $application->address,
                    trans('camping.signup.city')               => $application->city,
                    trans('camping.signup.postal')             => $application->postal,
                    trans('camping.signup.birthday')           => $application->birthday->format(trans('datetime.format.date')),
                    trans('camping.signup.remarks')            => $application->remarks,
                    trans('camping.signup.transaction_id')     => $application->transaction_id,
                    trans('camping.signup.transaction_url') => config('mollie.transaction_url') . $application->transaction_id,
                    trans('camping.signup.transaction_status') => $application->transaction_status,
                    trans('camping.signup.transaction_amount') => $application->transaction_amount,
                    //                   trans('camping.signup.status') => $application->status,
                    trans('camping.signup.created_at')         => $application->created_at->format(trans('datetime.format.date_and_time')),
                    trans('camping.signup.updated_at')         => $application->updated_at->format(trans('datetime.format.date_and_time'))
                ];
            });
            return $return;
        }
    }
