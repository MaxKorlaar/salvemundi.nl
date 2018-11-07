<?php
/**
 * Created by PhpStorm.
 * User: Niek van Gogh
 * Date: 11/7/2018
 * Time: 11:13 PM
 */

namespace App\Http\Controllers;


class MerchandiseController extends Controller
{


    public function getMerchandise() {
        return view('merchandise');
    }

}