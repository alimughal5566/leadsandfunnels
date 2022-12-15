@php
    $accountType = strtolower(LP_Helper::getInstance()->getClientIndustry());
    $accountType = str_replace(" ", "", $accountType);
    $surveyConfig = config("survey." . $accountType);
    $questionIndex = 1;
    $summaryHtml = "";
    $surveyData = [];
@endphp
<div class="survey-overlay">
    <div class="survey-overlay__wrapper">
        <div class="os-progress-bar">
            <div class="os-progress-bar__rail">
                <span class="os-progress-bar__dragger"></span>
            </div>
        </div>
        <div class="survey-overlay__inner owl-carousel">
            <div id="item0" class="survey-overlay__items">
                <div class="lp-step1" tabindex="0">
                    <h1 class="survey-overlay__title">Welcome to the leadPops<br />Client Success Survey! </h1>
                    <div class="survey-overlay__wnote">
                        <p class="survey-overlay__description">Please take a moment to answer some quick questions that will let us better <br />understand how we can help you build your mortgage business.</p>
                        <p class="survey-overlay__description">Once you answers these simple questions, you'll unlock the full leadPops Marketing <br />Training Library and get access to all your Funnels!</p>
                    </div>
                    <a href="#" class="btn survey-overlay__btn lp-step1__btn os-continue">get started now!</a>
                    <div class="survey-overlay__note survey-overlay__note_padd">Any information you share with us is kept private, secure, and will NOT be sold or shared.</div>
                </div>
            </div>

            @foreach($surveyConfig['questions'] as $question)
                @php $optionIndex = 0; $totalOptions = count($question['options']); @endphp
                <div id="item{{$questionIndex++}}" class="survey-overlay__items">
                    <div class="lp-survey-step lp-step{{$questionIndex}}" data-lp-step="{{$questionIndex}}">
                        <h1 class="survey-overlay__title survey-overlay__title_small">{!! $question['text'] !!}</h1>
                        <div class="lp-step{{$questionIndex}}__inner">
                            <!--  select html   -->
                            <div class="os-select">
                                @foreach($question['options'] as $option)
                                    @php
                                        $optionCls = "os-select__option";
                                        if($optionIndex == 0) {
                                            $optionCls .= " os-select__option_first";
                                            $surveyData[$question['name']] = $option;
                                            $summaryHtml .= '<li class="os-summary__items">' . $question['summary_text'] . ': <span id="question_summary_'.$questionIndex.'" class="os-summary__bold">'.$option.'</span></li>';
                                        } elseif (($optionIndex + 1) == $totalOptions) {
                                            $optionCls .= " os-select__option_last";
                                        }
                                        $optionIndex++;
                                    @endphp
                                    <div data-value="{{$option}}" class="{{$optionCls}}">{{$option}}</div>
                                @endforeach
                            </div>
                            <input type="hidden" name="{{$question['name']}}" id="lp-field-{{$questionIndex}}">
                        </div>
                        <div class="survey-overlay__note">Any information you share with us is kept private, secure, and will NOT be sold or shared.</div>
                    </div>
                </div>
            @endforeach

            <div id="item{{$questionIndex++}}" class="survey-overlay__items">
                <div class="lp-survey-last-step lp-step-summary" data-lp-step="{{$questionIndex}}">
                    <h1 class="survey-overlay__title">
                        Awesome job, <span class="os-bold">{{ @\App\Services\DataRegistry::getInstance()->leadpops->clientInfo['first_name'] }}!</span> <br />
                        Here's a quick summary:
                    </h1>
                    <!--  Radio Button html   -->
                    <div class="lp-step{{$questionIndex}}__inner">
                        <ul class="os-summary">
                            {!! $summaryHtml !!}
                        </ul>
                    </div>
                    <a href="#" class="btn survey-overlay__btn lp-step-summary__btn">I’m Finished -- Let Me In!</a>
                    <div class="survey-overlay__note">Any information you share with us is kept private, secure, and will NOT be sold or shared.</div>
                </div>
            </div>
        </div>
        <div class="os-footer">
            <div id="os-prv">
                <a href="#" class="btn survey-overlay__btn_back"><i class="fa fa-chevron-left"></i>Go Back</a>
            </div>
            <div class="os-footer__logo">
                <span class="os-footer__title">Powered by leadPops</span>
                <i class="os-lp-logo"></i>
            </div>
        </div>
        <div id="inner-loader" class="os-loader" style="display: none;">
            <div class="os-middle"></div>
            <div class="os-loader__wrapper">
                <div class="os-loader__inner"></div>
            </div>
        </div>
    </div>
    <div id="main-loader" class="os-loader">
        <div class="os-middle"></div>
        <div class="os-loader__wrapper">
            <div class="os-loader__inner"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ config('view.theme_assets') . "/survey/css/survey.css?v=" . LP_VERSION}}">
<script src="{{ config('view.theme_assets') . "/survey/js/survey.js?v=" . LP_VERSION}}"></script>
<script type="text/javascript">
    var totalSurveyQuestions = {{count($surveyConfig['questions'])}};
    var surveyData = JSON.parse("{{json_encode($surveyData)}}".replace(/&quot;/g,'"'));
</script>
