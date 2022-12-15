<?php

namespace App\Http\Controllers;
use App\Repositories\ExportRepository;
use App\Repositories\LpAdminRepository;
use App\Repositories\LeadpopsRepository;
use App\Services\DataRegistry;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Redirect;
use LP_Helper;
use function print_r;
use function rtrim;
use Illuminate\Support\Facades\Log;
use Session;
class ExportController extends BaseController {

    private $_exp_mod_obj="";
    // Set writers
    private $_writers = array('Word2007' => 'docx', 'ODText' => 'odt', 'RTF' => 'rtf', 'HTML' => 'html', 'PDF' => 'pdf');

    private  $phpWord,$objPHPExcel,$objRichText,$pdf;
    private $Mylead_Model;
    private $max_questions = 50;

    public function __construct(LpAdminRepository $lpAdmin, ExportRepository $_exp_mod_obj, PhpWord $phpWord,LeadpopsRepository $mylead ){
        $this->middleware(function($request, $next) use ($lpAdmin,$_exp_mod_obj,$phpWord,$mylead) {
            $this->Mylead_Model= $mylead;
            $this->_exp_mod_obj = $_exp_mod_obj;
            $this->phpWord = $phpWord;
            $this->objPHPExcel = new \PHPExcel();
            $this->pdf = new \FPDF();
            $this->objRichText = new\ PHPExcel_RichText();
            $this->registry = DataRegistry::getInstance();
            $this->registry->_initProperties(Session::get('leadpops'));
            $this->init($lpAdmin);
            if($request->ajax()) $this->check_ajax_session(); else $this->check_session();
            return $next($request);
        });

    }

    function getEndingNotes()
    {
        $writers=$this->_writers;
        $result = '';

        // Do not show execution time for index
        if (!IS_INDEX) {
            $result .= date('H:i:s') . " Done writing file(s)" . EOL;
            $result .= date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB" . EOL;
        }

        // Return
        if (CLI) {
            $result .= 'The results are stored in the "results" subdirectory.' . EOL;
        } else {
            if (!IS_INDEX) {
                $types = array_values($writers);
                $result .= '<p>&nbsp;</p>';
                $result .= '<p>Results: ';
                foreach ($types as $type) {
                    if (!is_null($type)) {
                        $resultFile = 'export_data/' . SCRIPT_FILENAME . '.' . $type;
                        if (file_exists($resultFile)) {
                            $result .= "<a href='{$resultFile}' class='btn btn-primary'>{$type}</a> ";
                        }
                    }
                }
                $result .= '</p>';
            }
        }

        return $result;
    }

    function write($filename, $writers=null){
        $result = '';
        $writers=$this->_writers;

        // Write documents
        foreach ($writers as $format => $extension) {
            $result .= date('H:i:s') . " Write to {$format} format";
            if (null !== $extension) {
                $targetFile = LP_BASE_DIR. "/export_data/{$filename}.{$extension}";
                $this->phpWord->save($targetFile, $format);
            } else {
                $result .= ' ... NOT DONE!';
            }
            $result .= EOL;
        }

        $result .= $this->getEndingNotes();

        return $result;
    }


    /**
     * exportsworddata  -> renamed to -> exportsworddataV1
     * lead_content table having all q1...qn columns
     *
     * @return mixed
     */
    function exportsworddataV1(){
        ini_set('memory_limit', -1);
        $test_mode=0;
        if($test_mode==1){
            $this->checksampleData();
            exit;
        }
        /*$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);*/

        $funnelURL  = $funnelName = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);


        //get funnel name
        if(isset($_POST["current_hash"]) and !empty($_POST["current_hash"])) {
            LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $hash_data = LP_Helper::getInstance()->getFunnelData();
                $funnelName = $hash_data['funnel']['funnel_name'];
            }
        }else{
            $funnelName =  $_GET["funnel_name"];
        }

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }
        $aunique = explode("~",$sunique);
        $lead_ids=implode(",", $aunique);
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);

        $section = $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        // 1. Header Table
        $section->addText('', $header);

        $headerFunnelTableStyleName = 'Header Funnel Table';
        $headerFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $headerFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $headerFunnelTableCellStyle = array('valign' => 'center');
        $headerFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $headerFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $this->phpWord->addTableStyle($headerFunnelTableStyleName, $headerFunnelTableStyle, $headerFunnelTableFirstRowStyle);
        $table = $section->addTable($headerFunnelTableStyleName);
        $table->addRow(900);
        $c1=$table->addCell(7000, $headerFunnelTableCellStyle);

        $c1->addText($this->_exp_mod_obj->parseTextForExport(ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($clientInfo['company_name']));

        $c1->addText($this->_exp_mod_obj->parseTextForExport($this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']));
        $c2=$table->addCell(3000, $headerFunnelTableCellStyle);
        $c2->addText("Powered by:  leadPops, Inc", $headerFunnelTableFontStyle);
        $c2->addText("http://www.leadpops.com", $headerFunnelTableFontStyle);

        $dataFunnelTableStyleName = 'Data Funnel Table ';
        $dataFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $dataFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '000');
        $dataFunnelTableCellStyle = array('valign' => 'center');
        $dataFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $dataFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";
        foreach ($return_data as $lead) {
            /*debug($lead);
            exit;*/

            /**
             * ipaddress is not being used in unique_key
             */
            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/

            $section->addTextBreak(1);

            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;


            $section->addText($this->_exp_mod_obj->parseTextForExport($linfo),array("bold"=>true,'size'=>'10','name'=>'arial, helvetica, sans-serif'),array('alignment' => 'center'));
            $this->phpWord->addTableStyle($dataFunnelTableStyleName, $dataFunnelTableStyle, $dataFunnelTableFirstRowStyle);
            $dtable = $section->addTable($dataFunnelTableStyleName);

            $dtable->addRow(900);
            $dc1=$dtable->addCell(7000, $dataFunnelTableCellStyle);
            $dc1->addText($heading,array(),array('alignment' => 'center'));

            for($i=1; $i<= $this->max_questions; $i++) {
                $qindex = 'q'.$i;
                $aindex = 'a'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question_text = str_replace(array("$", "%", "#", "<", ">", "|"), "", $lead[$qindex]);
                    $question = (string) $question_text;

                    $answer = $lead[$aindex];

                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addWordRow($dtable, $question, $answer, $dataFunnelTableCellStyle);



                    //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText("$question:",array("bold"=>true));
                    //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText($answer);
                }

                if($i == $this->max_questions) {
                    //Adding Funnel Name
                    if ($funnelName) {
                        $this->addWordRow($dtable, 'Funnel Name', $funnelName, $dataFunnelTableCellStyle);
                    }
                    //Adding Funnel URL
                    if ($funnelURL) {
                        $this->addWordRow($dtable, 'Funnel URL', $funnelURL, $dataFunnelTableCellStyle);
                    }
                    //Adding Date
                    $this->addWordRow($dtable, "Date", date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
                    //Adding Time
                    $this->addWordRow($dtable, "Time", date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
                }

            }
            /**
             * ip address remove export word from @mzac90
             */
            //$dtable->addRow(900);
            //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText("IP Address:",array("bold"=>true));
            //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText($this->_exp_mod_obj->parseTextForExport($ipaddress));

        }
        $file_name=date('d_m_Y_g:i_a').".docx";
        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $objWriter->save($report);
        return redirect(LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name);
    }


    /**
     * New exportsworddata() to utilize new structure of lead_content having JSON columns.
     *
     * @return mixed
     */
    function exportsworddata(){
    /*    if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->exportsworddataV1();
        }*/

        ini_set('memory_limit', -1);
        $test_mode=0;
        if($test_mode==1){
            $this->checksampleData();
            exit;
        }
        /*$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);*/

        $funnelURL = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                if($allfunnelkeys['allkey'] == 0) {
                    Log::debug("client => ",[@$_POST['client_id']]);
                    Log::debug("allkey export data issue ",$allfunnelkeys);
                   // dd($allfunnelkeys);
                    die('all key is 0');
                }
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }
        $aunique = explode("~",$sunique);
        $lead_ids=implode(",", $aunique);
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);

        $section = $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        // 1. Header Table
        $section->addText('', $header);

        $headerFunnelTableStyleName = 'Header Funnel Table';
        $headerFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $headerFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $headerFunnelTableCellStyle = array('valign' => 'center');
        $headerFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $headerFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $this->phpWord->addTableStyle($headerFunnelTableStyleName, $headerFunnelTableStyle, $headerFunnelTableFirstRowStyle);
        $table = $section->addTable($headerFunnelTableStyleName);
        $table->addRow(900);
        $c1=$table->addCell(7000, $headerFunnelTableCellStyle);

        $c1->addText($this->_exp_mod_obj->parseTextForExport(ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($clientInfo['company_name']));

        $c1->addText($this->_exp_mod_obj->parseTextForExport($this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']));
        $c2=$table->addCell(3000, $headerFunnelTableCellStyle);
        $c2->addText("Powered by:  leadPops, Inc", $headerFunnelTableFontStyle);
        $c2->addText("http://www.leadpops.com", $headerFunnelTableFontStyle);

        $dataFunnelTableStyleName = 'Data Funnel Table ';
        $dataFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $dataFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '000');
        $dataFunnelTableCellStyle = array('valign' => 'center');
        $dataFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $dataFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        // dd($return_data);

        $heading  =  "Lead Information";

        foreach ($return_data as $lead) {
            /*debug($lead);
            exit;*/
            $leadQuestions = json_decode($lead['lead_questions'], 1);
            $leadAnswers = json_decode($lead['lead_answers'], 1);

            /**
             * ipaddress is not being used in unique_key
             */
            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/

            $section->addTextBreak(1);

            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;


            $section->addText($this->_exp_mod_obj->parseTextForExport($linfo),array("bold"=>true,'size'=>'10','name'=>'arial, helvetica, sans-serif'),array('alignment' => 'center'));
            $this->phpWord->addTableStyle($dataFunnelTableStyleName, $dataFunnelTableStyle, $dataFunnelTableFirstRowStyle);
            $dtable = $section->addTable($dataFunnelTableStyleName);

            $dtable->addRow(900);
            $dc1=$dtable->addCell(7000, $dataFunnelTableCellStyle);
            $dc1->addText($heading,array(),array('alignment' => 'center'));

            foreach($leadQuestions as $qk => $oneQuestion) {
                /* echo $leadQuestions[$qk];
                 echo "<br>";
                 echo $leadAnswers[$qk];
                 echo "===========================\n";
                 continue;*/
//                $qindex = 'q'.$qk;

                if( $leadQuestions[$qk]!=""){
                    $answer = $leadAnswers[$qk];
                    if(is_array($oneQuestion)) {
                        $question = $oneQuestion['question'];
                    } else {
                        $question = $leadQuestions[$qk];
                    }

                    $question_text = str_replace(array("$", "%", "#", "<", ">", "|"), "", $question);
                    $question = (string) $question_text;


                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addWordRow($dtable, $question, $answer, $dataFunnelTableCellStyle);

                }
            }

//            if($i == $this->max_questions) {
                //Adding Funnel URL
                if ($funnelURL) {
                    $this->addWordRow($dtable, 'Funnel URL', $funnelURL, $dataFunnelTableCellStyle);
                }
                //Adding Date
                $this->addWordRow($dtable, "Date", date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
                //Adding Time
                $this->addWordRow($dtable, "Time", date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
//            }
            /**
             * ip address remove export word from @mzac90
             */
            //$dtable->addRow(900);
            //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText("IP Address:",array("bold"=>true));
            //$dtable->addCell(5000, $dataFunnelTableCellStyle)->addText($this->_exp_mod_obj->parseTextForExport($ipaddress));

        }
        $file_name=date('d_m_Y_g:i_a').".docx";
        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        $objWriter->save($report);
        return redirect(LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name);
    }

    /**
     * exportsexcelddata  -> renamed to -> exportsexcelddataV1
     * lead_content table having all q1...qn columns
     *
     * @return mixed
     */
    function exportsexcelddataV1(){
        ini_set('memory_limit', -1);

        $funnelURL = $funnelName = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);

        //get funnel name
        if(isset($_POST["current_hash"]) and !empty($_POST["current_hash"])) {
            LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $hash_data = LP_Helper::getInstance()->getFunnelData();
                $funnelName = $hash_data['funnel']['funnel_name'];
            }
        }else{
            $funnelName =  $_GET["funnel_name"];
        }

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }
        $aunique = explode("~",$sunique);

        $this->objPHPExcel->getProperties()->setCreator("Leadpops Inc")
            ->setTitle("Myleads Export Excel Data")
            ->setSubject("Myleads Export Excel Data Document");

        $row = 1; // 1-based index

        $col=0;
        //comment from @mzac90 because no need in excel
        //$leadname=$this->_exp_mod_obj->getleadname($client_id,$aunique[0]);
        //$objBold = $this->objRichText->createTextRun($leadname);
       //$objBold->getFont()->setBold(true);

        $this->objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(35);
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $this->objRichText);
        $objBold = $this->objRichText->createTextRun("Lead Information");
        $objBold->getFont()->setBold(true);
        $row +=1;
            //comment from @mzac90 because it was duplicate lead information title row
//        $this->objPHPExcel->getActiveSheet()->mergeCells("A".($row).":B".($row));
//        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
//        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $this->objRichText);
        $row +=1;

        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";
        $lead_data=[];

        /**
         * ip address remove export excel from @mzac90
         */

        /**
         * ipaddress is not being used in unique_key
         */
        foreach ($return_data as $lead) {
            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/
            //if(!isset($lead["ipaddress"])) $lead["ipaddress"]=$ipaddress;
            if(!isset($lead_data[$lead["id"]]["heading"])) $lead_data[$lead["id"]]["heading"]=$heading;
            if(!isset($lead_data[$lead["id"]]["leaddata"])) $lead_data[$lead["id"]]["leaddata"]=$lead;
        }

        $question=[];
        $answers=[];
        //echo '<pre>';

        foreach ($lead_data as $uniquekey => $data) {

            for($i=1; $i<= $this->max_questions; $i++) {

                $qindex = 'q'.$i;

                if($data["leaddata"][$qindex]!=""){

                    $aindex = 'a'.$i;
                    $data["leaddata"][$aindex] = str_replace(":","",$data["leaddata"][$aindex]);
                    $data["leaddata"][$qindex] = str_replace(":","",$data["leaddata"][$qindex]);
                    $answer = rtrim($data["leaddata"][$aindex]);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    if(!isset($question[rtrim($data["leaddata"][$qindex])])){
                        $question[rtrim($data["leaddata"][$qindex])]=$data["leaddata"][$qindex];
                    }
                    $answers[$uniquekey][rtrim($data["leaddata"][$qindex])]=$answer;
                }

                if($i == $this->max_questions) {
                    $answers[$uniquekey]["date"] = date($this->_exp_mod_obj->date_format, strtotime($data["leaddata"]["date_completed"]));
                    $answers[$uniquekey]["time"] = date($this->_exp_mod_obj->time_format, strtotime($data["leaddata"]["date_completed"]));
                }
                //$answers[$uniquekey]["ipaddress"]=$data["leaddata"]["ipaddress"];
            }

        }

        $col = 0;
        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
        foreach ($question as $qkey => $ans) {
            $this->_exp_mod_obj->replaceQuestionIfMatchesAny($qkey);
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qkey);
            $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            $col++;
        }

        //Funnel URL, Funnel Name, Date, Time column Heading
        if ($funnelName) {
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Funnel Name");$col++;
        }
        if($funnelURL){
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Funnel URL");$col++;
            $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Date");$col++;
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Time");$col++;
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        //$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row,"IP Address");
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col+1)->setAutoSize(true);
        $row = 3;
        foreach ($answers as $ukey => $qad) {
            $row +=1;
            $col = 0;
            $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
            foreach ($question as $qkey => $ans) {
                if (array_key_exists($qkey, $qad)) {
                    $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad[$qkey]);
                    $col++;
                }else{
                    $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"--");
                    $col++;
                }
            }
            //Adding Funnel Name
            if ($funnelName) {
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $funnelName);$col++;
            }
            if($funnelURL){
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $funnelURL);$col++;
            }
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad["date"]); $col++;
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad["time"]); $col++;
            //$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row,$qad["ipaddress"]);

        }
        $file_name=date('d_m_Y_g_i_a').".xlsx";
        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PHPExcel_IOFactory::createWriter( $this->objPHPExcel, 'Excel2007');
        $objWriter->save($report);
        return redirect(LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name);
    }

    /**
     * New exportsexcelddata() to utilize new structure of lead_content having JSON columns.
     *
     * @return mixed
     */
    function exportsexcelddata(){
      /*  if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->exportsexcelddataV1();
        }*/

        ini_set('memory_limit', -1);

        $funnelURL = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                if($allfunnelkeys['allkey'] == 0) {
                    Log::debug("client => ",[@$_POST['client_id']]);
                    Log::debug("allkey export data issue ",[$allfunnelkeys]);
                    die('all key is 0');
                }
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }
        $aunique = explode("~",$sunique);

        $this->objPHPExcel->getProperties()->setCreator("Leadpops Inc")
            ->setTitle("Myleads Export Excel Data")
            ->setSubject("Myleads Export Excel Data Document");

        $row = 1; // 1-based index

        $col=0;
        //comment from @mzac90 because no need in excel
        //$leadname=$this->_exp_mod_obj->getleadname($client_id,$aunique[0]);
        //$objBold = $this->objRichText->createTextRun($leadname);
        //$objBold->getFont()->setBold(true);

        $this->objPHPExcel->getActiveSheet()->mergeCells('A1:I1');
        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(35);
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $this->objRichText);
        $objBold = $this->objRichText->createTextRun("Lead Information");
        $objBold->getFont()->setBold(true);
        $row +=1;
        //comment from @mzac90 because it was duplicate lead information title row
//        $this->objPHPExcel->getActiveSheet()->mergeCells("A".($row).":B".($row));
//        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(30);
//        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $this->objRichText);
        $row +=1;

        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";
        $lead_data=[];

        /**
         * ip address remove export excel from @mzac90
         */

        /**
         * ipaddress is not being used in unique_key
         */
        foreach ($return_data as $lead) {
            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/
            //if(!isset($lead["ipaddress"])) $lead["ipaddress"]=$ipaddress;
            if(!isset($lead_data[$lead["id"]]["heading"])) $lead_data[$lead["id"]]["heading"]=$heading;
            if(!isset($lead_data[$lead["id"]]["leaddata"])) $lead_data[$lead["id"]]["leaddata"]=$lead;
        }


        $questions=[];
        $answers=[];
        //echo '<pre>';


//        dd($lead_data);
        $totalLeads = count($return_data); $counter = 0;
        foreach ($lead_data as $uniquekey => $data) {
            $counter++;
            $leadQuestions = json_decode($data['leaddata']['lead_questions'], 1);
            $leadAnswers = json_decode($data['leaddata']['lead_answers'], 1);

            foreach($leadQuestions as $qk => $oneQuestion) {
                if(is_array($oneQuestion)) {
                    $question = $oneQuestion['question'];
                    $label = $oneQuestion['label'];
                } else {
                    $question = $oneQuestion;
                    $label = $oneQuestion;
                }
               /* echo $leadQuestions[$qk];
                echo "<br>";
                echo $leadAnswers[$qk];
                echo "===========================\n";
                continue;*/
                $qindex = 'q'.$qk;
                $aindex = 'a'.$qk;
                if( $leadQuestions[$qk]!=""){
                    $answer = rtrim(str_replace(":","",$leadAnswers[$qk]));
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $columnName = strtolower(rtrim(str_replace(":","", $label)));
                    if(($counter == $totalLeads) && !isset($questions[$columnName])){
                        $questions[$columnName] = str_replace(":","",$question);
                    }
                    $answers[$uniquekey][$columnName]=$answer;
                }

                //$answers[$uniquekey]["ipaddress"]=$data["leaddata"]["ipaddress"];
            }

//            if($i == $this->max_questions) {
                $answers[$uniquekey]["date"] = date($this->_exp_mod_obj->date_format, strtotime($data["leaddata"]["date_completed"]));
                $answers[$uniquekey]["time"] = date($this->_exp_mod_obj->time_format, strtotime($data["leaddata"]["date_completed"]));
//            }



           // dd($lead_data, $lead_ids);



           /* for($i=1; $i<= $this->max_questions; $i++) {

                $qindex = 'q'.$i;

                if($data["leaddata"][$qindex]!=""){

                    $aindex = 'a'.$i;
                    $data["leaddata"][$aindex] = str_replace(":","",$data["leaddata"][$aindex]);
                    $data["leaddata"][$qindex] = str_replace(":","",$data["leaddata"][$qindex]);
                    $answer = rtrim($data["leaddata"][$aindex]);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    if(!isset($question[rtrim($data["leaddata"][$qindex])])){
                        $question[rtrim($data["leaddata"][$qindex])]=$data["leaddata"][$qindex];
                    }
                    $answers[$uniquekey][rtrim($data["leaddata"][$qindex])]=$answer;
                }

                if($i == $this->max_questions) {
                    $answers[$uniquekey]["date"] = date($this->_exp_mod_obj->date_format, strtotime($data["leaddata"]["date_completed"]));
                    $answers[$uniquekey]["time"] = date($this->_exp_mod_obj->time_format, strtotime($data["leaddata"]["date_completed"]));
                }
                //$answers[$uniquekey]["ipaddress"]=$data["leaddata"]["ipaddress"];
            }*/

        }
     //   dd($questions, $answers);

        $col = 0;
        $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
        foreach ($questions as $qkey => $question) {
            $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $question);
            $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
            $col++;
        }
        //Funnel URL, Date, Time column Heading
        if($funnelURL){
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Funnel URL");$col++;
            $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        }
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Date");$col++;
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"Time");$col++;
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
        //$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row,"IP Address");
        $this->objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col+1)->setAutoSize(true);
        $row = 3;
        foreach ($answers as $ukey => $qad) {
            $row +=1;
            $col = 0;
            $this->objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(25);
            foreach ($questions as $qkey => $ans) {
                if (array_key_exists($qkey, $qad)) {
                    $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad[$qkey]);
                    $col++;
                }else{
                    $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,"--");
                    $col++;
                }
            }

            if($funnelURL){
                $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $funnelURL);$col++;
            }
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad["date"]); $col++;
            $this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row,$qad["time"]); $col++;
            //$this->objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col+1, $row,$qad["ipaddress"]);

        }
        $file_name=date('d_m_Y_g_i_a').".xlsx";
        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PHPExcel_IOFactory::createWriter( $this->objPHPExcel, 'Excel2007');
        $objWriter->save($report);
        return redirect(LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name);
    }


    /**
     * exportspdfdata  -> renamed to -> exportspdfdataV1
     * lead_content table having all q1...qn columns
     *
     * @return mixed
     */
    function exportspdfdataV1(){
        //set_time_limit(0);
        ini_set('memory_limit', -1);

        $funnelURL = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }

        $aunique = explode("~",$sunique);
        $this->pdf->SetCompression(true);
        $this->pdf->AddPage('P','A4');
        $this->pdf->SetFont('Arial','',8);
        $y = 4;
        $x = 2;
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);
        $this->pdf->SetFont('Arial', 'B',8);
        $this->pdf->Text( $x, $y, $clientInfo['first_name']." ".$clientInfo['last_name']." Courtesy of LeadPops, LLC - http://www.leadpops.com");
        $y += 3;
        $this->pdf->Text( $x, $y,$clientInfo['company_name']);
        $y += 3;
        $this->pdf->Text( $x, $y,$this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']);


        $filename=$this->_exp_mod_obj->getFileNameForExport($client_id);

        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        /**
         * ipaddress is not being used in unique_key
         */
        foreach ($return_data as $lead) {

            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/

            $this->pdf->SetFont('Arial', 'B',8);
            $x = 2;
            $y += 6;
            $this->pdf->Text( 2, $y, "________________________________________________________________________________________________");
            $y += 4;
            $dtime = strtotime($lead['date_completed']);
            $dt = date('m/d/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            //$pdf->Text( $x, $y, $this->_exp_mod_obj->getleadname($client_id,$aunique[$f]));
            $this->pdf->Text( $x, $y, $linfo);
            $y += 4;
            $this->pdf->Text( $x, $y, $heading);
            $y += 4;
            for($i=1; $i <= $this->max_questions; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];

                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addPdfRow($question, $answer, $x, $y);
                }
                if($i == $this->max_questions) {
                    //Adding Funnel URL
                    if($funnelURL) {
                        $this->addPdfRow('Funnel URL', $funnelURL, $x, $y);
                    }

                    //Adding Date
                    $this->addPdfRow('Date', date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $x, $y);

                    //Adding Time
                    $this->addPdfRow('Time', date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $x, $y);
                }
            }
            /**
             * ip address remove export pdf from @mzac90
             */
            //$y += 5;
            //$x = 5;
            //$this->pdf->SetFont('Arial', 'B',8);
            //$this->pdf->Text( $x, $y, "IP Address");
            //$x = 90;
            //$this->pdf->SetFont('Arial','',8);
            //$x = 45;
            //$this->pdf->Text( $x, $y, $ipaddress);
        }
        $this->pdf->Output($filename,"D");
        exit;

        for($f=0; $f<count($aunique); $f++) {

            $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($aunique[$f]);

            $lead = $return_data['lead'];
            //debug($lead);
            $aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);

            $z = $return_data['z'];

            $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:"Lead Information";
            if($heading) {
                $this->pdf->SetFont('Arial', 'B',8);
                $x = 2;
                $y += 6;
                $this->pdf->Text( 2, $y, "________________________________________________________________________________________________");
                $y += 4;
                $this->pdf->Text( $x, $y, $this->_exp_mod_obj->getleadname($client_id,$aunique[$f]));
                $y += 4;
                $this->pdf->Text( $x, $y, $heading);
                $y += 4;
            }
            for($i=1; $i< 51; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];
                    $y += 5;
                    $x = 5;
                    $this->pdf->SetFont('Arial', 'B',8);
                    $this->pdf->Text( $x, $y, $question);
                    $x = 90;
                    $this->pdf->SetFont('Arial','',8);
                    $this->pdf->Text( $x, $y, $answer);
                    if($y>260) {
                        $this->pdf->AddPage('P','A4');
                        $y = 0;
                    }
                }
            }
            //$y += 5;
            //$x = 5;
            /**
             * ip address remove export pdf from @mzac90
             */
            //$this->pdf->SetFont('Arial', 'B',8);
            //$this->pdf->Text( $x, $y, "IP Address");
            //$x = 90;
            //$this->pdf->SetFont('Arial','',8);
            //$x = 45;
            //$this->pdf->Text( $x, $y, $ipaddress);
        }
        $this->pdf->Output($filename,"D");
        exit;
    }

    /**
     * New exportspdfdata() to utilize new structure of lead_content having JSON columns.
     *
     * @return mixed
     */
    function exportspdfdata(){
        /*if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->exportspdfdataV1();
        }*/
        //set_time_limit(0);
        ini_set('memory_limit', -1);

        $funnelURL = $funnelName = null;
        $this->_exp_mod_obj->setFunnelURL($funnelURL);

        //get funnel name
        if(isset($_POST["current_hash"]) and !empty($_POST["current_hash"])) {
            LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
            if (LP_Helper::getInstance()->getCurrentHash()) {
                $hash_data = LP_Helper::getInstance()->getFunnelData();
                //$funnelName = $hash_data['funnel']['funnel_name'];
            }
        }else{
            //$funnelName =  $_GET["funnel_name"];
        }

        if(isset($_POST['allfunnelkey']) && $_POST['allfunnelkey']!="" ){
            $sunique = $_POST['allfunnelkey'];
            if($sunique == 1){
                $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
                if($allfunnelkeys['allkey'] == 0) {
                    Log::debug("client => ",[@$_POST['client_id']]);
                    Log::debug("allkey export data issue ",$allfunnelkeys);
                    die('all key is 0');
                }
                $sunique = implode('~',$allfunnelkeys['allkey']);
            }
            $client_id = $_POST['client_id'];

        }elseif(isset($_GET['u']) && $_GET['u']!="" ){
            $sunique = $_GET['u'];
            $client_id = $_GET['client_id'];
        }

        $aunique = explode("~",$sunique);
        $this->pdf->SetCompression(true);
        $this->pdf->AddPage('P','A4');
        $this->pdf->SetFont('Arial','',8);
        $y = 4;
        $x = 2;
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);
        $this->pdf->SetFont('Arial', 'B',8);
        $this->pdf->Text( $x, $y, $clientInfo['first_name']." ".$clientInfo['last_name']." Courtesy of LeadPops, LLC - http://www.leadpops.com");
        $y += 3;
        $this->pdf->Text( $x, $y,$clientInfo['company_name']);
        $y += 3;
        $this->pdf->Text( $x, $y,$this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']);


        $filename=$this->_exp_mod_obj->getFileNameForExport($client_id);

        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        /**
         * ipaddress is not being used in unique_key
         */
        foreach ($return_data as $lead) {
           # dd($lead);

            $leadQuestions = json_decode($lead['lead_questions'], 1);
            $leadAnswers = json_decode($lead['lead_answers'], 1);

            /*$aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);*/

            $this->pdf->SetFont('Arial', 'B',8);
            $x = 2;
            $y += 6;
            $this->pdf->Text( 2, $y, "________________________________________________________________________________________________");
            $y += 4;
            $dtime = strtotime($lead['date_completed']);
            $dt = date('m/d/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            //$pdf->Text( $x, $y, $this->_exp_mod_obj->getleadname($client_id,$aunique[$f]));
            $this->pdf->Text( $x, $y, $linfo);
            $y += 4;
            $this->pdf->Text( $x, $y, $heading);
            $y += 4;


            foreach($leadQuestions as $qk => $oneQuestion) {

                /* echo $leadQuestions[$qk];
                 echo "<br>";
                 echo $leadAnswers[$qk];
                 echo "===========================\n";
                 continue;*/
//                $qindex = 'q'.$qk;

                if( $leadQuestions[$qk]!=""){
//                    $aindex = 'a'.$qk;
                    $answer = $leadAnswers[$qk];
                    if(is_array($oneQuestion)) {
                        $question = $oneQuestion['question'];
                    } else {
                        $question = $leadQuestions[$qk];
                    }

                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addPdfRow($question, $answer, $x, $y);

                }
            }


                //Adding Funnel URL
                if($funnelURL) {
                    $this->addPdfRow('Funnel URL', $funnelURL, $x, $y);
                }

                //Adding Date
                $this->addPdfRow('Date', date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $x, $y);

                //Adding Time
                $this->addPdfRow('Time', date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $x, $y);

         /*   for($i=1; $i <= $this->max_questions; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];

                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addPdfRow($question, $answer, $x, $y);
                }
                if($i == $this->max_questions) {
                    //Adding Funnel Name
                    if ($funnelName) {
                        $this->addPdfRow('Funnel Name', $funnelName, $x, $y);
                    }
                    //Adding Funnel URL
                    if($funnelURL) {
                        $this->addPdfRow('Funnel URL', $funnelURL, $x, $y);
                    }

                    //Adding Date
                    $this->addPdfRow('Date', date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $x, $y);

                    //Adding Time
                    $this->addPdfRow('Time', date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $x, $y);
                }
            }*/

            /**
             * ip address remove export pdf from @mzac90
             */
            //$y += 5;
            //$x = 5;
            //$this->pdf->SetFont('Arial', 'B',8);
            //$this->pdf->Text( $x, $y, "IP Address");
            //$x = 90;
            //$this->pdf->SetFont('Arial','',8);
            //$x = 45;
            //$this->pdf->Text( $x, $y, $ipaddress);
        }
        $this->pdf->Output($filename,"D");
        exit;

        for($f=0; $f<count($aunique); $f++) {

            $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($aunique[$f]);

            $lead = $return_data['lead'];
            //debug($lead);
            $aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);

            $z = $return_data['z'];

            $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:"Lead Information";
            if($heading) {
                $this->pdf->SetFont('Arial', 'B',8);
                $x = 2;
                $y += 6;
                $this->pdf->Text( 2, $y, "________________________________________________________________________________________________");
                $y += 4;
                $this->pdf->Text( $x, $y, $this->_exp_mod_obj->getleadname($client_id,$aunique[$f]));
                $y += 4;
                $this->pdf->Text( $x, $y, $heading);
                $y += 4;
            }
            for($i=1; $i< 51; $i++) {
                $qindex = 'q'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question = $lead[$qindex];
                    $aindex = 'a'.$i;
                    $answer = $lead[$aindex];
                    $y += 5;
                    $x = 5;
                    $this->pdf->SetFont('Arial', 'B',8);
                    $this->pdf->Text( $x, $y, $question);
                    $x = 90;
                    $this->pdf->SetFont('Arial','',8);
                    $this->pdf->Text( $x, $y, $answer);
                    if($y>260) {
                        $this->pdf->AddPage('P','A4');
                        $y = 0;
                    }
                }
            }
            //$y += 5;
            //$x = 5;
            /**
             * ip address remove export pdf from @mzac90
             */
            //$this->pdf->SetFont('Arial', 'B',8);
            //$this->pdf->Text( $x, $y, "IP Address");
            //$x = 90;
            //$this->pdf->SetFont('Arial','',8);
            //$x = 45;
            //$this->pdf->Text( $x, $y, $ipaddress);
        }
        $this->pdf->Output($filename,"D");
        exit;
    }

    function myleadsemailV1(){
        ini_set('memory_limit', -1);
        //set_time_limit(0);
        $funnelName = null;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnelName = $hash_data['funnel']['funnel_name'];
        }
        $sunique = $_POST['u'];
        if($sunique == 1){
            $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
            $sunique = implode('~',$allfunnelkeys['allkey']);
        }
        $aunique = explode("~",$sunique);
        $client_id = $_POST['client_id'];
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);

        $section = $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);
        // 1. Header Table
        $section->addText('', $header);

        $headerFunnelTableStyleName = 'Header Funnel Table';
        $headerFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $headerFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $headerFunnelTableCellStyle = array('valign' => 'center');
        $headerFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $headerFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $this->phpWord->addTableStyle($headerFunnelTableStyleName, $headerFunnelTableStyle, $headerFunnelTableFirstRowStyle);
        $table = $section->addTable($headerFunnelTableStyleName);
        $table->addRow(900);
        $c1=$table->addCell(7000, $headerFunnelTableCellStyle);
        $c1->addText($this->_exp_mod_obj->parseTextForExport(ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($clientInfo['company_name']));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']));
        $c2=$table->addCell(3000, $headerFunnelTableCellStyle);
        $c2->addText("Powered by:  leadPops, Inc", $headerFunnelTableFontStyle);
        $c2->addText("http://www.leadpops.com", $headerFunnelTableFontStyle);


        $dataFunnelTableStyleName = 'Data Funnel Table ';
        $dataFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $dataFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '000');
        $dataFunnelTableCellStyle = array('valign' => 'center');
        $dataFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $dataFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        foreach ($return_data as $lead) {

            $unique_arr = explode("-", $lead["unique_key"]);
            $common_str = substr($unique_arr[1], 0, 10);
            $ipaddress = str_replace($common_str, "", $unique_arr[0]);

            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            $section->addTextBreak(1);
            $section->addText($this->_exp_mod_obj->parseTextForExport($linfo),array("bold"=>true,'size'=>'10','name'=>'arial, helvetica, sans-serif'),array('alignment' => 'center'));
            $this->phpWord->addTableStyle($dataFunnelTableStyleName, $dataFunnelTableStyle, $dataFunnelTableFirstRowStyle);
            $dtable = $section->addTable($dataFunnelTableStyleName);
            $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:"Lead Information";
            if($heading){
                $dtable->addRow(900);
                $dc1=$dtable->addCell(7000, $dataFunnelTableCellStyle);
                $dc1->addText($heading,array(),array('alignment' => 'center'));
            }
            for($i=1; $i<= $this->max_questions; $i++) {
                $qindex = 'q'.$i;
                $aindex = 'a'.$i;
                if(isset($lead[$qindex]) && $lead[$qindex] != "") {
                    $question_text = str_replace(array("$", "%", "#", "<", ">", "|"), "", $lead[$qindex]);
                    $question = (string) $question_text;
                    $answer = $lead[$aindex];

                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);

                    $this->addWordRow($dtable, $question, $answer, $dataFunnelTableCellStyle);
                }

            }
            //Adding Funnel URL
            if(isset($_POST['funnel_url']) && !empty($_POST['funnel_url'])) {
                $this->addWordRow($dtable, 'Funnel URL', $_POST['funnel_url'], $dataFunnelTableCellStyle);
            }
            //Adding Date
            $this->addWordRow($dtable, "Date", date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
            //Adding Time
            $this->addWordRow($dtable, "Time", date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);

            //debug($ar);
            $dtable->addRow(900);
            $dtable->addCell(5000, $dataFunnelTableCellStyle)->addText("IP Address:",array("bold"=>true));
            $dtable->addCell(5000, $dataFunnelTableCellStyle)->addText($this->_exp_mod_obj->parseTextForExport($ipaddress));
            //$section->addPageBreak();

        }
        $file_name = "";
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $file_name = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".docx";


        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        //$this->phpWord->save($report, "Word2007");
        $objWriter->save($report);
        $time = time() + (3*86400);
        $expire = date('m/d/Y g:i a',$time);
        $link = "Visit ".LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name. " to view. Files will remain active until ". $expire;
        return $link;
    }

    /**
     * On the base of .env variable this function will generate export file
     * from V1 OR lead content new table
     * @return string
     * @throws \PhpOffice\PhpWord\Exception\Exception
     */
    function myleadsemail(){
        /*if(env('TBL_LEAD_CONTENT_v2', 0) == 0){
            return $this->myleadsemailV1();
        }*/

        ini_set('memory_limit', -1);
        //set_time_limit(0);
        $funnelName = null;
        LP_Helper::getInstance()->getCurrentHashData($_POST["current_hash"]);
        if (LP_Helper::getInstance()->getCurrentHash()) {
            $hash_data = LP_Helper::getInstance()->getFunnelData();
            $funnelName = $hash_data['funnel']['funnel_name'];
        }
        $sunique = $_POST['u'];
        if($sunique == 1){
            $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
            if($allfunnelkeys['allkey'] == 0) {
                Log::debug("client => ",[@$_POST['client_id']]);
                Log::debug("allkey export data issue ",[$allfunnelkeys]);
                die('all key is 0');
            }
            $sunique = implode('~',$allfunnelkeys['allkey']);
        }
        $aunique = explode("~",$sunique);
        $client_id = $_POST['client_id'];
        $clientInfo = $this->_exp_mod_obj->getClientInfo($client_id);

        $section = $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);
        // 1. Header Table
        $section->addText('', $header);

        $headerFunnelTableStyleName = 'Header Funnel Table';
        $headerFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $headerFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $headerFunnelTableCellStyle = array('valign' => 'center');
        $headerFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $headerFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $this->phpWord->addTableStyle($headerFunnelTableStyleName, $headerFunnelTableStyle, $headerFunnelTableFirstRowStyle);
        $table = $section->addTable($headerFunnelTableStyleName);
        $table->addRow(900);
        $c1=$table->addCell(7000, $headerFunnelTableCellStyle);
        $c1->addText($this->_exp_mod_obj->parseTextForExport(ucfirst($clientInfo['first_name'])." ".ucfirst($clientInfo['last_name'])));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($clientInfo['company_name']));
        $c1->addText($this->_exp_mod_obj->parseTextForExport($this->_exp_mod_obj->formatPhone($clientInfo['phone_number'])." - ". $clientInfo['contact_email']));
        $c2=$table->addCell(3000, $headerFunnelTableCellStyle);
        $c2->addText("Powered by:  leadPops, Inc", $headerFunnelTableFontStyle);
        $c2->addText("http://www.leadpops.com", $headerFunnelTableFontStyle);


        $dataFunnelTableStyleName = 'Data Funnel Table ';
        $dataFunnelTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $dataFunnelTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '000');
        $dataFunnelTableCellStyle = array('valign' => 'center');
        $dataFunnelTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $dataFunnelTableFontStyle = array("name"=> "arial, helvetica, verdana, sans-serif", "italic"=> true);
        $lead_ids=implode(",", $aunique);
        $return_data=$this->_exp_mod_obj->getLeadContentByFunnel($lead_ids);

        $heading  =  "Lead Information";

        foreach ($return_data as $lead) {
            /*debug($lead);
            exit;*/

            $leadQuestions = json_decode($lead['lead_questions'], 1);
            $leadAnswers = json_decode($lead['lead_answers'], 1);

            $aipaddress = explode("-",$lead["unique_key"]);
            $ipaddress = $aipaddress[0];
            $ipaddress = str_replace($aipaddress[1],"",$ipaddress);

            $section->addTextBreak(1);
            $dtime = strtotime($lead['date_completed']);
            $dt = date('d/m/Y g:i a',$dtime);

            $phone = preg_replace("[^0-9]", "", $lead['phone'] );
            $phone = $this->_exp_mod_obj->formatPhone($phone);
            $linfo = ucfirst($lead['firstname'])." ".ucfirst($lead['lastname'])." | ". $phone . " | ". $lead['email'] . " |  Completed " . $dt;

            $section->addText($this->_exp_mod_obj->parseTextForExport($linfo),array("bold"=>true,'size'=>'10','name'=>'arial, helvetica, sans-serif'),array('alignment' => 'center'));
            $this->phpWord->addTableStyle($dataFunnelTableStyleName, $dataFunnelTableStyle, $dataFunnelTableFirstRowStyle);
            $dtable = $section->addTable($dataFunnelTableStyleName);

            $dtable->addRow(900);
            $dc1=$dtable->addCell(7000, $dataFunnelTableCellStyle);
            $dc1->addText($heading,array(),array('alignment' => 'center'));

            foreach($leadQuestions as $qk => $oneQuestion) {
                if( $leadQuestions[$qk]!=""){
                    $answer = $leadAnswers[$qk];
                    if(is_array($oneQuestion)) {
                        $question = $oneQuestion['question'];
                    } else {
                        $question = $leadQuestions[$qk];
                    }
                    $question_text = str_replace(array("$", "%", "#", "<", ">", "|"), "", $question);
                    $question = (string) $question_text;
                    $this->_exp_mod_obj->replaceQuestionIfMatchesAny($question);
                    $this->_exp_mod_obj->replaceAnswerIfMatchesAny($answer);
                    $this->addWordRow($dtable, $question, $answer, $dataFunnelTableCellStyle);
                }

            }
            //Adding Funnel Name
            if ($funnelName) {
                $this->addWordRow($dtable, 'Funnel Name', $funnelName, $dataFunnelTableCellStyle);
            }

            //Adding Funnel URL
            if(isset($_POST['funnel_url']) && !empty($_POST['funnel_url'])) {
                $this->addWordRow($dtable, 'Funnel URL', $_POST['funnel_url'], $dataFunnelTableCellStyle);
            }
            //Adding Date
            $this->addWordRow($dtable, "Date", date($this->_exp_mod_obj->date_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);
            //Adding Time
            $this->addWordRow($dtable, "Time", date($this->_exp_mod_obj->time_format, strtotime($lead["date_completed"])), $dataFunnelTableCellStyle);

            //debug($ar);
            $dtable->addRow(900);
            $dtable->addCell(5000, $dataFunnelTableCellStyle)->addText("IP Address:",array("bold"=>true));
            $dtable->addCell(5000, $dataFunnelTableCellStyle)->addText($this->_exp_mod_obj->parseTextForExport($ipaddress));
            //$section->addPageBreak();
        }

        $file_name = "";
        $m = "select first_name,last_name from clients where client_id = " . $client_id;
        $fn = $this->db->fetchRow($m);
        $file_name = preg_replace("[^a-zA-Z0-9]", "",$fn['first_name'].$fn['last_name']).date('m-d-Y-g-i-a').".docx";


        $report = public_path().'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name;
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($this->phpWord, 'Word2007');
        //$this->phpWord->save($report, "Word2007");
        $objWriter->save($report);
        $time = time() + (3*86400);
        $expire = date('m/d/Y g:i a',$time);
        $link = "Visit ".LP_BASE_URL.'/'.env('RACKSPACE_TMP_DIR', '').'/'.$file_name. " to view. Files will remain active until ". $expire;
        return $link;
    }
    function exportleadsemaildata(){
        LP_Helper::getInstance()->getCurrentHashData();
        if(LP_Helper::getInstance()->getCurrentHash()) {
            $this->_exp_mod_obj->exportMyLeadsEmailData();
            echo True;
            //echo json_encode($return_data);
        }else{
            echo 'something wronge ajax call';
        }
    }
    function myleadsprint(){
        $sunique = $_POST['u'];
        if($sunique == 1){
            $allfunnelkeys =$this->Mylead_Model->getAllFunnelKey();
            if($allfunnelkeys['allkey'] == 0) {
                Log::debug("client => ",[@$_POST['client_id']]);
                Log::debug("allkey export data issue ",[$allfunnelkeys]);
                die('all key is 0');
            }
            $_POST['u'] = implode('~',$allfunnelkeys['allkey']);
        }
        $return_data=$this->_exp_mod_obj->getMyLeadsPrint();
        echo $return_data;
        exit;
    }
    function myleadpopprint(){
        $return_data=$this->_exp_mod_obj->getMyLeadPopPrint();
        echo $return_data;

    }
    //================================================================================================================//
    function checksampleData(){
        // New Word Document
        echo date('H:i:s'), ' Create new PhpWord object';
        $section =  $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);

        // 1. Basic table

        $rows = 10;
        $cols = 5;
        $section->addText('Basic table', $header);

        $table = $section->addTable();
        for ($r = 1; $r <= 8; $r++) {
            $table->addRow();
            for ($c = 1; $c <= 5; $c++) {
                $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
            }
        }

        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        // 2. Advanced table
        for ($k=0; $k <10 ; $k++) {
            $section->addTextBreak(1);
            $section->addText('Fancy table', $header);
            $this->phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
            $table = $section->addTable($fancyTableStyleName);
            $table->addRow(900);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Row 1', $fancyTableFontStyle);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Row 2', $fancyTableFontStyle);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Row 3', $fancyTableFontStyle);
            $table->addCell(2000, $fancyTableCellStyle)->addText('Row 4', $fancyTableFontStyle);
            $table->addCell(500, $fancyTableCellBtlrStyle)->addText('Row 5', $fancyTableFontStyle);
            for ($i = 1; $i <= 51; $i++) {
                $table->addRow();
                $table->addCell(2000)->addText("Cell {$i}");
                $table->addCell(2000)->addText("Cell {$i}");
                $table->addCell(2000)->addText("Cell {$i}");
                $table->addCell(2000)->addText("Cell {$i}");
                $text = (0== $i % 2) ? 'X' : '';
                $table->addCell(500)->addText($text);
            }
        }
        // Save file
        $file_name="test_".date('d_m_Y_g:i_a').".docx";
        return $this->write( $file_name, $writers);


        /* Add our HTTP Headers */
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html

        // Doc generated on the fly, may change so do not cache it; mark as public or
        // private to be cached.
        header('Pragma: no-cache');
        // Mark file as already expired for cache; mark with RFC 1123 Date Format up to
        // 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
        header('Expires: 0');
        // Forces cache to re-validate with server
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // DocX Content Type
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // Tells browser we are sending file
        header('Content-Disposition: attachment; filename='.$file_name.';');
        // Tell proxies and gateways method of file transfer
        header('Content-Transfer-Encoding: binary');
        // Indicates the size to receiving browser
        header('Content-Length: '.filesize($file_name));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter( $this->phpWord, 'Word2007');
        $objWriter->save('php://output');

    }
    function sampledocumentAction(){
        // Creating the new document...

        //* Note: any element you append to a document must reside inside of a Section. */

        // Adding an empty Section to the document...
        $section =  $this->phpWord->addSection();
        // Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)'
        );

        /*
        * Note: it's possible to customize font style of the Text element you add in three ways:
        * - inline;
        * - using named font style (new font style object will be implicitly created);
        * - using explicitly created font style object.
        */

        // Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Tahoma', 'size' => 10)
        );

        // Adding Text element with font customized using named font style...
        $fontStyleName = 'oneUserDefinedStyle';
        $this->phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
        );
        $section->addText(
            '"The greatest accomplishment is not in never falling, '
            . 'but in rising again after you fall." '
            . '(Vince Lombardi)',
            $fontStyleName
        );

        // Adding Text element with font customized using explicitly created font style object...
        $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        $fontStyle->setBold(true);
        $fontStyle->setName('Tahoma');
        $fontStyle->setSize(13);
        $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
        $myTextElement->setFontStyle($fontStyle);
        $file_name=date('d/m/Y_g:i_a').".doc";



        /* Add our HTTP Headers */
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html

        // Doc generated on the fly, may change so do not cache it; mark as public or
        // private to be cached.
        header('Pragma: no-cache');
        // Mark file as already expired for cache; mark with RFC 1123 Date Format up to
        // 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
        header('Expires: 0');
        // Forces cache to re-validate with server
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // DocX Content Type
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // Tells browser we are sending file
        header('Content-Disposition: attachment; filename='.$file_name.';');
        // Tell proxies and gateways method of file transfer
        header('Content-Transfer-Encoding: binary');
        // Indicates the size to receiving browser
        header('Content-Length: '.filesize($file_name));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter( $this->phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;

        // Send the file:
        //readfile($file_name);

        // Delete the file if you so choose. BE CAREFULE; YOU MAY NEED TO DO THIS
        // THROUGH YOUR FRAMEWORK:
        //unlink($file_name);

        // End the session. BE CAREFUL; YOU NEED TO DO THIS THROUGH YOUR FRAMEWORK:
        //session_write_close();

    }
    function tableexportsampleAction(){

        // New Word Document
        $section =  $this->phpWord->addSection();
        $header = array('size' => 16, 'bold' => true);
        // 1. Basic table
        $section->addText('Basic table', $header);
        $table = $section->addTable();
        for ($r = 1; $r <= 8; $r++) {
            $table->addRow();
            for ($c = 1; $c <= 5; $c++) {
                $table->addCell(1750)->addText("Row {$r}, Cell {$c}");
            }
        }
        // 2. Advanced table
        $section->addTextBreak(1);
        $section->addText('Fancy table', $header);
        $fancyTableStyleName = 'Fancy Table';
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
        $fancyTableFirstRowStyle = array('borderBottomSize' => 18, 'borderBottomColor' => '0000FF', 'bgColor' => '66BBFF');
        $fancyTableCellStyle = array('valign' => 'center');
        $fancyTableCellBtlrStyle = array('valign' => 'center', 'textDirection' => \PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR);
        $fancyTableFontStyle = array('bold' => true);
        $this->phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle);
        $table = $section->addTable($fancyTableStyleName);
        $table->addRow(900);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 1', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 2', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 3', $fancyTableFontStyle);
        $table->addCell(2000, $fancyTableCellStyle)->addText('Row 4', $fancyTableFontStyle);
        $table->addCell(500, $fancyTableCellBtlrStyle)->addText('Row 5', $fancyTableFontStyle);
        for ($i = 1; $i <= 8; $i++) {
            $table->addRow();
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $table->addCell(2000)->addText("Cell {$i}");
            $text = (0== $i % 2) ? 'X' : '';
            $table->addCell(500)->addText($text);
        }
        /**
         *  3. colspan (gridSpan) and rowspan (vMerge)
         *  ---------------------
         *  |     |   B    |    |
         *  |  A  |--------|  E |
         *  |     | C |  D |    |
         *  ---------------------
         */
        /*$section->addPageBreak();
        $section->addText('Table with colspan and rowspan', $header);
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => 'FFFF00');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        $spanTableStyleName = 'Colspan Rowspan';
         $this->phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        $table = $section->addTable($spanTableStyleName);
        $table->addRow();
        $cell1 = $table->addCell(2000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('A');
        $textrun1->addFootnote()->addText('Row span');
        $cell2 = $table->addCell(4000, $cellColSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('B');
        $textrun2->addFootnote()->addText('Column span');
        $table->addCell(2000, $cellRowSpan)->addText('E', null, $cellHCentered);
        $table->addRow();
        $table->addCell(null, $cellRowContinue);
        $table->addCell(2000, $cellVCentered)->addText('C', null, $cellHCentered);
        $table->addCell(2000, $cellVCentered)->addText('D', null, $cellHCentered);
        $table->addCell(null, $cellRowContinue);*/
        /**
         *  4. colspan (gridSpan) and rowspan (vMerge)
         *  ---------------------
         *  |     |   B    |  1 |
         *  |  A  |        |----|
         *  |     |        |  2 |
         *  |     |---|----|----|
         *  |     | C |  D |  3 |
         *  ---------------------
         * @see https://github.com/PHPOffice/PHPWord/issues/806
         */
        $section->addPageBreak();
        $section->addText('Table with colspan and rowspan', $header);
        $styleTable = array('borderSize' => 6, 'borderColor' => '999999');
        $this->phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $table = $section->addTable('Colspan Rowspan');
        $row = $table->addRow();
        $row->addCell(null, array('vMerge' => 'restart'))->addText('A');
        $row->addCell(null, array('gridSpan' => 2, 'vMerge' => 'restart',))->addText('B');
        $row->addCell()->addText('1');
        $row = $table->addRow();
        $row->addCell(null, array('vMerge' => 'continue'));
        $row->addCell(null, array('vMerge' => 'continue','gridSpan' => 2,));
        $row->addCell()->addText('2');
        $row = $table->addRow();
        $row->addCell(null, array('vMerge' => 'continue'));
        $row->addCell()->addText('C');
        $row->addCell()->addText('D');
        $row->addCell()->addText('3');
        // 5. Nested table
        $section->addTextBreak(2);
        $section->addText('Nested table in a centered and 50% width table.', $header);
        $table = $section->addTable(array('width' => 50 * 50, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));
        $cell = $table->addRow()->addCell();
        $cell->addText('This cell contains nested table.');
        $innerCell = $cell->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER))->addRow()->addCell();
        $innerCell->addText('Inside nested table');
        $file_name=date('d/m/Y_g:i_a').".doc";
        /* Add our HTTP Headers */
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
        // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html

        // Doc generated on the fly, may change so do not cache it; mark as public or
        // private to be cached.
        header('Pragma: no-cache');
        // Mark file as already expired for cache; mark with RFC 1123 Date Format up to
        // 1 year ahead for caching (ex. Thu, 01 Dec 1994 16:00:00 GMT)
        header('Expires: 0');
        // Forces cache to re-validate with server
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // DocX Content Type
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        // Tells browser we are sending file
        header('Content-Disposition: attachment; filename='.$file_name.';');
        // Tell proxies and gateways method of file transfer
        header('Content-Transfer-Encoding: binary');
        // Indicates the size to receiving browser
        header('Content-Length: '.filesize($file_name));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter( $this->phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }

    private function addPdfRow($label, $value, &$x, &$y){
        $y += 5;
        $x = 5;
        $this->pdf->SetFont('Arial', 'B',8);
        $this->pdf->Text( $x, $y, $label);
        $x = 90;
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->Text( $x, $y, $value);
        if($y>260) {
            $this->pdf->AddPage('P','A4');
            $y = 0;
        }
    }

    private function addWordRow(&$dtable, $label, $value, $dataFunnelTableCellStyle){
        $dtable->addRow(900);
        // define the cell
        $cell1 = $dtable->addCell(5000,$dataFunnelTableCellStyle);
        // add one line

        $cell1->addText($this->_exp_mod_obj->parseTextForExport($label),array("bold"=>true));
        //$cell1->addText("$question:",array("bold"=>true));
        // define the cell
        $cell2 = $dtable->addCell(5000,$dataFunnelTableCellStyle);

        // add one line
        $cell2->addText($this->_exp_mod_obj->parseTextForExport($value));
    }
}
