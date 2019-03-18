<?php

    namespace App\Http\Controllers\Admin;

    use App\Camp;
    use App\CampingApplication;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\CreateCamp;
    use App\Year;
    use Carbon\Carbon;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\View\View;
    use Throwable;

    /**
     * Class CampingController
     *
     * @package App\Http\Controllers\Admin
     */
    class CampingController extends Controller {

        public function __construct() {
            $this->middleware('permission:view camps');
            $this->middleware('permission:edit camps')->only(['create', 'store', 'edit', 'update']);
            $this->middleware('permission:delete camps')->only(['destroy', 'getDeleteConfirmation']);
        }

        /**
         * @return Factory|View
         */
        public static function index() {
            return view('admin.camping.index', [
                'camps' => Camp::with(['year', 'applications'])->get()
            ]);
        }

        /**
         * @return Factory|View
         */
        public function create() {
            return view('admin.camping.create', [
                'years'        => Year::all(),
                'signup_open'  => Carbon::now(),
                'signup_close' => Carbon::now()->addMonth()
            ]);
        }

        /**
         * @param Camp $kamp
         *
         * @return Factory|View
         */
        public static function edit(Camp $kamp) {
            return view('admin.camping.edit', [
                'years' => Year::all(),
                'camp'  => $kamp
            ]);
        }

        /**
         * @param Camp $kamp
         *
         * @return Factory|View
         */
        public static function show(Camp $kamp) {
            return view('admin.camping.show', [
                'camp' => $kamp
            ]);
        }

        /**
         * @param Camp       $kamp
         * @param CreateCamp $request
         *
         * @return RedirectResponse
         */
        public function update(Camp $kamp, CreateCamp $request) {
            $kamp->update($request->all());
            return redirect()->back()->with('success', trans('admin.campings.edit.updated'));
        }

        /**
         * @param CreateCamp $request
         *
         * @return RedirectResponse
         * @throws Throwable
         */
        public function store(CreateCamp $request) {
            $camp = new Camp($request->all());
            $camp->saveOrFail();
            return redirect()->route('admin.camping.show', [$camp])->with('success', trans('admin.campings.create.created'));
        }

        /**
         * @param Request $request
         *
         * @return array
         */
        public static function getSignups(Request $request) {
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
                    trans('camping.signup.transaction_url')    => config('mollie.transaction_url') . $application->transaction_id,
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
