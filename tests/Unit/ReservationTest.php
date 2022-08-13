<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use User\Repositories\ReservationRepository;

class ReservationTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_create_a_reservation_success()
    {
        $payload = [
            'room_id' => 3,
            'start_date' => '2022-08-12',
            'end_date' => '2022-08-15',
        ];

        $repository = app(ReservationRepository::class);
        $response = $repository->createReservation($payload);

        $this->assertArrayHasKey('start_date', $response);
    }

    public function test_create_a_reservation_exception_room_is_already_booked()
    {
        try {
            $payload = [
                'room_id' => 3,
                'start_date' => '2022-08-12',
                'end_date' => '2022-08-15',
            ];

            $repository = app(ReservationRepository::class);
            $repository->createReservation($payload);
            $repository->createReservation($payload);
        } catch (\Exception $exception) {
            $this->assertStringMatchesFormat($exception->getMessage(), 'O quarto selecionado já está reservado.');
        }
    }

    public function test_create_a_reservation_with_room_is_invalid()
    {
        $payload = [
            'room_id' => 99,
            'start_date' => '2022-08-12',
            'end_date' => '2022-08-15',
        ];

        $repository = app(ReservationRepository::class);

        try {
            $repository->createReservation($payload);
        } catch (\Exception $exception) {
            $this->assertStringMatchesFormat($exception->getMessage(), 'Escolha um quarto válido.');
        }
    }

    public function test_create_a_reservation_with_numer_days_exception()
    {
        $payload = [
            'room_id' => 1,
            'start_date' => '2022-08-12',
            'end_date' => '2022-08-12',
        ];

        $repository = app(ReservationRepository::class);

        try {
            $repository->createReservation($payload);
        } catch (\Exception $exception) {
            $this->assertStringMatchesFormat($exception->getMessage(), 'O número de dias tem que ser maior que 1.');
        }
    }

    public function test_check_in_date_cannot_be_greater_than_the_check_out_date()
    {
        $payload = [
            'room_id' => 1,
            'start_date' => '2022-08-13',
            'end_date' => '2022-08-12',
        ];

        $repository = app(ReservationRepository::class);

        try {
            $repository->createReservation($payload);
        } catch (\Exception $exception) {
            $this->assertStringMatchesFormat($exception->getMessage(), 'A data de check-in não pode ser maior que a data de check-out.');
        }
    }

    public function test_list_all_reservations()
    {
        $repository = app(ReservationRepository::class);
        $reservations = $repository->all();

        $this->assertArrayHasKey('id', $reservations->first());
    }

    public function test_list_a_reservation_by_id()
    {
        $payload = [
            'room_id' => 3,
            'start_date' => '2022-08-12',
            'end_date' => '2022-08-15',
        ];

        $repository = app(ReservationRepository::class);

        $repository->createReservation($payload);
        $reservation = $repository->findById(3);

        $this->assertArrayHasKey('pivot', $reservation->toArray());
    }
}
