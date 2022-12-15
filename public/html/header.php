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
        <!-- content of the page -->
        <main class="main">
            <section class="main-content header-page">
                <!-- Title wrap of the page -->
                <form id="header-page" method="post" action="">
                    <input type="hidden" id="hp_color_opacity" name="hp_color_opacity" value="39">
                    <input type="hidden" id="hp-modeowncolor-hex" name="hp-modeowncolor-hex" value="#7888ff">
                    <input type="hidden" id="hp-modeowncolor-rgb" name="hp-modeowncolor-rgb" value="120, 136, 255">
                    <div class="main-content__head main-content__head_tabs">
                        <div class="col-left">
                            <h1 class="title">
                                Header / Funnel: <span class="funnel-name el-tooltip">203K Hybrid Loans</span>
                            </h1>
                            <div class="disabled-wrapper el-tooltip" title="This feature is coming soon!">
                                <input checked  id="header-page" name="header-page"
                                        data-thelink="header-page_active" data-toggle="toggle"
                                        data-onstyle="active" data-offstyle="inactive"
                                        data-width="127" data-height="43" data-on="INACTIVE"
                                        data-off="ACTIVE" type="checkbox">
                            </div>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Header" data-lp-wistia-key="g050iwwq0w" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                            <div class="tab__wrapper">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tblogo" data-toggle="pill" href="#tbLogo">Logo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tbcontactinfo" data-toggle="pill" href="#tbContactInfo">Contact Info</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-panel_tabs">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Header Preview
                                </h2>
                            </div>
                            <div class="col-right">
                                <ul class="nav nav__tab" role="tablist">
                                    <li class="nav-item logo-size-item">
                                        <div class="hp-logo-size">
                                            <div class="hp-logo-size__label">
                                                Logo Size
                                                <span class="question-mark el-tooltip" title='<div
                                                class="mobile-button-tooltip"><p>Adjust the logo size.</p></div>'>
                                                    <span class="ico ico-question"></span>
                                                </span>
                                            </div>
                                            <div class="range-slider">
                                                <div class="input__wrapper">
                                                    <input id="" class="form-control logo-size-slider" data-slider-id='logo-size-slider'
                                                           type="text"/>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <div class="col-clr nav-link m-0">
                                            <label>Background</label>
                                            <div id="clr_bg_header" class="last-selected">
                                                <div class="color-picker" style="background-color: #ffffff"></div>
                                            </div>
                                            <!-- Main header background color picker -->
                                            <div class="color-box__panel-wrapper main-bgheader-clr">

                                                <div class="color-box__panel-dropdown">
                                                    <select class="color-picker-options">
                                                        <option value="1">Color Selection:  Pick My Own</option>
                                                        <option value="2">Color Selection:  Pull from Logo</option>
                                                    </select>
                                                </div>
                                                <div class="color-picker-block">
                                                    <div class="picker-block" id="main-bgheader-colorpicker">
                                                    </div>
                                                    <label class="color-box__label">Add custom color code</label>
                                                    <div class="color-box__panel-rgb-wrapper">
                                                        <div class="color-box__r">
                                                            R: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                        <div class="color-box__g">
                                                            G: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                        <div class="color-box__b">
                                                            B: <input class="color-box__rgb" value="255"/>
                                                        </div>
                                                    </div>
                                                    <div class="color-box__panel-hex-wrapper">
                                                        <label class="color-box__hex-label">Hex code:</label>
                                                        <input class="color-box__hex-block" value="#ffffff" />
                                                    </div>
                                                </div>
                                                <div class="color-pull-block">
                                                    <label class="color-box__label">Pulled colors</label>
                                                    <ul class="color-box__list">
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item red"></li>
                                                        <li class="color-box__item green"></li>
                                                        <li class="color-box__item black"></li>
                                                        <li class="color-box__item blue"></li>
                                                        <li class="color-box__item orange"></li>
                                                        <li class="color-box__item yellow"></li>
                                                        <li class="color-box__item parrot"></li>
                                                    </ul>
                                                </div>
                                                <div class="color-box__panel-pre-wrapper">
                                                    <label class="color-box__label">Previously used colors</label>
                                                    <ul class="color-box__list">
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                        <li class="color-box__item"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tbcomputer" data-toggle="pill" href="#computer">
                                            <span class="ico ico-devices el-tooltip" title="Computer & Tablet"></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tbmobile" data-toggle="pill" href="#mobile">
                                            <span class="ico ico-Mobile el-tooltip" title="Mobile"></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="lp-panel__body">
                            <div class="tab-content">
                                <div id="computer" class="tab-pane fade in show active">
                                    <div class="drop-hplogo" class="hp__wrapper">
                                        <div class="hp-step1">
                                            <div class="hp-area">
                                                <p class="hp-area__placeholder">
                                                    Click and drag the logo of your choice from below into this box.
                                                </p>
                                                <div class="hp-area__head-bg"></div>
                                            </div>
                                        </div>
                                        <div class="hp-step2">
                                            <div class="hp-area">
                                                <div class="hp-area__head">
                                                    <div class="hp__logo">
                                                        <img src="" alt="">
                                                        <div class="alt-logo">
                                                            <span class="info__name"></span>
                                                        </div>
                                                    </div>
                                                    <div class="hp__cta">
                                                        <div class="info__wrapper">
                                                            <div class="info__upper">
                                                                <span class="info__name"></span>
                                                            </div>
                                                            <div class="info__lower">
                                                                <span class="info__cta"></span>
                                                                <span class="info__cellnumber"></span>
                                                            </div>
                                                            <div class="info__lower">
                                                                <span class="info__email"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="hp-area__head-bg"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="mobile" class="tab-pane fade">
                                    <div class="drop-hplogo" class="hp__wrapper">
                                        <div class="hp-step1">
                                            <div class="d-flex">
                                                <div class="hp-area">
                                                    <p class="hp-area__placeholder">
                                                        Your header is currently empty.
                                                    </p>
                                                    <div class="hp-area__head-bg"></div>
                                                </div>
                                            </div>
                                            <div class="hp-message">
                                                <p>
                                                    Click and drag the logo of your choice from below into this box.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="hp-step2">
                                            <div class="d-flex">
                                                <div class="hp-area">
                                                    <div class="hp-area__head">
                                                        <div class="hp__logo">
                                                            <img src="" alt="">
                                                        </div>
                                                        <div class="hp__cta">
                                                            <div class="info__wrapper">
                                                                <a class="cta-button" id="callnow" href="#">
                                                                    <i class="ico ico-phone"></i><span>Call Now!</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="hp-area__head-bg"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div id="tbLogo" class="tab-pane active">
                            <div class="row">
                                <div class="col mb-1">
                                    <div class="lp-panel lp-panel_tabs mb-4">
                                        <div class="lp-panel__head" id="logos-head">
                                            <div class="col-left">
                                                <ul class="nav nav__tab">
                                                    <li class="nav-item pl-0">
                                                        <span class="nav-link">
                                                            <h2 class="lp-panel__title">
                                                                Upload Logos
                                                            </h2>
                                                        </span>
                                                    </li>
                                                    <li class="nav-item">
                                                        <span class="nav-link">
                                                            <div class="checkbox mt-2">
                                                                <input type="checkbox" id="logocenter" name="logocenter" value="">
                                                                <label class="normal-font" for="logocenter">
                                                                    Center logo in header if there is no active Contact Info
                                                                </label>
                                                            </div>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-right">
                                                <div class="action">
                                                    <ul class="action__list">
                                                        <li class="action__item">
                                                            <div class="lp-image__browse d-flex align-items-center">
                                                                <div class="dropzone-btn-wrap">
                                                                    <div class="dropzone needsclick dropzon__logo-image"
                                                                         id="logo-image">
                                                                        <div class="dz-message needsclick button
                                                                        button-primary">
                                                                            <span class="text-uppercase">Browse</span>
                                                                        </div>
                                                                    </div>
                                                                    <span class="btn-tootltip el-tooltip"
                                                                          title='<div
                                                                          class="mobile-button-tooltip"><p>The max
                                                                          number of logos you <br >can upload is 3.
                                                                          Delete 1 or <br >more logos to add another.
                                                                          </p></div>'></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="file__control">
                                                    <p class="file__extension" style="display: none;">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                    <p class="file__size" style="display: none;">Maximum file size limit is 4MB.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="lp-panel__body">
                                            <div class="upload-logo__wrapper">
                                                <div class="upload-step">
                                                    <div class="logos-preview" id="logos-append">
                                                    </div>
                                                </div>
                                                <div class="nologo-step">
                                                    <div class="no-logos">
                                                        <div class="no-logos-wrap">
                                                            <span class="img">
                                                                <i class="icon ico-image"></i>
                                                            </span>
                                                            <p>You havent uploaded any logos yet.</p>
                                                            <a href="#" class="button button-primary
                                                            btn-dropzone">upload a logo</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="lp-panel__head border-0 p-0 mt-0">
                                                <div class="col-left">
                                                    <h2 class="card-title">
                                                        <span>
                                                            Co-Marketing Logo Combinator
                                                        </span>
                                                    </h2>
                                                </div>
                                                <div class="col-right">
                                                    <div class="card-link expandable collapsed" data-toggle="collapse" href="#combinator"></div>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="combinator" class="collapse" >
                                            <div class="card-body">
                                                <div class="card-body__row border-0">
                                                    <div class="comb__wrapper">
                                                        <div class="comb__col">
                                                            <div class="file__control mw-100">
                                                                <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                <p class="file__size">Maximum file size limit is 4MB.</p>
                                                            </div>
                                                            <div class="upload-drag__wrapper">
                                                                <div class="upload-drag__step1">
                                                                    <div class="upload-drag-browse__wrapper">
                                                                        <div class="upload-drag-browse__img">
                                                                            <i class="icon ico-image"></i>
                                                                        </div>
                                                                        <div class="upload-drag-browse__desc">
                                                                            <p>
                                                                                Drag and drop files here to upload. <br>
                                                                                Or <span>browse files</span> from your computer.
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hp-progress-area">
                                                                    <span class="file-name">new file</span>
                                                                    <div class="progress-bar">
                                                                        <div class="progress" style=" width: 0;"></div>
                                                                    </div>
                                                                    <span class="progress-val">0%</span>
                                                                </div>
                                                                <div class="upload-drag__step2">
                                                                    <img class="pre-image" src="" alt="">
                                                                </div>
                                                                <input id="comb1" class="upload-drag__file" type="file">
                                                            </div>
                                                        </div>
                                                        <div class="comb__col">
                                                            <div class="file__control mw-100">
                                                                <p class="file__extension">Invalid image format. Image format must be PNG, JPG, or JPEG.</p>
                                                                <p class="file__size">Maximum file size limit is 4MB.</p>
                                                            </div>
                                                            <div class="upload-drag__wrapper">
                                                                <div class="upload-drag__step1">
                                                                    <div class="upload-drag-browse__wrapper">
                                                                        <div class="upload-drag-browse__img">
                                                                            <i class="icon ico-image"></i>
                                                                        </div>
                                                                        <div class="upload-drag-browse__desc">
                                                                            <p>
                                                                                Drag and drop files here to upload. <br>
                                                                                Or <span>browse files</span> from your computer.
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hp-progress-area">
                                                                    <span class="file-name">new file</span>
                                                                    <div class="progress-bar">
                                                                        <div class="progress" style=" width: 0;"></div>
                                                                    </div>
                                                                    <span class="progress-val">0%</span>
                                                                </div>
                                                                <div class="upload-drag__step2">
                                                                    <img class="post-image" src="" alt="">
                                                                </div>
                                                                <input id="comb2" class="upload-drag__file" type="file">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="sliders__wrapper">
                                                    <div class="comb__wrapper">
                                                        <div class="comb__col">
                                                            <div class="slider__wrapper">
                                                                <input id="combex1" data-slider-id='ex1Slider' data-slider-min='' data-slider-max='' type="text"/>
                                                            </div>
                                                        </div>
                                                        <div class="comb__col">
                                                            <div class="slider__wrapper">
                                                                <input id="combex2" data-slider-id='ex1Slider' type="text"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body__row">
                                                    <div class="button-control mt-4">
                                                        <button type="button" id="combinelogo" class="button
                                                        button-primary" disabled>combine</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="tbContactInfo" class="tab-pane lp-panel_cta-info-wrap">
                            <div class="lp-panel lp-panel_cta-info">
                                <div class="panel-hp__wrapper">
                                    <div class="panel-hp__col-left">
                                        <h2 class="lp-panel__title lp-panel__title_size18">
                                            Company Name
                                        </h2>
                                    </div>
                                    <div class="panel-hp__col-center">
                                        <div class="panel-hp__setting hide">
                                            <div class="setting-col-left">
                                                <div class="input__wrapper company-as-logo">
                                                    <input id="company-name" name="company-name" class="form-control"
                                                           type="text" placeholder="Enter Company Name">
                                                    <span class="el-tooltip" title="Use Company Name as a logo">
                                                        <input  id="comanyname_as_logo" name="comanyname_as_logo" data-toggle="toggle"
                                                            data-onstyle="active" data-offstyle="inactive"
                                                            data-width="71" data-height="30" data-on=" "
                                                            data-off=" " type="checkbox">
                                                    </span>
                                                </div>
                                                <div class="font-type">
                                                <label for="">Font</label>
                                                <div class="select2__parent-company-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="" id="companyfonttype">
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="setting-col-right">
                                                <div class="font-size">
                                                    <div class="select2__parent-company-font-size
                                                    select2js__nice-scroll select2-parent">
                                                        <select class="form-control" name="" id="companyfontsize">
                                                            <option value="10">10 px</option>
                                                            <option value="11">11 px</option>
                                                            <option value="12">12 px</option>
                                                            <option value="13">13 px</option>
                                                            <option value="14">14 px</option>
                                                            <option value="15">15 px</option>
                                                            <option value="16">16 px</option>
                                                            <option value="17">17 px</option>
                                                            <option value="18">18 px</option>
                                                            <option value="19">19 px</option>
                                                            <option value="20">20 px</option>
                                                            <option value="21">21 px</option>
                                                            <option value="22">22 px</option>
                                                            <option value="23">23 px</option>
                                                            <option value="24" selected="selected">24 px</option>
                                                            <option value="25">25 px</option>
                                                            <option value="26">26 px</option>
                                                            <option value="27">27 px</option>
                                                            <option value="28">28 px</option>
                                                            <option value="29">29 px</option>
                                                            <option value="30">30 px</option>
                                                            <option value="31">31 px</option>
                                                            <option value="32">32 px</option>
                                                            <option value="33">33 px</option>
                                                            <option value="34">34 px</option>
                                                            <option value="35">35 px</option>
                                                            <option value="36">36 px</option>
                                                            <option value="37">37 px</option>
                                                            <option value="38">38 px</option>
                                                            <option value="39">39 px</option>
                                                            <option value="40">40 px</option>
                                                            <option value="41">41 px</option>
                                                            <option value="42">42 px</option>
                                                            <option value="43">43 px</option>
                                                            <option value="44">44 px</option>
                                                            <option value="45">45 px</option>
                                                            <option value="46">46 px</option>
                                                            <option value="47">47 px</option>
                                                            <option value="48">48 px</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="font-bold">
                                                    <button type="button" class="form-control txt-company-bold">
                                                        <i class="ico ico-alphabet-b"></i>
                                                    </button>
                                                </div>
                                                <div class="font-italic">
                                                    <button type="button" class="form-control txt-company-italic">
                                                        <i class="ico ico-alphabet-i"></i>
                                                    </button>
                                                </div>
                                                <div class="col-clr">
                                                <div id="clr_company_txt" class="last-selected">
                                                    <div class="last-selected__box" style="background: #0f101a"></div>
                                                    <div class="last-selected__code">#0f101a</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-hp__col-right">
                                        <input class="info-check-field"  id="comanyname" name="comanyname" data-toggle="toggle"
                                                data-onstyle="active" data-offstyle="inactive"
                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel lp-panel_cta-info lp-panel_marg">
                                <div class="panel-hp__wrapper">
                                    <div class="panel-hp__col-left">
                                        <h2 class="lp-panel__title lp-panel__title_size18 ">
                                            Phone Number CTA
                                        </h2>
                                    </div>
                                    <div class="panel-hp__col-center">
                                        <div class="panel-hp__setting hide">
                                            <div class="setting-col-left">
                                                <div class="input__wrapper">
                                                <input id="cta-phone-number" placeholder="Enter CTA Message" name="cta-phone-number" value=""                                                        class="form-control" type="text">
                                            </div>
                                                <div class="font-type">
                                                <label for="">Font</label>
                                                <div class="select2__parent-cta-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="" id="ctafonttype">
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="setting-col-right">
                                                <div class="font-size">
                                                    <div class="select2__parent-cta-font-size select2js__nice-scroll select2-parent">
                                                        <select class="form-control" name="" id="ctafontsize">
                                                            <option value="10">10 px</option>
                                                            <option value="11">11 px</option>
                                                            <option value="12">12 px</option>
                                                            <option value="13">13 px</option>
                                                            <option value="14">14 px</option>
                                                            <option value="15">15 px</option>
                                                            <option value="16">16 px</option>
                                                            <option value="17">17 px</option>
                                                            <option value="18">18 px</option>
                                                            <option value="19">19 px</option>
                                                            <option value="20">20 px</option>
                                                            <option value="21">21 px</option>
                                                            <option value="22">22 px</option>
                                                            <option value="23">23 px</option>
                                                            <option value="24" selected="selected">24 px</option>
                                                            <option value="25">25 px</option>
                                                            <option value="26">26 px</option>
                                                            <option value="27">27 px</option>
                                                            <option value="28">28 px</option>
                                                            <option value="29">29 px</option>
                                                            <option value="30">30 px</option>
                                                            <option value="31">31 px</option>
                                                            <option value="32">32 px</option>
                                                            <option value="33">33 px</option>
                                                            <option value="34">34 px</option>
                                                            <option value="35">35 px</option>
                                                            <option value="36">36 px</option>
                                                            <option value="37">37 px</option>
                                                            <option value="38">38 px</option>
                                                            <option value="39">39 px</option>
                                                            <option value="40">40 px</option>
                                                            <option value="41">41 px</option>
                                                            <option value="42">42 px</option>
                                                            <option value="43">43 px</option>
                                                            <option value="44">44 px</option>
                                                            <option value="45">45 px</option>
                                                            <option value="46">46 px</option>
                                                            <option value="47">47 px</option>
                                                            <option value="48">48 px</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="font-bold">
                                                    <button type="button" class="form-control txt-cta-bold">
                                                        <i class="ico ico-alphabet-b"></i>
                                                    </button>
                                                </div>
                                                <div class="font-italic">
                                                    <button type="button" class="form-control txt-cta-italic">
                                                        <i class="ico ico-alphabet-i"></i>
                                                    </button>
                                                </div>
                                                <div class="col-clr">
                                                <div id="clr_cta_txt" class="last-selected">
                                                    <div class="last-selected__box" style="background: #6e7c81"></div>
                                                    <div class="last-selected__code">#6e7c81</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-hp__col-right">
                                        <input class="info-check-field" id="phonecta" name="phonecta" data-toggle="toggle"
                                                data-onstyle="active" data-offstyle="inactive"
                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel lp-panel_cta-info">
                                <div class="panel-hp__wrapper">
                                    <div class="panel-hp__col-left">
                                        <h2 class="lp-panel__title lp-panel__title_size18 ">
                                            Phone Number
                                        </h2>
                                    </div>
                                    <div class="panel-hp__col-center">
                                        <div class="panel-hp__setting hide">
                                            <div class="setting-col-left">
                                                <div class="input__wrapper">
                                                    <input id="phone-number" name="phone-number" value="" class="form-control" type="tel">
                                                </div>
                                                <div class="font-type">
                                                <label for="">Font</label>
                                                <div class="select2__parent-phone-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="" id="phonefonttype">
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="setting-col-right">
                                                <div class="font-size">
                                                    <div class="select2__parent-phonenumber-font-size
                                                    select2js__nice-scroll select2-parent">
                                                        <select class="form-control" name="" id="phonefontsize">
                                                            <option value="10">10 px</option>
                                                            <option value="11">11 px</option>
                                                            <option value="12">12 px</option>
                                                            <option value="13">13 px</option>
                                                            <option value="14">14 px</option>
                                                            <option value="15">15 px</option>
                                                            <option value="16">16 px</option>
                                                            <option value="17">17 px</option>
                                                            <option value="18">18 px</option>
                                                            <option value="19">19 px</option>
                                                            <option value="20">20 px</option>
                                                            <option value="21">21 px</option>
                                                            <option value="22">22 px</option>
                                                            <option value="23">23 px</option>
                                                            <option value="24" selected="selected">24 px</option>
                                                            <option value="25">25 px</option>
                                                            <option value="26">26 px</option>
                                                            <option value="27">27 px</option>
                                                            <option value="28">28 px</option>
                                                            <option value="29">29 px</option>
                                                            <option value="30">30 px</option>
                                                            <option value="31">31 px</option>
                                                            <option value="32">32 px</option>
                                                            <option value="33">33 px</option>
                                                            <option value="34">34 px</option>
                                                            <option value="35">35 px</option>
                                                            <option value="36">36 px</option>
                                                            <option value="37">37 px</option>
                                                            <option value="38">38 px</option>
                                                            <option value="39">39 px</option>
                                                            <option value="40">40 px</option>
                                                            <option value="41">41 px</option>
                                                            <option value="42">42 px</option>
                                                            <option value="43">43 px</option>
                                                            <option value="44">44 px</option>
                                                            <option value="45">45 px</option>
                                                            <option value="46">46 px</option>
                                                            <option value="47">47 px</option>
                                                            <option value="48">48 px</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="font-bold">
                                                    <button type="button" class="form-control txt-phone-bold">
                                                        <i class="ico ico-alphabet-b"></i>
                                                    </button>
                                                </div>
                                                <div class="font-italic">
                                                    <button type="button" class="form-control txt-phone-italic">
                                                        <i class="ico ico-alphabet-i"></i>
                                                    </button>
                                                </div>
                                                <div class="col-clr">
                                                <div id="clr_phone_txt" class="last-selected">
                                                    <div class="last-selected__box" style="background: #6e7c81"></div>
                                                    <div class="last-selected__code">#6e7c81</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-hp__col-right">
                                        <input class="info-check-field" id="phonenumber" name="phonenumber" data-toggle="toggle"
                                                data-onstyle="active" data-offstyle="inactive"
                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel lp-panel_cta-info">
                                <div class="panel-hp__wrapper">
                                    <div class="panel-hp__col-left">
                                        <h2 class="lp-panel__title lp-panel__title_size18 ">
                                            Email Address
                                        </h2>
                                    </div>
                                    <div class="panel-hp__col-center">
                                        <div class="panel-hp__setting hide">
                                            <div class="setting-col-left">
                                                <div class="input__wrapper">
                                                <input id="company-email" placeholder="Enter Your Email Address"
                                                       name="company-email"
                                                       class="form-control"
                                                       type="text">
                                            </div>
                                                <div class="font-type">
                                                <label for="">Font</label>
                                                <div class="select2__parent-email-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="" id="emailfonttype">
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="setting-col-right">
                                                <div class="font-size">
                                                    <div class="select2__parent-email-font-size
                                                    select2js__nice-scroll select2-parent">
                                                        <select class="form-control" name="" id="emailfontsize">
                                                            <option value="10">10 px</option>
                                                            <option value="11">11 px</option>
                                                            <option value="12">12 px</option>
                                                            <option value="13">13 px</option>
                                                            <option value="14">14 px</option>
                                                            <option value="15">15 px</option>
                                                            <option value="16">16 px</option>
                                                            <option value="17">17 px</option>
                                                            <option value="18">18 px</option>
                                                            <option value="19">19 px</option>
                                                            <option value="20">20 px</option>
                                                            <option value="21">21 px</option>
                                                            <option value="22">22 px</option>
                                                            <option value="23">23 px</option>
                                                            <option value="24" selected="selected">24 px</option>
                                                            <option value="25">25 px</option>
                                                            <option value="26">26 px</option>
                                                            <option value="27">27 px</option>
                                                            <option value="28">28 px</option>
                                                            <option value="29">29 px</option>
                                                            <option value="30">30 px</option>
                                                            <option value="31">31 px</option>
                                                            <option value="32">32 px</option>
                                                            <option value="33">33 px</option>
                                                            <option value="34">34 px</option>
                                                            <option value="35">35 px</option>
                                                            <option value="36">36 px</option>
                                                            <option value="37">37 px</option>
                                                            <option value="38">38 px</option>
                                                            <option value="39">39 px</option>
                                                            <option value="40">40 px</option>
                                                            <option value="41">41 px</option>
                                                            <option value="42">42 px</option>
                                                            <option value="43">43 px</option>
                                                            <option value="44">44 px</option>
                                                            <option value="45">45 px</option>
                                                            <option value="46">46 px</option>
                                                            <option value="47">47 px</option>
                                                            <option value="48">48 px</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="font-bold">
                                                    <button type="button" class="form-control txt-email-bold">
                                                        <i class="ico ico-alphabet-b"></i>
                                                    </button>
                                                </div>
                                                <div class="font-italic">
                                                    <button type="button" class="form-control txt-email-italic">
                                                        <i class="ico ico-alphabet-i"></i>
                                                    </button>
                                                </div>
                                                <div class="col-clr">
                                                <div id="clr_email_txt" class="last-selected">
                                                    <div class="last-selected__box" style="background: #6e7c81"></div>
                                                    <div class="last-selected__code">#6e7c81</div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-hp__col-right">
                                        <input class="info-check-field" id="email" name="email" data-toggle="toggle"
                                                data-onstyle="active" data-offstyle="inactive"
                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                data-off="ACTIVE" type="checkbox">
                                    </div>
                                </div>
                            </div>
                            <div class="lp-panel lp-panel_cta-info">
                                <div class="panel-hp__wrapper">
                                    <div class="panel-hp__col-left">
                                        <h2 class="lp-panel__title lp-panel__title_size18 ">
                                            Mobile Call Button
                                            <span class="question-mark el-tooltip" title='<div class="mobile-button-tooltip"><p>A Call Button is only displayed on mobile devices.</p><p>The phone number you list above will be automatically<br> used as the Call Button number.</p></div>'>
                                                <span class="ico ico-question"></span>
                                            </span>
                                        </h2>
                                    </div>
                                    <div class="panel-hp__col-center panel-hp__col-center_mobile">
                                        <div class="panel-hp__setting hide">
                                            <div class="setting-col-left">
                                                <div class="input__wrapper">
                                                    <input id="mobile-text" placeholder="Call Button Text"
                                                           name="mobile-text"
                                                           class="form-control" value="" type="text">
                                                </div>
                                                <div class="font-type">
                                                <label for="">Font</label>
                                                <div class="select2__parent-mobile-font-type select2js__nice-scroll">
                                                    <select class="form-control font-type" name="" id="mobilefonttype">
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="setting-col-right">
                                                <div class="clr-elm__wrapper clr-elm__wrapper_header">
                                                    <div class="col-clr-wrap">
                                                        <label for="selectedcolor">Background</label>
                                                        <div id="clr-bgbutton-txt" class="clr-bgbutton-txt last-selected">
                                                            <div class="color-picker" style="background-color: #01c6f7"></div>
                                                        </div>
                                                        <!-- Mobile call bg button color picker -->
                                                        <div class="color-box__panel-wrapper mobile-call-bg-clr">

                                                            <div class="color-box__panel-dropdown">
                                                                <select class="color-picker-options">
                                                                    <option value="1">Color Selection:  Pick My Own</option>
                                                                    <option value="2">Color Selection:  Pull from Logo</option>
                                                                </select>
                                                            </div>
                                                            <div class="color-picker-block">
                                                                <div class="picker-block" id="mobile-callbg-colorpicker">
                                                                </div>
                                                                <label class="color-box__label">Add custom color code</label>
                                                                <div class="color-box__panel-rgb-wrapper">
                                                                    <div class="color-box__r">
                                                                        R: <input class="color-box__rgb" value="1"/>
                                                                    </div>
                                                                    <div class="color-box__g">
                                                                        G: <input class="color-box__rgb" value="198"/>
                                                                    </div>
                                                                    <div class="color-box__b">
                                                                        B: <input class="color-box__rgb" value="247"/>
                                                                    </div>
                                                                </div>
                                                                <div class="color-box__panel-hex-wrapper">
                                                                    <label class="color-box__hex-label">Hex code:</label>
                                                                    <input class="color-box__hex-block" value="#01c6f7" />
                                                                </div>
                                                            </div>
                                                            <div class="color-pull-block">
                                                                <label class="color-box__label">Pulled colors</label>
                                                                <ul class="color-box__list">
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item red"></li>
                                                                    <li class="color-box__item green"></li>
                                                                    <li class="color-box__item black"></li>
                                                                    <li class="color-box__item blue"></li>
                                                                    <li class="color-box__item orange"></li>
                                                                    <li class="color-box__item yellow"></li>
                                                                    <li class="color-box__item parrot"></li>
                                                                </ul>
                                                            </div>
                                                            <div class="color-box__panel-pre-wrapper">
                                                                <label class="color-box__label">Previously used colors</label>
                                                                <ul class="color-box__list">
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-clr-wrap">
                                                        <label for="selectedcolor">Text Color</label>
                                                        <div id="clr-clrbutton-txt" class="clr-clrbutton-txt last-selected">
                                                            <div class="color-picker" style="background-color: #ffffff"></div>
                                                        </div>
                                                        <!-- Mobile call text button color picker -->
                                                        <div class="color-box__panel-wrapper mobile-call-txt-clr">
                                                            <div class="color-box__panel-dropdown">
                                                                <select class="color-picker-options">
                                                                    <option value="1">Color Selection:  Pick My Own</option>
                                                                    <option value="2">Color Selection:  Pull from Logo</option>
                                                                </select>
                                                            </div>
                                                            <div class="color-picker-block">
                                                                <div class="picker-block" id="mobile-calltxt-colorpicker">
                                                                </div>
                                                                <label class="color-box__label">Add custom color code</label>
                                                                <div class="color-box__panel-rgb-wrapper">
                                                                    <div class="color-box__r">
                                                                        R: <input class="color-box__rgb" value="255"/>
                                                                    </div>
                                                                    <div class="color-box__g">
                                                                        G: <input class="color-box__rgb" value="255"/>
                                                                    </div>
                                                                    <div class="color-box__b">
                                                                        B: <input class="color-box__rgb" value="255"/>
                                                                    </div>
                                                                </div>
                                                                <div class="color-box__panel-hex-wrapper">
                                                                    <label class="color-box__hex-label">Hex code:</label>
                                                                    <input class="color-box__hex-block" value="#ffffff" />
                                                                </div>
                                                            </div>
                                                            <div class="color-pull-block">
                                                                <label class="color-box__label">Pulled colors</label>
                                                                <ul class="color-box__list">
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item red"></li>
                                                                    <li class="color-box__item green"></li>
                                                                    <li class="color-box__item black"></li>
                                                                    <li class="color-box__item blue"></li>
                                                                    <li class="color-box__item orange"></li>
                                                                    <li class="color-box__item yellow"></li>
                                                                    <li class="color-box__item parrot"></li>
                                                                </ul>
                                                            </div>
                                                            <div class="color-box__panel-pre-wrapper">
                                                                <label class="color-box__label">Previously used colors</label>
                                                                <ul class="color-box__list">
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                    <li class="color-box__item"></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel-hp__col-right">
                                        <input class="info-check-field" id="mobile" name="mobile"
                                                data-thelink="mobile_active" data-toggle="toggle"
                                                data-onstyle="active" data-offstyle="inactive"
                                                data-width="127" data-height="43" data-on="INACTIVE"
                                                data-off="ACTIVE" type="checkbox">
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
                </form>
            </section>
        </main>
    </div>

    <!-- Company name color picker -->
    <div class="color-box__panel-wrapper company-name-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="company-name-colorpicker">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="0"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="0"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="0"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#000000" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
    <!-- Phone number Cta color picker -->
    <div class="color-box__panel-wrapper cta-number-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="cta-number-colorpicker">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="110"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="124"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="129"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#6e7c81" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
    <!-- Phone number color picker -->
    <div class="color-box__panel-wrapper phone-number-clr">

        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="phone-number-colorpicker">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="110"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="124"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="129"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#6e7c81" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
    <!-- Email address color picker -->
    <div class="color-box__panel-wrapper email-address-clr">
        <div class="color-box__panel-dropdown">
            <select class="color-picker-options">
                <option value="1">Color Selection:  Pick My Own</option>
                <option value="2">Color Selection:  Pull from Logo</option>
            </select>
        </div>
        <div class="color-picker-block">
            <div class="picker-block" id="email-address-colorpicker">
            </div>
            <label class="color-box__label">Add custom color code</label>
            <div class="color-box__panel-rgb-wrapper">
                <div class="color-box__r">
                    R: <input class="color-box__rgb" value="110"/>
                </div>
                <div class="color-box__g">
                    G: <input class="color-box__rgb" value="124"/>
                </div>
                <div class="color-box__b">
                    B: <input class="color-box__rgb" value="129"/>
                </div>
            </div>
            <div class="color-box__panel-hex-wrapper">
                <label class="color-box__hex-label">Hex code:</label>
                <input class="color-box__hex-block" value="#6e7c81" />
            </div>
        </div>
        <div class="color-pull-block">
            <label class="color-box__label">Pulled colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item red"></li>
                <li class="color-box__item green"></li>
                <li class="color-box__item black"></li>
                <li class="color-box__item blue"></li>
                <li class="color-box__item orange"></li>
                <li class="color-box__item yellow"></li>
                <li class="color-box__item parrot"></li>
            </ul>
        </div>
        <div class="color-box__panel-pre-wrapper">
            <label class="color-box__label">Previously used colors</label>
            <ul class="color-box__list">
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
                <li class="color-box__item"></li>
            </ul>
        </div>
    </div>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>