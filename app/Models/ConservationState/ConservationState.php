<?php

namespace App\Models\ConservationState;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConservationState extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'conservation_state';

    protected $fillable = [
        'conservation_state_type',
    ];
}
