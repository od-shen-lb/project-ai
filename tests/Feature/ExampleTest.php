<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function testHealthCheck()
    {
        $response = $this->getJson(route('health-check.index'));

        $response
            ->assertStatus(200)
            ->assertJson(['status' => 'ok']);
    }
}
