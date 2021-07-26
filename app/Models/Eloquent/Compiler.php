<?php

namespace App\Models\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compiler extends Model
{
    protected $table='compiler';
    protected $primaryKey='coid';
    const DELETED_AT=null;
    const UPDATED_AT=null;
    const CREATED_AT=null;

    public function getReadableNameAttribute()
    {
        return $this->display_name.' @ '.$this->oj->name;
    }

    public function oj() {
        return $this->belongsTo('App\Models\Eloquent\OJ','oid','oid');
    }
}
