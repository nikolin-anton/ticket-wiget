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
}
