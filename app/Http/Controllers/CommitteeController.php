<?php

namespace App\Http\Controllers;

use App\Committee;
use App\CommitteeMember;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class CommitteeController
 *
 * @package App\Http\Controllers
 */
class CommitteeController extends Controller
{
    /**
     * @return Factory|View
     */
    public static function getAdministrationPage()
    {
        return view('committees.administration');
    }

    /**
     * @return Factory|View
     */
    public static function getFounders()
    {
        return view('committees.administration', [
            'administration_title' => trans('committee.administration.founders'),
            'administration_text' => trans('committee.administration.founders_text'),
        ]);
    }

    /**
     * @return Factory|View
     */
    public static function get2017()
    {
        return view('committees.administration',
            [
                'administration_title' => trans('committee.administration.administration_versions.2017.title'),
                'administration_text' => trans('committee.administration.administration_versions.2017.text'),
                'administration_image' => 'images/bestuur_2017.jpg',
                'administration_caption' => trans('committee.administration.administration_versions.2017.caption')
            ]);
    }

    /**
     * @return Factory|View
     */
    public static function get2018()
    {
        return view('committees.administration',
            [
                'administration_title' => trans('committee.administration.administration_versions.2018.title'),
                'administration_text' => trans('committee.administration.administration_versions.2018.text'),
                'administration_image' => null,
                'administration_caption' => trans('committee.administration.administration_versions.2018.caption')
            ]);
    }

    /**
     * @param $committee
     * @return Factory|View
     */
    public static function getCommittee(Committee $committee)
    {
        return view('committees.committee', [
            'committee' => $committee
        ]);
    }


    public function getMemberPicture(Committee $committee, CommitteeMember $member)
    {
        return $member->member->getResizedCachedImage(400, null, true)->response();
    }
}
