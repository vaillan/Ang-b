<?php

namespace App\Models\ExteriorSelected;

use App\Models\Exterior\Exterior;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExteriorSelected extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'exteriors_selected';

    protected $fillable = [
        'exterior_id',
        'post_client_id',
        'post_user_id',
    ];

    public function exterior() 
    {
        return $this->belongsTo(Exterior::class, 'exterior_id', 'id');   
    }
}
