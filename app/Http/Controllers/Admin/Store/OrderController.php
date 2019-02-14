<?php

    namespace App\Http\Controllers\Admin\Store;

    use App\Helpers\PaymentHelper;
    use App\Http\Controllers\Controller;
    use App\Store\Order;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Http\Request;
    use Illuminate\Http\Response;
    use Illuminate\View\View;
    use Mollie\Api\Exceptions\ApiException;
    use Mollie\Api\Exceptions\IncompatiblePlatform;

    /**
     * Class OrderController
     *
     * @package App\Http\Controllers\Admin\Store
     */
    class OrderController extends Controller {
        /**
         * Display a listing of the resource.
         *
         * @return void
         */
        public static function index() {
            //
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return void
         */
        public static function create() {
            //
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  Request $request
         *
         * @return void
         */
        public static function store(Request $request) {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param Order $bestellingen
         *
         * @return Factory|View
         * @throws ApiException
         * @throws IncompatiblePlatform
         */
        public function show(Order $bestellingen) {
            if ($bestellingen->mollie_order_id !== null) {
                $mollie      = new PaymentHelper();
                $mollieOrder = $mollie->orders->get($bestellingen->mollie_order_id);
            } else {
                $mollieOrder = null;
            }

            return view('admin.store.orders.show', [
                'order'        => $bestellingen,
                'mollie_order' => $mollieOrder
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         *
         * @return void
         */
        public static function edit($id) {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  Request $request
         * @param  int     $id
         *
         * @return void
         */
        public static function update(Request $request, $id) {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         *
         * @return void
         */
        public static function destroy($id) {
            //
        }
    }
