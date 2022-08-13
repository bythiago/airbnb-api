<?php

namespace User\Http\Controllers;

use App\Http\Requests\ReservationRequest;
use Illuminate\Routing\Controller;
use User\Repositories\ReservationRepository;

class ReservationController extends Controller
{
    private ReservationRepository $reservationRepository;

    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function index()
    {
        return $this->reservationRepository->all();
    }

    public function show($id)
    {
        return $this->reservationRepository->findById($id);
    }

    public function store(ReservationRequest $request)
    {
        $validated = $request->all();

        return $this->reservationRepository->createReservation($validated);
    }
}
