@php
    date_default_timezone_set('America/Los_Angeles');
    $db = App::make('App\Services\DbService');
    LP_Helper::getInstance()->getCurrentHashData();
    $hash_data = LP_Helper::getInstance()->getFunnelData();
    $contact_arr = array();
    $contact_seq = array('First Name','Last Name','Email','Primary Email','Phone','Primary Phone');

    $leadQuestions = json_decode($lead['lead_questions'], 1);
    $leadAnswers = json_decode($lead['lead_answers'], 1);


     foreach($leadQuestions as $qk => $oneQuestion) {
        if($leadQuestions[$qk] != "") {
            if(is_array($oneQuestion)) {
                $question = $oneQuestion['label'];
            } else {
                $question = $leadQuestions[$qk];
            }
            $answer = $leadAnswers[$qk];

            if (in_array($question, $contact_seq)) {

                if(strpos(strtolower($question),'email') !== false){
                    $question = 'Email Address';
                    $answer = '<a href="mailto:'.$answer.'">'.$answer.'</a>';
                }

                if(strpos(strtolower($question),'phone') !== false){
                    $question = 'Phone Number';
                    $answer = '<a href="tel:'.$answer.'">'.$answer.'</a>';
                }

                if(in_array($question, array('First Name','Last Name')))  $answer=ucfirst($answer);
                    $contact_arr[$question] = $answer;
            }
        }
    }

    $funnelURL = "https://" . $hash_data['funnel']['domain_name'];
    $contact_arr['Funnel URL'] = $funnelURL;
    $s = "";
    $heading = "";
@endphp
<div class="modal-dialog modal-max__dialog modal-dialog-centered" data-backdrop="static">
    <div class="modal-content">
        <div class="modal-head-wrap">
            <div class="modal-header">
                @php
                    if($heading == "") {
                    $heading  =  (isset($z[0]['heading']))?$z[0]['heading']:$lead["firstname"]." ".$lead["lastname"];
                @endphp
                <h3 class="modal-title">{{ $heading }}</h3>
                @php
                    }
                @endphp
                <button type="button" class="close" data-dismiss="modal"><i class="ico ico-cross"></i></button>
                <div class="col__wrapper lead__options border-0 p-0 h-auto">
                    <div class="col-left">
                        <div class="lead__action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <a href="{{ LP_BASE_URL.LP_PATH.'/export/exportsworddata?u='.$unique_key.'&client_id='.$client_id.'&funnel_url=' . $funnelURL }}"
                                       class="action__link">
                                        <span class="ico ico-ms-word"></span>export as .doc
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="{{ LP_BASE_URL.LP_PATH.'/export/exportsexcelddata?u='.$unique_key.'&client_id='.$client_id.'&funnel_url=' . $funnelURL }}"
                                       class="action__link">
                                        <span class="ico ico-adobe-xs"></span>export excel
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="{{ LP_BASE_URL.LP_PATH.'/export/exportspdfdata?u='.$unique_key.'&client_id='.$client_id.'&funnel_url=' . $funnelURL }}"
                                       class="action__link">
                                        <span class="ico ico-adobe"></span>export as pdf
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="javascript:void(0);" id="printmailtopophref"
                                       data-uniquekey="{{$unique_key}}" class="action__link">
                                        <span class="ico ico-print"></span>print
                                    </a>
                                </li>
                                <li class="action__item">
                                    <a href="javascript:void(0);" id="mailtopophref" data-uniquekey="{{$unique_key}}"
                                       class="action__link">
                                        <span class="ico ico-email"></span>email
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-right">
                        <ul class="action__list">
                            <li class="action__item">
                                <a href="#" data-dismiss="modal" id="delmyleads" class="action__link lead__btn-del"
                                   data-uniquekey="{{ $unique_key }}">
                                    <span class="ico ico-cross"></span>delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-body-wrap">
            <div class="modal-body quick-scroll">
                <div class="modal-lead__info">
                    <div class="lead-modal-wrapper">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="lead-modal-des">
                                    @php
                                        foreach ($contact_arr as $q => $a) {
                                    @endphp
                                    <div class="outer">
                                        <div class="modal-left">
                                            <h5>{{ str_replace(":","",$q) }}:</h5>
                                        </div>
                                        <div class="modal-right">
                                            <h5>{!! $a !!}</h5>
                                        </div>
                                    </div>
                                    @php
                                        }
                                    @endphp
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="lead-modal-des">


                                    @php
                                        // for($i=1; $i<= 50; $i++) {
                         foreach($leadQuestions as $qk => $oneQuestion) {
                                         if(is_array($oneQuestion)) {
                                            $question = $oneQuestion['label'];
                                         } else {
                                            $question = $leadQuestions[$qk];
                                         }
                                         if($question != "") {
                                         $question = str_replace(":","",rtrim($question));

                                         $answer = stripslashes($leadAnswers[$qk]);

                                         if(strtolower($answer) === "computer"){
                                            $answer="Desktop";
                                         }
                                         else if(strtolower($answer) ==="phone" ){
                                            $answer="Tablet/Smartphone";
                                         }


                                         $statecode = "";
                                         $city = "";
                                         if(stristr($question,'zip')) {
                                             $ss = "select state,city from zipcodes where zipcode = '".trim($answer)."' limit 1 ";
                                             $resz = $db->fetchAll($ss);

                                             if(!empty($resz)){
                                                 $statecode = $resz[0]['state'];
                                                 $city = $resz[0]['city'];
                                             } else {
                                                if(trim($answer) != "" && strpos(trim($answer), ",")){
                                                    $expr = explode(",", trim($answer));
                                                    $statecode = @$expr[1];
                                                    $city = @$expr[0];
                                                    $answer = @$expr[2];
                                                }
                                             }
                                         }

                                         if (!in_array($question, $contact_seq)) {
                                         $fans=($statecode == "")?$answer:$answer."-".$city."-".$statecode;
                                         // if ($question == "Query String") $fans =  str_replace("~","&",$fans);
                                         $showQuestion = is_array($oneQuestion)  ? $oneQuestion['question'] : $question;
                                    @endphp
                                    <div class="outer" {{  ($question == "Referrer" ? " style='display: none' ":'') }}>
                                        <div class="modal-left">
                                            <h5>{{ $showQuestion }}</h5>
                                        </div>
                                        <div class="modal-right">
                                            <h5{{ ($question == "Query String" ? " style='line-height: 1.2;max-width: 500px;word-wrap: break-word' ":'') }}>{{ $fans }}</h5>
                                        </div>
                                    </div>
                                    @php
                                        }
                                        }
                                        }
                                    @endphp

                                    {{--<div class="outer"><div class="modal-left"><h5>IP Address:</h5></div><div class="modal-right"><h5>{{ $ipaddress }}</h5></div></div>--}}
                                    <div class="outer">
                                        <div class="modal-left">
                                            <h5>Date:</h5>
                                        </div>
                                        <div class="modal-right">
                                            <h5>@php echo date('F j, Y',strtotime($lead["date_completed"])) @endphp</h5>
                                        </div>
                                    </div>
                                    <div class="outer">
                                        <div class="modal-left">
                                            <h5>Time:</h5>
                                        </div>
                                        <div class="modal-right">
                                            <h5>@php echo date('g:i a T',strtotime($lead["date_completed"])) @endphp</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer-wrap">
            <div class="modal-footer">
                <div class="action">
                    <ul class="action__list">
                        <li class="action__item">
                            <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
