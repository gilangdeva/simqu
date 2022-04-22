<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    protected $table = 'tbl_master_users';
    protected $primaryKey = 'user_id';

    protected $fillable = [
    	'username',
    	'complete_name',
    	'password',
    	'email',
    	'token',
    	'user_default',
        'picture',
        'created_at',
        'creator',
        'updated_at',
        'pic'
    ];
}
