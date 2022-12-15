var question_select_list = [
    {selecter:".msgfontsize", parent:".select2__parent-font-size"},
    {selecter:".dfontsize", parent:".select2__parent-font-size"},
    {selecter:".select2js__transition-type", parent:".select2js__transition-type-parent"},
    {selecter:".url-prefix", parent:".select2__parent-url-prefix"}
];

/*
** custom select loop
**/
function customQuestion() {
    var selectlist = question_select_list;
    for(var i = 0; i < selectlist.length; i++){
        questionsSelectinit(selectlist[i].selecter,selectlist[i].parent);
    }
}

function showQuestionSelect2(element, config) {
    var amIclosing = false;
    $(element).select2(config)
        .on('select2:openning', function() {
            $(this).parent().find('.select2-selection__rendered').css('opacity', '0');
        }).on('select2:open', function() {
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
            _self.parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = _self.find(':selected').index();
                var defaultHeight = 40;
                var scrolledArea = getindex * defaultHeight;
                _self.parent().find(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        console.log('closing area');
        if(!amIclosing) {
            var _self = jQuery(this);
            e.preventDefault();
            amIclosing = true;
            _self.parent().find('.select2-dropdown').attr('style', '');
            setTimeout(function () {
                console.log('set time out');
                _self.select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery(this).parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        console.log('last-close');
        jQuery(this).parent().find('.select2-selection__rendered').show();
        jQuery(this).parent().find('.select2-results__options').css('pointer-events', 'none');
    });
}

/*
** init custom select
**/
function questionsSelectinit(selecter,parent) {
    var amIclosing = false;
    var _selector = jQuery(selecter);
    var _parent = jQuery(parent);
    var selectorClass = selecter.replace(/[#.]/g,'');
    console.log(selecter,parent);
    _selector.select2({
        //data: selectItems[selectorClass],/*(selecter == '.add-sticky-bar__select')?stickybar.add_StickyBarOption: stickybar.sb_ButtonPosition,*/
        minimumResultsForSearch: -1,
        dropdownParent: jQuery(parent),
        width: '100%',
        /*templateResult: function (d) {
            return $(d.text);
        },
        templateSelection: function (d) {
            return $(d.text);
        }*/

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

        _selectoptions.css('pointer-events', 'none');

        setTimeout(function() {
            _selectoptions.css('pointer-events', 'auto');
        }, 300);

        _selectdropdown.hide();
        _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        _parent.find('.select2-selection__rendered').hide();
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
            e.preventDefault();
            amIclosing = true;

            _parent.find('.select2-dropdown').attr('style', '');

            setTimeout(function () {
                _selector.select2("close");
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
        _parent.find('.select2-results__options').css('pointer-events', 'none');
    });
}

//*
// ** Font Load Function
// *

function font_load(){
    var a = [];
    $.each(font_object, function( index, value ) {
        a.push(value);
    });

    WebFontConfig = {
        google: { families: a }
    };

    var wf = document.createElement('script');
    wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = true;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
}


var font_object = {};

//*
// ** Font Object
// *

font_object = {
    "Abril Fatface": 'Abril Fatface',
    "Antic Slab": 'Antic Slab',
    "Anton": 'Anton',
    "Archivo Black": 'Archivo Black',
    "Arial": 'Arial',
    "Arvo": 'Arvo',
    "Berkshire Swash": 'Berkshire Swash',
    "Bevan": 'Bevan',
    "Bree Serif": 'Bree Serif',
    "Bungee Inline": 'Bungee Inline',
    "Cardo": 'Cardo',
    "Chela One": 'Chela One',
    "Chivo": 'Chivo',
    "Cinzel": 'Cinzel',
    "Coiny": 'Coiny',
    "Concert One": 'Concert One',
    "Cormorant": 'Cormorant',
    "Crimson Text": 'Crimson Text',
    "Exo 2": 'Exo 2',
    "Fira Sans": 'Fira Sans',
    "Fjalla One": 'Fjalla One',
    "Frank Ruhl Libre": 'Frank Ruhl Libre',
    "Fugaz One": 'Fugaz One',
    "Josefin Sans": 'Josefin Sans',
    "Judson": 'Judson',
    "Julius Sans One": 'Julius Sans One',
    "Kanit": 'Kanit',
    "Karla": 'Karla',
    "Kavoon": 'Kavoon',
    "Lato": 'Lato',
    "Libre Baskerville": 'Libre Baskerville',
    "Lobster": 'Lobster',
    "Lora": 'Lora',
    "Martel": 'Martel',
    "Merienda": 'Merienda',
    "Merriweather": 'Merriweather',
    "Monoton": 'Monoton',
    "Montserrat": 'Montserrat',
    "Notable": 'Notable',
    "Noto Sans": 'Noto Sans',
    "Nunito": 'Nunito',
    "Oleo Script": 'Oleo Script',
    "Open Sans": 'Open Sans',
    "Open Sans Condensed": 'Open Sans Condensed',
    "Oswald": 'Oswald',
    "Pacifico": 'Pacifico',
    "Paytone One": 'Paytone One',
    "Permanent Marker": 'Permanent Marker',
    "Philosopher": 'Philosopher',
    "Playfair Display": 'Playfair Display',
    "Poiret One": 'Poiret One',
    "Poppins": 'Poppins',
    "PT Sans": 'PT Sans',
    "PT Serif": 'PT Serif',
    "Prata": 'Prata',
    "Quicksand": 'Quicksand',
    "Rajdhani": 'Rajdhani',
    "Rakkas": 'Rakkas',
    "Raleway": 'Raleway',
    "Roboto": 'Roboto',
    "Rock Salt": 'Rock Salt',
    "Rubik": 'Rubik',
    "Sintony": 'Sintony',
    "Source Sans Pro": 'Source Sans Pro',
    "Special Elite": 'Special Elite',
    "Spectral": 'Spectral',
    "Spirax": 'Spirax',
    "Times New Roman":'Times New Roman',
    "Ubuntu Condensed": 'Ubuntu Condensed',
    "Ultra": 'Ultra',
    "Work Sans": 'Work Sans'
};


//*
// ** Window Load
// *

$(window).on('load',function() {
    //*
    // ** Load Font Object
    // *
    autosize($('textarea'));
    font_load();
});

jQuery(document).ready(function () {
    var amIclosing = false;
    var obj_data= {
        question_type:'',
        question_dsc:'',
        question_icon:'',
        question_class:'',
        question_transition:0,
        data_list:'',
        data_icon:'',
        dropable_only:''
    };

    autosize($('textarea'));

    //*
    // ** Font Object Loop
    // *
    var fontSize = [];
    for (var i = 8; i <= 72; i++) {
        fontSize.push(i);
    }

    //*
    // ** Send Object In Options
    // *

    var $options = $();
    $options = $options.add($('<option>').attr('value', '').html('Select Font Type'));
    $.each(font_object , function (index , value) {
        $class = value;
        $class = $class.replace(" ", "_");
        $options = $options.add(
            $('<option>').attr('value', index).html(value).css('font-family', value)
        );
    });
    $('select.font-type').html($options).trigger('change');

    function matchCustom(params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
            return data;
        }

        // Do not display the item if there is no 'text' property
        if (typeof data.text === 'undefined') {
            return null;
        }

        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) == 0) {
            var modifiedData = $.extend({}, data, true);
            modifiedData.text;

            // You can return modified objects from here
            // This includes matching the `children` how you want in nested data sets
            return modifiedData;
        }

        // Return `null` if the term should not be displayed
        return null;
    }

    function getOptionsFormat(options) {
        var optionsHtml = '';
        jQuery(options).each(function(index, option){
            optionsHtml += '<option value="'+option.value+'"><label>'+option.title +'</label></option>';
        });
        return optionsHtml;
    }

    $('#question-select-group').select2({
        minimumResultsForSearch: -1,
        width: '100%', // need to override the changed default
        dropdownParent: $('.standard-question-option-parent-group-wrap'),
    }).on('change',function () {
        obj_data.question_transition = 0;
        if($(this).val() == 1) {
            $('.question-transition').hide();
            $('.question-standard').show();
            history.replaceState(null,null, window.location.pathname + "#standard-question");
        }else if($(this).val() ==  2) {
            if ($('.question-option-list > li').length > 0) {
                $('.question-global .placeholder').hide();
            }
            $('.question-standard').hide();
            $('.question-transition').show();
            history.replaceState(null, null, window.location.pathname + "#transition");
            obj_data.question_transition = 1
        }
    }).on('select2:openning', function() {
        jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').hide();
        jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.standard-question-option-parent-group-wrap .select2-dropdown .nicescroll-rails-vr').each(function () {
                this.style.setProperty( 'opacity', '1', 'important' );
                var getindex = jQuery('#question-select-group').find(':selected').index();
                var defaultHeight = 36;
                var scrolledArea = getindex * defaultHeight;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.standard-question-option-parent-group-wrap .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#question-select-group').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.standard-question-option-parent-group-wrap .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.standard-question-option-parent-group-wrap .select2-selection__rendered').show();
        jQuery('.standard-question-option-parent-group-wrap .select2-results__options').css('pointer-events', 'none');
    });

    $(".question-list-item").draggable({
        revert: 'invalid',
        cursor: "move",
        helper: "clone",
        connectToSortable: ".funnel-panel__sortable",
        appendTo: 'body',
        cursorAt: { top: 10, left: 10 },
        start: function(event, ui) {
            $('.question-list-item, .question-list-item-hidden').addClass('disabled');
            obj_data.data_icon = '';
            obj_data.question_type = $(this).text();
            obj_data.question_icon = $(this).data('icon');
            obj_data.question_class = $(this).data('class');
            if($('.funnel-panel__sortable .fb-question-item').length == 2){
                $('.funnel-panel__sortable').removeClass("placeholder");
            }
        },
        stop: function (event, ui) {
            $('.question-list-item, .question-list-item-hidden').removeClass('disabled');
            if($(this).hasClass('hidden-field-item')) {
                $('.funnel-body-scroll-group').addClass('hidden-label-active');
            }
        }
    });

    $(".question-list-item[disabled]").draggable({
        disabled: true
    });

    $(".dropable-funnel-option").droppable({
        accept: ".question-list-item",
        drop: function( event, ui ) {
            obj_data.dropable_only = 1;
        }
    });

    $('.funnel-panel__sortable').sortable({
        connectWith:'.innerDropable-element',
        placeholder: "fb-question-item__highlight",
        items: ".fb-question-item",
        handle: ".lp-control__link_cursor_move",
        tolerance: "pointer",
        update: function( event, ui ) {
            initColorChanger('.innerDropable-element');
        },
        start:function(event,ui){
            var $item = ui.item;
            if (ui.item.hasClass('transition-item')) {
                $('.fb-question-item__highlight').text('Drag & Drop Your Transition Here');
            }else {
                $('.fb-question-item__highlight').text('Drag & Drop Your Question Here');
            }
        },
        stop: function(event,ui) {
            if (obj_data.dropable_only == 1) {
                $('.funnel-panel__placeholder').hide();
                $('.funnel-panel__sortable').show();
                $('.dropable-funnel-option').css({'height':'auto','margin':'0'});
                if (ui.item.hasClass('birthday-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_birthday_overlay.addclassclick();
                    });
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                }
                if (ui.item.hasClass('number-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="What type of number do you need?"><span class="sub-text">What type of number do you need?</span></span></div>';
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_number_overlay.addclassclick();
                    });
                    $('.question-icon-text').text('What type of number do you need?');
                    $('.question-icon-text').tooltipster('content', 'What type of number do you need?');
                }
                if (ui.item.hasClass('date-picker-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Arrange an appointment?"><span class="sub-text">Arrange an appointment?</span></span></div>';
                    $('.question-icon-text').text('Arrange an appointment?');
                    $('.question-icon-text').tooltipster('content', 'Arrange an appointment?');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_number_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('contact-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col fb-question-item__col_plr14">\n' +
                        '\t<label class="fb-step-label">3 - STEP</label>\n' +
                        '</div>\n' +
                        '<div class="fb-question-item__col fb-question-item__col__steps">\n' +
                        '    <div class="fb-step">\n' +
                        '        <div class="fb-step__title">Step 1:</div>\n' +
                        '        <ul class="fb-step__list">\n' +
                        '            <li class="fb-step__list__item">First Name</li>\n' +
                        '            <li class="fb-step__list__item">Email Address</li>\n' +
                        '        </ul>\n' +
                        '    </div>\n' +
                        '    <div class="fb-step">\n' +
                        '        <div class="fb-step__title">Step 2:</div>\n' +
                        '        <ul class="fb-step__list">\n' +
                        '            <li class="fb-step__list__item">Email Address</li>\n' +
                        '        </ul>\n' +
                        '    </div>\n' +
                        '    <div class="fb-step">\n' +
                        '        <div class="fb-step__title">Step 3:</div>\n' +
                        '        <ul class="fb-step__list">\n' +
                        '            <li class="fb-step__list__item">Phone Number</li>\n' +
                        '        </ul>\n' +
                        '    </div>\n' +
                        '</div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        contact_info_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('slider-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="What is the purchase price of the new property?"><span class="sub-text">What is the purchase price of the new property?</span></span></div>';
                    $('.question-icon-text').text('What is the purchase price of the new property?');
                    $('.question-icon-text').tooltipster('content', 'What is the purchase price of the new property?');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        slider_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('text-field-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="How will this property be used?"><span class="sub-text">How will this property be used?</span></span></div>';
                    $('.question-icon-text').text('How will this property be used?');
                    $('.question-icon-text').tooltipster('content', 'How will this property be used?');
                    $('body').addClass('text-overlay-active');
                }
                if (ui.item.hasClass('bundle-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Vehicle Make + Model"><span class="sub-text">Vehicle Make + Model</span></span></div>';
                    $('.question-icon-text').text('Vehicle Make + Model');
                    $('.question-icon-text').tooltipster('content', 'Vehicle Make + Model');
                }
                if (ui.item.hasClass('text-field-item-iframe')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="How will this property be used?"><span class="sub-text">How will this property be used?</span></span></div>';
                    $('.question-icon-text').text('How will this property be used?');
                    $('.question-icon-text').tooltipster('content', 'How will this property be used?');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        text_field_overlay.addclassclick();
                    });

                }
                if (ui.item.hasClass('dropdown-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        dropdown_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('address-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_address_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('menu-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_menu_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('cta-message-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_cta_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('group-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question  N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                }
                if (ui.item.hasClass('time-picker-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Question N/A"><span class="sub-text">Question N/A</span></span></div>';
                    $('.question-icon-text').text('Question N/A');
                    $('.question-icon-text').tooltipster('content', 'Question N/A');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        question_timepicker_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('hidden-field-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="Marketing strategy"><span class="sub-text">Marketing strategy</span></span></div>';
                    $('.question-icon-text').text('Marketing strategy');
                    $('.question-icon-text').tooltipster('content', 'Marketing strategy');
                    $('#hidden-field-modal').modal('show');
                }
                if (ui.item.hasClass('zip-code-item')) {
                    obj_data.question_dsc = '<div class="fb-question-item__col sub-text-wrap"><span class="sub-text-holder text-tooltip" title="FREE Down Payment Assistance Finder"> <span class="sub-text">FREE Down Payment Assistance Finder</span></span></div>';
                    $('.question-icon-text').text('FREE Down Payment Assistance Finder');
                    $('.question-icon-text').tooltipster('content', 'FREE Down Payment Assistance Finder');
                    $('body').addClass('overlay-active');

                    // HANDLEBAR
                    hbar.renderTemplate(ui.item.data('icon')+'.hbs', "questionEditor", {}, function(){
                        zip_code_overlay.addclassclick();
                    });
                }
                if (ui.item.hasClass('group-item')) {
                    $('#icon-color-modal').modal('show');
                    $('#icon-color-modal').on('show.bs.modal', function (event) {
                        $('.icon-color-opener').find('.last-selected__box').css('backgroundColor', '#b6c7cd');
                        $('.icon-color-opener').find('.last-selected__code').text('#b6c7cd');
                    });
                }
                if(!ui.item.hasClass('ui-draggable')) return;
                if(obj_data.question_transition == 0) {
                    ui.item.replaceWith(
                        '<div class="fb-question-item slide '+obj_data.question_icon+ (ui.item.hasClass('hidden-field-item')? ' hidden-field-active' : '') + obj_data.data_list +' '+obj_data.question_class +'" >\n' +
                        '   <div class="question-item single-question-slide">\n' +
                        '   <div class="fb-question-item__serial"></div>\n' +
                        '      <div class="fb-question-item__detail">\n' +
                        '         <div class="fb-question-item__col">\n' +
                        '            <div class="question-text '+obj_data.question_icon+ (ui.item.hasClass('group-item')? ' lastQuestion-colorText' : '')+ '"><span class="sub-text">'+obj_data.question_type+'</span></div>\n' +
                        (ui.item.hasClass('group-item')? ' <a href="#" class="dropable-slide-opener"><span class="ico-arrow-down"></span></a>\n' : '') +
                        '         </div> '+obj_data.question_dsc +
                        '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                        '            <a href="#" class="hover-hide">\n' +
                        '               <i class="fbi fbi_dots">\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '               </i>\n' +
                        '            </a>\n' +
                        '            <ul class="lp-control">\n' +
                        '                <li class="lp-control__item reply">\n' +
                        '                    <a title="Conditional&nbsp;Logic" class="lp-control__link fb-tooltip fb-tooltip_control" href="#conditional-logic" data-toggle="modal">\n' +
                        '                       <i class="lp-icon-conditional-logic ico-back"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item edit">\n' +
                        '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-edit"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item copy">\n' +
                        '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-copy"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit drag">\n' +
                        '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control lp-icon-drag" href="#">\n' +
                        '                       <i class="ico-dragging"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item lp-control__item_edit delete">\n' +
                        '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#confirmation-delete" data-toggle="modal">\n' +
                        '                       <i class="ico-cross"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '            </ul>\n' +
                        '         </div>\n' +
                        '          '+obj_data.data_icon+'  \n'+
                        '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                        '              <a href="#">\n' +
                        '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                        '                 <i class="ico-back"></i>\n' +
                        '                 <i class="ico-globe"></i>\n' +
                        '              </a>\n' +
                        '         </div>\n' +
                        '   </div>\n' +
                        '   </div>\n' +
                        (ui.item.hasClass('group-item')? ' <div class="innerDropable-element"></div>\n' : '') +
                        '   </div>\n' +
                        '</div>');
                }
                else {
                    ui.item.replaceWith(
                        '<div class="fb-question-item fb-question-item_transition">\n' +
                        '   <div class="question-item">\n' +
                        '      <div class="fb-question-item__detail">\n' +
                        '         <div class="fb-question-item__col">\n' +
                        '            <i class="bar"></i><div class="question-text '+obj_data.question_icon+'"><span class="sub-text">'+obj_data.question_type+'</span></div>\n' +
                        '         </div>\n' +
                        '         <div class="fb-question-item__col fb-question-item__col_control">\n' +
                        '            <a href="#" class="hover-hide">\n' +
                        '               <i class="fbi fbi_dots">\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '                  <i class="fa fa-circle" aria-hidden="true"></i>\n' +
                        '               </i>\n' +
                        '            </a>\n' +
                        '            <ul class="lp-control">\n' +
                        '                <li class="lp-control__item lp-control__item_edit reply">\n' +
                        '                    <a title="Edit" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-edit"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item edit">\n' +
                        '                    <a title="Duplicate" class="lp-control__link fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-copy"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item drag">\n' +
                        '                    <a title="Move" class="lp-control__link lp-control__link_cursor_move fb-tooltip fb-tooltip_control" href="#">\n' +
                        '                       <i class="ico-dragging"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '                <li class="lp-control__item delete">\n' +
                        '                    <a title="Delete" class="lp-control__link fb-tooltip fb-tooltip_control" href="#delete-tranistion" data-toggle="modal">\n' +
                        '                       <i class="ico-cross"></i>\n' +
                        '                    </a>\n' +
                        '                </li>\n' +
                        '            </ul>\n' +
                        '         </div>\n' +
                        '         <div class="fb-question-item__col fb-question-item__col_lock">\n' +
                        '              <a href="#">\n' +
                        '                 <i class="lp-icon-lock ico-lock"></i>\n' +
                        '                 <i class="ico-back"></i>\n' +
                        '                 <i class="ico-globe"></i>\n' +
                        '              </a>\n' +
                        '         </div>\n' +
                        '   </div>\n' +
                        '   </div>\n' +
                        '</div>');
                }
                var hiddenClone = jQuery('.hidden-field-active').clone();
                jQuery('.funnel-panel-hidden__sortable').append(hiddenClone).find('.hidden-field-active').removeClass('hidden-field-active');
                jQuery('.hidden-field-active').remove();
                if (jQuery('.funnel-panel__sortable > div').length > 1) {
                    $('.funnel-panel__placeholder').hide();
                    $('.funnel-panel__sortable').show();
                    $('.dropable-funnel-option').css({'height':'auto','margin':'0'});
                }
                else {
                    $('.funnel-panel__placeholder').show();
                    $('.dropable-funnel-option').css({'height':'180px','margin':'0 0 20px'});
                }
                $('.fb-tooltip_control').tooltipster({
                    parent:'.funnel-wrap',
                    delay: 0,
                    contentAsHTML:true,
                    multiple: true
                });
                $('.text-tooltip').tooltipster({
                    contentAsHTML:true
                });
                $('.text-tooltip').tooltipster('disable');
                $('.innerDropable-element .innerDropable-element .text-tooltip').tooltipster('enable');
                $('.innerDropable-element').sortable({
                    connectWith:'.funnel-panel__sortable',
                    placeholder: "inner-fb-question-item__highlight",
                    handle: ".lp-control__link_cursor_move",
                    tolerance:'pointer',
                    start:function(event,ui){
                        //$('.inner-fb-question-item__highlight').text('Drag & Drop Your Question Into Question Group');
                        $('.inner-fb-question-item__highlight').text('Drag & Drop Your Question Here');
                    },
                    stop: function (event, ui) {
                        alert(1)
                        initdragAccordion('.innerDropable-element');
                    }
                });
                initdragAccordion('.innerDropable-element');
            }else {
                ui.item.replaceWith('');
            }
            initColorChanger('.innerDropable-element');
        }
    });

    $('.fb-tooltip_control').tooltipster({
        parent:'.funnel-wrap',
        delay: 0,
        contentAsHTML:true,
        multiple: true
    });

    $('.title-tooltip').tooltipster({
        contentAsHTML:true
    });

    $('.text-tooltip').tooltipster({
        contentAsHTML:true
    });

    $('#icon-color-modal').on('shown.bs.modal', function (event) {
        $('.question-icon-text').each(function () {
            if($(this).outerWidth() > 268) {
                $('.title-tooltip').tooltipster('enable');
            }
            else {
                $('.title-tooltip').tooltipster('disable')
            }
        });
    });


    $('#icon-color-modal').on('hidden.bs.modal', function (event) {
        jQuery('.question-text').removeClass('lastQuestion-colorText');
    });

    $(document).on('click' ,'.dropable-slide-opener', function(e){
        e.preventDefault();
        var _self = jQuery(this);
        _self.toggleClass('active');
        _self.parents('.question-item').parent('.fb-question-item').find('.innerDropable-element').first().slideToggle();
    });

    // sort dragged questions by holding mouse
    $(document).on('mouseenter', '.single-question-slide', function(event) {
        setTimeout(function(){
            var handle = $( ".funnel-panel__sortable" ).sortable( "option", "handle" );
            $( ".funnel-panel__sortable" ).sortable( "option", "handle", ".single-question-slide" );
            $('.single-question-slide').css('cursor', 'move');
        }, 1000);
    });

    $(document).on('mouseleave', '.single-question-slide', function(event) {
        var handle = $( ".funnel-panel__sortable" ).sortable( "option", "handle" );
        $( ".funnel-panel__sortable" ).sortable( "option", "handle", ".lp-control__link_cursor_move" );
        $('.single-question-slide').css('cursor', 'default');
    });

    function initdragAccordion(el) {
        jQuery(el).each(function (){
            var _self = jQuery(this);
            var getLength = _self.children().length;
            if(getLength > 0) {
                _self.parent('.fb-question-item').find('.dropable-slide-opener').addClass('slide-opener');
            }
            else {
                _self.parent('.fb-question-item').find('.dropable-slide-opener').removeClass('slide-opener');
            }
        });
    }

    function initColorChanger(el) {
        jQuery(el).each(function(){
            var getCurrColor = jQuery(this).attr('data-color') || "#b6c7cd";
            jQuery(this).find('.question-text:not(.group)').css('color', getCurrColor);
        });
    }

    /**
     *
     * Thank you page
     *
     * **/
    $( "body" ).on( "change",".thktogbtn" , function(e) {
        if ($(this).is(':checked')) {
            $('.thktogbtn').not(this).each(function(){
                $(this).bootstrapToggle("off");
            });
        }else{
            $('.thktogbtn').not(this).each(function(){
                $(this).bootstrapToggle("on");
            });
        }
    });

    $('.icon-color-opener').click(function () {
        var name = ".icon-color-picker-parent";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('.icon-color-picker').ColorPicker({
        color: '#b6c7cd',
        flat: true,
        opacity: true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(500);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(500);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".icon-color-picker-parent .color-box__r .color-box__rgb").val(rgb.r);
            $(".icon-color-picker-parent .color-box__g .color-box__rgb").val(rgb.g);
            $(".icon-color-picker-parent .color-box__b .color-box__rgb").val(rgb.b);
            $(".icon-color-picker-parent .color-box__hex-block").val('#'+hex);
            $('.icon-color-opener').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('.icon-color-opener').find('.last-selected__code').text('#'+hex);
            $('.lastQuestion-colorText').css('color', rgba_fn).closest('.fb-question-item').find(' >.innerDropable-element').attr('data-color', rgba_fn);
        },
    });

    $('#msgfonttype').select2({
        // minimumResultsForSearch: -1,
        placeholder: 'Times New Roman',
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-font-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
        matcher: matchCustom,
    }).on('select2:openning', function() {
        jQuery('.select2__parent-font-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2__parent-font-type .select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-font-type .select2-dropdown').hide();
        jQuery('.select2__parent-font-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-font-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#msgfonttype').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight - 50;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-font-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#msgfonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2__parent-font-type .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-font-type .select2-selection__rendered').show();
        jQuery('.select2__parent-font-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#dfonttype').select2({
        // minimumResultsForSearch: -1,
        placeholder: 'Arial',
        width: '100%', // need to override the changed default
        dropdownParent: $('.select2__parent-dfont-type'),
        templateResult: function (data, container) {
            if (data.element) {
                var font_family = $(data.element).css("font-family")
                $(container).css('font-family', font_family );
            }
            return data.text;
        },
        matcher: matchCustom,
    }).on('select2:openning', function() {
        jQuery('.select2__parent-dfont-type .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        $(".select2__parent-dfont-type .select2-search__field").attr("placeholder", "Search....");
        jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2__parent-dfont-type .select2-dropdown').hide();
        jQuery('.select2__parent-dfont-type .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2__parent-dfont-type .select2-selection__rendered').hide();
        lpUtilities.niceScroll();
        setTimeout(function () {
            jQuery('.select2__parent-dfont-type .select2-dropdown .nicescroll-rails-vr').each(function () {
                var getindex = jQuery('#dfonttype').find(':selected').index();
                var defaultHeight = 44;
                var scrolledArea = getindex * defaultHeight - 50;
                $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                this.style.setProperty( 'opacity', '1', 'important' );
            });
        }, 400);
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2__parent-dfont-type .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#dfonttype').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
        jQuery('.select2__parent-dfont-type .select2-dropdown .nicescroll-rails-vr').each(function () {
            this.style.setProperty( 'opacity', '0', 'important' );
        });
    }).on('select2:close', function() {
        jQuery('.select2__parent-dfont-type .select2-selection__rendered').show();
        jQuery('.select2__parent-dfont-type .select2-results__options').css('pointer-events', 'none');
    });

    $('#msgfonttype').val(1);
    //*
    // ** Select2 Js Select Event
    // *

    $('#msgfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $("#mian__message").css('font-family', font_type);
        autosize.update($('textarea'));
    });
    $('#msgfontsize').on("select2:select", function () {
        var fontsize__msg = $(this).val();
        $("#mian__message").css('font-size', fontsize__msg+"px");
        autosize.update($('textarea'));
    });

    $('#dfonttype').on("select2:select", function () {
        var font_type = $(this).val();
        $("#desc__message").css('font-family', font_type);
        autosize.update($('textarea'));
    });
    $('#dfontsize').on("select2:select", function () {
        var fontsize__desc = $(this).val();
        $("#desc__message").css('font-size', fontsize__desc+"px");
        autosize.update($('textarea'));
    });


    var line_height = [
        {
            id:1,
            text:'<div class="line-height">Single</div>'
        },
        {
            id:1.15,
            text:'<div class="line-height">1.15</div>'
        },
        {
            id:1.5,
            text:'<div class="line-height"></i>1.5</div>'
        },
        {
            id:2,
            text:'<div class="line-height">Double</div>'
        }
    ];

    $('.select2-linehight-main-msg').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-mian-msg-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#mian__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-mian-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-main-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-mian-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-mian-msg-parent .select2-results__options').css('pointer-events', 'none');
    });


    $('.select2-linehight-dsc-msg').select2({
        width: '100%',
        data:line_height,
        minimumResultsForSearch: -1,
        dropdownParent: $('.select2-linehight-dsc-msg-parent'),
        templateResult: function (d) { return $(d.text); },
        templateSelection: function (d) { return $(d.text); }
    }).on("select2:select", function () {
        var $this_val = $(this).val();
        $("#desc__message").css('line-height', $this_val);
        autosize.update($('textarea'));
    }).on('select2:openning', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').hide();
        jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2-linehight-dsc-msg-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('.select2-linehight-dsc-msg').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2-linehight-dsc-msg-parent .select2-selection__rendered').show();
        jQuery('.select2-linehight-dsc-msg-parent .select2-results__options').css('pointer-events', 'none');
    });

    $('.colorSelector-mmessagecp').click(function () {
        var name = ".main-message-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $('.colorSelector-mdescp').click(function () {
        var name = ".desc-message-clr";
        lpUtilities.custom_color_picker.call(this,name);
    });

    $("#main-message-colorpicker").ColorPicker({
        color: "#707d84",
        flat: true,
        // opacity:true,

        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        // set_opacity: 0.22,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            console.info('change:'+rgba.a)
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".main-message-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".main-message-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".main-message-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".main-message-clr .color-box__hex-block").val('#'+hex);
            $("#mmessagecpval").val('#' + hex);
            $('.colorSelector-mmessagecp').css('backgroundColor', rgba_fn);
            $('#mian__message').css('color', rgba_fn);
        }
    });
    $("#desc-message-colorpicker").ColorPicker({
        color: "#3f3f3f",
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".desc-message-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".desc-message-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".desc-message-clr .color-box__b .color-box__rgb").val(rgb.b);
            $(".desc-message-clr .color-box__hex-block").val('#'+hex);
            $("#dmessagecpval").val('#' + hex);
            $('.colorSelector-mdescp').css('backgroundColor', rgba_fn);
            $('#desc__message').css('color', rgba_fn);
        }
    });

    $('.cta__message').click(function () {
        $(this).find('.text-area').focus();
    });

    $(".lp_thankyou_toggle").click(function () {
        $(".third-party__panel").slideToggle({
            start: function () {
                $(".action__link_edit").hide();
                $(".action__link_cancel").css({
                    display: "flex"
                });
            }
        });
    });

    $(".action__link_cancel").click(function () {
        $(".third-party__panel").slideToggle({
            start: function () {
                $(".action__link_edit").show();
                $(".action__link_cancel").hide();
            }
        })
    });

    $('#hidden-field-option').change(function(){
        if ($(this).is(':checked')) {
            $('.hidden-parameter-slide').slideDown();
            $('.form-control').focus();
        }else {
            $('.hidden-parameter-slide').slideUp();
            $('.form-control').blur();
        }
    });

    /* security message modal funcation */

    //*
    // ** icon size range slider
    // *

    $('.security-icon-size-parent').bootstrapSlider({
        formatter: function(value) {
            $('.security-icon-size').val(value);
            return   value +'px';
        },
        min: 12,
        max: 50,
        value: $('.security-icon-size').val(),
        tooltip: 'always',
        tooltip_position:'bottom',
    });

    //*
    // ** icon align
    // *

    $('#select2js__icon-position').select2({
        minimumResultsForSearch: -1,
        width: '173px', // need to override the changed default
        dropdownParent: $('.select2js__icon-position-parent')
    }).on('select2:openning', function() {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').css('opacity', '0');
    }).on('select2:open', function() {
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');
        setTimeout(function() {
            jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'auto');
        }, 300);
        jQuery('.select2js__icon-position-parent .select2-dropdown').hide();
        jQuery('.select2js__icon-position-parent .select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').hide();
    }).on('select2:closing', function(e) {
        if(!amIclosing) {
            e.preventDefault();
            amIclosing = true;
            jQuery('.select2js__icon-position-parent .select2-dropdown').attr('style', '');
            setTimeout(function () {
                jQuery('#select2js__icon-position').select2("close");
            }, 200);
        } else {
            amIclosing = false;
        }
    }).on('select2:close', function() {
        jQuery('.select2js__icon-position-parent .select2-selection__rendered').show();
        jQuery('.select2js__icon-position-parent .select2-results__options').css('pointer-events', 'none');
    });


    //*
    // ** color picker click event
    // *

    $('#clr-text').click(function () {
        var name = ".security-text-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#clr-icon').click(function () {
        var name = ".security-icon-clr";
        var color_box_name = $(name);
        var get_color = $(this).find('.last-selected__code').text();
        lpUtilities.custom_color_picker.call(this,name);
        lpUtilities.set_colorpicker_box(color_box_name,get_color);
    });

    $('#text-clr').ColorPicker({
        color: "#b4bbbc",
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".security-text-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".security-text-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".security-text-clr .color-box__b .color-box__rgb").val(rgb.b);
            $('.security-text-clr .color-opacity').val(rgba.a);
            $(".security-text-clr .color-box__hex-block").val('#'+hex);
            $('#clr-text').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#clr-text').find('.last-selected__code').text('#'+hex);

        }
    });
    $('#icon-clr').ColorPicker({
        color: "#24b928",
        flat: true,
        opacity:true,
        width: 203,
        height: 144,
        outer_height: 162,
        outer_width: 281,
        onShow: function (colpkr) {
            $(colpkr).fadeIn(100);
            return false;
        },
        onHide: function (colpkr) {
            $(colpkr).fadeOut(100);
            return false;
        },
        onChange: function (hsb, hex, rgb, rgba) {
            var rgba_fn = 'rgba('+rgba.r+', '+rgba.g+', '+rgba.b+', '+rgba.a+')';
            $(".security-icon-clr .color-box__r .color-box__rgb").val(rgb.r);
            $(".security-icon-clr .color-box__g .color-box__rgb").val(rgb.g);
            $(".security-icon-clr .color-box__b .color-box__rgb").val(rgb.b);
            $('.security-icon-clr .color-opacity').val(rgba.a);
            $(".security-icon-clr .color-box__hex-block").val('#'+hex);
            $('#clr-icon').find('.last-selected__box').css('backgroundColor', rgba_fn);
            $('#clr-icon').find('.last-selected__code').text('#'+hex);
        }
    });


    $('.message-icon').change(function () {
        if($(this).is(':checked')) {
            $('.icon-setting').slideDown();
            $('body').addClass('security-text-color-active');
        }else {
            $('.icon-setting').slideUp();
            $('body').removeClass('security-text-color-active');
        }
    });

    $('.txt-cta-italic').click(function () {
        $(this).toggleClass('active');
        if(jQuery(this).hasClass('active')){
            $(".form-group_security-message .form-control").css({
                'font-style': 'italic',
            });
        }
        else {
            $(".form-group_security-message .form-control").css({
                'font-style': 'normal',
            });
        }
    });

    $('.txt-cta-bold').click(function () {
        $(this).toggleClass('active');
        if(jQuery(this).hasClass('active')){
            $(".form-group_security-message .form-control").css({
                'font-weight': '700',
            });
        }
        else {
            $(".form-group_security-message .form-control").css({
                'font-weight': '600',
            });
        }
    });

    //*
    // ** add icon
    // *

    var obj_fontawsome_security = [
        "ico-lock-1",
        "ico-lock-2",
        "ico-lock-3",
        "ico-lock-5",
        "ico-lock-4",
        "ico-shield-1",
        "ico-shield-2",
        "ico-shield-3",
        "ico-shield-4",
        "ico-shield-5",
    ];

    function fontAwsome() {
        $('.icon__wrapper').html('');
        $.each(obj_fontawsome_security,function (index,value) {
            $('.icon-wrapper').append('<li><i class="ico '+value+'"></i></li>');
        });
    }
    fontAwsome();

    var $fontAsome_security;


    $('.btn-icon-wrapper').click(function () {
        $('#icon-picker').modal('show');
        var icon_class = $(this).find('i').attr('class');
        if(icon_class) {
            var new_icon =  icon_class.replace(/ /g, ".");
            var icon_exist = $('.icon-wrapper').find('.' +new_icon);
            if(icon_exist){
                $($(icon_exist)[0]).parent().addClass('active');
            }
        }
    });

    $('.btn-cancel-icon').click(function () {
        $('#icon-picker').modal('hide');
        $('.icon-wrapper li').removeClass('active');
    });

    $('body').on('click','.icon-wrapper li', function(){
        $('.icon-wrapper li').removeClass('active');
        $(this).addClass('active');
        $fontAsome_security = $(this).html();
    });

    $('.btn-add-security-icon').click(function () {
        $('.btn-icon-wrapper .icon-block').html('');
        $('.btn-icon-wrapper .icon-block').html($fontAsome_security);
        $('#icon-picker').modal('hide');
        $('#security-message-modal').modal('show');
    });

    if(jQuery(".security-modal-body").length > 0) {
        jQuery(".security-modal-body").mCustomScrollbar({
            axis: "y",
            callbacks: {
                whileScrolling: function () {
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('down up');
                },
                onScroll:function(){
                    jQuery('.color-box__panel-wrapper').css('display', 'none');
                    jQuery('.last-selected').removeClass('down up');
                },
            },
        });
    }

    if(jQuery('.color-box__panel-wrapper-holder').length > 0) {
        jQuery('.color-box__panel-wrapper-holder').mCustomScrollbar({
            axis: "y",
        });
    }
});
