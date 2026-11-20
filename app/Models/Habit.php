<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Habit extends Model
{
    protected $fillable = ['name', 'frequency'];

    public function logs(): HasMany
    {
        return $this->hasMany(HabitLog::class);
    }
}