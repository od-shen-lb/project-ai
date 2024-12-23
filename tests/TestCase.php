<?php

namespace Tests;

use Database\Seeders\Develop\DatabaseSeeder as DevDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected $seeder = DevDatabaseSeeder::class;
}
