<?php
/**
 * Created by PhpStorm.
 * User: MZAC90
 * Date: 15/11/2019
 * Time: 6:00 PM
 */

/**
 * Code Migrated from Zend to Laravel  ==>  LpAcccountRepository --> Source: Default_Model_Account (Account.php)
 */

namespace App\Repositories;


use App\Services\DataRegistry;
use App\Services\DbService;
use LP_Helper;
use Illuminate\Support\Facades\DB;
//require_once($_SERVER['DOCUMENT_ROOT'].'/classes/AuthnetARB.php');

class LpAccountRepository
{
    private $db;
    private $sessionDb;

    public function __construct(DbService $service)
    {
        $this->db = $service;
    }


    /* ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- -----
                    CODE BELOW TO THIS SEPERATION NEEDS TO VERIFY
     ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- ----- */

    public function checkIfOneActiveArb($adata)
    {
        $s = "select count(*) from client_arb_invoices  where client_id = " . $adata['client_id'];
        $s .= " and arb_status = 'p' ";
        $cnt = $this->db->fetchOne($s);
        return $cnt;
    }

    public function updatePackage($post)
    {
        $s = "update client_leadpop_packages set package_id = " . $post["package_id"];
        $s .= " where client_id = " . $post["client_id"];
        $s .= " and invoice_number  = '" . $post["inv"] . "' ";
        $s .= " and leadpop_id  = " . $post["leadpop_id"];
        $s .= " and leadpop_template_id = " . $post["leadpop_template_id"];
        $s .= " and leadpop_vertical_id = " . $post["leadpop_vertical_id"];
        $s .= " and leadpop_vertical_sub_id = " . $post["leadpop_vertical_sub_id"];
        $s .= " and leadpop_version_id = " . $post["leadpop_version_id"];
        $s .= " and leadpop_version_seq = " . $post["leadpop_version_seq"];
        $s .= " and leadpop_type_id = " . $post["leadpop_type_id"];

        $this->db->query($s);
    }

    public function cancelArbCard($adata)
    {

        $s = "select subscriptionId,refid from client_arb_invoices where ";
        $s .= " client_id = " . $adata['client_id'];
        $s .= " and invoice_number = '" . $adata['invoice_number'] . "' ";
        $arbinfo = $this->db->fetchRow($s);

        $arb = new AuthnetARB();
        $arb->setParameter('subscrId', $arbinfo['subscriptionId']);
        $arb->setParameter('refID', $arbinfo['refid']);

        $arb->deleteAccount();

        if ($arb->isSuccessful()) {
            $s = "update client_arb_invoices set arb_status = 'c'  ";
            $s .= " where invoice_number = '" . $adata['invoice_number'] . "' ";
            $s .= " and client_id = " . $adata['client_id'];
            $this->db->query($s);

            $s = "select * from invoice_line where invoice_number = '" . $adata['invoice_number'] . "' ";
            $s .= " and line_item_type = 'LP' ";
            $alllines = $this->db->fetchAll($s);
            for ($i = 0; $i < count($alllines); $i++) {
                $akeys = explode("-", $alllines[$i]['line_item_keys']);
                $vertical_id = $akeys[0];
                $subvertical_id = $akeys[1];
                $aleadpop_ids = $this->getLpNamesFromVerticalIdSubverticalId($vertical_id, $subvertical_id, $adata['client_id']);
                for ($j = 0; $j < count($aleadpop_ids); $j++) {
                    $s = "select * from leadpops where id = " . $aleadpop_ids[$j]['leadpop_id'];
                    $leadpop = $this->db->fetchRow($s);
                    $leadpop_template_id = $leadpop['leadpop_template_id'];
                    $leadpop_version_id = $leadpop['leadpop_version_id'];
                    $leadpop_type_id = $leadpop['leadpop_type_id'];
                    $version_seq = $aleadpop_ids[$j]['leadpop_version_seq'];
                    $leadpop_id = $aleadpop_ids[$j]['leadpop_id'];

                    $s = "update clients_leadpops set leadpop_active = '0' ";
                    $s .= " where client_id = " . $adata['client_id'];
                    $s .= " and leadpop_version_id = " . $leadpop_version_id;
                    $s .= " and leadpop_version_seq = " . $version_seq;
                    $this->db->query($s);
                }
            }
            return 'ok';
        } else {
            $response = $arb->getResponse();
            return $response;
        }

    }

    private function getLpNamesFromVerticalIdSubverticalId($vertical_id, $subvertical_id, $client_id)
    {
        $s = " select a.leadpop_id,a.leadpop_version_seq  ";
        $s .= " from clients_leadpops a, leadpops b,leadpops_descriptions c ";
        $s .= " where a.leadpop_id = b.id ";
        $s .= " and b.leadpop_vertical_id = " . $vertical_id;
        $s .= " and b.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and a.client_id = " . $client_id;
        $s .= " and c.leadpop_vertical_id = b.leadpop_vertical_id ";
        $s .= " and c.leadpop_vertical_sub_id = b.leadpop_vertical_sub_id ";
        $s .= " and c.leadpop_vertical_id = " . $vertical_id;
        $s .= " and c.leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and b.leadpop_version_id = c.id ";
        $s .= " order by a.leadpop_version_seq";
        $lpNames = $this->db->fetchAll($s);
        return $lpNames;
    }

    public function updateArbCard($adata)
    {
        $s = "select subscriptionId,refid from client_arb_invoices where ";
        $s .= " client_id = " . $adata['client_id'];
        $s .= " and invoice_number = '" . $adata['invoice_number'] . "' ";
        $arbinfo = $this->db->fetchRow($s);

        $s = " select line_item_description from invoice_line where client_id = " . $adata['client_id'];
        $s .= " and invoice_number =  '" . $adata['invoice_number'] . "' ";
        $s .= " and line_item = " . $adata['line_id'];
        $arbdescr = $this->db->fetchOne($s);

        $cc_fullname = $adata['cc_fullname'];
        $pos = strpos($cc_fullname, ' ');
        if ($pos) {
            $first_name = substr($cc_fullname, 0, $pos);
            $last_name = substr($cc_fullname, $pos + 1);
        } else {
            $first_name = "";
            $last_name = $adata['cc_fullname'];
        }

        $expiration = $adata['cc_exp_month'] . $adata['cc_exp_year'];
        $cc_number = $adata['cc_number'];

        $arb = new AuthnetARB();
        $arb->setParameter('cardNumber', $cc_number);
        $arb->setParameter('expirationDate', $expiration);
        $arb->setParameter('firstName', $first_name);
        $arb->setParameter('lastName', $last_name);
        $arb->setParameter('subscrId', $arbinfo['subscriptionId']);
        $arb->setParameter('subscrName', substr($arbdescr, 0, 50));
        $arb->setParameter('refID', $arbinfo['refid']);

        $arb->updateAccount();
        if ($arb->isSuccessful()) {
            $s = "update client_arb_invoices set card_expiration = '" . $this->lastday($adata['cc_exp_month'], $adata['cc_exp_year']) . "'  ";
            $s .= " where invoice_number = '" . $adata['invoice_number'] . "' ";
            $s .= " and client_id = " . $adata['client_id'];
            $this->db->query($s);
            return 'ok';
        } else {
            $response = $arb->getResponse();
            return $response;
        }
    }

    function removeglobalRecipent($client_id, $group_identifier, $fkey)
    {
        $s = "select id from lp_auto_recipients ";
        $s .= " where client_id =  " . $client_id;
        $s .= " AND group_identifier =  " . $group_identifier;
        $s .= " AND CONCAT(leadpop_vertical_id,'~',leadpop_vertical_sub_id,'~',leadpop_id,'~',leadpop_version_seq) NOT IN (" . $fkey . " ) ";
        $recipient_ids = $this->db->fetchAll($s);
        if ($recipient_ids) {
            $recipient_ids = implode(",", $recipient_ids);
            $query = "DELETE FROM lp_auto_recipients WHERE group_identifier = '$group_identifier'";
            $query .= " AND id IN ($recipient_ids) AND client_id = $client_id";
            //echo $query;
            $this->db->query($query);
            $query = "DELETE FROM lp_auto_text_recipients WHERE ";
            $query .= " lp_auto_recipients_id IN ($recipient_ids)";
            //echo $query;
            return $this->db->query($query);

        }
    }

    public function saveNewRecipient($adata, $client_id,$conditionlogic=null)
    {
        $condQueryColumns = "";
        $condQueryValues = "";
        $adata['newemail'] = trim($adata['newemail']);
        if (isset($adata['full_name'])) {
            $condQueryColumns = ",full_name";
            $condQueryValues = ",'" . $adata["full_name"] . "'";
        }

        if ($adata['isnewrowid'] == 'n') {
            if ($adata['lpkey_recip']) { // global edit recipient
                $lplist = explode(",", $adata['lpkey_recip']);
                $lplistkey = "'" . implode("','", $lplist) . "'";

                $this->removeglobalRecipent($client_id, $adata["editrowid"], $lplistkey);
                foreach ($lplist as $index => $lp) {

                    $lpconstt = explode("~", $lp);
                    $leadpop_vertical_id = $lpconstt[0];
                    $leadpop_vertical_sub_id = $lpconstt[1];
                    $leadpop_id = $lpconstt[2];
                    $leadpop_version_seq = $lpconstt[3];

                    $s = "select id from lp_auto_recipients ";
                    $s .= " where client_id =  " . $client_id;
                    $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                    $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                    $s .= " AND leadpop_id =  " . $leadpop_id;
                    $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                    $s .= " AND group_identifier =  " . $adata["editrowid"];
                    $recipient_id = $this->db->fetchOne($s);
                    $lastId = $recipient_id;
                    if ($recipient_id) { // update
                        $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                        if (isset($adata['full_name'])) {
                            $s .= ", full_name = '" . $adata['full_name'] . "' ";
                        }
                        $s .= " where client_id =  " . $client_id;
                        $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                        $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                        $s .= " AND leadpop_id =  " . $leadpop_id;
                        $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                        $s .= " AND group_identifier =  " . $adata["editrowid"];
                        $this->db->query($s);
                        if ($adata['newtextcell'] == 'y') {
                            $row = "select * from lp_auto_text_recipients";
                            $row .= " where client_id =  " . $client_id;
                            $row .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                            $row .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                            $row .= " AND leadpop_id =  " . $leadpop_id;
                            $row .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                            $info = $this->db->fetchAll($row);
                            if (count($info) > 0) {
                                $s = "update lp_auto_text_recipients set phone_number = '" . $adata['cell_number'] . "', ";
                                $s .= " carrier = '" . $adata['carrier'] . "'";
                                $s .= " where client_id =  " . $client_id;
                                $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                                $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                                $s .= " AND leadpop_id =  " . $leadpop_id;
                                $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                                $this->db->query($s);
                            } else {
                                $s = "select * from leadpops where id = " . $leadpop_id;
                                $lp = $this->db->fetchRow($s);
                                $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                                $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $recipient_id . ",";
                                $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                                $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                                $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','y')";
                                $this->db->query($s);
                            }
                        } else if ($adata['newtextcell'] == 'n') {
                            $s = "update lp_auto_text_recipients set phone_number = '', carrier = 'none'  ";
                            $s .= " where client_id =  " . $client_id;
                            $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                            $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                            $s .= " AND leadpop_id =  " . $leadpop_id;
                            $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                            $this->db->query($s);
                        }

                    } else { // insert new global
                        $s = "select * from leadpops where id = " . $leadpop_id;
                        $lp = $this->db->fetchRow($s);
                        $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,email_address,is_primary,group_identifier) values (" . $client_id . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n','" . $adata["editrowid"] . "')";
                        $this->db->query($s);
                        $lastId = $this->db->lastInsertId();

                        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                        $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
                        $this->db->query($s);
                    }
                }
                return "edit--" . $adata['lpkey_recip'] . "--" . $adata["editrowid"] . "--" . $lastId;
            } else { // single funnel edit recipient
                list($verticalName, $subverticalName, $leadpop_id, $leadpop_version_seq, $client_id) = explode("~", $adata['newkeys']);

                $s = "select * from leadpops where id = " . $leadpop_id;
                $lp = $this->db->fetchRow($s);
                $s = "select count(*) as cnt  from lp_auto_recipients where ";
                $s .= " client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
                $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
                $s .= " and id != '" . $adata['editrowid'] . "' ";
                $cnt = $this->db->fetchOne($s);
                if ($cnt > 0) {
                    return 'edit-duplicate';
                }

                $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                if (isset($adata['full_name'])) {
                    $s .= ", full_name = '" . $adata['full_name'] . "' ";
                }
                $s .= " where id =  " . $adata['editrowid'];
                $this->db->query($s);
                if ($adata['newtextcell'] == 'y') {
                    $row = "select * from lp_auto_text_recipients where lp_auto_recipients_id = '" . $adata['editrowid'] . "'";
                    $info = $this->db->fetchAll($row);
                    if (count($info) > 0) {
                        $s = "update lp_auto_text_recipients set phone_number = '" . $adata['cell_number'] . "', ";
                        $s .= " carrier = '" . $adata['carrier'] . "' where lp_auto_recipients_id = " . $adata['editrowid'];
                        $this->db->query($s);
                    } else {
                        list($verticalName, $subverticalName, $leadpop_id, $leadpop_version_seq, $client_id) = explode("~", $adata['newkeys']);
                        $s = "select * from leadpops where id = " . $leadpop_id;
                        $lp = $this->db->fetchRow($s);

                        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $adata['editrowid'] . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                        $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','y')";
                        $this->db->query($s);
                    }
                } else if ($adata['newtextcell'] == 'n') {
                    $s = "update lp_auto_text_recipients set phone_number = '', carrier = 'none'  ";
                    $s .= "  where lp_auto_recipients_id = " . $adata['editrowid'];
                    $this->db->query($s);
                }
            }
        }
        else if ($adata['isnewrowid'] == 'y') {
            if ($adata['lpkey_recip']) { // global add recipient

                $lplist = explode(",", $adata['lpkey_recip']);
                $date = new \DateTime();
                $ts = $date->getTimestamp();
                $group_identifier = $client_id . $ts;
                $lastId = 0;
                foreach ($lplist as $index => $lp) {

                    $lpconstt = explode("~", $lp);
                    $leadpop_vertical_id = $lpconstt[0];
                    $leadpop_vertical_sub_id = $lpconstt[1];
                    $leadpop_id = $lpconstt[2];
                    $leadpop_version_seq = $lpconstt[3];
                    $s = "select * from leadpops where id = " . $leadpop_id;
                    $lp = $this->db->fetchRow($s);
                    $s = "select count(*) as cnt  from lp_auto_recipients where ";
                    $s .= " client_id = " . $client_id;
                    $s .= " and leadpop_id = " . $leadpop_id;
                    $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
                    $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
                    $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
                    $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                    $s .= " and email_address = '" . $adata['newemail'] . "' ";
                    //die($s);
                    $cnt = $this->db->fetchOne($s);

                    if ($cnt == 0) {
                        $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,email_address,is_primary,group_identifier) values (" . $client_id . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n','" . $group_identifier . "')";
                        $this->db->query($s);
                        $lastId = $this->db->lastInsertId();

                        $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                        $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                        $s .= "leadpop_version_seq,phone_number,carrier,is_primary $condQueryColumns) values (" . $client_id . "," . $lastId . ",";
                        $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                        $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                        $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n' $condQueryValues)";
                        $this->db->query($s);
                    }
                }
//                return 'one';
                return "add--" . $adata['lpkey_recip'] . "--" . $group_identifier . "--" . $lastId;
            }
            else {
                list($verticalName, $subverticalName, $leadpop_id, $leadpop_version_seq, $client_id) = explode("~", $adata['newkeys']);
                // dd($leadpop_id);

                $s = "select * from leadpops where id = " . $leadpop_id;
                $lp = $this->db->fetchRow($s);
                $s = "select count(*) as cnt  from lp_auto_recipients where ";
                $s .= " client_id = " . $client_id;
                $s .= " and leadpop_id = " . $leadpop_id;
                $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
                $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
                //die($s);
                $cnt = $this->db->fetchOne($s);

                if ($cnt == 0) {
                    $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,email_address,is_primary $condQueryColumns) values (" . $client_id . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n' $condQueryValues)";
                    //die($s);

                    $this->db->query($s);
                    $lastId = $this->db->lastInsertId();

                    $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                    $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
                    $this->db->query($s);
//                    return 'two';

                    if($conditionlogic){
                        $dataInserted=DB::table('lp_auto_recipients')->where('id',$lastId)->first();
                        $lastId=$dataInserted;
                        return $lastId;
                    }
                    return $lastId;
                    //die($s);
                } else {
                    return 'new-duplicate';
                }

            }
        }
    }


    public function getClient($client_id)
    {
        $s = "select * from clients where client_id = " . $client_id;
        $row = $this->db->fetchRow($s);
        //$row['password'] = ($row['password']);
        $s = "select email_address from lp_auto_recipients where client_id = " . $client_id;
        $s .= " and is_primary = 'y' limit 1 ";
        $email = $this->db->fetchRow($s);
        $row['notify_email'] = $email['email_address'];
        $s = "select carrier,phone_number from lp_auto_text_recipients where client_id = " . $client_id;
        $s .= " and is_primary = 'y' limit 1 ";
        $text = $this->db->fetchAll($s);
        if ($text) {
            $row['send_text'] = 'y';
            $row['carrier'] = $text[0]['carrier'];
            $row['phone'] = $text[0]['phone_number'];
        } else {
            $row['send_text'] = 'n';
            $row['carrier'] = '';
            $row['phone_number'] = '';
        }

        $row['cell_number'] = @preg_replace('/(\d{3})(\d{3})(\d{4})/i', '($1) $2-$3', preg_replace("/\D/", "", $row['cell_number']));
        $row['phone_number'] = @preg_replace('/(\d{3})(\d{3})(\d{4})/i', '($1) $2-$3', preg_replace("/\D/", "", $row['phone_number']));
        return $row;
    }

    private function lastday($month = '', $year = '')
    {

        if (empty($month)) {
            $month = date('m');
        }
        if (empty($year)) {
            $year = date('Y');
        }
        $result = strtotime("{$year}-{$month}-01");
        $result = strtotime('-1 second', strtotime('+1 month', $result));
        return date('Y-m-d', $result);

    }

    /**
     * TODO:CLEAN-UP
     * @deprecated didn't found usage in complete repo
     *
    public function getPayments($adata)
    {

        if ($adata['search'] == 'all') {
            $s = "select * from client_arb_invoices where client_id = " . $adata['client_id'];
            $s .= " order by subscribed_date ";
        } else if ($adata['search'] == 'current') {
            $s = "select * from client_arb_invoices where client_id = " . $adata['client_id'];
            $s .= " and arb_status = 'p'  order by subscribed_date ";
        } else if ($adata['search'] == 'cancelled') {
            $s = "select * from client_arb_invoices where client_id = " . $adata['client_id'];
            $s .= " and arb_status = 'c'  order by subscribed_date ";
        } else if ($adata['search'] == 'expiring') { // go out three months
            $s = "select * from client_arb_invoices where client_id = " . $adata['client_id'];
            $currMonth = date('m');
            $currYear = date('Y');
            $lastDayDate = $this->lastday($currMonth, $currYear);
            $lastDayTime = strtotime($lastDayDate);
            $endDayTime = strtotime('+3 month', $lastDayTime);
            $endDayDate = date('Y-m-d', $endDayTime);
            $s .= " and card_expiration >= '" . $lastDayDate . "' and card_expiration <= '" . $endDayDate . "' ";
            $s .= "   order by subscribed_date ";
        }
        $arbs = $this->db->fetchAll($s);
        if ($arbs) {
            $r = "";
            for ($i = 0; $i < count($arbs); $i++) {
                if ($adata['vertical'] == '9999999') {
                    $r .= "<tr><td align='left' width='45%'>" . $this->getLeadpopName($arbs[$i]['leadpop_keys'], $adata['client_id']) . "</td>";
                    $r .= "<td  align='center'  width='15%'>" . date('m/Y', strtotime($arbs[$i]['card_expiration'])) . "</td>";
                    $r .= "<td  align='center'  width='15%'>" . $this->decodeStatus($arbs[$i]['arb_status']) . "</td>";
                    if ($arbs[$i]['arb_status'] == 'c') {
                        $r .= "<td  align='center'  width='12%'>---</td>";
                        $r .= "<td  align='center'  width='12%'>---</td></tr>";
                    } else {
                        $r .= "<td  align='center'  width='12%'><a href='#' onclick=\"updatearbcreditcard('" . $arbs[$i]['line_id'] . "','" . $arbs[$i]['invoice_number'] . "','" . $arbs[$i]['client_id'] . "','" . $arbs[$i]['leadpop_keys'] . "')\">Update</a></td>";
                        $r .= "<td  align='center'  width='12%'><a href='#' onclick=\"cancelarb('" . $arbs[$i]['line_id'] . "','" . $arbs[$i]['invoice_number'] . "','" . $arbs[$i]['client_id'] . "','" . $arbs[$i]['leadpop_keys'] . "')\">Cancel</a></td></tr>";
                    }
                } else {
                    list($vertical, $subvertical, $leadpopid, $versionseq) = explode("-", $arbs[$i]['leadpop_keys']);
                    if ($vertical == $adata['vertical']) {
                        $r .= "<tr><td align='left' width='45%'>" . $this->getLeadpopName($arbs[$i]['leadpop_keys'], $adata['client_id']) . "</td>";
                        $r .= "<td  align='center'  width='15%'>" . date('m/Y', strtotime($arbs[$i]['card_expiration'])) . "</td>";
                        $r .= "<td  align='center'  width='15%'>" . $this->decodeStatus($arbs[$i]['arb_status']) . "</td>";

                        if ($arbs[$i]['arb_status'] == 'c') {
                            $r .= "<td  align='center'  width='12%'>---</td>";
                            $r .= "<td  align='center'  width='12%'>---</td></tr>";
                        } else {
                            $r .= "<td  align='center'  width='12%'><a href='#' onclick=\"updatearbcreditcard('" . $arbs[$i]['line_id'] . "','" . $arbs[$i]['invoice_number'] . "','" . $arbs[$i]['client_id'] . "','" . $arbs[$i]['leadpop_keys'] . "')\">Update</a></td>";
                            $r .= "<td  align='center'  width='12%'><a href='#' onclick=\"cancelarb('" . $arbs[$i]['line_id'] . "','" . $arbs[$i]['invoice_number'] . "','" . $arbs[$i]['client_id'] . "','" . $arbs[$i]['leadpop_keys'] . "')\">Cancel</a></td></tr>";
                        }
                    }
                }
            }
        } else {
            $r = "<tr><td colspan='5' align='center'>No accounts found.</td></tr>";
        }
        if ($r == "") {
            $r = "<tr><td colspan='5' align='center'>No accounts found.</td></tr>";
        }
        return $r;
    }
     */

    public function decodeStatus($status)
    {
        if ($status == 'c') return 'Cancelled';
        else if ($status == 'p') return 'Paid';
        else return 'bozo';
    }

    /**
     * TODO:CLEAN-UP
     * @duplicate function
     * @deprecated only found usage in getPayments, which isn't used in repo now
     * Also we have another function to return domain name
     *
    public function getLeadpopName($keys, $client_id)
    {
        list($vertical_id, $subvertical_id, $leadpop_version_id, $leadpoptype_id, $version_seq) = explode("-", $keys);
        $leadpop_id = $this->getLeadpopId($vertical_id, $subvertical_id, $leadpoptype_id, $leadpop_version_id);

        $s = "select * from leadpops where id = " . $leadpop_id;
        $leadpop = $this->db->fetchRow($s);
        $leadpop_template_id = $leadpop['leadpop_template_id'];
        $leadpop_version_id = $leadpop['leadpop_version_id'];
        $leadpop_type_id = $leadpop['leadpop_type_id'];

        if ($leadpop['leadpop_type_id'] == '1') { // sub-domain
            $s = "select id,subdomain_name,top_level_domain from clients_subdomains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $leadpop['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $leadpop['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $leadpop['leadpop_template_id'];
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $version_seq;

            $tempdomain = $this->db->fetchRow($s);

            $domainname = $tempdomain['subdomain_name'];
            $topname = $tempdomain['top_level_domain'];
        } else if ($leadpop['leadpop_type_id'] == '2') { // domain
            $s = "select id,domain_name from clients_domains ";
            $s .= "where client_id = " . $client_id . " and leadpop_vertical_id = " . $leadpop['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $leadpop['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $leadpop['leadpop_template_id'];
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_version_id = " . $leadpop['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $version_seq . " limit 1 ";

            $tempdomain = $this->db->fetchRow($s);

            $domainname = $tempdomain['domain_name'];
            $topname = "notop";
        }
        if ($topname == "notop") {
            $ret = $domainname;
        } else {
            $ret = $domainname . "." . $topname;
        }
        return $ret;
    } */

    private function getLeadpopId($vertical_id, $subvertical_id, $leadpoptype_id, $leadpop_version_id)
    {
        $s = "select id from leadpops ";
        $s .= " where leadpop_type_id = " . $leadpoptype_id;
        $s .= " and leadpop_vertical_id = " . $vertical_id;
        $s .= " and leadpop_vertical_sub_id = " . $subvertical_id;
        $s .= " and leadpop_version_id = " . $leadpop_version_id;
        $s .= " limit 1 ";
        $leadpop_id = $this->db->fetchOne($s);
        return $leadpop_id;
    }

    public function getVerticals($client_id)
    {
        $s = "select distinct a.* from leadpops_verticals a,clients_leadpops b,leadpops c ";
        $s .= " where a.id = c.	leadpop_vertical_id ";
        $s .= " and c.id = b.leadpop_id ";
        $s .= " and b.client_id = " . $client_id;
        $subs = $this->db->fetchAll($s);
        $s = "<option value='9999999'>All LeadPops</option>\n";
        for ($i = 0; $i < count($subs); $i++) {
            $s .= "<option  value='" . $subs[$i]['id'] . "'>" . ucwords($subs[$i]['lead_pop_vertical']) . "</option>\n";
        }
        return $s;
    }

    public function saveEditContactInfo($adata)
    {

        // if ($adata['emailnotify'] == 'n') {
        //     $s = " update lp_auto_recipients set email_address = '".$adata['notify_email']."' ";
        //     $s .= " where is_primary = 'y' and client_id = " . $adata['client_id'];
        //     $this->db->query($s);
        // }
        // else if  ($adata['emailnotify'] == 'y') {
        //     $s = " update lp_auto_recipients set email_address = '".$adata['contact_email']."' ";
        //     $s .= " where is_primary = 'y' and client_id = " . $adata['client_id'];
        //     $this->db->query($s);
        // }

        $s = " update lp_auto_recipients set email_address = '" . $adata['contact_email'] . "' ";
        $s .= " where is_primary = 'y' and client_id = " . $adata['client_id'];
        $this->db->query($s);

        if ($adata['textcell'] == 'y') {
            $s = " delete from lp_auto_text_recipients  where is_primary = 'y' and client_id = " . $adata['client_id'];
            $this->db->query($s);
            $s = "select * from clients_leadpops where client_id = " . $adata['client_id'];
            $lp = $this->db->fetchAll($s);
            for ($i = 0; $i < count($lp); $i++) {
                $s = "select * from leadpops where id = " . $lp[$i]['leadpop_id'];
                $templp = $this->db->fetchRow($s);

                $s = "select leadpop_template_id from leadpops_template_info where ";
                $s .= " leadpop_vertical_id = " . $templp['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $templp['leadpop_vertical_sub_id'];
                $s .= " and leadpop_version_id = " . $templp['leadpop_version_id'];
                $template_id = $this->db->fetchOne($s);
//  insert into lp_auto_text_recipients (client_id, leadpop_id, leadpop_type_id,leadpop_vertical_id,leadpop_vertical_sub_id,
//  leadpop_template_id,leadpop_version_id, leadpop_version_seq, email_address,carrier, is_primary ) values
//  (44,1,1,1,1,1,2,'','messaging.sdiepcs.com','y')"
                $s = " insert into lp_auto_text_recipients (client_id, leadpop_id, leadpop_type_id,";
                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                $s .= "leadpop_version_id, leadpop_version_seq, phone_number,carrier, is_primary ) values (";
                $s .= $adata['client_id'] . "," . $lp[$i]['leadpop_id'] . "," . $templp['leadpop_type_id'] . "," . $templp['leadpop_vertical_id'] . ",";
                $s .= $templp['leadpop_vertical_sub_id'] . "," . $template_id . "," . $templp['leadpop_version_id'] . ",";
                $s .= $lp[$i]['leadpop_version_seq'] . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','y')";
                $this->db->query($s);
            }
        } else if ($adata['textcell'] == 'n') {
            $s = " delete from lp_auto_text_recipients  where is_primary = 'y' and client_id = " . $adata['client_id'];
            $this->db->query($s);
        }

        $s = "update clients set first_name = '" . addslashes($adata['first_name']) . "', ";
        $s .= "password = '" . $this->encrypt($adata['password']) . "',";
        $s .= "contact_email = '" . $adata['contact_email'] . "',";
        $s .= "last_name = '" . addslashes($adata['last_name']) . "',";
        $s .= "company_name = '" . addslashes($adata['company_name']) . "',";
        $s .= "phone_number = '" . $adata['phone_number'] . "',";
        $s .= "fax_number = '" . $adata['fax_number'] . "',";
        $s .= "address1= '" . addslashes($adata['address1']) . "',";
        $s .= "address2= '" . addslashes($adata['address2']) . "',";
        $s .= "city = '" . addslashes($adata['city']) . "',";
        $s .= "state = '" . $adata['state'] . "',";
        $s .= "zip = '" . $adata['zip'] . "',";
        $s .= "cell_number= '" . $adata['cell_number'] . "',";
        $s .= "leadpops_branding= '" . $adata['leadpops_branding'] . "',";
        $s .= "join_date= '" . $dt . "' ";
        $s .= " where client_id = " . $adata['client_id'];
        $this->db->query($s);
    }

    private function encrypt($string)
    {
        $key = "petebird";
        $string = base64_encode(openssl_encrypt($string, 'AES-256-CBC', md5($key), OPENSSL_RAW_DATA, md5(md5($key))));
        return $string;
    }

    private function decrypt($string)
    {

        $key = "petebird";
        $string = rtrim(openssl_decrypt(base64_decode($string), 'AES-128-CBC', md5($key, $string), OPENSSL_RAW_DATA));
        return $string;
    }

    public function updatePassword($newpassword, $adata)
    {
        $s = "UPDATE clients SET password = '" . \Hash::make($newpassword) . "'";
        $s .= "WHERE client_id = " . $adata['client_id'];
        $s .= " AND contact_email = '" . $adata['contact_email'] . "'";

        $this->db->query($s);
    }

    public function saveEditProfileContact($adata, $files)
    {
        # $s = " update lp_auto_recipients set email_address = '" . $adata['notify_email'] . "' ";
        # $s .= " where is_primary = 'y' and client_id = " . $adata['client_id'];
        # $this->db->query( $s );

        if ($adata['textcell'] == 'y') {
            $s = " delete from lp_auto_text_recipients  where is_primary = 'y' and client_id = " . $adata['client_id'];
            $this->db->query($s);

            $s = "select * from clients_leadpops where client_id = " . $adata['client_id'];
            $lp = $this->db->fetchAll($s);

            for ($i = 0; $i < count($lp); $i++) {
                $s = "select * from leadpops where id = " . $lp[$i]['leadpop_id'];
                $templp = $this->db->fetchRow($s);
                if($templp) {

                    $s = "select leadpop_template_id from leadpops_template_info where ";
                    $s .= " leadpop_vertical_id = " . $templp['leadpop_vertical_id'];
                    $s .= " and leadpop_vertical_sub_id = " . $templp['leadpop_vertical_sub_id'];
                    $s .= " and leadpop_version_id = " . $templp['leadpop_version_id'];
                    $template_id = $this->db->fetchOne($s);

                    $s = " insert into lp_auto_text_recipients (client_id, leadpop_id, leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,";
                    $s .= "leadpop_version_id, leadpop_version_seq, phone_number,carrier, is_primary ) values (";
                    $s .= $adata['client_id'] . "," . $lp[$i]['leadpop_id'] . "," . $templp['leadpop_type_id'] . ",
                " . $templp['leadpop_vertical_id'] . ",";
                    $s .= $templp['leadpop_vertical_sub_id'] . "," . $template_id . "," . $templp['leadpop_version_id'] . ",";
                    $s .= $lp[$i]['leadpop_version_seq'] . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','y')";
                    $this->db->query($s);
                }
            }
        } else if ($adata['textcell'] == 'n') {
            $s = " delete from lp_auto_text_recipients  where is_primary = 'y' and client_id = " . $adata['client_id'];
            $this->db->query($s);
        }


        /*
         * Note: to replace unknown character like black diamond sign form address and name.
         * */

        $pattern_for_unknown_Char = '/[^\x00-\x7F]/';
        $replacement = ' ';

        $s = "UPDATE clients SET first_name = '" . addslashes(preg_replace($pattern_for_unknown_Char, $replacement, $adata['first_name'])) . "', ";
        $s .= "contact_email = '" . $adata['contact_email'] . "',";
        $s .= "last_name = '" . addslashes($adata['last_name']) . "',";
        $s .= "company_name = '" . addslashes($adata['company_name']) . "',";
        $s .= "phone_number = '" . $adata['phone_number'] . "',";
        $s .= "fax_number = '" . $adata['fax_number'] . "',";
        $s .= "cell_number= '" . $adata['cell_number'] . "',";
        $s .= "address1= '" . addslashes(preg_replace($pattern_for_unknown_Char, $replacement, $adata['address1'])) . "',";
        $s .= "address2= '" . addslashes(preg_replace($pattern_for_unknown_Char, $replacement, $adata['address2'])) . "',";
        $s .= "city = '" . addslashes($adata['city']) . "',";
        $s .= "state = '" . $adata['state'] . "',";
        $s .= "zip = '" . $adata['zip'] . "',";
        $s .= "leadpops_branding= '" . $adata['leadpops_branding'] . "',";
        $s .= "join_date= '" . $adata['join_date'] . "', ";
        $s .= "office_name= '" . $adata['office_name'] . "' ";

        if (isset($files['profile_img']) && is_uploaded_file($files['profile_img']['tmp_name'])) {
            $section = substr($adata['client_id'], 0, 1);
            $rackspacePath = $section . '/' . $adata['client_id'] . '/pics/';

            $avatarImage = $adata['client_id'] . "-" . $files['profile_img']["name"];
            $rackspac_response = move_uploaded_file_to_rackspace($files["profile_img"]["tmp_name"], $rackspacePath . $avatarImage);
            if ($rackspac_response) {
                $s .= ", avatar= '" . $avatarImage . "' ";
                $thumbnailImage = "thumbnail-" . $avatarImage;
                // these link use for testing
               // https://images.lp-imagesdev.com/images1/9/9979//pics/9979-36689987.jpg
                //https://images.lp-imagesdev.com/images1/9/9979//logos/9979_212_1_5_100_106_106_5_bigstockprint163213010.png
                //https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTM5hSj0drOJLCyMr4RvesGAxhxA41BTbDU9w&usqp=CAU
                //https://gcontent.robertsonmarketing.com/store/20160512512/assets/themes/theme1_en/images/home/aug19/google_row_box1_drinkware_notext.jpg
                //$rackspac_response["image_url"] = 'https://images.lp-imagesdev.com/images1/9/9979//pics/9979-7000-KanyeRBF.jpg';

                $thumbnailImagePath = $this->createThumbnail( $rackspac_response["image_url"], $thumbnailImage, 50,50);

                if (file_exists($thumbnailImagePath)) {
                    move_uploaded_file_to_rackspace($thumbnailImagePath, $rackspacePath . $thumbnailImage);
                }
            }
        } elseif (isset($adata['delete_image']) && $adata['delete_image'] == "y") {
            // in case profile image is deleted
            $avatarImage = "";
            $s .= ", avatar= '' ";
        }


        $s .= "WHERE client_id = " . $adata['client_id'];

        if ($this->db->query($s)) {
            $registry = DataRegistry::getInstance();
            $registry->leadpops->clientInfo["first_name"] = $adata['first_name'];
            $registry->leadpops->clientInfo["last_name"] = $adata['last_name'];

            //Only set when image in uploaded OR deleted
            if (isset($avatarImage)) {
                $registry->leadpops->clientInfo["avatar"] = $avatarImage;
            }
            $registry->updateRegistry();
        }
    }


    public function createThumbnail($src, $destImage, $desired_width, $desired_height = null)
    {
        $dest = public_path("rs_tmp") . "/" . $destImage;
        $info = getimagesize($src);
        $type = $info['mime'];
        switch ($type) {
            case 'image/jpeg':
                $image_create_func = 'imagecreatefromjpeg';
                $image_save_func = 'imagejpeg';
                break;

            case 'image/png':
                $image_create_func = 'imagecreatefrompng';
                $image_save_func = 'imagepng';
                break;

            case 'image/gif':
                $image_create_func = 'imagecreatefromgif';
                $image_save_func = 'imagegif';
                break;

            default:
                throw new Exception('Unknown image type.');
        }

        /* read the source image */
        $source_image = $image_create_func($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);



            // if is portrait
            // use ratio to scale height to fit in square
            if ($width > $height) {
                // maintain aspect ratio when no height set
                // get width to height ratio
                $ratio = $width / $height;
                $desired_height = floor( $desired_width / $ratio );
            }

            else if ($height > $width) {
                // maintain aspect ratio when no height set
                // get width to height ratio
                $ratio = $height / $width;
                $desired_width = floor( $desired_height / $ratio );
            }

        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

        // set transparency options for GIFs and PNGs
        if ($type == 'image/gif' || $type == 'image/png') {
            // make image transparent
            imagecolortransparent(
                $virtual_image,
                imagecolorallocate($virtual_image, 0, 0, 0)
            );

            // additional settings for PNGs
            if ($type == 'image/png') {
                imagealphablending($virtual_image, false);
                imagesavealpha($virtual_image, true);
            }
        }

        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

        /* create the physical thumbnail image to its destination */
        $image_save_func($virtual_image, $dest);

        return $dest;
    }








    //==============================================Admin Three ======================================================
    //==============================================Admin Three ======================================================
    //==============================================Admin Three ======================================================
    //==============================================Admin Three ======================================================
    //==============================================Admin Three ======================================================

    public function saveNewRecipientAdminThree($adata, $client_id,$ConditionalLogicCall=null)
    {
        $condQueryColumns = "";
        $condQueryValues = "";
        $adata['newemail'] = trim($adata['newemail']);
        if (isset($adata['full_name'])) {
            $condQueryColumns = ",full_name";
            $condQueryValues = ",'" . $adata["full_name"] . "'";
        }

        $cur_hash=$adata["current_hash"];
        LP_Helper::getInstance()->getCurrentHashData($cur_hash);
        $funneldata = LP_Helper::getInstance()->getFunnelData();
        list($verticalName, $subverticalName, $leadpop_id, $leadpop_version_seq, $client_id) = explode("~", $adata['newkeys']);
        // dd($leadpop_id);

        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);
        $s = "select count(*) as cnt  from lp_auto_recipients where ";
        $s .= " client_id = " . $client_id;
        $s .= " and leadpop_id = " . $leadpop_id;
        $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
        $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
        $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
        $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
        $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
        $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
        $s .= " and email_address = '" . $adata['newemail'] . "' ";
        //die($s);
        $cnt = $this->db->fetchOne($s);

        if ($cnt == 0) {
            $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
            $s .= "leadpop_version_seq,email_address,is_primary $condQueryColumns) values (" . $client_id . ",";
            $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
            $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n' $condQueryValues)";
            // die($s);

            $insertlastdata=$this->db->query($s);
            $lastId = $this->db->lastInsertId();

            $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
            $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
            $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
            $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
            $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
            $insertlastdata=$this->db->query($s);


            /* update clients_leadpops table's col last edit*/
            /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
            update_clients_leadpops_last_eidt($funneldata['client_leadpop_id']);
if($ConditionalLogicCall){

    return $lastId;
}
            return $lastId;
//            return $lastId;
            //die($s);



        } else {
            return 'new-duplicate';
        }

    }


    public function editRecipientAdminThree($adata, $client_id)
    {
        list($verticalName, $subverticalName, $leadpop_id, $leadpop_version_seq, $client_id) = explode("~", $adata['newkeys']);
        $adata['newemail'] = trim($adata['newemail']);
        $adata['old_email'] = trim($adata['old_email']);
        $cur_hash=$adata["current_hash"];
        LP_Helper::getInstance()->getCurrentHashData($cur_hash);
        $funneldata = LP_Helper::getInstance()->getFunnelData();
        $s = "select * from leadpops where id = " . $leadpop_id;
        $lp = $this->db->fetchRow($s);
        if($adata['old_email'] != $adata['newemail']) {
            $s = "select count(*) as cnt  from lp_auto_recipients where ";
            $s .= " client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
            $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
            $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;
            $s .= " and email_address = '" . $adata['newemail'] . "' ";
            $s .= " and id != '" . $adata['editrowid'] . "' ";
            $cnt = $this->db->fetchOne($s);
            if ($cnt > 0) {
                return 'edit-duplicate';
            }
        }

        $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
        if (isset($adata['full_name'])) {
            $s .= ", full_name = '" . $adata['full_name'] . "' ";
        }
        $s .= " where client_id = $client_id and leadpop_version_id = " . $lp['leadpop_version_id']."
         and leadpop_version_seq = " . $leadpop_version_seq." and email_address =  '". $adata['old_email']."'";
        $this->db->query($s);
        if ($adata['newtextcell'] == 'y') {
            $phoneNumber = $adata['cell_number'];
            $carrier =  $adata['carrier'];
        }
        else {
            $phoneNumber = '';
            $carrier =  'none';
        }

            $row = "select * from lp_auto_text_recipients where lp_auto_recipients_id = '" . $adata['editrowid'] . "'";
            $info = $this->db->fetchAll($row);
            if (count($info) > 0) {
                $where = 'lp_auto_recipients_id = '.$adata['editrowid'];
                $data = array('phone_number' => $phoneNumber,'carrier' => $carrier);
                $this->db->update('lp_auto_text_recipients',$data,$where);
            } else {
                $lp_auto_text_recipients = array(
                    'client_id' => $client_id,
                    'lp_auto_recipients_id' => $adata['editrowid'],
                    'leadpop_id' => $leadpop_id,
                    'leadpop_type_id' => $lp['leadpop_type_id'],
                    'leadpop_vertical_id' => $lp['leadpop_vertical_id'],
                    'leadpop_vertical_sub_id' =>  $lp['leadpop_vertical_sub_id'],
                    'leadpop_template_id' => $lp['leadpop_template_id'],
                    'leadpop_version_id' => $lp['leadpop_version_id'],
                    'leadpop_version_seq' => $leadpop_version_seq,
                    'phone_number' => $adata['cell_number'],
                    'carrier' => $adata['carrier'],
                    'is_primary' => 'y'
                );
                $this->db->insert('lp_auto_text_recipients', $lp_auto_text_recipients);
            }
        /* update clients_leadpops table's col last edit*/
        /* if LP_Helper::getInstance()->getFunnelData() not work then send id in parameter */
        update_clients_leadpops_last_eidt($funneldata['client_leadpop_id']);

        return 'edit';

    }


    public function saveRecipientGlobalAdminThree($adata, $client_id)
    {
        $condQueryColumns = "";
        $condQueryValues = "";
        $adata['newemail'] = trim($adata['newemail']);
        if (isset($adata['full_name'])) {
            $condQueryColumns = ",full_name";
            $condQueryValues = ",'" . $adata["full_name"] . "'";
        }


        $lplist = explode(",", $adata['selected_funnels']);
        if (empty($lplist) || !count($lplist)) {
            return false;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist = array_unique($lplist);

        //end add current Funnel key

        $date = new \DateTime();
        $ts = $date->getTimestamp();
        $group_identifier = $client_id . $ts;
        $lastId = 0;

        // record in case of edit recipient
        $referenceRecord = null;
        $result = true;
        if(isset($adata["editrowid"]) && $adata["editrowid"]) {
            $s = "select * from lp_auto_recipients ";
            $s .= " where client_id =  " . $client_id;
            $s .= " AND id =  '" . $adata["editrowid"] . "'";
            $referenceRecord = $this->db->fetchRow($s);

            if($referenceRecord) {
                $s = "select count(*) as cnt  from lp_auto_recipients where ";
                $s .= " client_id = " . $client_id;
                $s .= " and leadpop_id = " . $referenceRecord['leadpop_id'];
                $s .= " and leadpop_type_id = " . $referenceRecord['leadpop_type_id'];
                $s .= " and leadpop_vertical_id = " . $referenceRecord['leadpop_vertical_id'];
                $s .= " and leadpop_vertical_sub_id = " . $referenceRecord['leadpop_vertical_sub_id'];
                $s .= " and leadpop_template_id = " . $referenceRecord['leadpop_template_id'];
                $s .= " and leadpop_version_id = " . $referenceRecord['leadpop_version_id'];
                $s .= " and leadpop_version_seq = " . $referenceRecord['leadpop_version_seq'];
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
                $s .= " and id != '" . $adata['editrowid'] . "' ";
                $cnt = $this->db->fetchOne($s);
                if ($cnt > 0) {
                    return 'edit-duplicate';
                }
                $result = "edit";
            }
        }

        foreach ($lplist as $index => $lpkey) {

            $lpconstt = explode("~", $lpkey);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];
            $s = "select * from leadpops where id = " . $leadpop_id;
            $lp = $this->db->fetchRow($s);
            $s = "select id, email_address from lp_auto_recipients where ";
            $s .= " client_id = " . $client_id;
            $s .= " and leadpop_id = " . $leadpop_id;
            $s .= " and leadpop_type_id = " . $lp['leadpop_type_id'];
            $s .= " and leadpop_vertical_id = " . $lp['leadpop_vertical_id'];
            $s .= " and leadpop_vertical_sub_id = " . $lp['leadpop_vertical_sub_id'];
            $s .= " and leadpop_template_id = " . $lp['leadpop_template_id'];
            $s .= " and leadpop_version_id = " . $lp['leadpop_version_id'];
            $s .= " and leadpop_version_seq = " . $leadpop_version_seq;

            if($referenceRecord) {
                $s .= " and email_address IN('" . $referenceRecord['email_address'] . "', '" . $adata['newemail'] . "')";
            } else {
                $s .= " and email_address = '" . $adata['newemail'] . "' ";
            }
            //die($s);
            $recipients = $this->db->fetchAll($s);

            if ($recipients) {
                $recipient_id = $recipients[0]['id'];
                /**
                 * Case 1 -> Found record with new email address than update that one
                 * Case 2 -> Found record with OLD email address but not with new than update that one
                 * Case 3 -> Found both email address than update only new one
                 */
                if(count($recipients) > 1 && $recipients[0]['email_address'] != $adata['newemail']) {
                    foreach ($recipients as $recipient) {
                        if($recipient['email_address'] == $adata['newemail']) {
                            $recipient_id = $recipient['id']; break;
                        }
                    }
                }

                $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                if (isset($adata['full_name'])) {
                    $s .= ", full_name = '" . $adata['full_name'] . "' ";
                }
                $s .= " where client_id =  " . $client_id;
                $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                $s .= " AND id =  " . $recipient_id;
                $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                $s .= " AND leadpop_id =  " . $leadpop_id;
                $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                $this->db->query($s);
                /* echo $s;
                   echo "<br>";
                   echo "<br>"; */

                $cell_number = "";
                $carrier = "";
                if ($adata['newtextcell'] == 'y') {
                    $carrier = $adata['carrier'];
                    $cell_number = $adata['cell_number'];
                }

                $row = "select * from lp_auto_text_recipients";
                $row .= " where client_id =  " . $client_id;
                $row .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                $row .= " AND lp_auto_recipients_id =  " . $recipient_id; //added
                $row .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                $row .= " AND leadpop_id =  " . $leadpop_id;
                $row .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                $info = $this->db->fetchAll($row);

                /* echo $row;
                  echo "<br>";
                  echo "<br>"; */

                if (count($info) > 0) {
                    $s = "update lp_auto_text_recipients set phone_number = '" . $cell_number . "', ";
                    $s .= " carrier = '" . $carrier . "'";
                    $s .= " where client_id =  " . $client_id;
                    $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                    $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                    $s .= " AND leadpop_id =  " . $leadpop_id;
                    $s .= " AND lp_auto_recipients_id =  " . $recipient_id; //added
                    $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                    $this->db->query($s);
                    /* echo $s;
                    echo "<br>";
                    echo "<br>"; */
                } else {
                    $s = "select * from leadpops where id = " . $leadpop_id;
                    $lp = $this->db->fetchRow($s);
                    $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                    $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                    $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $recipient_id . ",";
                    $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                    $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                    $s .= "," . $leadpop_version_seq . ",'" . $cell_number . "','" . $carrier . "','n')";
                    $this->db->query($s);
                    /* echo $s;
                    echo "<br>";
                    echo "<br>"; */
                }
            } else {

                $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,email_address,is_primary $condQueryColumns) values (" . $client_id . ",";
                $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n' $condQueryValues)";
                // die($s);

                $this->db->query($s);
                $lastId = $this->db->lastInsertId();
                if($currentKey == $lpkey) {
                    $result = $lastId;
                }

                $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
                $this->db->query($s);

            }
        }

        return $result;
        // return "add--" . $adata['lpkey_recip'] . "--" . $group_identifier . "--" . $lastId;
    }


    public function editRecipientGlobalAdminThree($adata, $client_id)
    {
        $condQueryColumns = "";
        $condQueryValues = "";
        $adata['newemail'] = trim($adata['newemail']);
        if (isset($adata['full_name'])) {
            $condQueryColumns = ",full_name";
            $condQueryValues = ",'" . $adata["full_name"] . "'";
        }



        $s = "select * from lp_auto_recipients ";
        $s .= " where client_id =  " . $client_id;
        $s .= " AND id =  '" . $adata["editrowid"] . "'";
        $referenceRecord = $this->db->fetchRow($s);
        if($referenceRecord == null){
            return false;
        }
//        dd($referenceRecord);

        $lplist = explode(",", $adata['selected_funnels']);
        if (empty($lplist) || !count($lplist)) {
            return false;
        }

        //start add current Funnel key
        $currentHash = $_POST['current_hash'];
        $currentKey = \LP_Helper::getInstance()->getFunnelKeyStringFromHash($currentHash);
        if (!empty($currentKey)) {
            array_push($lplist, $currentKey);
        }
        $lplist = array_unique($lplist);
        //end add current Funnel key


        //  $lplistkey = "'" . implode("','", $lplist) . "'";
        // $this->removeglobalRecipent($client_id, $adata["editrowid"], $lplistkey);

        foreach ($lplist as $index => $lp) {

            $lpconstt = explode("~", $lp);
            $leadpop_vertical_id = $lpconstt[0];
            $leadpop_vertical_sub_id = $lpconstt[1];
            $leadpop_id = $lpconstt[2];
            $leadpop_version_seq = $lpconstt[3];

            $s = "select id from lp_auto_recipients ";
            $s .= " where client_id =  " . $client_id;
            $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
            $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
            $s .= " AND leadpop_id =  " . $leadpop_id;
            $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
            $s .= " AND email_address =  '" . $referenceRecord["email_address"] . "'"; //added

//            $s .= " AND group_identifier =  " . $adata["editrowid"];
 /*           echo $s;
            echo "<br>";
            echo "<br>";*/
            $recipient_id = $this->db->fetchOne($s);

            if ($recipient_id) { // update
                $s = "update lp_auto_recipients set email_address = '" . $adata['newemail'] . "' ";
                if (isset($adata['full_name'])) {
                    $s .= ", full_name = '" . $adata['full_name'] . "' ";
                }
                $s .= " where client_id =  " . $client_id;
                $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                $s .= " AND id =  " . $recipient_id;
                $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                $s .= " AND leadpop_id =  " . $leadpop_id;
                $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                $this->db->query($s);
//                $s .= " AND group_identifier =  " . $adata["editrowid"];
   /*             echo $s;
                echo "<br>";
                echo "<br>";*/
                if ($adata['newtextcell'] == 'y') {
                    $row = "select * from lp_auto_text_recipients";
                    $row .= " where client_id =  " . $client_id;
                    $row .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                    $row .= " AND lp_auto_recipients_id =  " . $recipient_id; //added
                    $row .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                    $row .= " AND leadpop_id =  " . $leadpop_id;
                    $row .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                    $info = $this->db->fetchAll($row);
             /*       echo $row;
                    echo "<br>";
                    echo "<br>";*/
                    if (count($info) > 0) {
                        $s = "update lp_auto_text_recipients set phone_number = '" . $adata['cell_number'] . "', ";
                        $s .= " carrier = '" . $adata['carrier'] . "'";
                        $s .= " where client_id =  " . $client_id;
                        $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                        $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                        $s .= " AND leadpop_id =  " . $leadpop_id;
                        $s .= " AND lp_auto_recipients_id =  " . $recipient_id; //added
                        $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                        $this->db->query($s);
                 /*      echo $s;
                        echo "<br>";
                        echo "<br>";*/
                    }
                      else {
                          $s = "select * from leadpops where id = " . $leadpop_id;
                          $lp = $this->db->fetchRow($s);
                          $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                          $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                          $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $recipient_id . ",";
                          $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                          $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                          $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','y')";
                          $this->db->query($s);
                      /*    echo $s;
                          echo "<br>";
                          echo "<br>";*/
                      }
                }

                /*  else if ($adata['newtextcell'] == 'n') {
                      $s = "update lp_auto_text_recipients set phone_number = '', carrier = 'none'  ";
                      $s .= " where client_id =  " . $client_id;
                      $s .= " AND leadpop_vertical_id =  " . $leadpop_vertical_id;
                      $s .= " AND leadpop_vertical_sub_id =  " . $leadpop_vertical_sub_id;
                      $s .= " AND leadpop_id =  " . $leadpop_id;
                      $s .= " AND leadpop_version_seq =  " . $leadpop_version_seq;
                      $this->db->query($s);
                      echo $s;
                      echo "<br>";
                      echo "<br>";
                  }*/

            }

            /*            else { // insert new global
                            $s = "select * from leadpops where id = " . $leadpop_id;
                            $lp = $this->db->fetchRow($s);
                            $s = "insert into lp_auto_recipients (client_id,leadpop_id,leadpop_type_id,";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                            $s .= "leadpop_version_seq,email_address,is_primary,group_identifier) values (" . $client_id . ",";
                            $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . "," . $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                            $s .= "," . $leadpop_version_seq . ",'" . $adata['newemail'] . "','n','" . $adata["editrowid"] . "')";
                            $this->db->query($s);
                            $lastId = $this->db->lastInsertId();

                            $s = "insert into lp_auto_text_recipients (client_id,lp_auto_recipients_id,leadpop_id,leadpop_type_id,";
                            $s .= "leadpop_vertical_id,leadpop_vertical_sub_id,leadpop_template_id,leadpop_version_id,";
                            $s .= "leadpop_version_seq,phone_number,carrier,is_primary) values (" . $client_id . "," . $lastId . ",";
                            $s .= $leadpop_id . "," . $lp['leadpop_type_id'] . "," . $lp['leadpop_vertical_id'] . "," . $lp['leadpop_vertical_sub_id'] . ",";
                            $s .= $lp['leadpop_template_id'] . "," . $lp['leadpop_version_id'];
                            $s .= "," . $leadpop_version_seq . ",'" . $adata['cell_number'] . "','" . $adata['carrier'] . "','n')";
                            $this->db->query($s);
                        }*/
        }
       // exit;
//        return "edit--" . $adata['lpkey_recip'] . "--" . $adata["editrowid"] . "--" . $lastId;
        return true;
    }


}
