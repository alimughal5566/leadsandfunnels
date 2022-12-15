<?php
include ("includes/head.php");
?>
<!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
?>
<!-- contain the main content of the page -->
<div id="content" class="w-100">
    <!-- header of the page -->
    <?php
    include ("includes/header.php");
    ?>
    <!-- contain main informative part of the site -->
    <main class="main">
        <div class="main-content">

            <!-- page messages-->
            <!-- Title wrap of the page -->
            <div class="main-content__head">
                <div class="col-left">
                    <ul class="list-inline m-0 d-flex align-items-center">
                        <li class="list-inline-item">
                            <h1 class="title">leadPops Support</h1>
                        </li>
                    </ul>
                </div>
                <div class="col-right">
                    <a data-target="#lp-video-modal50" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Support">
                        <span class="icon ico-video"></span>
                        <span class="action-title">Watch how to video</span>
                    </a>
                </div>
            </div>
            <!-- support content of the page -->
            <div class="support-content-area">
                <!-- support block area -->
                <div class="support-block-area">
                    <div class="row">
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Contact Info</h2>
                                </div>
                                <div class="support-block-area__map">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d498.3826894594638!2d-117.22970727497747!3d32.826561027633325!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3680f9671aeb2612!2sleadPops%2C%20Inc!5e0!3m2!1sen!2sus!4v1601371660553!5m2!1sen!2sus"></iframe>
                                </div>
                                <div class="support-block-area__info">
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="contact-info list-unstyled">
                                                <li>
                                                    <a class="link-wrap" href="mailto:&#115;&#117;&#112;&#112;&#111;&#114;&#116;&#064;&#108;&#101;&#097;&#100;&#080;&#111;&#112;&#115;&#046;&#099;&#111;&#109;">
                                                        <span class="icon">
                                                            <i class="ico-smart-mail"></i>
                                                        </span>
                                                        <span class="text">&#115;&#117;&#112;&#112;&#111;&#114;&#116;&#064;&#108;&#101;&#097;&#100;&#080;&#111;&#112;&#115;&#046;&#099;&#111;&#109;</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="link-wrap" href="tel:8555323767">
                                                        <span class="icon">
                                                            <i class="ico-Mobile"></i>
                                                        </span>
                                                        <span class="text">855.leadPops (855.532.3767)</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="contact-info list-unstyled">
                                                <li>
                                                    <div class="link-wrap">
                                                        <span class="icon">
                                                            <i class="ico-building"></i>
                                                        </span>
                                                        <address class="text">
                                                            leadPops, Inc.<br>
                                                            2665 Ariane Dr #201<br>
                                                            San Diego, CA 92117
                                                        </address>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <ul class="support-chat-list list-unstyled">
                                    <li><a href="https://myleads.leadpops.com/lp/popadmin/hub" class="button button-primary"><i class="ico-marketing-hub"></i>Marketing Hub</a></li>
                                    <li><a href="https://support.leadpops.com/" target="_blank" class="button button-primary"><i class="ico-knowledge"></i>Knowledge Base</a></li>
                                    <li><a target="_blank" href="https://leadpops.com/consult" class="button button-primary">Schedule An Appointment</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <form id="lp-support-form" name="lp-support-form" action="" method="get">
                                <div class="support-block-area__block">
                                    <div class="support-block-area__head">
                                        <h2>Submit a Support Request</h2>
                                    </div>
                                    <div class="subject-select-wrap">
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Category</strong>
                                            <div class="subject-select-parent subject-select-parent01 select2js__nice-scroll">
                                                <select id="maintopic" name="maintopic" class="subject-select01">
                                                    <option value="">Category</option>
                                                    <option>Funnels</option>
                                                    <option>Websites</option>
                                                    <option>PagePops</option>
                                                    <option>Email Fire</option>
                                                    <option>Marketing</option>
                                                    <option>Billing</option>
                                                    <option>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Topic</strong>
                                            <div class="subject-select-parent subject-select-parent02 select2js__nice-scroll">
                                                <select id="mainissue" name="mainissue" class="subject-select02" disabled>
                                                    <option value="">Select Topic</option>
                                                    <option>Select Topic1</option>
                                                    <option>Select Topic2</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="subject-select-wrap field">
                                        <div class="subject-select-area">
                                            <strong class="subject-select-area__title">Subject</strong>
                                            <div class="field-wrap">
                                                <input name="subject" id="subject" type="text" class="form-control" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="textarea-field">
                                        <textarea name="message" id="message" placeholder="" class="form-control"></textarea>
                                    </div>
                                    <span class="btn-wrap">
                                        <button class="button button-secondary" type="submit">submit</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- support video section -->
                <div class="support-video-section">
                    <div class="support-video-section__wrap">
                        <div class="support-video-section__head">
                            <h2>How To Videos</h2>
                        </div>
                        <div class="video-accordion-area">
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                            <span>
                                                Funnels Homepage
                                            </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#funnel-homepage"><span></span></div>
                                    </div>
                                </div>
                                <div id="funnel-homepage" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal11" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="kno9puyv5s" data-lp-wistia-title="Funnels Homepage">
                                                            <img src="assets/images/video-thumb.png" title="Funnels Homepage" alt="Funnels Homepage">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">The Home Page</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                             </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Edit > Content
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#edit-content"><span></span></div>
                                    </div>
                                </div>
                                <div id="edit-content" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal19" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="epni9wlwah" data-lp-wistia-title="Contact">
                                                            <img src="assets/images/video-thumb.png" title="Contact Info" alt="Contact Info">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Contact</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Edit > Design
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#edit-design"><span></span></div>
                                    </div>
                                </div>
                                <div id="edit-design" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal60" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Contact Info" alt="Contact Info">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Design</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Edit > Domains
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#edit-domains"><span></span></div>
                                    </div>
                                </div>
                                <div id="edit-domains" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal61" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Contact Info" alt="Contact Info">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Domains</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Edit > Settings
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#edit-settings"><span></span></div>
                                    </div>
                                </div>
                                <div id="edit-settings" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal64" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Contact Info" alt="Contact Info">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Settings</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Edit > Basic Info
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#edit-info"><span></span></div>
                                    </div>
                                </div>
                                <div id="edit-info" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal63" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Contact Info" alt="Contact Info">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Basic Info</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Lead Alerts
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#alert"><span></span></div>
                                    </div>
                                </div>
                                <div id="alert" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal12" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="ukxb3c6k74" data-lp-wistia-title="Lead Alerts">
                                                            <img src="assets/images/video-thumb.png" title="Lead Alerts" alt="Lead Alerts">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Lead Alerts</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Promote > Share My Funnel
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#promote"><span></span></div>
                                    </div>
                                </div>
                                <div id="promote" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal22" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Lead Alerts" alt="Lead Alerts">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Share My Funnel</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Promote > Sticky Bars
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#sticky-bar"><span></span></div>
                                    </div>
                                </div>
                                <div id="sticky-bar" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal23" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Lead Alerts" alt="Lead Alerts">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Sticky Bars</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Stats
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#stats"><span></span></div>
                                    </div>
                                </div>
                                <div id="stats" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal13" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="d3fj9pnvmv" data-lp-wistia-title="Stats">
                                                            <img src="assets/images/video-thumb.png" title="Stats" alt="Stats">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Stats</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Leads
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#lead"><span></span></div>
                                    </div>
                                </div>
                                <div id="lead" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal14" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="31uskalsne" data-lp-wistia-title="My Leads">
                                                            <img src="assets/images/video-thumb.png" title="My Leads" alt="My Leads">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Leads</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel">
                                <div class="card-header">
                                    <div class="lp-panel__head">
                                        <strong class="card-title">
                                        <span>
                                            Clone
                                        </span>
                                        </strong>
                                        <div class="card-link collapsed expandable" data-toggle="collapse" href="#clone"><span></span></div>
                                    </div>
                                </div>
                                <div id="clone" class="collapse">
                                    <div class="card-body">
                                        <div class="support-video-row">
                                            <div class="support-video-row__col">
                                                <div class="support-video-row__block">
                                                    <div class="video-wrap">
                                                        <a data-target="#lp-video-modal51" data-toggle="modal" href="#" class="video-link lp-wistia-video" data-lp-wistia-key="g050iwwq0w" data-lp-wistia-title="Domain Names">
                                                            <img src="assets/images/video-thumb.png" title="Mobile" alt="Mobile">
                                                        </a>
                                                    </div>
                                                    <strong class="support-video-row__name">Clone</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- support block area -->
                <div class="support-block-area mb-0">
                    <div class="row">
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Social Media</h2>
                                </div>
                                <div class="support-block-area__text">
                                    <p>Connect with the leadPops community on social media using the links below. We look forward to getting to know you!</p>
                                </div>
                                <ul class="social-networks list-unstyled">
                                    <li>
                                        <a target="_blank" href="https://www.facebook.com/leadpops" class="facebook"><i class="icon ico-facebook"></i> facebook</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://twitter.com/leadpops" class="twitter"><i class="icon ico-twitter"></i> twitter</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://www.linkedin.com/company/leadpops-llc" class="linkedin"><i class="icon ico-linkedin"></i> linkedin</a>
                                    </li>
                                    <li>
                                        <a target="_blank" href="https://www.youtube.com/c/leadpopsinc" class="youtube"><i class="icon ico-youtube"></i> youtube</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="support-block-area__block">
                                <div class="support-block-area__head">
                                    <h2>Deactivate Account</h2>
                                </div>
                                <div class="support-block-area__text">
                                    <p>Not getting the results you're looking for from Funnels? Be sure to <a target="_blank" href="https://leadpops.com/consult">schedule a FREE 1:1 call</a> with one of our Marketing Coaches. We can help turbocharge your marketing and referral generation efforts.</p>
                                    <p>Otherwise, you can request to cancel your account by clicking the button below.</p>
                                </div>
                                <span class="cancel-btn-wrap">
                                    <a href="#" class="button button-cancel">Request Cancellation</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer of the page -->
            <div class="footer">
                <div class="row">
                    <img src="assets/images/footer-logo.png" alt="footer logo">
                </div>
            </div>
        </div>
    </main>
</div>

<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>

