<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LeadpopBackgroundColor extends Model
{
//  Assigning custom table to this model
    protected $table = 'leadpop_background_color';

//  Disabling laravel default timestamp
    public $timestamps = false;

//  Overriding larave timestamps with custom column names
    const CREATED_AT = 'date_created';
    const UPDATED_AT = 'date_updated';

//  Defining primary key
    protected $primaryKey = 'id';

//  Fillables
    protected $fillable = [
        'client_id',
        'leadpop_vertical_id',
        'leadpop_vertical_sub_id',
        'leadpop_type_id',
        'leadpop_template_id',
        'leadpop_id',
        'leadpop_version_id',
        'leadpop_version_seq',
        'background_color',
        'active',
        'default_changed',
        'bgimage_url',
        'active_background_image',
        'background_overlay',
        'active_overlay',
        'bgimage_properties',
        'bgimage_style',
        'background_type',
        'background_custom_color',
        'background_overlay_opacity',
        'color_mode',
        'previously_used_colors',
    ];

}
