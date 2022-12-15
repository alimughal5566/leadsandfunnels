<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClientLeadpopsSocial extends Model
{
//  Assigning custom table to this model
    protected $table = 'clients_leadpops_social';

//  Defining primary key
    protected $primaryKey = 'id';

//  Fillables
    protected $fillable = [

        'client_id',
        'leadpop_id',
        'leadpop_version_id',
        'leadpop_version_seq',

        'social_image',
        'image_type',
        'image_width',
        'image_height'
    ];

}
