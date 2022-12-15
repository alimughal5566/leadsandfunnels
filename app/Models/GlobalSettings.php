<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSettings extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'global_settings';
    protected $fillable = [

        'client_id',
        'logo',
        'logo_url',
        'funnel_ids',
        'companyname',
        'phonenumber',
        'email',
        'companyname_active',
        'phonenumber_active',
        'email_active',
        'image',
        'image_url',
        'image_path',
        'logo_path',
        'logo_color',

        'seo_title_active', 'seo_title', 'seo_description_active', 'seo_description', 'seo_keyword_active', 'seo_keyword',


        'disclosures_active', 'disclosures_type', 'disclosures_text', 'disclosures_url', 'disclosures',

        'sec_fot_licence_number_active', 'sec_fot_url_active',

        'contact_us_active', 'contact_type', 'contact_text', 'contact_url', 'contact',

        'about_us_active', 'about_type', 'about_text', 'about_url', 'about',

        'licensing_information_active', 'licensing_type', 'licensing_text', 'licensing_url', 'licensing',

        // Footer => PrivacyPolicy
        'privacy_type', 'privacy_url', 'privacy', 'privacy_text', 'privacy_policy_active',

        'terms_of_use', 'terms_of_use_active', 'terms_type', 'terms_text', 'terms_url', 'terms',

        'compliance_is_linked', 'compliance_text', 'compliance_link',

        'license_number_text',
        'license_number_is_linked',
        'license_number_link',
        'bk_image_active',
        'default_logo',
        'logo1',
        'logo2',
        'logo3',

        'gf_image_active',
        'swatches',
        'bgimage_url',
        'active_backgroundimage',
        'background_overlay',
        'bgimage_properties',
        'bgimage_style',
        'background_custom_color',
        'background_overlay_opacity',
        'background_type',
        'date_created',
        'date_updated'
    ];
}
