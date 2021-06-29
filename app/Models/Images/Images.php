<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Images extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'images';
    
    protected $fillable = [
        'post_client_id',
        'image',
    ];
}
