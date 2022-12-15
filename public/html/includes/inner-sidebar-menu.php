<?php
$page_name = str_replace('/','',$_SERVER['PHP_SELF']);
list($name,$content) = explode('|',$page_arr[$page_name]);
//echo $page_name;
//echo '<pre>'; print_r($_SERVER);
?>
<aside class="sidebar-inner">
    <div class="sidebar-inner-holder">
        <div class="menu-holder">
            <div class="menu-holder__head">
                <span class="menu-holder__head__tooltip el-tooltip" title="<p class='global-tooltip font-small text-uppercase'>Expand menu</p>"></span>
                <h6><?php echo $content; ?>:<span><?php echo $name;  ?></span></h6>
            </div>
            <div class="sidebar-inner-menu-wrap">
                <ul class="menu list-unstyled">
                    <li class="menu__list active">
                        <a href="dashboard.php" title="Home" class="menu__link">
                            <span class="menu__link-icon ico-home"></span><span class="menu__link-text">Home</span>
                        </a>
                    </li>
                    <li class="menu__list">
                        <a href="#" class="menu__link">
                            <span class="menu__link-icon ico-view"></span><span class="menu__link-text">View</span>
                        </a>
                    </li>
                    <li class="menu__list menu__list_sub-menu">
                        <a href="#" title="Edit" class="menu__link">
                            <span class="menu__link-icon ico-edit"></span><span class="menu__link-text">Edit</span>
                        </a>
                        <div class="menu__dropdown-wrapper">
                            <div class="menu__dropdown">
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">content</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="auto-responder-basic.php" class="menu__dropdown-link" title="Autoresponder">Autoresponder</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="cta-messaging.php" class="menu__dropdown-link" title="Call-to-Action">Call-to-Action</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="contact-info.php" class="menu__dropdown-link" title="Contact Info">Contact Info</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="footer-basic.php" class="menu__dropdown-link" title="Footer">Footer</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="thank-you.php" class="menu__dropdown-link" title="Thank You Page">Thank You Page</a>
                                        </li>
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Questions</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">design</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="background.php" class="menu__dropdown-link" title="Background">Background</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="featured-image.php" class="menu__dropdown-link" title="Featured Image">Featured Image</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="logo.php" class="menu__dropdown-link" title="Logo">Logo</a>
                                        </li>
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Buttons</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Header</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Progress Bar</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Text</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Themes</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="menu__dropdown-col">
                                    <h3 class="menu__dropdown-head">settings</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="integrations-ada.php" class="menu__dropdown-link" title="Integrations">ADA Accessibility</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="integrations-funnel.php" class="menu__dropdown-link" title="Integrations">Integrations</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="lead-alert.php" class="menu__dropdown-link" title="Lead Alerts">Lead Alerts</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="pixels.php" class="menu__dropdown-link" title="Pixels">Pixels</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link" title="Status">Status</a>
                                        </li>
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">A/B Testing</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Favicon</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Partial Leads</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#umt-parameters" data-toggle="modal" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">UTM Parameters</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="menu__dropdown-col menu__dropdown-col_110">
                                    <h3 class="menu__dropdown-head">basic info</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="domain.php" class="menu__dropdown-link" title="Domains">Domains</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="name-tags.php" class="menu__dropdown-link" title="Name & Tags">Name & Tags</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="funnel-seo.php" class="menu__dropdown-link" title="SEO">SEO</a>
                                        </li>
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">leadPops Branding</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="menu__list menu__list_sub-menu">
                        <a href="#" title="Promote" class="menu__link">
                            <span class="menu__link-icon ico-promote"></span><span class="menu__link-text">Promote</span>
                        </a>
                        <div class="menu__dropdown-wrapper">
                            <div class="menu__dropdown">
                                <div class="menu__dropdown-col menu__dropdown-col_250">
                                    <h3 class="menu__dropdown-head">Promote</h3>
                                    <ul class="menu__dropdown-list">
                                        <li class="menu__dropdown-item">
                                            <a href="funnel-share.php" class="menu__dropdown-link" title="Share Your Funnel">Share Funnel</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="sticky-bar.php" class="menu__dropdown-link" title="Sticky Bar">Sticky Bar Builder</a>
                                        </li>
                                    </ul>
                                    <ul class="menu__dropdown-list coming-soon">
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Embed in a Web Page</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Open in Lightbox</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Open in Popup</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Place it in iFrame</a>
                                        </li>
                                        <li class="menu__dropdown-item">
                                            <a href="#" class="menu__dropdown-link disabled el-tooltip" title="COMING SOON!">Platforms</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="menu__list">
                        <a href="stats.php" title="Stats" class="menu__link <?php echo activeClass($page_name,'stats.php'); ?>">
                            <span class="menu__link-icon ico-stats"></span><span class="menu__link-text">Stats</span>
                        </a>
                    </li>
                    <li class="menu__list">
                        <a href="my-leads.php" title="Leads" class="menu__link <?php echo activeClass($page_name,'my-leads.php'); ?>">
                            <span class="menu__link-icon ico-multi-user"></span><span class="menu__link-text">Leads</span>
                        </a>
                    </li>
                    <li class="menu__list">
                        <a href="#" title="Clone" class="menu__link">
                            <span class="menu__link-icon ico-copy"></span><span class="menu__link-text">Clone</span>
                        </a>
                    </li>
        <!--            <li class="menu__list">-->
        <!--                <a href="#" title="Status" class="menu__link">-->
        <!--                    <span class="menu__link-icon ico-info"></span><span class="menu__link-text">Status</span>-->
        <!--                </a>-->
        <!--            </li>-->
                </ul>
            </div>
        </div>
    </div>
</aside>
