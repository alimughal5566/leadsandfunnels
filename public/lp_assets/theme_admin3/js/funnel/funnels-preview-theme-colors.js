<!-- dyanmic colors for funnel builder funnel questions -->
let fuunnel_theme_primary = window.parent.$('#theme_color').val();
let fuunnel_theme_secondary = "#ebebeb";
let styles = `
    .question-preview-parent .form-control.filled,
    .question-preview-parent .form-control:focus,
    .question-preview-parent .input-wrap.focused,
    .question-preview-parent .input-wrap._focused_,
    .question_answer .input-wrap._focused_ .form-control,
    .question_contact-info .form-group:first-child .input-wrap.field-focus,
    .question_dropdown .multi-check-list input[type="checkbox"]:checked + .fake-label:before,
    .question_dropdown .multi-check-list .fake-label:hover:before,
    .question_menu .radio-button,
    .search-mode-area .search-box__list input[type="checkbox"]:checked + .fake-label:before,
    .search-mode-area .search-box__list .fake-label:hover:before,
    .question_menu .checkbox-button,
    .question_menu .checkbox-button.active .fake-input,
    .question_menu .checkbox-button.active,
    .question_menu .input-wrap-other.focused .form-control {
        border-color: ` + fuunnel_theme_primary + ` !important;
    }

    .question_zip-code .states-box,
    .question_slider .range-slider .slider-handle,
    .question_slider .range-slider .slider-selection,
    .question_birthday .field-opener,
    .question_birthday .dropdown-holder .dropdown-wrap,
    .question_dropdown .multi-select-opener-wrap,
    .question_dropdown .multi-select-dropdown,
    .question_vehicle .single-select-opener-wrap,
    .question_vehicle .single-select-dropdown,
    .question_menu .radio-button,
    .question_dropdown .single-select-opener-wrap,
    .question_dropdown .single-select-dropdown,
    .search-mode-area .search-box,
    .search-mode-area .tag-box__list .tag-text,
    .question_menu .checkbox-button,
    .question_slider .range-slider .slider-handle:before,
    .search-tag-text {
        background-color: ` + fuunnel_theme_primary + ` !important;
    }

    .question_zip-code .states-box .states:hover,
    .question_zip-code .states-box .states.hover,
    .question_zip-code .states-box .states.selected,
    .question_zip-code .states-box .states:after,
    .question_slider .range-slider .current-val,
    .question_slider .range-slider__value,
    .question_birthday .list-options a:hover,
    .question_birthday .list-options a.active,
    .question_dropdown .multi-check-list .fake-label:hover,
    .question_dropdown .multi-check-list input[type="checkbox"]:checked + .fake-label,
    .question_dropdown .multi-check-list .fake-label:after,
    .question_dropdown .multi-select-dropdown .finish-btn,
    .question_dropdown .multi-select-area__tag .tag-text,
    .question_vehicle .single-select-list a.selected,
    .question_vehicle .single-select-list a:hover,
    .question_vehicle .single-select-list a.hover,
    .question_vehicle .single-select-list a:before,
    .question_menu .radio-button.active,
    .question_menu .input-wrap .icon-valid,
    .question_dropdown .single-select-list a.selected,
    .question_dropdown .single-select-list a:before,
    .question_dropdown .input-wrap-other .other-input label,
    .question_dropdown .single-select-list a:hover,
    .question_dropdown .single-select-list a.hover,
    .question_dropdown .single-finish-btn,
    .search-mode-area .search-box__list .fake-label:hover,
    .search-mode-area .search-box__list input[type="checkbox"]:checked + .fake-label,
    .search-mode-area .search-box .finish-btn,
    .search-mode-area .search-box__list .fake-label:after,
    .question_menu .checkbox-button.active,
    .search-mode-area .single-search-option-list a:hover,
    .search-mode-area .single-search-option-list a.hover,
    .search-mode-area .single-search-option-list a.selected,
     .search-mode-area .single-search-option-list a:hover:before,
    .search-mode-area .single-search-option-list a.hover:before,
    .search-mode-area .single-search-option-list a.selected:before {
        color: ` + fuunnel_theme_primary + ` !important;
    }

    .question_dropdown .multi-select-area__tag .tag-text:hover,
    .question_dropdown .multi-select-area__tag .tag-text.focus {
        color: #fff !important;
    }

    .question_menu .radio-button.active,
    .question_menu .checkbox-button.active {
        background: #fff !important;
    }

    .question_zip-code.question-preview-parent .states-box .mCSB_scrollTools .mCSB_draggerRail,
    .question_zip-code.question-preview-parent .states-box .mCSB_scrollTools,
    .question_birthday .mCSB_scrollTools .mCSB_draggerRail,
    .question_birthday .mCSB_scrollTools,
    .question_dropdown .mCSB_scrollTools .mCSB_draggerRail,
    .question_dropdown .mCSB_scrollTools,
    .question_vehicle .mCSB_scrollTools .mCSB_draggerRail,
    .question_vehicle .mCSB_scrollTools {
        background: ` + fuunnel_theme_secondary + ` !important;
    }

    `;
$('head').append('<style type="text/css">' + styles + '</style>');
