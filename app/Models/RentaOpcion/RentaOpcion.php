<?php

namespace App\Models\RentaOpcion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentaOpcion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'renta_opciones';

    protected $fillable = [
        'type_rent_option',
    ];
}
