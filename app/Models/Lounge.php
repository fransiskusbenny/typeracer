<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lounge extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(fn($model) => $model->token = Str::uuid());
    }

    public function currentGame(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Game::class)->latestOfMany();
    }

    public function games(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Game::class);
    }
}
