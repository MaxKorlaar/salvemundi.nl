<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 11/02/2019
 * Time: 11:32
 */

namespace App\Helpers\eboekhouden;

abstract class TransactionType
{
    const Received = "GeldOntvangen";
    const CashBack = "GeldUitgegeven";
}