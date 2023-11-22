<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'is_recurring',
        'category',
        'completed',
        'notes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'is_recurring' => 'boolean',
        'completed' => 'boolean',
    ];
}
