<?php

namespace App\Models\usersType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserType extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'users_type';

  protected $fillable = [
    'role',
  ];
}
