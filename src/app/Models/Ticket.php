<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'customer_id',
        'responded_id',
        'subject',
        'text',
        'status',
        'responded_at',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function responded(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responded_id');
    }
}
