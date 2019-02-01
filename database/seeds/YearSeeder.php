<?php

    use Illuminate\Database\Seeder;

    /**
     * Class YearSeeder
     */
    class YearSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         * @throws Throwable
         */
        public function run() {
            \App\Year::getCurrentYear();
        }
    }
