<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\TicketStoreResource;
use App\Models\Ticket;
use App\Repositories\Ticket\TicketRepositoryInterface;
use App\Services\FileService;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TicketController extends Controller
{

    private TicketRepositoryInterface $ticket;
    public FileService $fileService;

    public function __construct(TicketRepositoryInterface $ticket)
    {
        $this->ticket = $ticket;
        $this->fileService = new FileService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = $this->ticket->index();
        return view('admin.tickets-index', compact('tickets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketStoreRequest $request)
    {
        $ticket = $this->ticket->create($request->validated());
        return TicketStoreResource::make($ticket);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        $ticket = $this->ticket->show($ticket);
        return view('admin.tickets-show', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(UpdateStatusRequest $request, Ticket $ticket)
    {
        $this->ticket->updateStatus($ticket, $request->validated());

        return back()->with('success', 'Ticket status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function downloadFile(Media $media)
    {
        return $this->fileService->download($media);
    }

    public function downloadAllFile(Ticket $ticket)
    {
        return $this->fileService->downloadAllFille($ticket, 'tickets');
    }
}
