<?php

    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use Facebook\Exceptions\FacebookSDKException;
    use Facebook\GraphNodes\GraphNode;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;

    /**
     * Class IndexController
     *
     * @package App\Http\Controllers
     */
    class IndexController extends Controller {

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getHomePage() {
            return view('index');
        }


        /**
         * @param Request $request
         *
         * @return array
         */
        public function getFacebookEvents(Request $request) {
            $e      = [
                [
                    'name'            => 'Grill & Chill',
                    'description'     => 'Beste feestangers van Salve Mundi,

Het einde van het schooljaar is in zicht en daarom staat er een bbq met een leuk feest gepland om dit jaar goed af te sluiten! Er is genoeg vlees aanwezig om een prima bodem te leggen. Na de bbq is er namenlijk nog een knallend eindfeest in de Villa Fiesta! 

Natuurlijk moeten wij ook aan onze kas en budget denken en vragen wij dan ook maar een kleine vergoeding van 6€ voor leden en 10€ voor niet-leden. Je kan jezelf aanmelden via Google Forms: https://goo.gl/forms/pmfYYNQjwUoN6zC92 en geef hier ook even aan of je iemand mee wil brengen of dat je vegetarisch bent. Wij houden hier natuurlijk rekening mee. 

Wij hopen jullie graag de 27ste allemaal te zien vanaf 17:00 uur bij de Villa Fiesta! 

Tot dan!

Groetjes, 
De feestcommissie',
                    'url'             => 'https://www.facebook.com/events/199477927352995/',
                    'date'            => [
                        'day'   => '27',
                        'month' => 'juni',
                        'year'  => '2018'
                    ],
                    'attending_count' => '?',
                    'cover'           => [
                        'source'   => 'https://scontent-amt2-1.xx.fbcdn.net/v/t1.0-9/34532240_837026896498310_1336634427136016384_o.jpg?_nc_cat=0&oh=4a5f5f8fcd4396a537c48c0e23ef0f06&oe=5BC2E16B',
                        'offset_y' => 175
                    ],
                    'place'           => [
                        'name' => 'Villa Fiesta'
                    ]
                ],
            ];
            $return = Cache::remember('facebook_events', 60, function () {
                $fb = new \Facebook\Facebook([
                    'app_id'                => config('facebook.app_id'),
                    'app_secret'            => config('facebook.secret'),
                    'default_graph_version' => 'v2.10',
                    'default_access_token'  => config('facebook.access_token')
                ]);
                try {
                    // Returns a `Facebook\FacebookResponse` object
                    $response = $fb->get(
                        '/' . config('facebook.page_id') . '/events?limit=200&time_filter=upcoming&fields=attending_count,category,description,end_time,id,cover,interested_count,name,place,start_time'
                    );
                } catch (FacebookSDKException $e) {
                    Log::warning("Facebook-evenementen konden niet worden opgevraagd", ['exception' => $e]);

                    return Cache::get('facebook_events_old');
                }
                Log::debug("FB Response", ['response' => $response->getRequest()->getUrl(), 'fb' => $fb]);
                $graphEdge = $response->getGraphEdge();
                $return    = [];
                /** @var GraphNode $graphNode */
                foreach ($graphEdge as $graphNode) {
                    $return[] = $graphNode->all();
                }
                usort(/**
                 * @param GraphNode $event1
                 * @param GraphNode $event2
                 *
                 * @return int
                 */
                    $return, function ($event1, $event2) {
                    if ($event1['start_time'] < $event2['start_time']) return -1;
                    if ($event1['start_time'] > $event2['start_time']) return 1;
                    return 0;
                });
                Carbon::setLocale(config('app.locale'));
                setlocale(LC_TIME, 'nl_NL.utf8');

                $months = ['januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december'];

                foreach ($return as &$item) {
                    $startTime    = Carbon::instance($item['start_time']);
                    $item['date'] = [
                        'day'   => $startTime->formatLocalized('%d'),
                        'month' => $months[$startTime->month - 1],
                        'year'  => $startTime->formatLocalized('%Y')
                    ];
                    if (isset($item['cover'])) {
                        /** @var GraphNode $cover */
                        $cover         = $item['cover'];
                        $item['cover'] = $cover->all();
                    }
                    if (isset($item['place'])) {
                        /** @var GraphNode $place */
                        $place         = $item['place'];
                        $item['place'] = $place->all();
                    }
                    $item['url'] = 'https://facebook.com/events/' . $item['id'];
                }

                Cache::put('facebook_events_old', $return, 600);
                return $return;
            });

            if ($return || is_array($return)) {
                return $return;
            } else {
                Log::warning("Evenementen konden niet worden opgevraagd", ['cache_result' => $return]);
                abort(500, "Er ging iets mis tijdens het opvragen van de evenementen");
            }

            //            $graphNode = $response->getGraphNode();

        }

        /**
         * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         */
        public function getDriveRedirect() {
            return redirect('https://drive.google.com/drive/folders/0Bz1jQEqeNpawdkRXRVNwVzZZbGM?usp=sharing');
        }

        /**
         * @return string
         */
        public function getCancelPage() {
            return "ik ook bedankt <img src='" . asset('images/dep.gif') . "'>";
        }

    }
