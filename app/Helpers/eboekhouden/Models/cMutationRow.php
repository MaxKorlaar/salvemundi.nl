<?php
    /**
     * Created by PhpStorm.
     * User: pc
     * Date: 11/02/2019
     * Time: 11:34
     */

    namespace App\Helpers\eboekhouden\Models;

    /**
     * Class cMutationRow
     *
     * @package App\Helpers\eboekhouden\Models
     */
    class cMutationRow {
        /**
         * cMutationRow constructor.
         *
         * @param $amount
         * @param $generalLedgerAccount
         */
        public function __construct($amount, $generalLedgerAccount) {
            $this->BedragInvoer      = $amount;
            $this->TegenrekeningCode = $generalLedgerAccount;
            $this->BedragExclBTW     = $amount;
            $this->BedragBTW         = 0;
            $this->BedragInclBTW     = $amount;
            $this->BTWCode           = "GEEN";
            $this->BTWPercentage     = 0;
            $this->KostenplaatsID    = 0;
        }
    }
