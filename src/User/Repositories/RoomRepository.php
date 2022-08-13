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

    public function all()
    {
        return $this->model->with(['owner'])->get();
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
