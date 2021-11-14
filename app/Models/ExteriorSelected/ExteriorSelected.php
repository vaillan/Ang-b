<?php

namespace App\Models\ExteriorSelected;

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
    ];
}
