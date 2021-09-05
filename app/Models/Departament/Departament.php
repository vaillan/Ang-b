<?php

namespace App\Models\Departament;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departament';

    protected $fillable = [
        'departament_type',
    ];
}
