<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptancePool extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function published(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($this->created_at)->toFormattedDateString(),
        );
    }
}
