window.selectItems = {
    'theme-select':[
        {
            id: 'select',
            text: '<div class="options-style placeholder-text">select theme</div>',
            title: 'select theme'
        },
        {
            id: '1',
            text: '<div class="options-style">leadPops Default</div>',
                title: 'leadPops Default'
        },
        {
            id: 'center',
            text: '<div class="options-style">Dark-Blue w/o background</div>',
            title: 'Descending'
        },
        {
            id: 'manage',
            text: '<div class="options-style placeholder-text"><i class="icon ico-settings"></i>manage themes</div>',
            title: 'manage themes'
        },
    ],
    'layout-select':[
        {
            id: '0',
            text: '<div class="options-style">Boxed</div>',
            title: 'Boxed'
        },
        {
            id: '1',
            text: '<div class="options-style">Full - Width</div>',
            title: 'Full - Width'
        },
    ],
};

var theme = {

    theme_select_list : [
        {selecter:".theme-select", parent:".theme-select-parent"},
        {selecter:".layout-select", parent:".layout-select-parent"},
    ],

    /*
    ** custom select loop
    **/
    allCustomSelect: function () {
        var selectlist = theme.theme_select_list;
        for(var i = 0; i < selectlist.length; i++){
            theme.initCustomSelect(selectlist[i].selecter,selectlist[i].parent);
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
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    jQuery(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
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

        if (selectorClass == 'theme-select') {
            _selector.val(1).trigger('change');
            _selector.on('change', function () {
                if(jQuery(this).val() == 'manage') {
                    jQuery('#manage-theme').modal('show');
                }
            });
        }
    },

    initCodeSwitcher: function () {
      jQuery('.code-switcher').change(function () {
         if(jQuery(this).is(':checked')) {
             jQuery(this).parents('.code-wrap-area').find('.code-slide').stop().slideDown(function(){
                 theme.initCodemirrorRefresh();
             });
         }

         else {
             jQuery(this).parents('.code-wrap-area').find('.code-slide').stop().slideUp();
         }
      });
    },


    initCodemirror: function(){
        // set minimum number of lines CodeMirror instance is allowed to have
        (function (mod) {
            mod(CodeMirror);
        })(function (CodeMirror) {
            var fill = function (cm, start, n) {
                while (start < n) {
                    let count = cm.lineCount();
                    cm.replaceRange("\n", { line: count - 1 }), start++;
                    // remove new line change from history (otherwise user could ctrl+z to remove line)
                    let history = cm.getHistory();
                    history.done.pop(), history.done.pop();
                    cm.setHistory(history);
                    if (start == n) break;
                }
            };
            var pushLines = function (cm, selection, n) {
                // push lines to last change so that "undo" doesn't add lines back
                var line = cm.lineCount() - 1;
                var history = cm.getHistory();
                history.done[history.done.length - 2].changes.push({
                    from: {
                        line: line - n,
                        ch: cm.getLine(line - n).length,
                        sticky: null
                    },
                    text: [""],
                    to: { line: line, ch: 0, sticky: null }
                });
                cm.setHistory(history);
                cm.setCursor({ line: selection.start.line, ch: selection.start.ch });
            };

            var keyMap = {
                Backspace: function (cm) {
                    var cursor = cm.getCursor();
                    var selection = {
                        start: cm.getCursor(true),
                        end: cm.getCursor(false)
                    };

                    // selection
                    if (selection.start.line !== selection.end.line) {
                        let func = function (e) {
                            var count = cm.lineCount(); // current number of lines
                            var n = cm.options.minLines - count; // lines needed
                            if (e.key == "Backspace" || e.code == "Backspace" || e.which == 8) {
                                fill(cm, 0, n);
                                if (count <= cm.options.minLines) pushLines(cm, selection, n);
                            }
                            cm.display.wrapper.removeEventListener("keydown", func);
                        };
                        cm.display.wrapper.addEventListener("keydown", func); // fires after CodeMirror.Pass

                        return CodeMirror.Pass;
                    } else if (selection.start.ch !== selection.end.ch) return CodeMirror.Pass;

                    // cursor
                    var line = cm.getLine(cursor.line);
                    var prev = cm.getLine(cursor.line - 1);
                    if (
                        cm.lineCount() == cm.options.minLines &&
                        prev !== undefined &&
                        cursor.ch == 0
                    ) {
                        if (line.length) {
                            // add a line because this line will be attached to previous line per default behaviour
                            cm.replaceRange("\n", { line: cm.lineCount() - 1 });
                            return CodeMirror.Pass;
                        } else cm.setCursor(cursor.line - 1, prev.length); // set cursor at end of previous line
                    }
                    if (cm.lineCount() > cm.options.minLines || cursor.ch > 0)
                        return CodeMirror.Pass;
                },
                Delete: function (cm) {
                    var cursor = cm.getCursor();
                    var selection = {
                        start: cm.getCursor(true),
                        end: cm.getCursor(false)
                    };

                    // selection
                    if (selection.start.line !== selection.end.line) {
                        let func = function (e) {
                            var count = cm.lineCount(); // current number of lines
                            var n = cm.options.minLines - count; // lines needed
                            if (e.key == "Delete" || e.code == "Delete" || e.which == 46) {
                                fill(cm, 0, n);
                                if (count <= cm.options.minLines) pushLines(cm, selection, n);
                            }
                            cm.display.wrapper.removeEventListener("keydown", func);
                        };
                        cm.display.wrapper.addEventListener("keydown", func); // fires after CodeMirror.Pass

                        return CodeMirror.Pass;
                    } else if (selection.start.ch !== selection.end.ch) return CodeMirror.Pass;

                    // cursor
                    var line = cm.getLine(cursor.line);
                    if (cm.lineCount() == cm.options.minLines) {
                        if (
                            cursor.ch == 0 &&
                            (line.length !== 0 || cursor.line == cm.lineCount() - 1)
                        )
                            return CodeMirror.Pass;
                        if (cursor.ch == line.length && cursor.line + 1 < cm.lineCount()) {
                            // add a line because next line will be attached to this line per default behaviour
                            cm.replaceRange("\n", { line: cm.lineCount() - 1 });
                            return CodeMirror.Pass;
                        } else if (cursor.ch > 0) return CodeMirror.Pass;
                    } else return CodeMirror.Pass;
                }
            };

            var onCut = function (cm) {
                var selection = {
                    start: cm.getCursor(true),
                    end: cm.getCursor(false)
                };
                setTimeout(function () {
                    // wait until after cut is complete
                    var count = cm.lineCount(); // current number of lines
                    var n = cm.options.minLines - count; // lines needed
                    fill(fm, 0, n);
                    if (count <= cm.options.minLines) pushLines(cm, selection, n);
                });
            };

            var start = function (cm) {
                // set minimum number of lines on init
                var count = cm.lineCount(); // current number of lines
                cm.setCursor(count); // set the cursor at the end of existing content
                fill(cm, 0, cm.options.minLines - count);

                cm.addKeyMap(keyMap);

                // bind events
                cm.display.wrapper.addEventListener("cut", onCut, true);
            };
            var end = function (cm) {
                cm.removeKeyMap(keyMap);

                // unbind events
                cm.display.wrapper.removeEventListener("cut", onCut, true);
            };

            CodeMirror.defineOption("minLines", undefined, function (cm, val, old) {
                if (val !== undefined && val > 0) start(cm);
                else end(cm);
            });
        });

        const $ = function (selector, bind) {
            var bind = bind === undefined ? document : bind;
            let nodes = bind.querySelectorAll.bind(bind)(selector);
            return nodes.length == 1 ? nodes[0] : nodes;
        };

        var code = $(".codemirror-textarea");
        var editor = CodeMirror.fromTextArea(code, {
            autoRefresh: true,
            firstLineNumber: 1,
            lineNumbers: true,
            smartIndent: true,
            lineWrapping: true,
            indentWithTabs: true,
            refresh: true,
            minLines: 14

        });

        var code_alt = $(".codemirror-textarea-modal");
        var editor_alt = CodeMirror.fromTextArea(code_alt, {
            autoRefresh: true,
            firstLineNumber: 1,
            lineNumbers: true,
            smartIndent: true,
            lineWrapping: true,
            indentWithTabs: true,
            refresh: true,
            minLines: 20
        });
    },

    initModalCode: function () {
        jQuery('.custom-code-theme').on('shown.bs.modal', function () {
            theme.initCodemirrorRefresh();
        });
    },

    initCodemirrorRefresh: function () {
        $('.CodeMirror').each(function(i, el){
            el.CodeMirror.refresh();
        });
    },

    initResetCode: function() {
      jQuery('.clear-code').click(function(e){
          e.preventDefault();
          var codemirror = $('.codemirror-textarea').nextAll('.CodeMirror')[0].CodeMirror;
          codemirror.getDoc().setValue("");
      });
        jQuery('.code-reset').click(function(e){
            e.preventDefault();
            var codemirror = $('.codemirror-textarea-modal').nextAll('.CodeMirror')[0].CodeMirror;
            codemirror.getDoc().setValue("");
        });
    },

    init: function () {
        theme.allCustomSelect();
        theme.initCodeSwitcher();
        theme.initCodemirror();
        theme.initResetCode();
        theme.initModalCode();
    },
};

jQuery(document).ready(function () {
    theme.init();
});
