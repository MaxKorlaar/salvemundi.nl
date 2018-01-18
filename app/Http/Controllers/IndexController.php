<?php

    namespace App\Http\Controllers;

    use Carbon\Carbon;
    use Facebook\Exceptions\FacebookSDKException;
    use Facebook\GraphNodes\GraphNode;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;

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
            return Cache::remember('facebook_events', 60, function () {
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
                    return Cache::get('facebook_events_old');
                }
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
            }) ?: abort(500);

            //            $graphNode = $response->getGraphNode();

        }
    }
