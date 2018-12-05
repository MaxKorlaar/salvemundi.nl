<?php

    namespace App\Http\Controllers;

    use App\Store\Item;

    /**
     * Class StoreController
     *
     * @package App\Http\Controllers
     */
    class StoreController extends Controller {
        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            return view('store.index', ['items' => Item::with(['stock'])->get()]);
        }

        /**
         * @param $slug
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function viewItem($slug) {
            $item = Item::where('slug', $slug)->first();
            if ($item === null) abort(404);
            return view('store.item', [
                'item' => $item,
                'script_data' => [
                    'item' => $item->jsonSerialize(),
                    'stock' => $item->stock->jsonSerialize()
                ]
            ]);
        }
    }
