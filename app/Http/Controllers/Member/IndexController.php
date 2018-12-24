<?php

    namespace App\Http\Controllers\Member;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Member\UpdateOwnInfo;
    use App\Membership;
    use Illuminate\Support\Facades\Auth;
    use Intervention\Image\Constraint;

    /**
     * Class IndexController
     *
     * @package App\Http\Controllers\Member
     */
    class IndexController extends Controller {


        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getAboutView() {
            $user = Auth::user();
            $member = $user->member;
            if($member->country === null) {
                return redirect()->route('member.update_info');
            }

            return view('member.index', [
                'user'       => $user,
                'member'     => $member,
                'year_from'  => Membership::calculateFiscalYearStart(),
                'year_until' => Membership::calculateFiscalYearEnd()
            ]);
        }

        /**
         * @return mixed
         */
        public function getOwnPhoto() {
            $member = Auth::user()->member;
            return $member->getResizedCachedImage(400, null, true)->response();
        }

        /**
         * @param UpdateOwnInfo $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function updateOwnInfo(UpdateOwnInfo $request) {
            $member = Auth::user()->member;
            if($request->has('country') && $member->country === null) {
                $member->update(['country' => $request->get('country')]);
            }
            return redirect()->route('member.about_me');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getUpdatePage() {
            $user   = Auth::user();
            $member = $user->member;
            return view('member.update', [
                'user'       => $user,
                'member'     => $member
            ]);
        }



    }
