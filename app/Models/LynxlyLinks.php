<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LynxlyLinks extends Model
{
    protected $table = 'lynxly_links';
    protected $fillable = ['clients_leadpops_id', 'leadpop_id','client_id', 'slug_name', 'target_url'];
    protected $hidden = ["created_at", "updated_at"];


    public static function checkUniqunessOfHash($hash){
        return self::where('slug_name',$hash)->count();
    }
}

