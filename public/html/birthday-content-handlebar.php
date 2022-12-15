<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/iconmoon.css">
    <link rel="stylesheet" href="assets/external/custom-scrollbar/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-question-birthday-content.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/external/custom-scrollbar/jquery.mCustomScrollbar-new.js"></script>
    <script src="assets/pages/funnel-question-birthday-content.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var source = document.querySelector("#preview-template").innerHTML;
            template = Handlebars.compile(raw_html);

            var json = {
                "question":"Want to know EXACTLY how much San Diego home you can afford?",
                "desc":"Take the first step by getting pre-approved here for FREE. Enter your zip code below to get started in just 60 seconds or less!",
                "btn":"GO!"
            }
            var html = template(json);
            $("body").html(html);
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    <div class="zip-code-questions-wrap">
        <div class="question_zip-code">
            <div class="row">
                <div class="col">
                    <div class="question_zip-code__title">
                        <h1>{{question}}</h1>
                        <div class="question_zip-code__text">
                            <p>{{desc}}</p>
                        </div>
                    </div>
                    <div class="question_zip-code__fields zip-code">
                        <div class="step-holder">
                            <div class="form-group">
                                <div class="input-wrap">
                                    <input type="tel" id="zip_code" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">
                                    <label for="zip_code" class="input-label">Zip Code</label>
                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_zip-code__fields zip-code-wtih-city-code">
                        <div class="step-holder">
                            <div class="form-group">
                                <div class="input-wrap">
                                    <input type="tel" id="city_zip_code" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">
                                    <label for="city_zip_code" class="input-label">CITY OR ZIP CODE</label>
                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                    <div class="states-box scrollActive">
                                        <div class="scroll-bar">
                                            <div class="scroll-bar-wrap">
                                                <a href="#" class="states">99301, Pasco, WA</a>
                                                <a href="#" class="states">99302, Pasco, WA</a>
                                                <a href="#" class="states">99303, Pasco, WA</a>
                                                <a href="#" class="states">99304, Pasco, WA</a>
                                                <a href="#" class="states">99305, Pasco, WA</a>
                                                <a href="#" class="states">99306, Pasco, WA</a>
                                                <a href="#" class="states">99307, Pasco, WA</a>
                                                <a href="#" class="states">99308, Pasco, WA</a>
                                                <a href="#" class="states">99309, Pasco, WA</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_zip-code__fields">
                        <div class="form-group text-center btn-wrap cta-btn-wrap">
                            <a href="#" class="btn btn-secondary btn-next cta-btn">
                                <span class="icon-holder"><span class="icon-wrap"><i class="icon ico-start-rate"></i></span></span>
                                {{btn}}
                            </a>
                        </div>
                        <span class="privacy-text" style="display: none">
                            <span class="privacy"><i class="privacy-icon ico-lock-2"></i>Privacy & Security Guaranteed</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>
</body>
</html>
