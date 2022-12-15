<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SocialMediaSharing extends Model
{
//  Assigning custom table to this model
    protected $table = 'social_media_sharing';

//  Defining primary key
    protected $primaryKey = 'id';

//  Fillables
    protected $fillable = [

        'leadpop_vertical_id',
        'leadpop_version_id',
        'leadpop_version_seq',

        'fb_app_id',
        'twitter_card',
//        'url',

        'og_type',
        'og_title',
        'og_description',
        'og_image',
        'og_image_type',
        'og_image_width',
        'og_image_height',

//        'email_from',
        'email_subject',
        'email_text',
    ];

}
