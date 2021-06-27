<?php

namespace App\Models\Estado;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estados';
    
    protected $fillable = [
        'clave',
        'nombre',
        'abrev',
    ];

    public function municipio() {
        return $this->hasMany('App\Models\Municipios\Municipios', 'estado_id');
    }
}
