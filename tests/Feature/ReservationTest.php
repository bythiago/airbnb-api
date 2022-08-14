<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Laravel\Passport\Passport;
use Tests\TestCase;
use User\Repositories\ReservationRepository;

class ReservationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();

        Passport::actingAs(
            User::factory()->create(),
            ['create-servers']
        );
    }

    public function test_list_all_reversations()
    {
        $response = $this->get('/api/reservations');

        $response->assertStatus(200);
    }

    public function test_create_a_reservation()
    {
        $payload = [
            'room_id' => 1,
            'start_date' => '2022-08-10',
            'end_date' => '2022-08-12',
        ];

        $response = $this->postJson('/api/reservations', $payload);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_list_a_reservation_by_id()
    {
        $payload = [
            'room_id' => 1,
            'start_date' => '2022-08-12',
            'end_date' => '2022-08-15',
        ];

        $repository = app(ReservationRepository::class);
        $repository->createReservation($payload);

        $response = $this->getJson('/api/reservations/1');
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_list_a_reservation_by_id_exception_not_exists()
    {
        $response = $this->getJson('/api/reservations/99');
        $response->assertJson(['message' => 'Reserva não existe.']);
    }
}
