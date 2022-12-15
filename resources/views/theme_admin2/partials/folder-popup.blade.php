<!---Muhammd Zulfiqar--->
<!-- ===== Model Boxes - Add folder Funnels- Start ===== -->
<div class="modal fade add-folder in" id="add-folder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Folders</h3>
            </div>
            <div class="folder-notifcations">
            </div>
            <div class="modal-body">
                <form action="" method="post" name="add-folder" class="add-folder-form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="lp-group">
                                <label class="control-label" for="add-folder">Add New Folder</label>
                                <div class="row">
                                    <div class="col-sm-9" style="padding-left: 13px;">
                                        <input type="text" name="folder_name" class="form-control" id="folder_name" placeholder="New Folder" required  aria-required="true">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" class="btn folder-btn" value="Add Folder">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                <div class="folder-list">
                    <div class="folder-col">
                        <div class="row">
                            <div class="col-sm-6"><h3>Folder Name</h3></div>
                            <div class="col-sm-6"><h3 align="right">Options</h3></div>
                        </div>
                    </div>
                    <div class="folder-listing">
                        <div class="sorting">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-modal-footer block-footer">
                            <a data-dismiss="modal" class="btn lp-btn-cancel lp-folder">Close</a>
                            <a href="#" class="btn lp-btn-add btnAction_sort">Save</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Add folder Funnels- End ===== -->

<!-- ===== Model Boxes - Add tag Funnels- Start ===== -->
<div class="modal fade add-folder in" id="add-tag">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Global Tag Management</h3>
            </div>
            <div class="tag-notifcations">
            </div>
            <div class="modal-body">
                <form action="" method="post" name="add-tag" class="add-tag-form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="lp-group">
                                <label class="control-label" for="add-tag">Add New Tag</label>
                                <div class="row">
                                    <div class="col-sm-9" style="padding-left: 13px;">
                                        <input type="text" name="tag_name" class="form-control" id="tag_name" placeholder="New Tag" required  aria-required="true">
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="submit" class="btn tag-btn" value="Add Tag">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
                <div class="folder-list">
                    <div class="folder-col">
                        <div class="row">
                            <div class="col-sm-6"><h3>Tag Name</h3></div>
                            <div class="col-sm-6"><h3 align="right">Options</h3></div>
                        </div>
                    </div>
                    <div class="tag-listing"></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="lp-modal-footer block-footer">
                            <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Add tag Funnels- End ===== -->

<!-- ===== Model Boxes - Add delete folder- Start ===== -->
<div class="modal fade add_recipient home_popup in" id="delete_folder">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-action-header">
                <h3 class="modal-title modal-action-title"></h3>
            </div>
            <div class="modal-body model-action-body">
                <div class="lp-lead-modal-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="modal-action-msg-wrap">
                                <div class="funnel-message modal-msg"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lp-modal-footer footer-border">
                    <a data-dismiss="modal" class="btn lp-btn-cancel">Close</a>
                    <input type="button" class="btn lp-btn-add" id="delete" value="delete">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ===== Model Boxes - Add delete folder- End ===== -->
<!-- abubakar added this span -->
<span class="modal-overlay"></span>