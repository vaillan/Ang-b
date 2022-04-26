<?php

namespace App\Models\PaypalProduct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaypalProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $table = 'products_paypal';
   
    protected $fillable = [
      'name',
      'description',
      'paypal_product_identifier',
      'paypal_mode',
      'user_id',
      'created_by',
      'updated_by',
    ];
}
