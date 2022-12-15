<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/iconmoon.css">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-question-contact-info-content.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/pages/funnel-question-contact-info-content.js"></script></script>
    <script src="assets/external/input-mask/inputmask.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var source = document.querySelector("#preview-template").innerHTML;
            template = Handlebars.compile(raw_html);

            var json = {
                "question":"Enter your contact info",
                "btn":"Continue"
            }
            var html = template(json);
            $("body").html(html);
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    <div class="contact-info-questions-wrap">
        <div class="question_contact-info">
            <div class="row">
                <div class="col">
                    <div class="question_contact-info__title">
                        <h1>{{question}}</h1>
                    </div>
                    <div class="question_contact-info__fields">
                        <div class="step-holder">
                            <div class="form-group">
                                <div class="input-wrap">
                                    <input type="email" id="email_address" class="form-control validate-input" autocomplete="off" data-function-name="formValidation">
                                    <label for="email_address" class="input-label">Email Address</label>
                                    <span class="icon-valid"><span class="icon-check"></span></span>
                                    <span class="icon-invalid"><span class="icon-cross"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="question_contact-info__fields">
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
