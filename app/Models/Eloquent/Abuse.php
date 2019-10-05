<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Abuse extends Model
{
    use SoftDeletes;

    public static $supportCategory=['group'];
    public static $cause=[
        '0'=>'General'
    ];

    protected $fillable=[
        'title', 'cause', 'supplement', 'link', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Eloquent\UserModel', 'user_id');
    }
}
