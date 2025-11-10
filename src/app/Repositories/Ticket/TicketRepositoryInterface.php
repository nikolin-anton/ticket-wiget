<?php

namespace App\Repositories\Ticket;

interface TicketRepositoryInterface
{
    public function create(array $data);

    public function index();

    public function show($ticket);

    public function updateStatus($ticket, $request);

    public function destroy($ticket);

    public function getStatistics();

    public function findRecentByPhoneOrEmail($phone, $email);
}
