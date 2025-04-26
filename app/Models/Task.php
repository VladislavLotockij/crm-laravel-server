<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'priority',
        'deal_id',
        'assigned_to',
        'created_by'
    ];

    protected $dates = [
        'due_date',
        'created_at',
        'updated_at'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
