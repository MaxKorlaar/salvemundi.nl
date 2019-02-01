<?php

    namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Tests\TestCase;

    /**
     * Class ExampleTest
     *
     * @package Tests\Feature
     */
    class ExampleTest extends TestCase {
        use RefreshDatabase;

        /**
         * A basic test example.
         *
         * @return void
         */
        public function testBasicTest() {
            $response = $this->get('/');

            $response->assertStatus(200);
        }
    }
