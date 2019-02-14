<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\Admin\CreateMember;
    use App\Http\Requests\Admin\ImportMemberListRequest;
    use App\Http\Requests\Admin\SendMailToMembers;
    use App\Http\Requests\Admin\UpdateMember;
    use App\Mail\Blank;
    use App\Member;
    use App\MemberApplication;
    use App\Membership;
    use App\User;
    use App\Year;
    use Auth;
    use Carbon\Carbon;
    use Exception;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Response;
    use Illuminate\Support\Facades\Log;
    use Illuminate\View\View;
    use Mail;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Shared\Date;
    use Throwable;

    /**
     * Class MemberController
     *
     * @package App\Http\Controllers\Admin
     */
    class MemberController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
            $this->middleware('throttle:1,1')->only('sendMail');
            $this->middleware('throttle:1,1')->only('sendInactiveMail');
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
         * @return Factory|View
         */
        public static function showImportForm() {
            return view('admin.members.import');
        }

        /**
         * @param ImportMemberListRequest $request
         *
         * @return RedirectResponse
         * @throws Exception
         * @throws Throwable
         */
        public function importList(ImportMemberListRequest $request) {
            //dd($request->file('member-list'));
            $file = $request->file('member-list');
            if (!$file->isValid()) {
                return back()->withErrors(['member-list' => trans('validation.uploaded', ['attribute' => $file->getClientOriginalName()])]);
            }

            if ($file->getClientOriginalExtension() != 'xls' && $file->getClientOriginalExtension() != 'xlsx') {
                return back()->withErrors(['member-list' => trans('validation.mimes',
                    ['attribute' => $file->getClientOriginalName(), 'values' => 'xls, xlsx']
                )]);
            }
            try {
                $spreadsheet = IOFactory::load($file->getRealPath());
                $sheet       = $spreadsheet->getActiveSheet();

                foreach ($sheet->getRowIterator(2) as $rowNumber => $row) {

                    $cellIterator = $row->getCellIterator();

                    if (($pcn = $cellIterator->seek('J')->current()->getValue()) !== null) {
                        if ($pcn !== '-') {
                            $member = Member::where('pcn', $pcn)->first();
                            if ($member === null) {
                                $member = new Member();
                            }
                        } else {
                            $member = new Member();
                        }

                    } else {
                        $member = new Member();
                    }

                    foreach ($cellIterator as $cell) {
                        if ($cell->getValue() === null && in_array($cell->getColumn(), range('A', 'O'))) {
                            return back()->withErrors(['member-list' => 'Veld leeg, graag \'-\' gebruiken: ' . $cell->getCoordinate()]);
                        }

                        //Lidnummer	Achternaam	Voornaam	Postcode	Straat	Woonplaats	Geboortedatum	MobielNr.	Email	pcn	Foto-Link	Pasje verwerkt	BT Lidnummer 2  Pasje in ontvangst
                        switch ($cell->getColumn()) {
                            case 'A':
                                $member->member_id = $cell->getValue();
                                //                                if ($member->member_id != '-' && Member::where('member_id', $cell->getValue())->count() > 0) {
                                //                                    $member = Member::findOrNew($cell->getValue());
                                //                                    //return back()->withErrors(['member-list' => 'lidnummer bestaat al: ' . $cell->getCoordinate()]);
                                //                                }
                                break;
                            case 'B':
                                $member->last_name = $cell->getValue();
                                break;
                            case 'C':
                                $member->first_name = $cell->getValue();
                                break;
                            case 'D':
                                $member->postal = $cell->getValue();
                                break;
                            case 'E':
                                $member->address = $cell->getValue();
                                break;
                            case 'F':
                                $member->city = $cell->getValue();
                                break;
                            case 'G':
                                $member->birthday = Carbon::createFromTimestamp(Date::excelToTimestamp($cell->getValue()));
                                break;
                            case 'H':
                                $member->phone = $cell->getValue();
                                break;
                            case 'I':
                                $member->email = str_replace(';', '', $cell->getValue());
                                break;
                            case 'J':
                                $member->pcn = $cell->getValue();
                                if ($member->pcn != '-' && false) {//&& Member::where('pcn', $cell->getValue())->count() > 0
                                    //continue 3;
                                    //return back()->withErrors(['member-list' => 'pcn bestaat al: ' . $cell->getCoordinate()]);
                                }
                                break;
                            case 'K':
                                if ($member->picture_name == null) {
                                    $member->picture_name = str_limit(str_replace('LedenFoto\'s\\', '', $cell->getValue()), 25);
                                }
                                // photo url
                                break;
                            case 'L':
                                // Pasje verwerkt
                                if ($cell->getValue() === 'Ja') {
                                    $member->card_status = Member::CARD_PROCESSED;
                                } elseif ($cell->getValue() === 'Nee') {
                                    $member->card_status = Member::CARD_UNPROCESSED;
                                } elseif ($cell->getValue() === 'Hoeft geen pas') {
                                    $member->card_status = Member::NO_CARD;
                                } else {
                                    return back()->withErrors(['member-list' => 'Kaart status ongeldig (' . $cell->getValue() . '): ' . $cell->getCoordinate()]);
                                }

                                break;
                            case 'M':
                                //dd($cell->getValue());
                                if ($cell->getValue() === 'Niet langer lid') {
                                    continue 3;
                                }
                                if ($cell->getValue() === 'Nee') {
                                    break;
                                }
                                $year   = substr($cell->getValue(), 0, 2);
                                $period = substr($cell->getValue(), 3);
                                try {
                                    $actualYear                 = Year::getYear('20' . $year);
                                    $actualYear->last_member_id = round(substr($member->member_id, 2));
                                    $actualYear->saveOrFail();

                                } catch (Throwable $e) {
                                    return back()->withErrors(['member-list' => 'Lidmaatschap ongeldig, gebruik (jaartal + s/f) (17 s, 18 f): ' . $cell->getCoordinate()]);
                                }
                                if ($period === 's') {
                                    $membership              = new Membership();
                                    $membership->valid_from  = Membership::calculateFiscalYearStart(Carbon::createFromDate($actualYear->year, 9));
                                    $membership->valid_until = Membership::calculateFiscalYearEnd(Carbon::createFromDate($actualYear->year, 9));
                                } elseif ($period === 'f') {
                                    $membership              = new Membership();
                                    $membership->valid_from  = Membership::calculateFiscalYearStart(Carbon::createFromDate($actualYear->year, 2));
                                    $membership->valid_until = Membership::calculateFiscalYearEnd(Carbon::createFromDate($actualYear->year, 2));
                                } else {
                                    return back()->withErrors(['member-list' => 'Lidmaatschap ongeldig, gebruik s voor september en f voor februari: ' . $cell->getCoordinate()]);
                                }
                                $membership->year_id = $actualYear->id;

                                break;
                            case 'N':
                                // lidnummer 2
                                break;
                            case 'O':
                                // Pasje in ontvangst
                                if ($cell->getValue() === 'Ja') {
                                    $member->card_status = Member::CARD_RECEIVED;
                                } elseif ($cell->getValue() === 'Nee' && $member->card_status === Member::CARD_PROCESSED) {
                                    $member->card_status = Member::CARD_NOT_PICKED_UP;
                                } elseif ($cell->getValue() === 'Nooit opgehaald') {
                                    $member->card_status = Member::CARD_NOT_PICKED_UP;
                                } elseif (substr($cell->getValue(), 0, 9) === 'Tijdelijk') {
                                    $temp = explode(':', $cell->getValue());
                                    if (count($temp) != 2) {
                                        return back()->withErrors(['member-list' => 'Kaartstatus ongeldig, verwacht: Tijdelijk: 00000 : ' . $cell->getCoordinate()]);
                                    }
                                    $tempNumber      = trim($temp[1]);
                                    $member->card_id = $tempNumber;
                                } elseif ($cell->getValue() === 'Nee') {
                                    break;
                                } else {
                                    return back()->withErrors(['member-list' => 'Kaartstatus ongeldig, verwacht: Ja, Nee, Nooit opgehaald, Tijdelijk: 00000 : ' . $cell->getCoordinate()]);
                                }
                                break;
                        }
                    }
                    $member->transaction_status = 'onbekend';
                    $member->transaction_amount = 0;
                    $member->transaction_id     = 'n.v.t.';
                    $member->ip_address         = $request->ip();
                    $member->saveOrFail();
                    if (!$member->exists) {
                        if (!$member->memberships()->save($membership)) {
                            $e             = new Exception("Kon lidmaatschap niet opslaan");
                            $e->membership = $membership;
                            throw $e;
                        }
                    } else {
                        if ($member->memberships()->count() < 1) {
                            $member->memberships()->save($membership);
                        }
                    }

                }

            } catch (Exception $e) {
                throw $e;
                //return back()->withErrors(['member-list' => trans('validation.uploaded', ['attribute' => $file->getClientOriginalName()])]);
            }
            return back();
        }

        /**
         * Display a listing of the resource.
         *
         * @return Response
         */
        public static function index() {
            return view('admin.members.index', [
                'members' => Member::with(['memberships', 'user'])->orderBy('member_id')->get()
            ]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return Response
         */
        public static function create() {
            return view('admin.members.create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param CreateMember $request
         *
         * @return RedirectResponse
         * @throws Throwable
         */
        public function store(CreateMember $request) {

            $member = new Member($request->all());
            if ($request->get('member_id') === null) {
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
         * @return Response
         */
        public static function show(Member $leden) {
            return view('admin.members.show', ['member' => $leden]);
        }

        /**
         * @param Member $member
         *
         * @return mixed
         */
        public function getPicture(Member $member) {
            return Member::getResizedCachedImage(800, null, true)->response();
        }

        /**
         * @param Member $member
         *
         * @return mixed
         */
        public function getFullPicture(Member $member) {
            return Member::getCachedImage(true)->response();
        }


        /**
         * @return Factory|View
         */
        public function getInactiveMailForm() {
            $members      = Member::with(['memberships'])->orderBy('member_id')->get();
            $invalidCount = 0;
            $members->each(function (Member $member) use (&$invalidCount) {
                if (!$member->isCurrentlyMember()) {
                    $invalidCount++;
                }
            });
            return view('admin.members.mail_inactive', [
                'invalid_count' => $invalidCount
            ]);
        }

        /**
         * @return Factory|View
         */
        public function getMailForm() {
            $members    = Member::with(['memberships'])->orderBy('member_id')->get();
            $validCount = 0;
            $members->each(function (Member $member) use (&$validCount) {
                if ($member->isCurrentlyMember()) {
                    $validCount++;
                }
            });
            return view('admin.members.mail', [
                'valid_count' => $validCount
            ]);
        }

        /**
         * @param SendMailToMembers $request
         *
         * @return Blank
         */
        public function getInactiveMailPreview(SendMailToMembers $request) {

            $content = $request->get('message_content');
            $content = MemberController::parseMailContents($content, Auth::user()->member);
            $title   = $request->get('subject');
            $mail    = new Blank($content, MemberController::parseMailContents($title, Auth::user()->member));
            return $mail;
        }

        /**
         * @param        $content
         * @param Member $member
         *
         * @return mixed
         */
        private static function parseMailContents($content, Member $member) {
            $content = nl2br($content);
            $content = str_replace('{voornaam}', $member->first_name, $content);
            $content = str_replace('{achternaam}', $member->last_name, $content);
            return $content;
        }

        /**
         * @param SendMailToMembers $request
         *
         * @return Blank
         */
        public function getMailPreview(SendMailToMembers $request) {

            $content = $request->get('message_content');
            $content = MemberController::parseMailContents($content, Auth::user()->member);
            $title   = $request->get('subject');
            $mail    = new Blank($content, MemberController::parseMailContents($title, Auth::user()->member));
            return $mail;
        }

        /**
         * @return Factory|View
         */
        public static function spreadsheetIndex() {
            return view('admin.members.spreadsheet', [
                'members' => Member::with(['memberships'])->orderBy('member_id')->get()
            ]);
        }

        /**
         * @param SendMailToMembers $request
         *
         * @return RedirectResponse
         */
        public function sendInactiveMail(SendMailToMembers $request) {
            $members      = Member::with(['memberships'])->orderBy('member_id')->get();
            $invalidCount = 0;
            $content      = $request->get('message_content');
            $title        = $request->get('subject');
            $members->each(function (Member $member) use ($title, $content, &$invalidCount) {
                if (!$member->isCurrentlyMember()) {
                    $content = MemberController::parseMailContents($content, $member);
                    $mail    = new Blank($content, MemberController::parseMailContents($title, $member));
                    $mail->to($member->email, $member->first_name . ' ' . $member->last_name);
                    Mail::queue($mail);
                    $invalidCount++;
                }
            });
            return back()->with('success', trans('admin.members.send_email.email_sent', ['members' => $invalidCount]));
        }

        /**
         * @param SendMailToMembers $request
         *
         * @return RedirectResponse
         */
        public function sendMail(SendMailToMembers $request) {
            $members    = Member::with(['memberships'])->orderBy('member_id')->get();
            $validCount = 0;
            $content    = $request->get('message_content');
            $title      = $request->get('subject');
            $members->each(function (Member $member) use ($title, $content, &$validCount) {
                if ($member->isCurrentlyMember()) {
                    $content = MemberController::parseMailContents($content, $member);
                    $mail    = new Blank($content, MemberController::parseMailContents($title, $member));
                    $mail->to($member->email, $member->first_name . ' ' . $member->last_name);
                    Mail::queue($mail);
                    $validCount++;
                }
            });
            return back()->with('success', trans('admin.members.send_email.email_sent', ['members' => $validCount]));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Member $leden
         *
         * @return Factory|View
         */
        public static function edit(Member $leden) {
            return view('admin.members.edit', ['member' => $leden]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param UpdateMember $request
         * @param Member       $leden
         *
         * @return Response
         * @throws Throwable
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
         * @return Factory|View
         */
        public function deleteInactiveConfirmation() {
            $members = Member::with(['memberships'])->orderBy('member_id')->get();

            return view('admin.members.delete_inactive', [
                'members' => $members->filter(function (Member $member) {
                    return !$member->isCurrentlyMember();
                })
            ]);
        }

        /**
         * @return RedirectResponse
         */
        public function deleteInactive() {
            $members      = Member::with(['memberships'])->orderBy('member_id')->get();
            $invalidCount = 0;
            $members->each(function (Member $member) use (&$invalidCount) {
                if (!$member->isCurrentlyMember()) {
                    $member->delete();
                    $invalidCount++;
                }
            });
            return redirect()->route('admin.members.index')->with('success', trans('admin.members.delete.inactive_deleted', ['count' => $invalidCount]));
        }

        /**
         * @param Member $member
         *
         * @return Factory|RedirectResponse|View
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
         * @return Response
         * @throws Exception
         */
        public function destroy(Member $leden) {
            if ($leden->isCurrentlyMember()) {
                return back();
            }
            $leden->delete();
            return redirect()->route('admin.members.index')->with('success', trans('admin.members.delete.deleted'));
        }

        /**
         * @return User[]|Builder[]|Collection
         */
        public static function getMembersWithFullAccess() {
            // Todo rechtensysteem implementeren
            $members = User::with(['member'])->where('rank', 'admin')->orWhere('rank', 'camping')->get();
            $return  = [];
            foreach ($members as $member) {
                $return[] = [
                    'username'      => $member->username,
                    'official_name' => $member->official_name,
                ];
            }
            return $return;
        }
    }
