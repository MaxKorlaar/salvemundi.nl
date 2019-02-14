<?php

    namespace App\Http\Controllers\Admin;

    use App\Http\Controllers\Controller;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\View\View;

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
         * @return Factory|View
         */
        public static function index() {
            return view('admin.applications');
        }
    }
