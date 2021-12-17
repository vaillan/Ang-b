<?php

namespace App\Models\ServiceSelected;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Service\Service;
class ServiceSelected extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'services_selected';

    protected $fillable = [
        'service_id',
        'post_client_id',
        'post_user_id',
    ];

    /**
     * Get the service by service selected.
    */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
