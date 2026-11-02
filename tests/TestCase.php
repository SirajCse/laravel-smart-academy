<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    /**
     * Set up the test environment.
     *
     * Laravel's RefreshDatabase trait handles the in-memory SQLite setup
     * automatically when phpunit.xml sets DB_CONNECTION=sqlite + DB_DATABASE=:memory:.
     * We just need to ensure parent::setUp() runs first.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }
}
