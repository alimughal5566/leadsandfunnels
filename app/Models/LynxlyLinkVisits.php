<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LynxlyLinkVisits extends Model
{
    protected $table = 'lynxly_link_visits';
    protected $fillable = ['date', 'visits', 'clients_leadpops_id'];
    protected $hidden = ["created_at", "updated_at"];
}

