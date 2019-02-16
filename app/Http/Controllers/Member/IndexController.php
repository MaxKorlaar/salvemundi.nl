<?php

    namespace App\Http\Controllers\Member;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Member\UpdateOwnInfo;
    use App\Member;
    use App\Membership;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\View\View;

    /**
     * Class IndexController
     *
     * @package App\Http\Controllers\Member
     */
    class IndexController extends Controller {


        /**
         * @return Factory|View
         */
        public function getAboutView() {
            $user   = Auth::user();
            $member = $user->member;
            if ($member->country === null) {
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
        public static function getOwnPhoto() {
            $member = Auth::user()->member;
            return $member->getResizedCachedImage(400, null, true)->response();
        }

        /**
         * @param UpdateOwnInfo $request
         *
         * @return RedirectResponse
         */
        public function updateOwnInfo(UpdateOwnInfo $request) {
            $member = Auth::user()->member;
            if ($request->has('country') && $member->country === null) {
                $member->update(['country' => $request->get('country')]);
            }
            return redirect()->route('member.about_me');
        }

        /**
         * @return Factory|View
         */
        public static function getUpdatePage() {
            $user   = Auth::user();
            $member = $user->member;
            return view('member.update', [
                'user'   => $user,
                'member' => $member
            ]);
        }


    }
