<?php
/**
 * Created by PhpStorm.
 * User: Niek
 * Date: 29-11-2018
 * Time: 01:11
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\GraphNodes\GraphNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class DiscountController extends Controller
{

    public function getDefaultView()
    {
        return view('discounts');
    }

    public function getHappiView()
    {
        return view('discounts',
            [
                'title' => "happii",
                'image_url' => "images/promo/happii.png",
                'discounts' => [
                    [
                        "Pizza's" => ["6,99", "5,50"],
                        "Grote pizza's" => ["9,00", "7,00"]
                    ],
                    [
                        "Broodje Doner" => ["3,00", "2,20"],
                        "Broodje Kipdoner" => ["3,50", "2,50"]
                    ],
                    [
                        "Drum Doner" => ["4,75", "3,50"],
                        "Drum Kip" => ["5,50", "5,50"],
                    ],
                    [
                        "Kapsalon Doner of Kip" => ["6,50", "5,00"],
                    ],
                    [
                        "Schotel Doner" => ["10,00", "8,00"],
                        "Schotel Kip" => ["11,00", "8,50"],
                    ],
                    [
                        "10 Nuggets of Hotwings" => ["5,50", "4,00"]
                    ]
                ]
            ]
        );
    }

    public function getVillaView()
    {
        return view('discounts',
            [
                'title'
            ]
        );
    }

}