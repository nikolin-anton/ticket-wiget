<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketStoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $files = $this->getMedia('tickets');

        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'text' => $this->text,
            'status' => $this->status,
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,

            ],
            'files' => $files->isEmpty()
                ? null
                : $files->map(fn ($file) => [
                    'id' => $file->id,
                    'url' => $file->getUrl(),
                    'name' => $file->file_name,
                ]),
            'created_at' => $this->created_at,
        ];
    }
}
