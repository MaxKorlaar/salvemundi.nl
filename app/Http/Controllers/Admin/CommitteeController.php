<?php

namespace App\Http\Controllers\Admin;

use App\Committee;
use App\CommitteeMember;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Committees\AddMember;
use App\Member;

/**
 * Class CommitteeController
 *
 * @package App\Http\Controllers
 */
class CommitteeController extends Controller
{
    public static function getAdminPage()
    {
        $committees = Committee::all();
        return view('admin.committees.index', [
            'committees' => $committees
        ]);
    }

    public static function getCommitteeCreationPage()
    {
        return view('admin.committees.create');
    }

    public static function getEditCommitteePage(Committee $committee)
    {
        return view('admin.committees.edit', [
            'committee' => $committee
        ]);
    }

    public static function getCommitteeOverview(Committee $committee)
    {
        return view('admin.committees.view', [
            'committee' => $committee
        ]);
    }

    public static function getAddMemberPage(Committee $committee)
    {
        return view('admin.committees.members.add', [
            'committee' => $committee
        ]);
    }

    public static function addMember(AddMember $request, Committee $committee)
    {
        $memberId = $request->get('memberId');

        $committeeMember = new CommitteeMember();

        $member = Member::whereMemberId($memberId)->first();
        $committeeMember->member()->associate($member);

        if ($committee->members()->where("member_id", $member->id)->exists()) {
            return redirect()->route('admin.committees.members.add', [
                'committee' => $committee
            ])->withErrors(["already_is_member" => trans('admin.committees.errors.already_is_member', [
                'name' => $member->first_name,
                'committee' => $committee->name
            ])]);
        } else {
            $committee->members()->save($committeeMember);

            return redirect()->route('admin.committees.overview', [
                'committee' => $committee
            ]);
        }
    }
}
