<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 11/02/2019
 * Time: 11:33
 */

namespace App\Helpers\eboekhouden;


abstract class GeneralLedgerAccount
{
    const ContributionMembersExpenses = "4008";
    const MerchandiseExpenses = "4307";
    const KampFeb2019Expenses = "4602";

    const ContributionMembersIncomes = "8008";
    const MerchandiseIncomes = "8307";
    const KampFeb2019Incomes = "8602";
}