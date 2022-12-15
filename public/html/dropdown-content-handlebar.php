<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/iconmoon.css">
    <link rel="stylesheet" href="assets/external/custom-scrollbar/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-question-dropdown-content.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/external/custom-scrollbar/jquery.mCustomScrollbar-new.js"></script>
    <script src="assets/pages/funnel-question-dropdown-content.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var source = document.querySelector("#preview-template").innerHTML;
            template = Handlebars.compile(raw_html);

            var json = {
                "question":"What type of property are you purchasing?",
                "desc":"You can select one or multiple answers.",
                "btn":"Continue"
            }
            var html = template(json);
            $("body").html(html);
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    <div class="dropdown-questions-wrap">
        <div class="question_dropdown">
            <div class="row">
                <div class="col">
                    <div class="question_dropdown__title">
                        <h1>{{question}}</h1>
                        <div class="question_dropdown__text">
                            <p>{{desc}}</p>
                        </div>
                    </div>
                    <div class="question_dropdown__fields">
                        <div class="step-holder">
                            <div class="single-select-area" style="display: none">
                                <div class="single-select-opener-wrap">
                                    <a href="#" class="select-opener">Select an Option </a>
                                    <span class="select-opener-text"></span>
                                </div>
                                <div class="single-select-dropdown">
                                    <strong class="single-select-dropdown__title">Select an option <span class="icon-cancel ico-cross"></span></strong>
                                    <div class="scroll-bar">
                                        <div class="single-select-dropdown__wrap">
                                            <div class="single-select-dropdown__holder">
                                                <ul class="single-select-list">
                                                    <li>
                                                        <a href="#">
                                                            <span>None</span>
                                                            <input type="radio" name="radio" value="None" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Townhouse</span>
                                                            <input type="radio" name="radio" value="Townhouse" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Triple-Decker</span>
                                                            <input type="radio" name="radio" value="Triple-Decker" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Vacation Home</span>
                                                            <input type="radio" name="radio" value="Vacation Home" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Townhouse</span>
                                                            <input type="radio" name="radio" value="Townhouse" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Triple-Decker</span>
                                                            <input type="radio" name="radio" value="Triple-Decker" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Vacation Home</span>
                                                            <input type="radio" name="radio" value="Vacation Home" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="other-button">
                                                            <span>Other</span>
                                                            <input type="radio" name="radio" value="Other" hidden="hidden">
                                                        </a>
                                                        <div class="input-wrap">
                                                            <div class="other-input">
                                                                <input id="other_answer" type="text" data-button-type="other_answer" class="form-control validate-input" autocomplete="off"  data-function-name="formValidation">
                                                                <label for="other_answer" class="input-label">your answer</label>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="single-select-area single-select-area_group" style="display: none">
                                <div class="single-select-opener-wrap">
                                    <a href="#" class="select-opener">Select an Option</a>
                                    <span class="select-opener-text"></span>
                                </div>
                                <div class="single-select-dropdown">
                                    <strong class="single-select-dropdown__title single-select-dropdown__title-group">Select an option <span class="icon-cancel ico-cross"></span></strong>
                                    <div class="scroll-bar">
                                        <div class="single-select-dropdown__wrap">
                                            <div class="single-select-dropdown__holder">
                                                <strong class="group-title">group one</strong>
                                                <ul class="single-select-list single-select-list_group">
                                                    <li>
                                                        <a href="#">
                                                            <span>Townhouse</span>
                                                            <input type="radio" name="radio" value="Townhouse" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Triple-Decker</span>
                                                            <input type="radio" name="radio" value="Triple-Decker" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Vacation Home</span>
                                                            <input type="radio" name="radio" value="Vacation Home" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="single-select-dropdown__holder">
                                                <strong class="group-title">group Two</strong>
                                                <ul class="single-select-list single-select-list_group">
                                                    <li>
                                                        <a href="#">
                                                            <span>Luxury Villa</span>
                                                            <input type="radio" name="radio" value="Luxury Villa" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Penthouse Apartment</span>
                                                            <input type="radio" name="radio" value="Penthouse Apartment" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Duplex / Triplex</span>
                                                            <input type="radio" name="radio" value="Duplex / Triplex" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="multi-select-area" style="display: none">
                                <div class="multi-select-opener-wrap">
                                    <ul class="multi-select-area__tag"></ul>
                                    <a href="#" class="multi-select-opener">Select an Option</a>
                                </div>
                                <div class="multi-select-dropdown">
                                    <strong class="multi-select-dropdown__title">Select an option <span class="icon-cancel ico-cross"></span></strong>
                                    <div class="scroll-bar">
                                        <div class="multi-select-dropdown__wrap">
                                            <div class="multi-select-dropdown__holder">
                                                <ul class="multi-check-list">
                                                    <li>
                                                        <label class="check-label uncheck-all">
                                                            <input type="checkbox" class="uncheckbox">
                                                            <span class="fake-label">None</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Educational Building</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Luxury Villa</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Tiny House</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Penthouse Apartment</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Duplex / Triplex</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom-area">
                                        <a href="#" class="finish-btn">i'm finished</a>
                                    </div>
                                </div>
                            </div>
                            <div class="multi-select-area" style="display: none">
                                <div class="multi-select-opener-wrap">
                                    <ul class="multi-select-area__tag"></ul>
                                    <a href="#" class="multi-select-opener">Select an Option</a>
                                </div>
                                <div class="multi-select-dropdown">
                                    <strong class="multi-select-dropdown__title">Select an option <span class="icon-cancel ico-cross"></span></strong>
                                    <div class="scroll-bar">
                                        <div class="multi-select-dropdown__wrap">
                                            <div class="multi-select-dropdown__holder">
                                                <strong class="group-title">group one</strong>
                                                <ul class="multi-check-list">
                                                    <li>
                                                        <label class="check-label uncheck-all">
                                                            <input type="checkbox" class="uncheckbox">
                                                            <span class="fake-label">None</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Educational Building</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="multi-select-dropdown__holder">
                                                <strong class="group-title">group Two</strong>
                                                <ul class="multi-check-list">
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Luxury Villa</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Tiny House</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Penthouse Apartment</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Duplex / Triplex</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom-area">
                                        <a href="#" class="finish-btn">i'm finished</a>
                                    </div>
                                </div>
                            </div>
                            <div class="search-mode-area" style="display: block">
                                <div class="form-group">
                                    <div class="search-input-wrap">
                                        <label for="search" class="input-label">Search</label>
                                        <input type="search" id="search" class="form-control search-input" autocomplete="off">
                                        <span class="search-icon ico-search-2"></span>
                                        <div class="tag-box">
                                            <ul class="tag-box__list"></ul>
                                        </div>
                                        <div class="search-box">
                                            <span class="search-box__title">search results</span>
                                            <div class="scroll-bar">
                                                <ul id="search-list" class="search-box__list">
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Educational Building</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Educational Building</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Townhouse</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Triple-Decker</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Vacation Home</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Working Farm</span>
                                                        </label>
                                                    </li>
                                                    <li>
                                                        <label class="check-label">
                                                            <input type="checkbox" class="checkbox">
                                                            <span class="fake-label">Educational Building</span>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="bottom-area">
                                                <a href="#" class="finish-btn">i'm finished</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="search-mode-area single-select" style="display: none">
                                <div class="form-group">
                                    <div class="search-input-wrap">
                                        <label for="search-single" class="input-label">Search</label>
                                        <input type="search" id="search-single" class="form-control search-input" autocomplete="off">
                                        <span class="search-icon ico-search-2"></span>
                                        <div class="tag-box">
                                            <div class="search-tag-text-wrap">
                                                <span class="search-tag-text"></span>
                                            </div>
                                        </div>
                                        <div class="search-box">
                                            <span class="search-box__title">search results</span>
                                            <div class="scroll-bar">
                                                <ul class="single-search-option-list">
                                                    <li>
                                                        <a href="#">
                                                            <span>Townhouse</span>
                                                            <input type="radio" name="radio" value="Townhouse" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Triple-Decker</span>
                                                            <input type="radio" name="radio" value="Triple-Decker" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Vacation Home</span>
                                                            <input type="radio" name="radio" value="Vacation Home" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Townhouse</span>
                                                            <input type="radio" name="radio" value="Townhouse" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Triple-Decker</span>
                                                            <input type="radio" name="radio" value="Triple-Decker" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Vacation Home</span>
                                                            <input type="radio" name="radio" value="Vacation Home" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Working Farm</span>
                                                            <input type="radio" name="radio" value="Working Farm" hidden="hidden">
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <span>Educational Building</span>
                                                            <input type="radio" name="radio" value="Educational Building" hidden="hidden">
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_dropdown__fields btns-fields">
                        <div class="btn-wrap cta-btn-wrap">
                            <a href="#" class="btn btn-secondary btn-next cta-btn">
                                <span class="icon-holder"><span class="icon-wrap"><i class="icon ico-start-rate"></i></span></span>
                                {{btn}}
                            </a>
                        </div>
                    </div>
                    <span class="privacy-text" style="display: none">
                        <span class="privacy"><i class="privacy-icon ico-lock-2"></i>Privacy & Security Guaranteed</span>
                    </span>
                    <span class="additional-content-text">
                        <span class="text">Additional Content</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</script>
</body>
</html>
