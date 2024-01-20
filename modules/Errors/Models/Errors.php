<?php

namespace Modules\Errors\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'name',
        'logs',
    ];
    protected $casts = [
        'logs' => 'array',
    ];
}
