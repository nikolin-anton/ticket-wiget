<?php

namespace App\Repositories\Ticket;

use App\Enum\TicketStatusEnum;
use App\Models\Customer;
use App\Models\Ticket;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TicketRepository implements TicketRepositoryInterface
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     */
    public function create(array $data): Ticket
    {
        $customer = Customer::firstOrCreate(
            [
                'email' => $data['email']
            ],
            [
                'name'  => $data['name'],
                'phone' => $data['phone'],
            ]
        );

        $ticket          = new Ticket();
        $ticket->subject = $data['subject'];
        $ticket->text    = $data['text'];
        $ticket->status  = TicketStatusEnum::NEW;
        $ticket->customer()->associate($customer);
        $ticket->save();

        if (!empty($data['files'])) {
            foreach ($data['files'] as $file) {
                $ticket->addMedia($file)->toMediaCollection('tickets');
            }
        }

        return $ticket;
    }

    public function index()
    {
        return Ticket::query()
            ->with('customer')
            ->when(request('email'), function ($query) {
                $query->whereHas('customer', function ($query) {
                    $query->where('email', 'like', '%' . request('email') . '%');
                });
            })
            ->when(request('phone'), function ($query) {
                $query->whereHas('customer', function ($query) {
                    $query->where('phone', 'like', '%' . request('phone') . '%');
                });
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('date_from'), function ($query) {
                $query->whereDate('created_at', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                $query->whereDate('created_at', '<=', request('date_to'));
            })
            ->latest()
            ->paginate(15);
    }

    public function show($ticket)
    {
        $ticket->load('customer');
        $ticket->files = $ticket->getMedia('tickets');
        return $ticket;
    }

    public function updateStatus($ticket, $request)
    {
        $ticket->update(['status' => $request['status']]);

        return $ticket;
    }

    public function destroy($ticket)
    {
        $ticket->delete();
    }
}
