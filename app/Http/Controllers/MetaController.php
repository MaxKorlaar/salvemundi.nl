<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    /**
     * Class MetaController
     *
     * @package App\Http\Controllers
     */
    class MetaController extends Controller {
        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function getPrivacyPage(Request $request) {
            return view('privacy');
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
         */
        public function getSitemap(Request $request) {

            $pages = [
                [
                    'url'      => '/',
                    'priority' => 1,
                    'frequency' => 'weekly'
                ],
                [
                    'url'      => route('signup.signup', [], false),
                    'priority' => 1,
                    'frequency' => 'monthly'
                ],
                [
                    'url'      => route('committees/administration', [], false),
                    'priority' => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'      => route('committees/camping', [], false),
                    'priority' => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'      => route('committees/media', [], false),
                    'priority' => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'      => route('committees/party', [], false),
                    'priority' => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'      => route('committees/women', [], false),
                    'priority' => 0.9,
                    'frequency' => 'monthly'
                ],
            ];

            foreach ($pages as &$page) {
                $page['path'] = $page['url'];
                $page['url']  = 'https://' . $request->getHost() . $page['url'];
            }

            return response(view('meta.sitemap', ['pages' => $pages]), 200, [
                'Content-Type' => 'text/xml'
            ]);
        }
    }
