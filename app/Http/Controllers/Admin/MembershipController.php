<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\CreateMembershipRequest;
    use App\Member;
    use App\Membership;
    use App\Year;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\View\View;
    use Throwable;

    /**
     * Class MembershipController
     *
     * @package App\Http\Controllers\Admin
     */
    class MembershipController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
        }

        /**
         * Display a listing of the resource.
         *
         * @param Member $leden
         *
         * @return Response
         */
        public function index(Member $leden) {
            return redirect()->route('admin.members.show', [$leden]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @param Member $leden
         *
         * @return Factory|View
         */
        public static function create(Member $leden) {
            return view('admin.memberships.create', [
                'member'      => $leden,
                'valid_from'  => Membership::calculateFiscalYearStart(),
                'valid_until' => Membership::calculateFiscalYearEnd()
            ]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateMembershipRequest $request
         *
         * @param Member                  $leden
         *
         * @return Response
         * @throws Throwable
         */
        public function store(CreateMembershipRequest $request, Member $leden) {
            $membership          = new Membership($request->all());
            $membership->year_id = Year::getCurrentYear()->id;
            $leden->memberships()->save($membership);
            return redirect()->route('admin.members.show', [$leden])->with('success', trans('admin.memberships.create.created'));
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return void
         */
        public static function show($id) {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return void
         */
        public static function edit($id) {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         * @param  int     $id
         *
         * @return void
         */
        public static function update(Request $request, $id) {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return void
         */
        public static function destroy($id) {
            //
        }
    }
