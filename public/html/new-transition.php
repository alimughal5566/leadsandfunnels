<?php
include ("includes/head.php");
?>
    <!-- contain sidebar of the page -->
<?php
include ("includes/sidebar-menu.php");
include ("includes/inner-sidebar-menu.php");
?>
<div class="panel-aside">
    <div class="panel-aside__head">
        <h4 class="panel-aside__title">
            <i class="ico ico-link"></i>New Transition
        </h4>
    </div>
    <div class="panel-aside-wrap">
        <div class="panel-aside-holder">
            <div class="panel-aside__body">
        <div class="form-group">
            <div class="control-head">
                <label for="transition-name">Transition Name</label>
            </div>
            <div class="input-holder">
                <input id="transition-name" name="transition-name" class="form-control" value="Circle loader" type="text">
            </div>
        </div>
        <div class="form-group">
            <div class="control-head">
                <div class="col-left">
                    <label for="content">Content</label>
                </div>
                <div class="col-right">
                    <div class="toggle-arrow">
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="toggle-block">
                <div class="input-holder">
                    <div class="classic-editor__wrapper">
                    <textarea class="fb-froala__init">
                        You're in! Now share this to go VIP and get all the bonuses!
                    </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="control-head">
                <label for="basic-setting">Basic Settings</label>
            </div>
            <div class="input-holder">
                <div class="select2js__transition-duration-parent">
                    <select id="transition-duration" class="select2js__transition-duration form-control">
                        <option value="">Transition Duration: 5 seconds</option>
                        <option value="">Transition Duration: 10 seconds</option>
                        <option value="">Transition Duration: 15 seconds</option>
                        <option value="">Transition Duration: 20 seconds</option>
                    </select>
                </div>
            </div>
            <div class="loader">
                <ul class="loader__list">
                    <li class="loader__item">
                        <div class="loader__wrapper">
                            <div class="lds-facebook"><div></div><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="loader__item">
                        <div class="loader__wrapper">
                            <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="loader__item">
                        <div class="loader__wrapper active">
                            <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="loader__item">
                        <div class="loader__wrapper">
                            <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="loader__item">
                        <div class="loader__wrapper">
                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        </div>
                    </li>
                    <li class="loader__item">
                        <div class="loader__wrapper">
                            <div class="lds-dual-ring"></div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="control-head dropdowns position-transition">
                <div class="col-left">
                    <div class="select2js__positioning-parent">
                        <select id="positioning-select" class="select2js__positioning form-control">
                            <option value="">Positioning: Top</option>
                            <option value="" selected>Positioning: Bottom</option>
                        </select>
                    </div>
                </div>
                <div class="col-right">
                    <div class="select2js__size-parent">
                        <select id="size-select" class="select2js__size form-control">
                            <option value="">Size: 20%</option>
                            <option value="">Size: 30%</option>
                            <option value="">Size: 40%</option>
                            <option value="">Size: 50%</option>
                            <option value="">Size: 60%</option>
                            <option value="">Size: 70%</option>
                            <option value="" selected>Size: 80%</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
    <div class="panel-aside__footer">
                <div class="action">
                    <ul class="action__list justify-content-end">
                        <li class="action__item">
                            <button class="button button-cancel">Close</button>
                        </li>
                        <li class="action__item">
                            <button class="button button-secondary">Save</button>
                        </li>
                    </ul>
                </div>
            </div>
</div>
    <!-- contain the main content of the page -->
    <div id="content">
        <!-- header of the page -->
        <?php
        include ("includes/header.php");
        ?>
        <!-- contain main informative part of the site -->
        <!-- content of the page -->
        <main class="main">
            <section class="main-content">
                <div class="scaling-viewport">
                    <div class="transition-preview">
                    <span class="transition-preview__text">
                        You're in! Now share this to go VIP and get all the bonuses!
                    </span>
                        <div class="transition-preview__loader">
                            <div class="lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
<?php
include ("includes/footer.php");
?>