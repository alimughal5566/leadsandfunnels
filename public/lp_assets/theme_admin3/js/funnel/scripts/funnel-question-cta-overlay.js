window.selectItems = {
    'cta-link-text' :[
        {
            id:'link-destination',
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span class="text">LINK DESTINATION</span></div>',
            title: 'link destination'
        },
        {
            id:'next-step',
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span class="text">Next Step</span></div>',
            title: 'Next Step'
        },
        {
            id:'leadpops-lead-funnel',
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span class="text">A leadPops Lead Funnel</span></div>',
            title: 'A leadPops Lead Funnel'
        },
        {
            id:'outside-url',
            text:'<div class="select2_style"><span class="select2js-placeholder">What should it link to?</span><span class="text">Outside URL</span></div>',
            title: 'Outside URL'
        }
    ],
};


var question_cta_overlay = {

    overlay_select_list : [
        {selecter:".cta-link-text", parent:".cta-link-text-parent"},
    ],

    /*
    ** custom select loop
    **/

    allCustomSelect: function () {
        var selectlist = question_cta_overlay.overlay_select_list;
        for(var i = 0; i < selectlist.length; i++){
            question_cta_overlay.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
        }
    },

    /*
    ** init custom select
    **/

    initCustomSelect: function (selecter,parent) {
        var amIclosing = false;
        var _selector = jQuery(selecter);
        var _parent = jQuery(parent);
        var selectorClass = selecter.replace(/[#.]/g,'');
        _selector.select2({
            data: selectItems[selectorClass],
            minimumResultsForSearch: -1,
            dropdownParent: jQuery(parent),
            width: '100%',
            templateResult: function (d) {
                return $(d.text);
            },
            templateSelection: function (d) {
                return $(d.text);
            }

            /*
            ** Triggered before the drop-down is opened.
            */
        }).on('select2:opening', function() {
            _parent.find('.select2-selection__rendered').css('opacity', '0');

            /*
            ** Triggered whenever the drop-down is opened.
            ** select2:opening is fired before this and can be prevented.
            */

        }).on('select2:open', function() {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');
            var _self = jQuery(this);
            _self.parent().find('.select2-results__options').css('pointer-events', 'none');
            setTimeout(function() {
                _self.parent().find('.select2-results__options').css('pointer-events', 'auto');
            }, 300);
            _self.parent().find('.select2-dropdown').hide();
            _self.parent().find('.select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _self.parent().find('.select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 100);

            /*
            ** Triggered before the drop-down is closed.
            */

        }).on('select2:closing', function(e) {
            if(!amIclosing) {
                var _self = jQuery(this);
                e.preventDefault();
                amIclosing = true;
                _self.parent().find('.select2-dropdown').attr('style', '');
                setTimeout(function () {
                    _self.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }

            /*
            ** Triggered whenever the drop-down is closed.
            ** select2:closing is fired before this and can be prevented.
            */

        }).on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            //_parent.find('.select2-results__options').css('pointer-events', 'none');
        }).on('select2:select', function (e) {
            var $this = $(this).val();
            var save_button_disabled = false;
            if ($this.value == "link-destination"){
                $(".outside-url-slide").slideUp();
                $(".select-funnel-slide").slideUp();
            } else if (this.value == "next-step"){
                $(".outside-url-slide").slideUp();
                $(".select-funnel-slide").slideUp();
            } else if (this.value == "leadpops-lead-funnel"){
                if(!$('.select-funnel-slide a.select-funnel-opener').hasClass('selected'))
                {
                    save_button_disabled = true;
                }
                $(".select-funnel-slide").slideDown();
                $(".outside-url-slide").slideUp();
            } else if (this.value == "outside-url"){
                var outside_url = $('.outside-url-slide .outside-url-field input').val();
                if(outside_url == '' || outside_url == 'undefined')
                {
                    save_button_disabled = true;
                }
                $(".outside-url-slide").slideDown(function () {
                    setTimeout(function () {
                        $('.outside-url-field .form-control').focus();
                    },50);
                });
                $(".select-funnel-slide").slideUp();
            }
            if(save_button_disabled == true)
            {
                setTimeout(function (){ FunnelActions.disableFunnelSaveBtn() },10);
            }
            else
            {
                SaveChangesPreview.saveQuestion(e, 'select');
            }
        });
        $('.cta-link-text').val($("[data-field-name='cta-button-settings.link-destination']").attr('data-selected-option')).trigger('change');
    },

    hideDefaultBtn: function () {
        const default_json = hbar.getJson("ctamessage.json");
        const funnel_questions = FunnelsUtil._getFunnelInfo('local_storage')
        const current_question = funnel_questions.questions[window.current_question_id]
        const is_default_cta_text = default_json.options['call-to-action'] === current_question.options['call-to-action']
        const is_default_cta_description = default_json.options['description'] === current_question.options['description']

        if (is_default_cta_description){
            $('.froala-clear-text.description').show();
        }
        if (is_default_cta_text){
            $('.froala-clear-text').not('.description').show();
        }
    },

    /*
    ** init Function
    **/
    init: function() {
        question_cta_overlay.hideDefaultBtn();
        question_cta_overlay.allCustomSelect();
    }
};


jQuery(document).ready(function() {
    question_cta_overlay.init();
    FBEditor.init();
    InputControls.init();
    FunnelActions.saveFunnelInDB();
    InputControls.setIconSecurityDropdown();

    $('#global-setting-funnel-list-pop').on('shown.bs.modal', function () {
        setTimeout(function () {
            $('#modal-search-bar').focus();
        },500);
        if($('#funnelsExample .funnels').find('.funnel-radio:checked').length == 1)
        {
            $('.funnel-radio:checked').parents('.setting-slide').addClass('show');
        }

    });
});
