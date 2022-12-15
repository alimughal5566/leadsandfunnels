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
            <section class="main-content">
                <form class="name-tag-form" action="" method="get">
                    <!-- Title wrap of the page -->
                    <div class="main-content__head">
                        <div class="col-left">
                            <h1 class="title">
                                Name & Tags / Funnel: <span class="funnel-name el-tooltip" title="203K Hybrid Loans">203K Hybrid Loans</span>
                            </h1>
                        </div>
                        <div class="col-right">
                            <a data-lp-wistia-title="Name & Tags" data-lp-wistia-key="ji1qu22nfq" class="video-link lp-wistia-video" href="#" data-toggle="modal" data-target="#lp-video-modal">
                                <span class="icon ico-video"></span>
                                Watch how to video
                            </a>
                        </div>
                    </div>
                    <!-- content of the page -->
                    <div class="lp-panel lp-tag pb-2">
                        <div class="lp-panel__head">
                            <div class="col-left">
                                <h2 class="lp-panel__title">
                                    Name & Tags
                                </h2>
                            </div>
                        </div>
                        <div class="lp-panel__body lp-panel__body_fb-info">
                            <div class="funnel__name">
                                <div class="funnel__col">
                                    <div class="form-group">
                                        <label for="funnel_name" class="nt-lbl">Funnel Name</label>
                                        <div class="input__wrapper">
                                            <input type="text" id="funnel_name" name="funnel_name" value="203K Hybrid Loans" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="funnel__col">
                                    <div class="form-group">
                                        <label class="nt-lbl text-center">Folder</label>
                                        <div class="input__wrapper">
                                            <div class="select2__folder-parent">
                                                <select class="select2__folder">
                                                    <option value="lp">leadPops</option>
                                                    <option value="mm">Movement Mortgage</option>
                                                    <option value="mf" selected="selected">All Funnels</option>
                                                    <option value="vl">VA Loans</option>
                                                </select>
                                            </div>
                                        </div>
                                        <span class="edit__field el-tooltip edit-folder-popup modal-opener" title="<b class='pop-tooltip'>Manage Folders</b>">
                                            <span class="ico ico-edit"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="tag_list"  class="nt-lbl">Funnel Tag(s)</label>
                                        <div class="input__wrapper lp-tag">
                                            <div class="select2js__tags-parent tag-result-common tag-result">
                                                <select class="form-control tag-drop-down" multiple name="tag_list" id="tag_list">
                                                    <option value="1">203k</option>
                                                    <option value="2">leadPops</option>
                                                    <option value="3">leadPops 2</option>
                                                    <option value="4">leadPops 3</option>
                                                    <option value="1">203k</option>
                                                    <option value="2">leadPops</option>
                                                    <option value="3">leadPops 2</option>
                                                    <option value="4">leadPops 3</option>
                                                    <option value="1">203k</option>
                                                    <option value="2">leadPops</option>
                                                    <option value="3">leadPops 2</option>
                                                    <option value="4">leadPops 3</option>
                                                    <option value="1">203k</option>
                                                    <option value="2">leadPops</option>
                                                    <option value="3">leadPops 2</option>
                                                    <option value="4">leadPops 3</option>
                                                    <option value="1">203k</option>
                                                    <option value="2">leadPops</option>
                                                    <option value="3">leadPops 2</option>
                                                    <option value="4">leadPops 3</option>
                                                </select>
                                            </div>
                                        </div>
                                        <span class="edit__field el-tooltip modal-opener" title="<b class='pop-tooltip'>manage tags</b>">
                                            <a href="#add-tag" data-toggle="modal">
                                                <span class="ico ico-edit"></span>
                                            </a>
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
                </form>
            </section>
        </main>
    </div>
    <div class="modal fade add-folder" id="add-folder" tabindex="-1" role="dialog" aria-labelledby="add-folder" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Folders</h5>
                    </div>
                    <div class="modal-body pb-0">
                        <form action="" method="post" name="add-folder" class="add-folder-form form-pop" novalidate="novalidate">
                            <div class="row">
                                <div class="col-12">
                                    <div class="lp-group">
                                        <label class="control-label" for="add-folder">Add New Folder</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group m-0">
                                                    <div class="input__holder">
                                                        <input type="text" name="folder_name" class="form-control" id="folder_name" placeholder="New Folder" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <input type="button" class="button folder-btn" value="Add Folder">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <div class="folder-list">
                            <div class="folder-col">
                                <div class="col">
                                    <h3>Folder Name</h3>
                                </div>
                                <div class="col">
                                    <h3>Options</h3>
                                </div>
                            </div>
                            <div class="folder-listing">
                                <div class="sorting ui-sortable">
                                    <div class="folder-col" data-id="168">
                                        <div class="tag-col">
                                            <div class="folder-inner">
                                                <div class="col">
                                                    <h4>Mortgage Funnels</h4>
                                                </div>
                                                <div class="col">
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link move" data-id="168" data-index="0">
                                                                    <span class="ico ico ico-dragging"></span>MOVE
                                                                </a>
                                                            </li>
                                                            <li class="action__item">
                                                                <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                                    <span class="ico ico-edit"></span>EDIT
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
                                                    <!--                                            <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
                                                    <!--                                            <ul class="action_nav">-->
                                                    <!--                                                <li> <a href="javascript:void(0);" class="move" data-id="168"><i class="ico ico-dragging"></i>MOVE</a></li>-->
                                                    <!--                                                <li> <a href="javascript:void(0);" class="edit-folder" data-id="168" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
                                                    <!--                                            </ul>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="folder-col" data-id="169">
                                        <div class="tag-col">
                                            <div class="folder-inner">
                                                <div class="col">
                                                    <h4>Real Estate Funnels</h4>
                                                </div>
                                                <div class="col">
                                                    <div class="action action_options">
                                                        <ul class="action__list">
                                                            <li class="action__item">
                                                                <a href="#" class="action__link move" data-id="169" data-index="0">
                                                                    <span class="ico ico ico-dragging"></span>MOVE
                                                                </a>
                                                            </li>
                                                            <li class="action__item">
                                                                <a href="#" class="action__link edit-folder" data-id="169" data-index="0">
                                                                    <span class="ico ico-edit"></span>EDIT
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
                                                    <!--                                            <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
                                                    <!--                                            <ul class="action_nav">-->
                                                    <!--                                                <li> <a href="javascript:void(0);" class="move" data-id="169"><i class="ico ico-dragging"></i>MOVE</a></li>-->
                                                    <!--                                                <li> <a href="javascript:void(0);" class="edit-folder" data-id="169" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
                                                    <!--                                            </ul>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                </li>
                                <li class="action__item">
                                    <input class="button button-primary lp-btn-add" value="Save" type="submit">
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade add-folder" id="add-tag" tabindex="-1" role="dialog" aria-labelledby="add-tag" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Global Tag Management</h5>
                    </div>
                    <div class="modal-body pb-0">
                        <form action="" method="post" name="add-folder" class="add-tag-form form-pop" novalidate="novalidate">
                            <div class="row">
                                <div class="col-12">
                                    <div class="lp-group">
                                        <label class="control-label" for="tag_name">Add New Tag</label>
                                        <div class="row">
                                            <div class="col-9">
                                                <div class="form-group m-0">
                                                    <div class="input__holder">
                                                        <input type="text" name="tag_name" class="form-control" id="tag_name" placeholder="New Tag" required="" aria-required="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-3 pl-0">
                                                <input type="submit" class="button tag-btn" value="Add Tag">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </form>
                        <div class="folder-list">
                            <div class="folder-col">
                                <div class="col">
                                    <h3>Tag Name</h3>
                                </div>
                                <div class="col">
                                    <h3>Options</h3>
                                </div>
                            </div>
                            <div class="folder-listing">
                                <div class="folder-col" data-id="168">
                                    <div class="col">
                                        <h4>Mortgage Funnels</h4>
                                    </div>
                                    <div class="col">
                                        <div class="action action_options">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                        <span class="ico ico-edit"></span>edit
                                                    </a>
                                                </li>
                                                <li class="action__item">
                                                    <a href="#" class="action__link del" data-id="168">
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
<!--                                        <a href="javascript:void(0);" class="show_nav"><i class="fa fa-circle"></i><i class="fa fa-circle"></i><i class="fa fa-circle"></i></a>-->
<!--                                        <ul class="action_nav">-->
<!--                                            <li> <a href="javascript:void(0);" class="edit-folder" data-id="168" data-index="0"><i class="ico ico-edit"></i>EDIT</a></li>-->
<!--                                            <li> <a href="javascript:void(0);" class="del" data-id="168"><i class="ico ico-cross"></i>Delete</a></li>-->
<!--                                        </ul>-->
                                    </div>
                                </div>
                                <div class="folder-col" data-id="169">
                                    <div class="col">
                                        <h4>Real Estate Funnels</h4>
                                    </div>
                                    <div class="col">
                                        <div class="action action_options">
                                            <ul class="action__list">
                                                <li class="action__item">
                                                    <a href="#" class="action__link edit-folder" data-id="168" data-index="0">
                                                        <span class="ico ico-edit"></span>edit
                                                    </a>
                                                </li>
                                                <li class="action__item">
                                                    <a href="#" class="action__link del" data-id="168">
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
                    <div class="modal-footer">
                        <div class="action">
                            <ul class="action__list">
                                <li class="action__item">
                                    <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                                </li>
                                <li class="action__item">
                                    <input class="button button-primary lp-btn-add" value="Save" type="submit">
                                </li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal fade add_recipient home_popup in" id="delete_folder">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header modal-action-header">
                    <h3 class="modal-title modal-action-title">Delete Tag</h3>
                </div>
                <div class="modal-body model-action-body">
                    <div class="lp-lead-modal-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-action-msg-wrap">
                                    <div class="funnel-message modal-msg">Are you sure to delete this tag?</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer lp-modal-footer footer-border">
                    <div class="action">
                        <ul class="action__list">
                            <li class="action__item">
                                <button type="button" class="button button-cancel" data-dismiss="modal">Close</button>
                            </li>
                            <li class="action__item">
                                <input class="button button-primary lp-btn-add" value="delete" type="button">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span class="modal-overlay"></span>
<?php
include ("includes/video-modal.php");
include ("includes/footer.php");
?>