<?php

namespace User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use User\Http\Requests\RoomRequest;
use User\Repositories\RoomRepository;

class RoomController extends Controller
{
    private $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function index(Request $request)
    {
        $reserved = $request->query('reserved');

        return $this->roomRepository->all($reserved);
    }

    public function show($id)
    {
        return $this->roomRepository->findById($id);
    }

    public function store(RoomRequest $request)
    {
        $data = $request->validated();

        return $this->roomRepository->create($data);
    }

    public function destroy($id)
    {
        return $this->roomRepository->destroy($id);
    }
}
