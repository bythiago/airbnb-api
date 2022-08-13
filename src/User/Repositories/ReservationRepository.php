<?php

namespace User\Repositories;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReservationRepository
{
    private User $user;

    private Room $room;

    public function __construct(User $user, Room $room)
    {
        $this->user = $user;
        $this->room = $room;
    }

    public function all()
    {
        return $this->user->with('reservations')->whereId(2)->get();
    }

    public function findById($id)
    {
        return $this->user->findOrFail(2)->reservations()->where('room_id', $id)->firstOrFail();
    }

    public function createReservation(array $data)
    {
        $room = $this->room->find($data['room_id']);

        if (! $room) {
            throw new \Exception('Escolha um quarto válido.');
        }

        $payload = $this->validateReservation($room, $data);

        $this->user->find(2)->reservations()->attach($room, $payload);

        return $payload;
    }

    private function validateReservation(Room $room, array $data)
    {
        if ($room->reservations()->exists()) {
            throw new \Exception('O quarto selecionado já está reservado.', Response::HTTP_UNAUTHORIZED);
        }

        $startDate = Carbon::create($data['start_date']);
        $endDate = Carbon::create($data['end_date']);

        if ($startDate > $endDate) {
            throw new \Exception('A data de check-in não pode ser maior que a data de check-out.');
        }

        $numberOfDays = $startDate->diffInDays($endDate);

        if (! $numberOfDays) {
            throw new \Exception('O número de dias tem que ser maior que 1.');
        }

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price' => $room->price,
            'total' => $room->price * $numberOfDays,
        ];
    }
}
