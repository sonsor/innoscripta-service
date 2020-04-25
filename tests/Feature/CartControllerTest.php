<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGenerate()
    {
        $response = $this->post('/api/cart', []);
        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('sub_total', $data);
        $this->assertArrayHasKey('discount', $data);
        $this->assertArrayHasKey('shipping_cost', $data);
        $this->assertArrayHasKey('items', $data);
    }

    public function testGetCart()
    {
        $response = $this->post('/api/cart', []);
        $data = json_decode($response->getContent(), true);

        $response = $this->get('/api/cart/' . $data['id']);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('total', $data);
        $this->assertArrayHasKey('sub_total', $data);
        $this->assertArrayHasKey('discount', $data);
        $this->assertArrayHasKey('shipping_cost', $data);
        $this->assertArrayHasKey('items', $data);
    }

    public function testAddItems()
    {
        $response = $this->post('/api/cart', []);
        $data = json_decode($response->getContent(), true);


        $response = $this->call(
            'POST',
            '/api/cart/' . $data['id'] . '/items',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'product_id' => 1,
                'quantity' => 1
            ])
        );


        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('items', $data);
        $this->assertEquals(count($data['items']), 1);
    }

    public function testUpdateQuantity()
    {
        $response = $this->post('/api/cart', []);
        $data = json_decode($response->getContent(), true);


        $response = $this->call(
            'POST',
            '/api/cart/' . $data['id'] . '/items',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'product_id' => 1,
                'quantity' => 1
            ])
        );

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $response = $this->call(
            'PATCH',
            '/api/cart/' . $data['id'] . '/items/' . $data['items'][0]['id'],
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'quantity' => 3
            ])
        );

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('items', $data);
        $this->assertEquals(count($data['items']), 1);
        $this->assertEquals($data['items'][0]['quantity'], 3);
    }

    public function testRemoveItem()
    {
        $response = $this->post('/api/cart', []);
        $data = json_decode($response->getContent(), true);


        $response = $this->call(
            'POST',
            '/api/cart/' . $data['id'] . '/items',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'product_id' => 1,
                'quantity' => 1
            ])
        );

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $response = $this->call(
            'DELETE',
            '/api/cart/' . $data['id'] . '/items/' . $data['items'][0]['id'],
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('items', $data);
        $this->assertEquals(count($data['items']), 0);
    }

    public function testCheckout()
    {
        $response = $this->post('/api/cart', []);
        $data = json_decode($response->getContent(), true);


        $response = $this->call(
            'POST',
            '/api/cart/' . $data['id'] . '/checkout',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            ''
        );

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('items', $data);
        $this->assertEquals(count($data['items']), 0);
    }
}
