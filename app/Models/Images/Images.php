<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Storage;
class Images extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'images';
    // protected $appends = ['content'];
    protected $fillable = [
        'post_client_id',
        'image',
        'url',
        'content',
    ];

    // public function getContentAttribute() {
    //     $content = Storage::disk('usersClientImg')->get($this->image);
    //     $image = "data:image/png;base64,".base64_encode($content);
    //     return $image;
    // }
}
