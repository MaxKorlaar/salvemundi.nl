<?php

    namespace App\Http\Controllers;

    use App\Helpers\PaymentHelper;
    use App\Http\Requests\Store\AddToCart;
    use App\Http\Requests\Store\PayCart;
    use App\Mail\NewOrder;
    use App\Mail\OrderConfirmation;
    use App\Member;
    use App\Store\Item;
    use App\Store\Order;
    use App\Store\Stock;
    use App\Store\StockImage;
    use App\Transaction;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;
    use Mail;
    use Mollie\Api\Exceptions\ApiException;
    use Mollie\Api\Resources\Payment;
    use Mollie\Api\Resources\ResourceFactory;

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
            /** @var \Illuminate\Http\Response $response */
            $response = $image->getResizedCachedImage(500, 500, true)->response();
            $response->header('Cache-Control', 'public, max-age=2678400');
            return $response;
        }

        /**
         * @param            $slug
         * @param Stock      $stock
         * @param StockImage $image
         *
         * @return mixed
         */
        public function getImageFull($slug, Stock $stock, StockImage $image) {
            /** @var \Illuminate\Http\Response $response */
            $response = $image->getResizedCachedImage(4000, 4000, true)->response();
            $response->header('Cache-Control', 'public, max-age=2678400');
            return $response;
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
            foreach ($cart as $index => &$sessionItem) {
                if ($sessionItem['stock']->id === $stock->id) {
                    $sessionItem['amount'] += $request->get('amount');
                    $found                 = true;
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
         * @return Collection
         */
        public static function getIdealBanks() {
            return Cache::remember('mollie.ideal.banks', 15, function () {
                $mollie  = new PaymentHelper();
                $methods = $mollie->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers,pricing"]);
                return new Collection($methods->issuers);
            });
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

            $vat    = 0.21 * $total;
            $user   = $request->user();
            $member = $user->member;
            return view('store.cart', [
                'items'          => $items,
                'total'          => $total,
                'subtotal'       => $total,
                'vat'            => $vat,
                'banks'          => $this->getIdealBanks(),
                'verify_address' => $this->verifyMemberAddress($member)
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
                if ($item['stock'] === null) {
                    continue;
                    // Het item bestaat niet meer. Schrap het item
                }
                $available = $item['stock']->in_stock;
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
         * @param Member $member
         *
         * @return array|bool
         */
        private function verifyMemberAddress(Member $member) {
            $invalid = [];
            $country = $member->country;
            if (!in_array($country, array_keys(trans('address.country')))) {
                $invalid[] = 'country';
            }
            if (count($invalid) > 0) return $invalid;
            return true;
        }

        /**
         * @param PayCart $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function placeOrderAndPay(PayCart $request) {
            $bank = $request->get('ideal_bank');

            $mollie = new PaymentHelper();

            $cart = $this->checkItemAvailability($request->session()->get('store.cart'));
            if (empty($cart)) {
                return redirect()->back();
            }
            if (app()->environment() === 'production') $request->session()->pull('store.cart');

            /** @var User $user */
            $user = $request->user();

            $member = $user->member;
            if ($this->verifyMemberAddress($member) !== true) {
                return redirect()->back();
            }

            $total = 0;

            $order                 = new Order();
            $order->transaction_id = null;
            $order->status         = Order::STATUS_SEE_TRANSACTION;
            $order->user()->associate($user);
            $order->saveOrFail();

            $mollieItems = [];

            foreach ($cart as $index => $item) {
                /** @var Stock $stock */
                $stock           = $item['stock'];
                $stock->in_stock = $stock->in_stock - $item['amount'];
                $stock->saveOrFail();

                $order->items()->create([
                    'amount'         => $item['amount'],
                    'price'          => $stock->price,
                    'store_stock_id' => $item['stock']->id
                ]);

                $mollieItems[] = [
                    "type"        => "physical",
                    "sku"         => $stock->item->id . $stock->id,
                    "name"        => trans('store.cart.item_name', ['product' => $stock->item->name, 'variant' => $stock->name]),
                    "productUrl"  => route('store.view_item', ['item' => $stock->item]),
                    "imageUrl"    => $stock->images->isNotEmpty() ? route('store.image', ['slug' => $stock->item->slug, 'stock' => $stock, 'image' => $stock->images->first()]) : null,
                    "quantity"    => $item['amount'],
                    "vatRate"     => config('mollie.vat_percentage'),
                    "unitPrice"   => [
                        "currency" => "EUR",
                        "value"    => (string)number_format($stock->price, 2)
                    ],
                    "totalAmount" => [
                        "currency" => "EUR",
                        "value"    => (string)number_format($stock->price, 2)
                    ],
                    "vatAmount"   => [
                        "currency" => "EUR",
                        "value"    => (string)number_format($stock->price * (config('mollie.vat_percentage') / (100 + config('mollie.vat_percentage'))), 2)]];

                $total += $item['stock']->price * $item['amount'];
            }
            /** @var Transaction $transaction */
            $transaction = $member->transactions()->create();
            $order->transaction()->associate($transaction);
            $order->saveOrFail();
            $mollieOrder = $mollie->orders->create([
                "amount"         => [
                    'currency' => 'EUR',
                    'value'    => (string)number_format($total, 2)
                ],
                "billingAddress" => [
                    //                    "organizationName" => "Mollie B.V.",
                    "streetAndNumber" => $member->address,
                    "city"            => $member->city,
                    "postalCode"      => $member->postal,
                    "country"         => $member->country,
                    //                    "title"            => "Dhr.",
                    "givenName"       => $member->first_name,
                    "familyName"      => $member->last_name,
                    "email"           => $member->email,
                    //                    "phone"            => "+31309202070",
                ],
                "metadata"       => [
                    "id"             => $order->id,
                    "description"    => trans('store.cart.payment_description'),
                    'transaction_id' => $transaction->id
                ],
                "locale"         => "nl_NL",
                "orderNumber"    => (string)$order->id,
                "redirectUrl"    => route('store.cart.confirm_payment'),
                "webhookUrl"     => route('webhook.payment.store', ['order' => $order]),
                "lines"          => $mollieItems
            ]);
            /*
             * Todo: Wachten op implementatie Order payments in Mollie PHP client
             * $molliePayment = $mollieOrder->payments->create([
                "method" => 'ideal',
                'issuer' => $bank
            ]);
            dd($molliePayment);*/
            $mollieOrder = $mollie->orders->get($mollieOrder->id, ['embed' => 'payments']);

            /** @var Payment $payment */
            $payment = ResourceFactory::createFromApiResult($mollieOrder->_embedded->payments[0], new Payment($mollie));

            $transaction->update([
                'transaction_id'     => $payment->id,
                'transaction_status' => $payment->status,
                'transaction_amount' => $payment->amount->value
            ]);
            $order->mollie_order_id = $mollieOrder->id;
            $order->saveOrFail();
            $request->session()->put('store.order', $order);
            $request->session()->save();
            return view('store.payment_redirect', [
                'links' => $payment->_links
            ]);
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function confirmPayment(Request $request) {
            //if (!$request->session()->has('camping.application')) abort(404);
            /** @var Order $order */
            $order = $request->session()->get('store.order');
            if ($order !== null) {
                $mollie  = new PaymentHelper();
                $payment = $mollie->payments->get($order->transaction->transaction_id);

                if (!$payment->isOpen() && !$payment->isPaid()) {
                    $this->updatePayment($order, $order->mollie_order_id);
                    return redirect()->route('store.cart')->withErrors(['payment' => trans('store.cart.payment.failed')]);
                }
            }

            return view('store.payment_confirmation', [
                'order' => $order
            ]);
        }


        /**
         * @param Order   $order
         * @param Request $request
         *
         * @return string
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function confirmPaymentWebhook(Order $order, Request $request) {
            if (!$request->has('id')) abort(400);
            return $this->updatePayment($order, $request->get('id'));
        }

        /**
         * @param Order $order
         *
         * @param       $id
         *
         * @return string
         * @throws ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         * @throws \Throwable
         */
        public function updatePayment(Order $order, $id) {


            $mollie = new PaymentHelper();
            try {
                $mollieOrder = $mollie->orders->get($id, ['embed' => 'payments']);
                if ($mollieOrder->metadata->id != $order->id) {
                    Log::debug('Order niet gelijk aan mollie order', [$mollieOrder->metadata, $order->id]);
                    abort(400);
                }
               // Log::debug('Mollie order webhook', ['order' => $mollieOrder]);

                // Todo: Tempfix weghalen
                /** @var Payment $payment */
                $payment = ResourceFactory::createFromApiResult($mollieOrder->_embedded->payments[0], new Payment($mollie));

                /** @var Transaction $transaction */
                $transaction = Transaction::findOrFail($mollieOrder->metadata->transaction_id);
                $transaction->update([
                    'transaction_id'     => $payment->id,
                    'transaction_status' => $payment->hasRefunds() ? 'refunded' : $payment->status,
                    'transaction_amount' => $payment->amount->value
                ]);
                if ($payment->isPaid() && !$payment->hasRefunds()) {
                    Log::debug('Er is betaald voor de bestelling in de webshop');
                    if($mollieOrder->isCompleted()) {
                        // De order is gemarkeerd als compleet. Er was echter al betaald voor de items, dus het is niet nodig om nog eens een
                        // email te sturen.
                    } else {
                        // Stuur de bevestigingen
                        $user = $order->user;
                        $mail = new OrderConfirmation($order);
                        $mail->to($user->member->email, $user->member->first_name . ' ' . $user->member->last_name);
                        Mail::queue($mail);

                        $mail = new NewOrder($order);
                        $mail->to(config('mail.store_to.address'), config('mail.store_to.name'));
                        Mail::queue($mail);
                    }

                    //                        $mail = new NewCampingApplication($application);
                    //                        $mail->to(config('mail.camping_to.address'), config('mail.camping_to.name'));
                    //
                    //                        Mail::queue($mail);
                    //
                    //                        // Stuur een bevestiging naar de gebruiker zelf
                    //
                    //                        $mail = new CampingApplicationPaymentConfirmation($application);
                    //                        $mail->to($application->email, $application->first_name . ' ' . $application->last_name);
                    //                        Mail::queue($mail);
                } else {
                    if ($payment->isCanceled() || $payment->hasRefunds() || $payment->isExpired() || $payment->isFailed() || (!$payment->isPaid() && !$payment->isOpen())) {
                        Log::debug('De betaling is geannuleerd of is verlopen en de bestelling zal worden verwijderd', ['order' => $mollieOrder, 'payment' => $payment]);
                        $order->undoOrder();
                    }
                }

            } catch (ApiException $exception) {
                Log::error($exception);
                abort(400);
            }
            return 'OK';
        }


        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Throwable
         */
        public function placeOrder(Request $request) {
            $cart = $this->checkItemAvailability($request->session()->get('store.cart'));

            if (empty($cart)) {
                return redirect()->back();
            }

            $request->session()->pull('store.cart');

            /** @var User $user */
            $user  = $request->user();
            $total = 0;

            $order                 = new Order();
            $order->transaction_id = null;
            $order->status         = Order::STATUS_OPEN;
            $order->user()->associate($user);
            $order->saveOrFail();
            foreach ($cart as $index => $item) {
                /** @var Stock $stock */
                $stock           = $item['stock'];
                $stock->in_stock = $stock->in_stock - $item['amount'];
                $stock->saveOrFail();

                $order->items()->create([
                    'amount'         => $item['amount'],
                    'price'          => $stock->price,
                    'store_stock_id' => $item['stock']->id
                ]);
                $total += $item['stock']->price * $item['amount'];
            }

            // De bestelling is geplaatst. Mailtje sturen naar persoon zelf en de mediacommissie

            // Stuur een bevestiging naar de gebruiker zelf

            $mail = new OrderConfirmation($order);
            $mail->to($user->member->email, $user->member->first_name . ' ' . $user->member->last_name);
            Mail::queue($mail);

            $mail = new NewOrder($order);
            $mail->to(config('mail.store_to.address'), config('mail.store_to.name'));
            Mail::queue($mail);

            return view('store.thanks_for_ordering');

        }
    }
