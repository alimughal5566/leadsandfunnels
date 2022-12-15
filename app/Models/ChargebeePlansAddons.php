<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ChargebeePlansAddons extends Model
{
//  Assigning custom table to this model
    protected $table = 'chargebee_plans_addons';

//  Defining primary key
    protected $primaryKey = 'id';

//  Fillables
    protected $fillable = [

        'plan_id',
        'plan_name',
        'period_unit',
        'plan_price',
        'pricing_model',
        'client_type',
        'industry',
        'funnel_type',
        'client_plan_type',
        'additional_fields',
        'plan_type',
        'status',
        'plan_price',
        'client_type',
        'client_plan_type',
        'date_created',
        'date_updated',
    ];



    /**
     * Set the plans's date_updated.
     *
     * @param  string  $value
     * @return void
     */
    public function setDateUpdatedAttribute($value)
    {
        if($value)
        $this->attributes['date_updated'] = Carbon::createFromTimestamp($value)->toDateTimeString();;
    }

}
