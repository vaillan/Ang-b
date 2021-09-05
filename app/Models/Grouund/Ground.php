<?php

namespace App\Models\Grouund;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ground extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ground';

    protected $fillable = [
    'ground_type',
    ];
}
