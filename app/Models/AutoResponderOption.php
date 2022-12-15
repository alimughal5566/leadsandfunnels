<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoResponderOption extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'autoresponder_options';

    public $timestamps = false;

    protected $guarded = [];
}
