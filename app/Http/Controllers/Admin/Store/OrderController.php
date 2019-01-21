<?php

namespace App\Http\Controllers\Admin\Store;

use App\Helpers\PaymentHelper;
use App\Store\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers\Admin\Store
 */
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Order $bestellingen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Mollie\Api\Exceptions\ApiException
     * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
     */
    public function show(Order $bestellingen)
    {
        if($bestellingen->mollie_order_id !== null) {
            $mollie      = new PaymentHelper();
            $mollieOrder = $mollie->orders->get($bestellingen->mollie_order_id);
        } else {
            $mollieOrder = null;
        }

        return view('admin.store.orders.show', [
            'order' => $bestellingen,
            'mollie_order' => $mollieOrder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
