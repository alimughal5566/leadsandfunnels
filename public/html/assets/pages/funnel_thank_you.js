var funnel_thank_you = {
   /*
   * clone thank you page
   * */
    clonePage: function () {
        jQuery(document).on('click', '.lp-control__link__copy', function (e){
            e.preventDefault();
            var _self = jQuery(this);
            var getClass = _self.parents('.fb-question-item').attr('class');
            var geticonText = _self.parents('.fb-question-item').find('.icon-text_link').html();
            var getURLText = _self.parents('.fb-question-item').find('.tu-url__url').html();
            var htmlLayout = '<div class="'+getClass+'">\n' +
                '                                    <div class="fb-question-item__serial"></div>\n' +
                '                                    <div class="fb-question-item__detail">\n' +
                '                                        <div class="fb-question-item__col">\n' +
                '                                            <div class="icon-text icon-text_link">\n' +
                '                                                '+geticonText+'\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="fb-question-item__col">\n' +
                '                                            <div class="tu-url">\n' +
                '                                                <div class="tu-url__url">'+getURLText+'</div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                        <div class="fb-question-item__col fb-question-item__col_control">\n' +
                '                                            <span class="tooltip-info-wrap">\n' +
                '                                                <span class="question-mark el-tooltip" title="TOOLTIP CONTENT">\n' +
                '                                                    <span class="ico ico-question"></span>\n' +
                '                                                </span>\n' +
                '                                            </span>\n' +
                '                                            <a href="#" class="hover-hide">\n' +
                '                                                <i class="fbi fbi_dots">\n' +
                '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                '                                                </i>\n' +
                '                                            </a>\n' +
                '                                            <ul class="lp-control">\n' +
                '                                                <li class="lp-control__item">\n' +
                '                                                    <a title="Conditional&nbsp;Logic" class="lp-control__link el-tooltip" href="#">\n' +
                '                                                        <i class="lp-icon-conditional-logic ico-back"></i>\n' +
                '                                                    </a>\n' +
                '                                                </li>\n' +
                '                                                <li class="lp-control__item lp-control__item_edit">\n' +
                '                                                    <a title="Edit" class="lp-control__link el-tooltip" href="funnel-add-new-page.php">\n' +
                '                                                        <i class="ico-edit"></i>\n' +
                '                                                    </a>\n' +
                '                                                </li>\n' +
                '                                                <li class="lp-control__item">\n' +
                '                                                    <a title="Clone" class="lp-control__link el-tooltip lp-control__link__copy" href="#">\n' +
                '                                                        <i class="ico-copy"></i>\n' +
                '                                                    </a>\n' +
                '                                                </li>\n' +
                '                                                <li class="lp-control__item">\n' +
                '                                                    <a title="Move" class="lp-control__link lp-control__link_cursor_move el-tooltip" href="#">\n' +
                '                                                        <i class="ico-dragging"></i>\n' +
                '                                                    </a>\n' +
                '                                                </li>\n' +
                '                                                <li class="lp-control__item">\n' +
                '                                                    <a title="Delete" class="lp-control__link el-tooltip" href="#confirmation-delete-funnel" data-toggle="modal">\n' +
                '                                                        <i class="ico-cross"></i>\n' +
                '                                                    </a>\n' +
                '                                                </li>\n' +
                '                                            </ul>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>'
            jQuery(htmlLayout).insertAfter(_self.parents('.fb-question-item'));
            lpUtilities.globalTooltip();
        });
    },

    addPage: function () {
        var htmlLayout = '<div class="fb-question-item">\n' +
            '                                    <div class="fb-question-item__serial"></div>\n' +
            '                                    <div class="fb-question-item__detail">\n' +
            '                                        <div class="fb-question-item__col">\n' +
            '                                            <div class="icon-text icon-text_link">\n' +
            '                                                Thank You\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="fb-question-item__col">\n' +
            '                                            <div class="tu-url">\n' +
            '                                                <div class="tu-url__url">Custom Test Funnel</div>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="fb-question-item__col fb-question-item__col_control">\n' +
            '                                            <span class="tooltip-info-wrap">\n' +
            '                                                <span class="question-mark el-tooltip" title="TOOLTIP CONTENT">\n' +
            '                                                    <span class="ico ico-question"></span>\n' +
            '                                                </span>\n' +
            '                                            </span>\n' +
            '                                            <a href="#" class="hover-hide">\n' +
            '                                                <i class="fbi fbi_dots">\n' +
            '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                    <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                </i>\n' +
            '                                            </a>\n' +
            '                                            <ul class="lp-control">\n' +
            '                                                <li class="lp-control__item">\n' +
            '                                                    <a title="Conditional&nbsp;Logic" class="lp-control__link el-tooltip" href="#">\n' +
            '                                                        <i class="lp-icon-conditional-logic ico-back"></i>\n' +
            '                                                    </a>\n' +
            '                                                </li>\n' +
            '                                                <li class="lp-control__item lp-control__item_edit">\n' +
            '                                                    <a title="Edit" class="lp-control__link el-tooltip" href="funnel-add-new-page.php">\n' +
            '                                                        <i class="ico-edit"></i>\n' +
            '                                                    </a>\n' +
            '                                                </li>\n' +
            '                                                <li class="lp-control__item">\n' +
            '                                                    <a title="Duplicate" class="lp-control__link el-tooltip lp-control__link__copy" href="#">\n' +
            '                                                        <i class="ico-copy"></i>\n' +
            '                                                    </a>\n' +
            '                                                </li>\n' +
            '                                                <li class="lp-control__item">\n' +
            '                                                    <a title="Move" class="lp-control__link lp-control__link_cursor_move el-tooltip" href="#">\n' +
            '                                                        <i class="ico-dragging"></i>\n' +
            '                                                    </a>\n' +
            '                                                </li>\n' +
            '                                                <li class="lp-control__item">\n' +
            '                                                    <a title="Delete" class="lp-control__link el-tooltip" href="#confirmation-delete-funnel" data-toggle="modal">\n' +
            '                                                        <i class="ico-cross"></i>\n' +
            '                                                    </a>\n' +
            '                                                </li>\n' +
            '                                            </ul>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>'
        jQuery('.add-box_page').click(function (e){
            e.preventDefault();
            jQuery('.fb-question-items-wrap').append(htmlLayout);
            lpUtilities.globalTooltip();
        });
    },

    sortable: function () {
        $( ".fb-question-items-wrap" ).sortable({
            items: ".fb-question-item",
            placeholder: "thankyou-item__highlight",
            handle: ".lp-control__link_cursor_move",
            start:function(event,ui){
                $('.thankyou-item__highlight').text('Drag & Drop Your Page Here');
            },
            stop:function(event,ui){
                $('.thankyou-item__highlight').text('Drag & Drop Your Page Here');
            }
        });
    },

    init: function () {
        funnel_thank_you.clonePage();
        funnel_thank_you.addPage();
        funnel_thank_you.sortable();
    },
}

jQuery(document).ready(function () {
    funnel_thank_you.init();
});
