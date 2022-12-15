<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/iconmoon.css">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/text-field-content.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/pages/text-field-content.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var source = document.querySelector("#preview-template").innerHTML;
            template = Handlebars.compile(raw_html);

            var json = {
                "question":"Anything else we should consider in the advisor matching process?",
                "desc":"Feel free to answer “no” if you've already provided enough information.",
                "btn":"Next Question"
            }
            var html = template(json);
            $("body").html(html);
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    <div class="text-field-questions-wrap">
        <div class="question_answer">
            <div class="row">
                <div class="col">
                    <div class="question_answer__title">
                        <h1>{{question}}</h1>
                        <div class="question_answer__text">
                            <p>{{desc}}</p>
                        </div>
                    </div>
                    <div class="question_answer__fields">
                        <div class="step-holder">
                            <div class="form-group text-field">
                                <div class="input-wrap">
                                    <input type="text" id="your_answer" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">
                                    <label for="your_answer" class="input-label">your answer</label>
                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                </div>
                            </div>
                            <div class="form-group textarea-field">
                                <div class="input-wrap">
                                    <textarea name="your_notes" id="your_notes" class="form-control validate-input" autocomplete="off" data-function-name="formValidation"></textarea>
                                    <label for="your_notes" class="input-label">your note</label>
                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_answer__fields btns-fields">
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
