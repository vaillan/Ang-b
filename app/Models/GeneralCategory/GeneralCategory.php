<?php

namespace App\Models\GeneralCategory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'general_categories';

    protected $fillable = [
        'general_category_type',
    ];
}
