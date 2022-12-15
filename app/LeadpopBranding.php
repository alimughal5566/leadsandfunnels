<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeadpopBranding extends Model
{
    //table
    protected  $table = "leadpop_brandings";
    //table primary key
    protected $primaryKey = "id";

    //table columns

    protected $fillable = [
        "client_id",
        "leadpop_version_id",
        "leadpop_version_seq",
        "leadpop_branding_active",
        "leadpop_branding",
        "image_dimension",
        "branding_image",
        "image_size",
        "image_position",
        "backlink_enable",
        "backlink_url",
        "backlink_target",
        "image_title",
        "image_alt"
    ];

}
