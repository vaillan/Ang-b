<?php

namespace App\Models\ConservationStateSelected;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConservationStateSelected extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'conservation_state_selected';

    protected $fillable = [
        'conservation_state_id',
        'post_client_id',
    ];
}