<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'company_name',
        'address',
        'status',
        'manager_id'
    ];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
