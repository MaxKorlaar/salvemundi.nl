<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\CreateMember;
    use App\Http\Requests\Admin\UpdateMember;
    use App\Member;
    use App\MemberApplication;
    use App\Membership;
    use App\Year;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Log;

    /**
     * Class MemberController
     *
     * @package App\Http\Controllers\Admin
     */
    class MemberController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
        }


        /**
         * @return array
         */
        public function applicationsToMembers() {
            $applications = MemberApplication::all();
            $members      = [];
            $applications->each(function (MemberApplication $application) use (&$members) {
                $member                  = Member::createFromApplication($application);
                $membership              = Membership::createNewMembership();
                $membership->valid_from  = Carbon::createFromDate(2017, 8, 1);
                $membership->valid_until = Carbon::createFromDate(2018, 7, 31);

                $membership->year_id = Year::getCurrentYear()->id;
                $member->memberships()->save($membership);
                Log::debug("Member aangemaakt vanuit bestaande aanmelding", [$member]);
                $application->delete(false); // Aanmelding verwijderen, afbeelding behouden
                $members[] = $member;
            });

            return [
                $applications, $members
            ];
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index() {
            return view('admin.members.index', [
                'members' => Member::with(['memberships'])->orderBy('member_id')->get()
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create() {
            return view('admin.members.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateMember $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function store(CreateMember $request) {

            $member = new Member($request->all());
            if (!$request->has('member_id')) {
                $member->member_id = Year::getCurrentYear()->getNewMemberID();
            }
            $picture  = $request->file('picture');
            $filename = $request->get('pcn') . '-' . time() . '.' . $picture->extension();
            $picture->storeAs('member_photos', $filename);
            $member->picture_name       = $filename;
            $member->ip_address         = $request->ip();
            $member->transaction_status = 'onbekend';
            $member->transaction_amount = 0;
            $member->transaction_id     = 'n.v.t.';
            $member->saveOrFail();
            return redirect()->route('admin.members.show', ['member' => $member]);
        }

        /**
         * Display the specified resource.
         *
         * @param Member $leden
         *
         * @return \Illuminate\Http\Response
         */
        public function show(Member $leden) {
            return view('admin.members.show', ['member' => $leden]);
        }

        /**
         * @param Member $member
         *
         * @return mixed
         */
        public function getPicture(Member $member) {
            return $member->getPicture();
        }


        /**
         * Show the form for editing the specified resource.
         *
         * @param Member $leden
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function edit(Member $leden) {
            return view('admin.members.edit', ['member' => $leden]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateMember $request
         * @param Member       $leden
         *
         * @return \Illuminate\Http\Response
         * @throws \Throwable
         */
        public function update(UpdateMember $request, Member $leden) {
            $leden->update($request->all());
            if ($request->hasFile('picture')) {
                $leden->deletePicture();
                $picture  = $request->file('picture');
                $filename = $request->get('pcn') . '-' . time() . '.' . $picture->extension();
                $picture->storeAs('member_photos', $filename);
                $leden->picture_name = $filename;
                $leden->saveOrFail();
            }
            return back()->with('success', trans('admin.members.edit.updated'));
        }

        /**
         * @param Member $member
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         */
        public function getDeleteConfirmation(Member $member) {
            if ($member->isCurrentlyMember()) {
                return back();
            }
            return view('admin.members.delete', ['member' => $member]);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param Member $leden
         *
         * @return \Illuminate\Http\Response
         * @throws \Exception
         */
        public function destroy(Member $leden) {
            if ($leden->isCurrentlyMember()) {
                return back();
            }
            $leden->delete();
            return redirect()->route('admin.members.index')->with('success', trans('admin.members.delete.deleted'));
        }
    }
