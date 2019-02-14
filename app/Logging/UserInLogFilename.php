<?php
    /**
     * Created by Max in 2019
     */

    namespace App\Logging;

    use Illuminate\Log\Logger;
    use Monolog\Handler\RotatingFileHandler;

    /**
     * Class UserInLogFilename
     *
     * @package App\Logging
     */
    class UserInLogFilename {
        /**
         * Customize the given logger instance.
         *
         * @param  Logger $logger
         *
         * @return void
         */
        public function __invoke($logger) {
            foreach ($logger->getHandlers() as $handler) {
                if ($handler instanceof RotatingFileHandler) {
                    $sapi = php_sapi_name();
                    $handler->setFilenameFormat("{filename}-$sapi-{date}", 'Y-m-d');
                }
            }
        }
    }