<?php

    namespace App\Http\Controllers;

    use App\Introduction;
    use App\Store\Item;
    use Illuminate\Contracts\Routing\ResponseFactory;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\Request;
    use Illuminate\View\View;
    use Symfony\Component\HttpFoundation\Response;

    /**
     * Class MetaController
     *
     * @package App\Http\Controllers
     */
    class MetaController extends Controller {
        /**
         * @param Request $request
         *
         * @return Factory|View
         */
        public static function getPrivacyPage(Request $request) {
            return view('privacy');
        }

        /**
         * @param Request $request
         *
         * @return ResponseFactory|Response
         */
        public function getSitemap(Request $request) {

            $pages = [
                [
                    'url'       => '/',
                    'priority'  => 1,
                    'frequency' => 'weekly'
                ],
                [
                    'url'       => route('store.index', [], false),
                    'priority'  => 1,
                    'frequency' => 'weekly'
                ],
                [
                    'url'       => route('discounts.index', [], false),
                    'priority'  => 1,
                    'frequency' => 'weekly'
                ],
                [
                    'url'       => route('discounts.villa_fiesta', [], false),
                    'priority'  => 0.8,
                    'frequency' => 'weekly'
                ],
                [
                    'url'       => route('discounts.happii', [], false),
                    'priority'  => 0.8,
                    'frequency' => 'weekly'
                ],
                [
                    'url'       => route('signup.signup', [], false),
                    'priority'  => 1,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('member.about_me', [], false),
                    'priority'  => 0.7,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('camping.signup', [], false),
                    'priority'  => 1,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('intro.info', [], false),
                    'priority'  => 1,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('intro.signup', [], false),
                    'priority'  => 1,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('intro.supervisor_info', [], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('intro.supervisor_signup', [], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/administration', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/camping', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/media', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/party', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/activity', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/study', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/alpha_centauri', [], false),
                    'priority'  => 0.9,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/internal_affairs', [], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/external_affairs', [], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ],
                [
                    'url'       => route('committees/treasure', [], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ],
            ];
            Item::all()->each(function (Item $item) use (&$pages) {
                $pages[] = [
                    'url'       => route('store.view_item', ['item' => $item->slug], false),
                    'priority'  => 0.7,
                    'frequency' => 'weekly'
                ];
            });
            Introduction::all()->each(function (Introduction $introduction) use (&$pages) {
                $pages[] = [
                    'url'       => route('intro.by_id.info', ['intro' => $introduction, 'year' => $introduction->year->year], false),
                    'priority'  => 0.85,
                    'frequency' => 'monthly'
                ];
                $pages[] = [
                    'url'       => route('intro.by_id.signup', ['intro' => $introduction, 'year' => $introduction->year->year], false),
                    'priority'  => 0.85,
                    'frequency' => 'monthly'
                ];
                $pages[] = [
                    'url'       => route('intro.by_id.supervisor.info', ['intro' => $introduction, 'year' => $introduction->year->year], false),
                    'priority'  => 0.5,
                    'frequency' => 'monthly'
                ];
            });

            foreach ($pages as &$page) {
                $page['path'] = $page['url'];
                $page['url']  = 'https://' . $request->getHost() . $page['url'];
            }

            return response(view('meta.sitemap', ['pages' => $pages]), 200, [
                'Content-Type' => 'text/xml'
            ]);
        }
    }
