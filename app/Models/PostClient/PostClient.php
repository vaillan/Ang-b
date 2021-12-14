<?php

namespace App\Models\PostClient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Departament\Departament;
use App\Models\Office\Office;
use App\Models\Grouund\Ground;
use App\Models\House\House;
use App\Models\User;
class PostClient extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = 'post_client';
   
    protected $fillable = [
        'user_id',
        'moneda_id',
        'renta_opcion_id',
        'ground_id',
        'office_id' ,
        'departament_id',
        'house_id',
        'pais',
        'estado',
        'ciudadMunicipio',
        'calle',
        'colonia',
        'titulo',
        'descripcion',
        'status',
        'precio',
        'type_post',
        'numExt',
        'numInt',
        'youtubeId',
        'leflet_map',
        'num_recamaras',
        'num_bathroom',
        'num_estacionamiento',
        'superficie_construida',
        'superficie_terreno',
        'otros',
    ];

    /**
    * Get the user that owns the comment.
    */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function house() {
        return $this->belongsTo(House::class, 'house_id');
    }

    public function departament() {
        return $this->belongsTo(Departament::class, 'departament_id');
    }

    public function office() {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function ground() {
        return $this->belongsTo(Ground::class, 'ground_id');
    }
}
