<?php

namespace User\Http\Controllers;

use App\Http\Controllers\Controller;
use User\Http\Requests\RoomRequest;
use User\Repositories\RoomRepository;

class RoomController extends Controller
{
    private $repository;

    public function __construct(RoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->repository->all();
    }

    public function show($id)
    {
        return $this->repository->findById($id);
    }

    public function store(RoomRequest $request)
    {
        $data = $request->validated();

        return $this->repository->create($data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }
}
