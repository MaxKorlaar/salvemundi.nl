<?php
    /**
     * Created by Max in 2018
     */

    namespace App\Helpers;

    use Mollie\Api\MollieApiClient;

    /**
     * Class PaymentHelper
     *
     * @package App\Helpers
     */
    class PaymentHelper extends MollieApiClient {

        /**
         * PaymentHelper constructor.
         *
         * @throws \Mollie\Api\Exceptions\ApiException
         * @throws \Mollie\Api\Exceptions\IncompatiblePlatform
         */
        public function __construct() {
            parent::__construct();
            $this->setApiKey(config('mollie.key'));
        }

    }