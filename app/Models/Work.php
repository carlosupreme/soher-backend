<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'skills',
        'deadline',
        'budget',
        'photo',
        'client_id',
        'status'
    ];

    protected $casts = [
        'skills' => 'object',
        'deadline' => 'date'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

}
