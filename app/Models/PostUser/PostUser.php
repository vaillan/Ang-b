<?php

namespace App\Models\PostUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'post_user';
    
    protected $fillable = [
        'user_id',
        'budget_minimum',
        'budget_maximum',
        'init_date',
        'end_date',
        'divisa_budget_minimum',
        'divisa_budget_maximum',
        'description',
        'localidad_id',
    ];
    /**
     * Get the user that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function address() {
        return $this->hasOne('App\Models\Address\Address', 'post_user_id');
    }

    public function localidad() {
        return $this->hasOne('App\Models\Localidad\Localidad', 'id', 'localidad_id');
    }
}
