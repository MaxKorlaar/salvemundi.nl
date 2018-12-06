<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\Store\AddToCart;
    use App\Store\Item;
    use App\Store\Stock;
    use App\Store\StockImage;
    use Illuminate\Http\Request;

    /**
     * Class StoreController
     *
     * @package App\Http\Controllers
     */
    class StoreController extends Controller {

        public function __construct() {
            $this->middleware('auth')->only(['viewCart', 'removeFromCart']);
        }

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
                'item'        => $item,
                'script_data' => [
                    'item'  => $item->jsonSerialize(),
                    'stock' => $item->stock->jsonSerialize()
                ]
            ]);
        }

        /**
         * @param            $slug
         * @param Stock      $stock
         * @param StockImage $image
         *
         * @return mixed
         */
        public function getImage($slug, Stock $stock, StockImage $image) {
            return $image->getResizedCachedImage(500, 500, true)->response();
        }

        /**
         * @param            $slug
         * @param Stock      $stock
         * @param StockImage $image
         *
         * @return mixed
         */
        public function getImageFull($slug, Stock $stock, StockImage $image) {
            return $image->getResizedCachedImage(4000, 4000, true)->response();
        }

        /**
         * @param AddToCart $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function addToCart(AddToCart $request) {
            $item  = Item::find($request->get('item'));
            $stock = Stock::find($request->get('stock_variant'));

            if ($request->get('amount') > $stock->in_stock) {
                return back();
            }

            $cart  = $this->checkItemAvailability($request->session()->get('store.cart'));
            $found = false;
            foreach ($cart as $index => &$item) {
                if ($item['stock']->id === $stock->id) {
                    $item['amount'] += $request->get('amount');
                    $found          = true;
                }
            }
            if ($found) {
                $request->session()->put('store.cart', $cart);
            } else {
                $request->session()->push('store.cart', [
                    'item'   => $item,
                    'stock'  => $stock,
                    'amount' => $request->get('amount')
                ]);
            }

            return redirect()->route('store.cart');
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function viewCart(Request $request) {
            $cart = $this->checkItemAvailability($request->session()->get('store.cart'));
            $request->session()->put('store.cart', $cart);

            $items = [];

            $total = 0;

            foreach ($cart as $index => $item) {
                $items[] = [
                    'index'   => $index,
                    'amount'  => $item['amount'],
                    'name'    => $item['item']->name,
                    'variant' => $item['stock']->name,
                    'price'   => $item['stock']->price * $item['amount']
                ];
                $total   += $item['stock']->price * $item['amount'];
            }

            $vat = 0.21 * $total;

            return view('store.cart', [
                'items'    => $items,
                'total'    => $total,
                'subtotal' => $total,
                'vat'      => $vat
            ]);
        }

        /**
         * @param $items
         *
         * @return array
         */
        public function checkItemAvailability($items) {
            $return = [];
            if ($items === null) return $return;
            foreach ($items as $index => $item) {

                if (!$item['item']->exists || !$item['stock']->exists) continue;

                $amount = $item['amount'];
                /** @var Stock $stock */
                $stock         = $item['stock'];
                $item['stock'] = $stock->fresh();
                $available     = $item['stock']->in_stock;
                if ($available > 0) {
                    if ($amount <= $available) {
                        $return[] = $item;
                    } else {
                        $item['amount'] = $available;
                        $return[]       = $item;
                    }
                } else {
                    continue;
                    // Schrap het item
                }
            }
            return $return;
        }

        /**
         * @param         $index
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function removeFromCart($index, Request $request) {
            $cart = $request->session()->get('store.cart');
            if (isset($cart[$index])) unset($cart[$index]);
            $request->session()->put('store.cart', $cart);

            return redirect()->route('store.cart');
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function placeOrder(Request $request) {
            $cart = $this->checkItemAvailability($request->session()->get('store.cart'));

            if(empty($cart)) {
                return redirect()->back();
            }
            $request->session()->pull('store.cart');

            $total = 0;

            foreach ($cart as $index => $item) {
                /** @var Stock $stock */
                $stock         = $item['stock'];
                $stock->in_stock = $stock->in_stock - $item['amount'];
                $stock->saveOrFail();

                $items[] = [
                    'index'   => $index,
                    'amount'  => $item['amount'],
                    'name'    => $item['item']->name,
                    'variant' => $item['stock']->name,
                    'price'   => $item['stock']->price * $item['amount']
                ];
                $total   += $item['stock']->price * $item['amount'];
            }


            $vat = 0.21 * $total;

        }
    }
