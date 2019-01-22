<?php

namespace App\Http\Controllers\Admin\Intro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ApplicationController
 *
 * @package App\Http\Controllers\Admin\Intro
 */
class ApplicationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin.intro.index', [
            'applications'            => IntroApplication::all(),
            'confirmed_count'         => IntroApplication::where('status', '=', IntroApplication::STATUS_PAID)->count(),
            'email_unconfirmed_count' => IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param IntroApplication $intro
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(IntroApplication $intro) {
        return view('admin.intro.show', ['application' => $intro]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param IntroApplication $application
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDeleteConfirmation(IntroApplication $application) {
        if ($application->status == IntroApplication::STATUS_PAID || $application->status == IntroApplication::STATUS_OPEN) {
            return back();
        }
        return view('admin.intro.delete', ['application' => $application]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function spreadsheetIndex() {
        return view('admin.intro.spreadsheet', [
            'applications'            => IntroApplication::all(),
            'confirmed_count'         => IntroApplication::where('status', '=', IntroApplication::STATUS_PAID)->count(),
            'email_unconfirmed_count' => IntroApplication::where('status', '=', IntroApplication::STATUS_EMAIL_UNCONFIRMED)->count()
        ]);
    }

    /**
     * @param IntroApplication $intro
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(IntroApplication $intro) {
        if ($intro->status == IntroApplication::STATUS_PAID || $intro->status == IntroApplication::STATUS_OPEN) {
            return back();
        }
        $intro->delete();
        return redirect()->route('admin.intro.index')->with('success', trans('admin.intro.delete.deleted'));
    }
}
