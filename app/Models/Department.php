<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function heads(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'department_heads')
            ->withTimestamps();
    }

    public function hasHead(User $user): bool
    {
        return $this->heads()->where('user_id', $user->id)->exists();
    }
}
