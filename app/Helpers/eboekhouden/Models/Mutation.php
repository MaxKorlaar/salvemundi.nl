<?php
    /**
     * Created by PhpStorm.
     * User: pc
     * Date: 11/02/2019
     * Time: 11:34
     */

    namespace App\Helpers\eboekhouden\Models;

    /**
     * Class Mutation
     *
     * @package App\Helpers\eboekhouden\Models
     */
    class Mutation {
        /**
         * Mutation constructor.
         *
         * @param $row
         * @param $paymentMethod
         * @param $transactionType
         * @param $description
         */
        public function __construct($row, $paymentMethod, $transactionType, $description) {
            $this->MutatieNr     = 0;
            $this->Soort         = $transactionType;
            $this->Datum         = date("Y-m-d") . 'T' . date("H:i:s");
            $this->Rekening      = $paymentMethod;
            $this->Omschrijving  = $description;
            $this->InExBTW       = "IN";
            $this->MutatieRegels = $row;
        }
    }