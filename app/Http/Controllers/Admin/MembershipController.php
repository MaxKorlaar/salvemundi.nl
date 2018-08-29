<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\CreateMembershipRequest;
    use App\Member;
    use App\Membership;
    use App\Year;
    use Illuminate\Http\Request;

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
         * @return \Illuminate\Http\Response
         */
        public function index(Member $leden) {
            return redirect()->route('admin.members.show', [$leden]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @param Member $leden
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function create(Member $leden) {
            return view('admin.memberships.create', [
                'member' => $leden,
                'valid_from' => Membership::calculateFiscalYearStart(),
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
         * @return \Illuminate\Http\Response
         * @throws \Throwable
         */
        public function store(CreateMembershipRequest $request, Member $leden) {
            $membership = new Membership($request->all());
            $membership->year_id        = Year::getCurrentYear()->id;
            $leden->memberships()->save($membership);
            return redirect()->route('admin.members.show', [$leden])->with('success', trans('admin.memberships.create.created'));
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function show($id) {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function edit($id) {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int                      $id
         *
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id) {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return \Illuminate\Http\Response
         */
        public function destroy($id) {
            //
        }
    }
