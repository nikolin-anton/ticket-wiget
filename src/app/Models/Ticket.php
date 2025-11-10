<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

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

    #[Scope]
    public function lastDay($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    #[Scope]
    public function lastWeek($query)
    {
        return $query->where('created_at', '>=', now()->subWeek());
    }

    #[Scope]
    public function lastMonth($query)
    {
        return $query->where('created_at', '>=', now()->subMonth());
    }
}
