<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;

    /**
     * Class ApplicationsController
     *
     * @package App\Http\Controllers\Admin
     */
    class ApplicationsController extends Controller {

        public function __construct() {
            $this->middleware('auth.admin');
        }

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            return view('admin.applications');
        }
    }
