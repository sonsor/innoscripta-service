<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PizzaControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllPizzas()
    {

        $response = $this->get('/api/pizzas');
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(count($data), 6);
        $this->assertArrayHasKey('id', $data[0]);
        $this->assertArrayHasKey('name', $data[0]);
        $this->assertArrayHasKey('price', $data[0]);
        $this->assertArrayHasKey('description', $data[0]);
        $this->assertArrayHasKey('thumbnail', $data[0]);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetPizzas()
    {

        $response = $this->get('/api/pizzas/1');
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('name', $data);
        $this->assertArrayHasKey('price', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('thumbnail', $data);
    }
}
