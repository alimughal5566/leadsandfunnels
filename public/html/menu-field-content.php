<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-question-slider.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/pages/funnel-question-slider-content.js"></script>
</head>
<body>
    <div class="funnel-slider-wrap">
        <div class="question_slider">
            <div class="row">
                <div class="col">
                    <div class="question_slider__title">
                        <h1>What is the purchase price of the new&nbsp;property?</h1>
                    </div>
                    <div class="puck-sliders-wrap">
                        <div class="question_slider__fields single-puck">
                            <div class="range-slider">
                                <div id="current_val" class="current-val">$80,000 to $100,000</div>
                                <input id="range_slider" type="text" data-slider-tooltip="hide" data-slider-min="$80,000" data-slider-max="$2,000,000" data-slider-step="1" data-slider-value="0"/>
                                <ul class="range-slider__value">
                                    <li>$80K</li>
                                    <li>$2M+</li>
                                </ul>
                            </div>
                        </div>
                        <div class="question_slider__fields double-puck">
                            <div class="range-slider">
                                <div id="current_val" class="current-val">
                                    <span class="newValue">$300,000</span> to <span class="oldValue">$100,000</span>
                                </div>
                                <input id="range_slider_multiple" type="text" value="" data-slider-min="80000" data-slider-max="2000000" data-slider-step="20000" data-slider-value="[300000,1400000]"/>
                                <ul class="range-slider__value">
                                    <li>$80K</li>
                                    <li>$2M+</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="question_slider__fields">
                        <div class="form-group text-center btn-wrap cta-btn-wrap">
                            <a href="#" class="btn btn-secondary btn-next cta-btn">
                                <span class="icon-holder"><span class="icon-wrap"><i class="icon ico-start-rate"></i></span></span>
                                continue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
