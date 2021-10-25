<?php

namespace App\Models\Divisa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Divisa extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'divisas';

    protected $fillable = [
        'type_divisa',
    ];
}
