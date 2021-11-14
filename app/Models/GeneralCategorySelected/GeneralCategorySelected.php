<?php

namespace App\Models\GeneralCategorySelected;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralCategorySelected extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'general_categories_selected';

    protected $fillable = [
        'general_category_id',
        'post_client_id',
    ];

}
