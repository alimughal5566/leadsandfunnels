<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/iconmoon.css">
    <link rel="stylesheet" href="../lp_assets/theme_admin3/css/funnel-question-cta-content.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/pages/funnel-question-cta-content.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var raw_html = $("#preview-template").html();
            var source = document.querySelector("#preview-template").innerHTML;
            template = Handlebars.compile(raw_html);

            var json = {
                "question":"You're in! Now share this to go VIP and get all the bonuses!",
                "desc":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam risus justo, rutrum nec lacinia insollicitudin a est. Maecenas sodales libero in eleifend sodales. Fusce convallis sed turpis. Phasellusnec dapibus sapien semper eget.",
                "btn":"Let's Finish"
            }
            var html = template(json);
            $("body").html(html);
        });
    </script>
</head>
<body>
<script id="preview-template" type="text/x-handlebars-template">
    <div class="cta-message-wrap">
        <div class="question_cta">
            <div class="row">
                <div class="col">
                    <div class="question_cta__title">
                        <h1>{{question}}</h1>
                        <div class="question_cta__text">
                            <p>{{desc}}</p>
                        </div>
                    </div>
                    <div class="question_cta__fields btns-fields">
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
                    <span class="additional-content-text" style="display: none">
                        <span class="text">Additional Content</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</script>
</body>
</html>
