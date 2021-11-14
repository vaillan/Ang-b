<?php

namespace App\Models\PostClient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
   ];

   /**
    * Get the user that owns the comment.
    */
   public function user()
   {
       return $this->belongsTo('App\Models\User', 'user_id');
   }
   
   public function address() {
       return $this->hasOne('App\Models\Address\Address', 'post_client_id');
   }
}
