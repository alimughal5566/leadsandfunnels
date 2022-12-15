<aside class="sidebar">
        <div class="menu-holder">
            <div class="menu-holder__logo">
            <a href="dashboard.php">
                <img src="assets/images/logo-micro-white.png" alt="leadpops" class="micro-logo">
                <img src="assets/images/logo-micro-white.png" alt="leadpops" class="large-logo">
            </a>
        </div>
            <div class="sidebar-inner-wrap">
                 <ul class="menu list-unstyled">
            <li class="menu__list active">
                <a href="#" class="menu__link <?php echo activeClass($page_name,''); ?>">
                    <span title="Launch Checklists" class="menu__link-icon ico-checklist"></span><span class="menu__link-text">Launch Checklists</span>
                </a>
            </li>
<!--            <li class="menu__list active">-->
<!--                <a href="#" class="menu__link">-->
<!--                    <span title="Dashboard" class="menu__link-icon ico-dashboard"></span><span class="menu__link-text">Dashboard</span>-->
<!--                </a>-->
<!--            </li>-->
            <li class="menu__list">
                <a href="#"  class="menu__link">
                    <span title="Quick Start" class="menu__link-icon ico-quick"></span><span class="menu__link-text">Quick Start</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="dashboard.php" class="menu__link  <?php echo activeClass($page_name,'dashboard.php'); ?>">
                    <span title="Lead Funnels" class="menu__link-icon ico-funnels-icon"></span><span class="menu__link-text">Lead Funnels</span>
                </a>
            </li>
            <li class="menu__list">
                <a data-toggle="modal" href="#emailfire" class="menu__link <?php echo activeClass($page_name,'email-fire.php'); ?>">
                    <span title="Email Fire" class="menu__link-icon ico-fire"></span><span class="menu__link-text">Email Fire</span>
                </a>
            </li>
            <li class="menu__list">
                <a href="#" class="menu__link">
                    <span title="My Website" class="menu__link-icon ico-landing"></span><span class="menu__link-text">My Website</span>
                </a>
            </li>
<!--            <li class="menu__list">-->
<!--                <a href="#" class="menu__link">-->
<!--                    <span title="Recent Webinars" class="menu__link-icon ico-webinars"></span><span class="menu__link-text">Recent Webinars</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="menu__list">-->
<!--                <a href="#" class="menu__link">-->
<!--                    <span title="Share the Love!" class="menu__link-icon ico-heart"></span><span class="menu__link-text">Share the Love!</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            <li class="menu__list">-->
<!--                <a href="#"  class="menu__link">-->
<!--                    <span title="Best Practises" class="menu__link-icon ico-light"></span><span class="menu__link-text">Best Practises</span>-->
<!--                </a>-->
<!--            </li>-->
            <li class="menu__list">
                <?php
                if($page_name != 'marketing-hub.php') {
                ?>
                <a href="marketing-hub.php" class="menu__link <?php echo activeClass($page_name,'marketing-hub.php'); ?>">
                    <span title="Marketing Hub" class="menu__link-icon ico-marketing-hub"></span><span class="menu__link-text">Marketing Hub</span>
                </a>
                <?php
                }
                ?>
                <?php
                if($page_name == 'marketing-hub.php') {
                    ?>
                    <a href="https://support.leadpops.com" target="_blank" class="menu__link <?php echo activeClass($page_name,'marketing-hub.php'); ?>">
                        <span title="Marketing Hub" class="menu__link-icon ico-marketing-hub"></span><span class="menu__link-text">Marketing Hub</span>
                    </a>
                    <?php
                }
                ?>
            </li>
            <li class="menu__list">
                <a href="#" class="menu__link">
                    <span title="Knowledge Base" class="menu__link-icon ico-knowledge"></span><span class="menu__link-text">Knowledge Base</span>
                </a>
            </li>
            <?php
                if($page_name == 'dashboard.php') {
                    ?>
                    <li class="menu__list collapse-item">
                        <a href="#" title="Collapse Menu" class="menu__link collapse-link">
                            <span class="menu__link-icon ico-right-chevron"></span>
                        </a>
                    </li>
                    <?php
                }
            ?>
        </ul>
            </div>
    </div>
</aside>