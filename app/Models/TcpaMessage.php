<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TcpaMessage extends Model
{
    protected $table = 'client_funnel_tcpa_security';
    public $timestamps = false;
    protected $fillable = ['client_id',
        'is_active',
        'is_required',
        'tcpa_title',
        'domain_id',
        'tcpa_text',
        'content_type',
        'leadpop_version_id',
        'leadpop_version_seq',
        'text_color',
        'icon',
    ];

    const CREATED_AT = 'date_added';
    const UPDATED_AT = 'date_updated';



    public function getDateAddedAttribute($date)
    {
        if($date==null) return $date;
        else return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d F, Y');
    }
}
