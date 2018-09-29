<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'mi_user';

    public $timestamps = false;

    protected $primaryKey= 'user_id';

    protected $fillable=['username','password','mobile'];


}
