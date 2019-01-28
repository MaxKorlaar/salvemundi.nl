<?php

    namespace Tests\Unit;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    /**
     * Class ExampleTest
     *
     * @package Tests\Unit
     */
    class ExampleTest extends TestCase {
        use RefreshDatabase;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest() {
            $this->assertTrue(true);
        }
    }
