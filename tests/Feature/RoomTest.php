<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;

class RoomTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_exception_http_too_many_requests()
    {
        for ($i = 0; $i <= 60; $i++) {
            $response = $this->withHeaders(['Accept' => 'application/json'])->get('/api/rooms');
        }

        $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    }

    public function test_create_a_room_with_return_success()
    {
        $factory = Room::factory()->make();
        $response = $this->postJson('/api/rooms', $factory->toArray());
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_show_room_by_id()
    {
        $response = $this->getJson('/api/rooms/1');
        $response->assertJsonStructure([
            'id',
            'home_type',
            'room_type',
            'total_occupancy',
            'total_bedrooms',
            'total_bathrooms',
            'summary',
            'address',
            'has_tv',
            'has_kitchen',
            'has_air_con',
            'has_heating',
            'has_internet',
            'price',
            'published_at',
            'owner_id',
            'created_at',
            'updated_at',
            'latitude',
            'longitude',
        ]);
    }

    public function test_create_a_room_with_return_message_validation()
    {
        $response = $this->postJson('/api/rooms', []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_a_room_with_return_success()
    {
        $factory = Room::factory()->create();
        $response = $this->deleteJson('/api/rooms/'.$factory->id);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_find_a_room_with_return_exception_not_found()
    {
        $response = $this->getJson('/api/rooms/99');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJson(['error' => 'Room not found.']);
    }
}
