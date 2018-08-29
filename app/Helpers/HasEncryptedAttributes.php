<?php
    /**
     * Created by Max in 2017
     */

    namespace App\Helpers;

    use Illuminate\Support\Facades\Crypt;

    /**
     * Trait HasEncryptedAttributes
     *
     * @package App\Helpers
     */
    trait HasEncryptedAttributes {

        /**
         * @param $key
         *
         * @return string
         */
        public function getAttribute($key) {
            $value = parent::getAttribute($key);
            if ($value === null) return null;
            if ($value === 0) return 0;
            if (in_array($key, $this->encrypted)) {
                $value = Crypt::decrypt($value);
            }
            return $value;
        }

        /**
         * @param $key
         * @param $value
         *
         * @return mixed
         */
        public function setAttribute($key, $value) {
            if ($value !== null && in_array($key, $this->encrypted)) {
                $value = Crypt::encrypt($value);
            }

            return parent::setAttribute($key, $value);
        }

        /**
         * @return array
         */
        public function getEncrypted(): array {
            return $this->encrypted;
        }

        /**
         * @param array $encrypted
         */
        public function setEncrypted(array $encrypted) {
            $this->encrypted = $encrypted;
        }
    }