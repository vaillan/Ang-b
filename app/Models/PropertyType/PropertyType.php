<?php

namespace App\Models\PropertyType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyType extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = 'property_types';
    
    protected $fillable = [
        'property_type'
    ];

    public function ground() {
        return $this->hasMany('App\Models\Grouund\Ground', 'property_type_id', 'id');
    }

    public function office() {
        return $this->hasMany('App\Models\Office\Office', 'property_type_id', 'id');
    }

    public function departament() {
        return $this->hasMany('App\Models\Departament\Departament', 'property_type_id', 'id');
    }

    public function house() {
        return $this->hasMany('App\Models\House\House', 'property_type_id', 'id');
    }
}
