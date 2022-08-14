<?php

namespace Tests\Unit;

use App\Models\Room;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use User\Exceptions\RoomException;
use User\Repositories\RoomRepository;

class RoomTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_create_a_room_with_return_success()
    {
        $factory = Room::factory()->make();
        $repository = app(RoomRepository::class);
        $room = $repository->create($factory->toArray());

        $this->assertArrayHasKey('id', $room);
    }

    public function test_list_all_rooms_with_success()
    {
        $repository = app(RoomRepository::class);
        $rooms = $repository->all();

        $this->assertArrayHasKey('id', $rooms->first());
    }

    public function test_list_all_rooms_with_parameter_reservation_true()
    {
        $repository = app(RoomRepository::class);
        $rooms = $repository->all(1);

        $this->assertIsArray($rooms->toArray());
    }

    public function test_list_all_rooms_with_parameter_reservation_false()
    {
        $repository = app(RoomRepository::class);
        $rooms = $repository->all(0);

        $this->assertIsArray($rooms->toArray());
    }

    public function test_find_room_by_id_with_success()
    {
        $repository = app(RoomRepository::class);
        $room = $repository->findById(1);

        $this->assertArrayHasKey('id', $room);
    }

    public function test_delete_a_room_by_id_with_return_success()
    {
        $factory = Room::factory()->create();
        $repository = app(RoomRepository::class);
        $room = $repository->destroy($factory->id);

        $this->assertTrue($room);
    }

    public function test_find_room_by_id_with_return_exception_not_found()
    {
        try {
            $repository = app(RoomRepository::class);
            $repository->findById(99);
        } catch (RoomException $e) {
            $this->assertStringMatchesFormat($e->getMessage(), 'Room not found.');
        }
    }
}
