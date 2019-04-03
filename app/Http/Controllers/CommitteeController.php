<?php

namespace App\Http\Controllers;

use App\Committee;
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


    /**
     * @return Factory|View
     */
    public static function getPartyPage()
    {
        return view('committees.party');
    }

    /**
     * @return Factory|View
     */
    public static function getMediaPage()
    {
        return view('committees.media');
    }

    /**
     * @return Factory|View
     */
    public static function getCampingPage()
    {
        return view('committees.camping');
    }

    /**
     * @return Factory|View
     */
    public static function getActivityPage()
    {
        return view('committees.activity');
    }

    /**
     * @return Factory|View
     */
    public static function getStudyPage()
    {
        return view('committees.study');
    }

    /**
     * @return Factory|View
     */
    public static function getInternalAffairsPage()
    {
        return view('committees.internal_affairs');
    }

    /**
     * @return Factory|View
     */
    public static function getExternalAffairsPage()
    {
        return view('committees.external_affairs');
    }

    /**
     * @return Factory|View
     */
    public static function getAlphaCentauriPage()
    {
        return view('committees.alpha_centauri');
    }

    /**
     * @return Factory|View
     */
    public static function getTreasurePage()
    {
        return view('committees.treasure');
    }

    /**
     * @return Factory|View
     */
    public static function getVacanciesPage()
    {
        return view('committees.vacancies');
    }

}
