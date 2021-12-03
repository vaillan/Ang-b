<?php

namespace App\Models\Idioma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idioma extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'idiomas';

    protected $fillable = [
        'lenguage_region_name',
        'iso_code',
        'flag_link'
    ];
}
