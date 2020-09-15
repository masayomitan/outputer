<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HttpStatusTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    public function testBookIndexTest()
    {
        $response = $this->get('/books');

        $response->assertStatus(200);
    }

    public function testBookShowNotExists()
    {

        $response = $this->get('/books/0');

        $response->assertStatus(404);
    }


}
