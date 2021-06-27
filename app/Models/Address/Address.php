<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $table = 'address';

  protected $fillable = [
      'user_id',
      'post_user_id',
      'post_client_id',
      'clave',
      'estado',
      'localidad',
      'municipio',
      'address',
      'lat',
      'lng',
  ];
}
