<?php

namespace App\Models\ServiceSelected;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSelected extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'services_selected';

    protected $fillable = [
        'service_id',
        'post_client_id',
    ];
}
