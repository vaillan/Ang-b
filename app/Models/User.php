<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\AsStringable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Helpers\Helpers;
use App\Models\categories\Category;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'role',
        'about_me',
        'name',
        'nick',
        'image',
        'url_image',
        'country',
        'city',
        'postal_code',
        'address',
        'configuration',
        'created_by',
        'updated_by',
        'user_type_id',
        'category_id',
        'password_encryp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'configuration' => 'object',
    ];

    /**
     * @return string
     */
    public function getPasswordEncrypAttribute($value)
    {
      $helper = new Helpers();
      $first_key = $helper->first_key;
      $second_key = $helper->second_key;
      $cipher = $helper->cipher;
      return $helper->decrypt($value, base64_encode($first_key), base64_encode($second_key), $cipher);
    }

    public function category() {
      return $this->belongsTo(Category::class);
    }

}
