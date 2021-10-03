<?php

namespace App\Models\Exterior;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exterior extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'exteriors';

    protected $fillable = [
        'exterior_type',
    ];
}
