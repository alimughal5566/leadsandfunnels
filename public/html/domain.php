<?php
    include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
    <?php
        include ("includes/sidebar-menu.php");
        include ("includes/inner-sidebar-menu.php");
    ?>
    <!-- contain the main content of the page -->
        <div id="content">
            <!-- header of the page -->
            <?php
                include ("includes/header.php");
            ?>
            <!-- contain main informative part of the site -->
            <main class="main">
                <!-- content of the page -->
                <section class="main-content">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Domains / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Domain Names" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                            <span class="icon ico-video"></span> Watch how to video</a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <form id="subdomain" method="post" action="">
                        <div class="sub-domain">
                        <div id="msg"></div>
                        <div class="card domain-card">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="domain-radio">
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Domain type:</span> sub-domain</span>
                                    </label>
                                </div>
                            </div>
                            <div class="domain-slide">
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="left-col">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changesubdomainname()" id="checkboxsubdomainname" checked name="checkboxsubdomainname" value="csn">
                                                        <label class="domain-label" for="checkboxsubdomainname">
                                                            Change sub-domain name
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subdomainname">Sub-domain Name</label>
                                                        <div class="input__wrapper">
                                                            <input id="subdomainname" name="subdomainname" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="right-col">
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changetopleveldomain()" id="checkboxsubdomainnametop" name="checkboxsubdomainnametop"  value="csnt" />
                                                        <label class="domain-label" for="checkboxsubdomainnametop">
                                                            Change top level domain
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="subdomaintoplist">Top Level Domain</label>
                                                        <div class="input__wrapper">
                                                            <div class="select2top-lvl-domain-parent select2js__nice-scroll">

                                                                <select class="form-control select2top-lvl-domain" name="subdomaintoplist" id="subdomaintoplist" disabled="disabled" name="">
                                                                    <option value="itclix.com">itclix.com</option>
                                                                    <option value="clixonit.com">clixonit.com</option>
                                                                    <option value="clixonme.com">clixonme.com</option>
                                                                    <option value="clixonus.com">clixonus.com</option>
                                                                    <option value="clixonthis.com">clixonthis.com</option>
                                                                    <option value="clixthis.com">clixthis.com</option>
                                                                    <option value="ezclx.com">ezclx.com</option>
                                                                    <option value="clixwithus.com">clixwithus.com</option>
                                                                    <option value="secure-clix.com">secure-clix.com</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body__row">
                                        <div class="copy-url">
                                            <div class="input-holder input-holder_icon flex-grow-1">
                                                <span class="ico-lock"></span>
                                                <div id="url__text" class="form-control pl-5"></div>
                                            </div>
                                            <button id="clone-url" class="flex-grow-0 button button-primary">SAVE & COPY URL</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card domain-card">
                            <div class="card-header">
                                <div class="card-link-wrap">
                                    <label class="card-link">
                                        <input type="radio" name="domain-radio">
                                        <span class="card-circle"></span>
                                        <span class="h2 card-title"><span>Domain type:</span> domain</span>
                                    </label>
                                </div>
                            </div>
                            <div class="domain-slide">
                                <div class="card-body">
                                    <div class="card-body__row">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="left-col">
                                                    <p class="ip-address">leadPops IP Address 161.47.4.15</p>
                                                    <div class="checkbox">
                                                        <input type="checkbox" onclick="changedomainname()" id="checkboxdomainname" name="checkboxdomainname" value="cdn">
                                                        <label class="domain-label" for="checkboxdomainname">
                                                            Add your own domain name
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="domainname">Domain Name</label>
                                                        <div class="input__wrapper">
                                                            <input disabled="disabled" type="text" id="domainname"  name="domainname"  class="domain-textbox textbox-size" value=""/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="domain-grid">
                                                    <div class="domain-grid__list">
                                                        <span class="domain-name">
                                                            leadpops.com
                                                        </span>
                                                        <div class="action action_options">
                                                            <ul class="action__list">
                                                                <li class="action__item">
                                                                    <a href="#" class="action__link btn-editCode">
                                                                        <span class="ico ico-edit"></span>edit
                                                                    </a>
                                                                </li>
                                                                <li class="action__item">
                                                                    <a href="#" class="action__link btn-deleteCode">
                                                                        <span class="ico ico-cross"></span>delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                            <ul class="action__list">
                                                                <li class="action__item">
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                    <i class="fa fa-circle" aria-hidden="true"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="domain-grid__list">
                                                        <span class="domain-name">
                                                            netflix.eu
                                                        </span>
                                                        <div class="action action_options">
                                                                    <ul class="action__list">
                                                                        <li class="action__item">
                                                                            <a href="#" class="action__link btn-editCode">
                                                                                <span class="ico ico-edit"></span>edit
                                                                            </a>
                                                                        </li>
                                                                        <li class="action__item">
                                                                            <a href="#" class="action__link btn-deleteCode">
                                                                                <span class="ico ico-cross"></span>delete
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="action__list">
                                                                        <li class="action__item">
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                    </div>
                                                    <div class="domain-grid__list">
                                                        <span class="domain-name">
                                                            clixonit.com
                                                        </span>
                                                        <div class="action action_options">
                                                                    <ul class="action__list">
                                                                        <li class="action__item">
                                                                            <a href="#" class="action__link btn-editCode">
                                                                                <span class="ico ico-edit"></span>edit
                                                                            </a>
                                                                        </li>
                                                                        <li class="action__item">
                                                                            <a href="#" class="action__link btn-deleteCode">
                                                                                <span class="ico ico-cross"></span>delete
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="action__list">
                                                                        <li class="action__item">
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!-- footer of the page -->
                    <div class="footer">
                        <div class="row">
                            <img src="assets/images/footer-logo.png" alt="footer logo">
                        </div>
                    </div>
                </section>
            </main>

        </div>

<?php
    include ("includes/video-modal.php");
    include ("includes/footer.php");
?>