<?php
    /**
     * Created by Max in 2018
     */

    namespace App\Helpers;

    /**
     * Class PaymentHelper
     *
     * @package App\Helpers
     */
    class PaymentHelper extends \Mollie_API_Client {

        /**
         * PaymentHelper constructor.
         *
         * @throws \Mollie_API_Exception_IncompatiblePlatform
         * @throws \Mollie_API_Exception
         */
        public function __construct() {
            parent::__construct();
            $this->setApiKey(config('mollie.key'));
        }

    }