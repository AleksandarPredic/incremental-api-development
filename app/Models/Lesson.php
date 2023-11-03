<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'some_bool'];

    public function Tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    protected function someBool(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => (bool)$value,
            set: fn (string $value) => (bool)$value,
        );
    }
}
