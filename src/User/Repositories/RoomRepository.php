<?php

namespace User\Repositories;

use App\Models\Room;
use User\Exceptions\RoomException;

class RoomRepository
{
    private $model;

    public function __construct(Room $model)
    {
        $this->model = $model->query();
    }

    public function all($reserved = null)
    {
        $query = $this->model->with(['owner']);

        if (is_null($reserved)) {
            return $query->get();
        }

        $query->when($reserved, function ($qb) {
            return $qb->has('reservations');
        })->when(! $reserved, function ($qb) {
            return $qb->doesntHave('reservations');
        });

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->findOr($id, function () {
            throw new RoomException('Room not found.', 404);
        });
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function destroy($id)
    {
        return $this->model->findOrFail($id)->deleteOrFail();
    }
}
