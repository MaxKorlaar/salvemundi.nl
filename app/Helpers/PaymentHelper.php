<?php
    /**
     * Created by Max in 2018
     */

    namespace App\Helpers;

    use Mollie\Api\Exceptions\ApiException;
    use Mollie\Api\Exceptions\IncompatiblePlatform;
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
         * @throws ApiException
         * @throws IncompatiblePlatform
         */
        public function __construct() {
            parent::__construct();
            $this->setApiKey(config('mollie.key'));
        }

    }