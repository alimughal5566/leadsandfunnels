<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
 * Class TCPAInsertDataSeeder
 *
 * Command to execute seeder - php artisan db:seed --class=TCPAInsertDataSeeder
 */
class TCPAInsertDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $old_tcpa_table = 'mm_tcpa_options';
       $new_tcpa_table = 'client_funnel_tcpa_security';
       $domain_table = 'clients_funnels_domains';

           if(\DB::table($new_tcpa_table)->select('id')->where('content_type','=',1)->count() < 50)
           {
               try{
                   $old_data =  \DB::table($old_tcpa_table)->select($old_tcpa_table.'.mortgage_tcpa_text',$old_tcpa_table.'.mortgage_tcpa_active',$domain_table.'.*')
                       ->join($domain_table,$old_tcpa_table.'.client_id','=',$domain_table.'.client_id')
                       ->get();
                   foreach ($old_data as $data)
                   {
                       $tcpa_text = $data->mortgage_tcpa_text;
                       $tcpa_active = $data->mortgage_tcpa_active;
                       if($tcpa_text == '')
                       {
                           $tcpa_text = $data->realestate_tcpa_text;
                           $tcpa_active = $data->realestate_tcpa_active;
                       }
                       DB::table($new_tcpa_table)->insert([[
                           'tcpa_title' => 'Default TCPA Message',
                           'tcpa_text'  => $tcpa_text,
                           'is_required'  => false,
                           'is_active'  => $tcpa_active,
                           'client_id'  => $data->client_id,
                           'domain_id'  => $data->clients_domain_id,
                           'leadpop_version_id'  => $data->leadpop_version_id,
                           'leadpop_version_seq'  => $data->leadpop_version_seq,
                           'content_type'  => 1,
                       ]]);
                   }
               }
               catch (\Exception $e){
                   $this->command->info('TCPAInsertDataSeeder : Seeder working failed');
               }
           }
           else{
               $this->command->info('TCPAInsertDataSeeder :It seems seeder already worked');
           }


    }
}
