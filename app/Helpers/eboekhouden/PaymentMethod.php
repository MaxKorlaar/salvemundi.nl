<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 11/02/2019
 * Time: 11:32
 */

namespace App\Helpers\eboekhouden;

abstract class PaymentMethod{
    const Cash = "1000";
    const Bank = "1010";
    const CreditCard = "1020";
    const SumUp = "1030";
    const Mollie = "1040";
}