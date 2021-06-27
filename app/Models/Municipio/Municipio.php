<?php

namespace App\Models\Municipio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;
    protected $table = 'municipios';
    
    protected $fillable = [
        'estado_id',
        'clave',
        'nombre',
    ];

    public function estado() {
        return $this->belongsTo('App\Models\Estado\Estado', 'estado_id'); 
    }
}
