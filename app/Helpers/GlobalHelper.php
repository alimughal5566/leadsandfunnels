<?php
/**
 * Created by PhpStorm.
 * User: haroon
 * Date: 10/02/2021
 * Time: 16:41
 */

namespace App\Helpers;


class GlobalHelper
{
    protected static $db;
    protected static $isInitialized;


    /**
     * Initializes local proties according to environment and based on current
     * request
     *
     * @return void
     */
    protected static function init()
    {
        // If it is initialized before, return early
        if ( self::$isInitialized ) {
            return;
        }
        // Get db service instance
        self::$db = app( '\App\Services\DbService' );
        // Get gearman instance

        self::$isInitialized = true;
    }


    public static function createLpCollectionFromLpList( $lplist, $isLpKeysFormat = true )
    {

        // We initialize if not already
        self::init();

        if($isLpKeysFormat){
            $collectedData = self::createKeyArrayformString( $lplist );
        } else {
            $collectedData = $lplist;
        }

        // setup comma seperated data convert multiple queries into one query
        $leadpop_ids = implode( ',', $collectedData->pluck( 'leadpop_id' )->unique()->all() );
        //  $leadpop_ids = implode(',', $collectedData->pluck('leadpop_id')->all());
        $leadpop_version_seq_ids = implode( ',', $collectedData->pluck( 'leadpop_version_seq' )->unique()->all() );


        $queryData = self::$db->fetchAll( 'select id as leadpop_id,
            leadpop_type_id,
            leadpop_vertical_id,
            leadpop_vertical_sub_id,
            leadpop_template_id,
            leadpop_version_id
             from leadpops where id in (' . $leadpop_ids . ')' );

        return collect( $queryData );


    }


    public static function createKeyArrayformString( $lplist )
    {
        self::init();
        $lpListCollection = collect( $lplist );

        $collectedData = $lpListCollection->map( function ( $item, $key ) {
            $lpconstt = explode( "~", $item );
            return [
                'vertical_id' => $lpconstt[ 0 ],
                'subvertical_id' => $lpconstt[ 1 ],
                'leadpop_id' => $lpconstt[ 2 ],
                'leadpop_version_seq' => $lpconstt[ 3 ],
            ];
        } );

        return $collectedData;
    }


    public static function getTrialLaunchCollection( $trial_launch_defaults, $lpListCollection )
    {


        // setup comma seperated data convert multiple queries into one query
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = "select * from $trial_launch_defaults where leadpop_id in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_type_id in  ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_vertical_id in  ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in  ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_template_id in  ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_version_id in   ( " . $leadpop_version_ids . " )";
        $s .= " and leadpop_version_seq = 1";

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


    /**
     * @param $client_id
     * @param $lplist
     * @param $column
     */
    public static function getLeadLineCollection( $leadpop_ids, $column, $client_id )
    {

        // setup comma seperated data convert multiple queries into one query
        self::init();

        $s = "SELECT id, client_id, leadpop_id, leadpop_version_seq,  " . $column . " FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id in ( " . $leadpop_ids . " )";
//        $s .= " AND leadpop_version_seq in ( " . $leadpop_version_seq_ids . " )";

        $res = self::$db->fetchAll( $s );

        return collect( $res );

        /* $variable = $res[$column];
         return $variable;*/
    }

    public static function getBackgroudSwatches()
    {
    }


    public static function getClientLogoByLogoSource( $logo_id, $logo_source )
    {
        self::init();
        if ( $logo_source == 'client' ) {

            $s = "select * from leadpop_logos where id = " . $logo_id;
            $clientlogo = self::$db->fetchRow( $s );

        } elseif ( $logo_source == 'default' ) {
            $clientlogo = null;
        }

        return $clientlogo;


    }


    public static function getLeadpopBackgroudColor( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from leadpop_background_color where client_id = " . $client_id;
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";
//        $s .= " and leadpop_version_seq = " . $version_seq;
        $s .= " and active_backgroundimage = 'y'";

        // echo $s;

        $res = self::$db->fetchAll( $s );
        return collect( $res );
    }


    public static function getSubmissionOptions( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from submission_options where client_id = " . $client_id;
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";
//        $s .= " and leadpop_version_seq = " . $version_seq;
        // $s .= " and active_backgroundimage = 'y'";

        // echo $s;
        $res = self::$db->fetchAll( $s );
        return collect( $res );
    }

    public static function getClientLogos( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from leadpop_logos where client_id = " . $client_id;
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";

        // echo $s;

        $res = self::$db->fetchAll( $s );
        return collect( $res );
    }


    public static function getLeadPopVertical( $lpListCollection )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );


        $s = "select lead_pop_vertical from leadpops_verticals where  id in ( '$leadpop_vertical_ids' )";

        $s = self::$db->fetchAll( $s );
        return collect( $s );
    }


    public static function getDefaultLogoColor( $lpListCollection )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = "select default_logo_color,leadpop_vertical_id, leadpop_vertical_sub_id,leadpop_version_id  from stock_leadpop_logos  where  leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_version_id in  ( " . $leadpop_version_ids . " )";

        // echo $s;

        $s = self::$db->fetchAll( $s );
        return collect( $s );
    }


    public static function getLeadpopBackgroundColor( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from leadpop_background_color where client_id = " . $client_id;
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";
//        $s .= " and leadpop_version_seq = " . $version_seq;
        // $s .= " and active_backgroundimage = 'y'";

        // echo $s;

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


    public static function getLeadpopBackgroundSwatches( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from leadpop_background_swatches where client_id = " . $client_id;
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";
//        $s .= " and leadpop_version_seq = " . $version_seq;
        // $s .= " and active_backgroundimage = 'y'";

        // echo $s;

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


    public static function getLeadpopImages( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from leadpop_images where client_id = " . $client_id;
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";

        // echo $s;

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


    /**
     * @param $lpListCollection
     * @param $client_id
     * @return mixed|string
     */
    public static function getFunnelVariablesCollection( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );

        $s = "SELECT id, client_id, leadpop_id, leadpop_version_seq, funnel_variables FROM clients_leadpops ";
        $s .= " WHERE client_id = " . $client_id;
        $s .= " AND leadpop_id in ( " . $leadpop_ids . " )";
        //   $s .= " AND leadpop_version_seq = " . $leadpop_version_seq;

        $res = self::$db->fetchAll( $s );
        return collect( $res );
        /*  dd($res);
          if ($res) {
              $funnel_variables = json_decode($res['funnel_variables'], 1);
                  return $funnel_variables;
          }*/

        // return "";

    }


    /**
     * @param $lpListCollection
     * @param $client_id
     * @return mixed|string
     */
    public static function getLeadpopsVerticals( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );

        $s = "SELECT lead_pop_vertical FROM leadpops_verticals ";
        $s .= " WHERE id in ( " . $leadpop_vertical_ids . " )";


        $res = self::$db->fetchAll( $s );
        return collect( $res );

    }


    public static function updateColumnsArrayToQuery( $whereColumns )
    {
        $leadpopBackgroundWhere = array_map( function ( $value, $key ) {
            return $key . '="' . $value . '"';
        }, array_values( $whereColumns ), array_keys( $whereColumns ) );

        return implode( ' , ', $leadpopBackgroundWhere );
    }


    public static function whereColumnsArrayToQuery( $whereColumns )
    {
        $leadpopBackgroundWhere = array_map( function ( $value, $key ) {
            return $key . '="' . $value . '"';
        }, array_values( $whereColumns ), array_keys( $whereColumns ) );

        return implode( ' and ', $leadpopBackgroundWhere );
    }


    public static function getClientDomains( $lpListCollection, $client_id )
    {
        self::init();

        $leadpop_vertical_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_id' )->unique()->all() );
        $leadpop_vertical_sub_id_ids = implode( ',', $lpListCollection->pluck( 'leadpop_vertical_sub_id' )->unique()->all() );
        $leadpop_type_ids = implode( ',', $lpListCollection->pluck( 'leadpop_type_id' )->unique()->all() );

        $leadpop_template_ids = implode( ',', $lpListCollection->pluck( 'leadpop_template_id' )->unique()->all() );
        $leadpop_ids = implode( ',', $lpListCollection->pluck( 'leadpop_id' )->unique()->all() );
        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );


        $s = " select * from clients_funnels_domains where client_id in ( " . $client_id. " )";
        $s .= " and leadpop_vertical_id in ( " . $leadpop_vertical_ids . " )";
        $s .= " and leadpop_vertical_sub_id in ( " . $leadpop_vertical_sub_id_ids . " )";
        $s .= " and leadpop_type_id  in ( " . $leadpop_type_ids . " )";
        $s .= " and leadpop_template_id  in ( " . $leadpop_template_ids . " )";
        $s .= " and leadpop_id  in ( " . $leadpop_ids . " )";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";

        // echo $s;

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


    public static function getTcpaMessages( $lpListCollection, $client_id, $clientDomains, $content_type =1, $tcpa_title = "" )
    {
        self::init();


        $leadpop_version_ids = implode( ',', $lpListCollection->pluck( 'leadpop_version_id' )->unique()->all() );
        $domain_ids = implode( ',', $clientDomains->pluck( 'clients_domain_id' )->unique()->all() );


        $s = " select * from client_funnel_tcpa_security where client_id = '" . $client_id . "'";
        if ( $tcpa_title != "" ) {
            $s .= " and tcpa_title  = '" . addslashes($tcpa_title) . "'";
        }
        $s .= " and content_type  = '" . $content_type . "'";
        $s .= " and leadpop_version_id  in ( " . $leadpop_version_ids . " )";
        $s .= " and domain_id  in ( " . $domain_ids . " )";


        /*echo $s;
         exit;*/

        $res = self::$db->fetchAll( $s );

        return collect( $res );
    }


}
