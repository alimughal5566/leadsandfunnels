/**
 *
 * Color picker
 * Author: Stefan Petre www.eyecon.ro
 *
 * Dual licensed under the MIT and GPL licenses
 *
 */
(function ($) {
    var ColorPicker = function () {
        var
            currentColor = {},
            currentCal = null,
            charMin = 65,
            options,
            tpl = `<div class="custom-colorpicker">
                        <div class="picker-block">
                           <div class="colorpicker">
                               <div class="colorpicker_color">
                                  <div>
                                     <div></div>
                                  </div>
                               </div>
                               <div class="colorpicker_hue">
                                  <div></div>
                               </div>
                               <div class="colorpicker_opacity">
                                  <div></div>
                               </div>
                           </div>
                        </div>
                        <label class="color-box__label">Add custom color code</label>
                       <div class="colorpicker_new_color"></div>
                       <div class="colorpicker_current_color"></div>
                       <div class="color-box__panel-rgb-wrapper">
                           <div class="colorpicker_rgb_r colorpicker_field">R: <input type="text" maxlength="3" size="3" /><span></span></div>
                           <div class="colorpicker_rgb_g colorpicker_field">G: <input type="text" maxlength="3" size="3" /><span></span></div>
                           <div class="colorpicker_rgb_b colorpicker_field">B: <input type="text" maxlength="3" size="3" /><span></span></div>
                       </div>
                       <div class="color-box__panel-hex-wrapper">
                            <label class="color-box__hex-label">Hex code:</label>
                            <div class="colorpicker_hex"><span class="colorpicker_hex_sign">#</span><input type="text" maxlength="7" size="7" /></div>
                       </div>
                       <div class="colorpicker_hsb_h colorpicker_field colorpicker_field_hidden">
                            <input type="text" maxlength="3" size="3" /><span></span>
                       </div>
                       <div class="colorpicker_hsb_s colorpicker_field colorpicker_field_hidden"><input type="text" maxlength="3" size="3" /><span></span></div>
                       <div class="colorpicker_hsb_b colorpicker_field colorpicker_field_hidden"><input type="text" maxlength="3" size="3" /><span></span></div>
                       <div class="colorpicker_submit colorpicker_field_hidden"></div>
                    </div>`,
            // tpl = '<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_opacity"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div>' + customTpl + '<div class="colorpicker_submit"></div></div>',
            defaults = {
                eventName: 'click',
                onShow: function () {},
                onBeforeShow: function(){},
                onHide: function () {},
                onChange: function () {},
                onSubmit: function () {},
                color: 'rgb(36, 170, 242)',
                livePreview: true,
                auto_show: true,
                flat: false,
                append_to: false,
                width: 203,
                height: 144,
                outer_height: 369,
                outer_width: 330,
                set_opacity:1,
                isMousedownFired: false,
                timestamp: 0
            },
            fillRGBFields = function  (hsb, cal) {
                var rgb = HSBToRGB(hsb);
                $(cal).data('colorpicker').fields
                    .eq(0).val(rgb.r).end()
                    .eq(1).val(rgb.g).end()
                    .eq(2).val(rgb.b).end();
            },
            fillHSBFields = function  (hsb, cal) {
                var resulth = (hsb.h - Math.floor(hsb.h)) !== 0;
                var results = (hsb.s - Math.floor(hsb.s)) !== 0;
                var resultb = (hsb.b - Math.floor(hsb.b)) !== 0;
                if(resulth){
                    hsb.h =  hsb.h.toFixed(2);
                }
                if(results){
                    hsb.s =  hsb.s.toFixed(2);
                }
                if(resultb){
                    hsb.b =  hsb.b.toFixed(2);
                }
                $(cal).data('colorpicker').fields
                    .eq(4).val(hsb.h).end()
                    .eq(5).val(hsb.s).end()
                    .eq(6).val(hsb.b).end();
            },
            fillHexFields = function (hsb, cal) {
                $(cal).data('colorpicker').fields
                    .eq(3).val(HSBToHex(hsb)).end();
            },
            setSelector = function (hsb, cal) {
                $(cal).data('colorpicker').selector.css('backgroundColor', '#' + HSBToHex({h: hsb.h, s: 100, b: 100}));
                var _height = defaults.height;
                if($(cal).data('height')!=undefined){
                    _height = $(cal).data('height');
                }
                var _width = defaults.width;
                if($(cal).data('width')!=undefined){
                    _width = $(cal).data('width');
                }
                let left = parseInt(_width * hsb.s/100, 10);
                let top = parseInt(_height * (100-hsb.b)/100, 10);
                //To adjust the color pointer in the center of mouse pointer position subtracted the value by 8
                left = left-8;
                top = top-8;
                $(cal).data('colorpicker').selectorIndic.css({
                    left: left,
                    top: top
                });
            },
            setHueOpacity = function (hsb, cal) {
                var _height = defaults.height;
                if($(cal).data('height')!=undefined){
                    _height = $(cal).data('height');
                }
                $(cal).data('colorpicker').hueOpcity.css('top', parseInt(_height - _height * hsb.h/360, 10));
            },
            setHueOpacityLoad = function (opc, cal) {
                var _height = defaults.height;
                if($(cal).data('height')!=undefined){
                    _height = $(cal).data('height');
                }
                var op = 1 - opc;
                $(cal).data('colorpicker').hueOpcity.css('top', parseInt((( op * 100)*_height) / 100, 10));
            },
            setHex = function(rgba) {
                // var valArr = val.split("(")[1].split(")")[0].split(","),
                red = toHex(rgba.r),
                    green = toHex(rgba.g),
                    blue = toHex(rgba.b),
                    alpha = toHex(rgba.a*256) || 100;

                if(currentCal.data('colorpicker').set_opacity == 1){
                    return red + green + blue;
                }else{
                    return red + green + blue + alpha;
                }
            };

        toHex = function(val) {
            val = parseInt(val);
            val = Math.max(0,val);
            val = Math.min(val,255);
            val = Math.ceil(val);
            return "0123456789ABCDEF".charAt((val-val%16)/16) + "0123456789ABCDEF".charAt(val%16);
        };

        setHue = function (hsb, cal) {
            var _height = defaults.height;
            if($(cal).data('height')!=undefined){
                _height = $(cal).data('height');
            }
            $(cal).data('colorpicker').hue.css('top', parseInt(_height - _height * hsb.h/360, 10));
        },
            setCurrentColor = function (hsb, cal) {
                $(cal).data('colorpicker').currentColor.css('backgroundColor', '#' + HSBToHex(hsb));
            },
            setNewColor = function (hsb, cal) {
                var _rgba = HSBToRGB(hsb);
                currentColor = hsb;
                if($(cal).data('colorpicker').set_opacity != 1){
                    var rgba_color = 'rgba('+_rgba.r+', '+_rgba.g+', '+_rgba.b+', '+$(cal).data('colorpicker').set_opacity+')';
                    $(cal).data('colorpicker').newColor.css('backgroundColor', rgba_color);
                }else{
                    $(cal).data('colorpicker').newColor.css('backgroundColor', '#' + HSBToHex(hsb));
                }
                var _rgba_str = 'rgba('+_rgba.r+', '+_rgba.g+', '+_rgba.b+', 0)';
                var _rgb_str = 'rgb('+_rgba.r+', '+_rgba.g+', '+_rgba.b+')';
                $(cal).data('colorpicker').opacityNewColor.css({'background':'rgba(0, 0, 0, 0) linear-gradient(to top, '+_rgba_str+', '+_rgb_str+') repeat scroll 0% 0%'});
            },
            keyDown = function (ev) {
                var pressedKey = ev.charCode || ev.keyCode || -1;
                if ((pressedKey > charMin && pressedKey <= 90) || pressedKey == 32) {
                    return false;
                }
                var cal = $(this).parents(".custom-colorpicker");
                if (cal.data('colorpicker').livePreview === true) {
                    change.apply(this);
                }
            },
            changeOpacity = function (ev) {
                var cal = $(this).parents(".custom-colorpicker"), _col;
                if (this.parentNode.className.indexOf('_hex') > 0) {
                    cal.data('colorpicker').color = _col = HexToHSB(fixHex(this.value));
                } else if (this.parentNode.className.indexOf('_hsb') > 0) {
                    cal.data('colorpicker').color = _col = fixHSB({
                        h: parseInt(cal.data('colorpicker').fields.eq(4).attr('data-val'), 10),
                        s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
                    });

                    currentColor = fixHSB({
                        h: parseInt(cal.data('colorpicker').fields.eq(4).val(), 10),
                        s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
                    });
                } else {
                    cal.data('colorpicker').color = _col = RGBToHSB(fixRGB({
                        r: parseInt(cal.data('colorpicker').fields.eq(0).val(), 10),
                        g: parseInt(cal.data('colorpicker').fields.eq(1).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(2).val(), 10)
                    }));
                }
                setHueOpacity(_col, cal.get(0));
                setOpacity(_col, cal.get(0));
                currentCal = cal;

                // cal.data('colorpicker').onChange.apply(cal, [currentColor, HSBToHex(currentColor), HSBToRGB(currentColor),HSBToRGBA(currentColor)]);
                cal.data('colorpicker').onChange.apply(cal, [currentColor, HSBToHex(currentColor), HSBToRGB(currentColor),HSBToRGBA(currentColor),setHex(HSBToRGBA(currentColor))]);
            },

            isValidRGBInputValue = function (input){
                if(input.val() === "" || isNaN(parseInt(input.val()))) {
                    return false;
                }
                return true;
            },

            change = function (ev) {
                var cal = $(this).parents(".custom-colorpicker"), col;
                if (this.parentNode.className.indexOf('_hex') > 0) {
                    this.value = this.value.replace("#", '');
                    cal.data('colorpicker').color = col = HexToHSB(fixHex(this.value));
                } else if (this.parentNode.className.indexOf('_hsb') > 0) {
                    cal.data('colorpicker').color = col = fixHSB({
                        h: parseInt(cal.data('colorpicker').fields.eq(4).val(), 10),
                        s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
                    });
                } else {
                    if(isValidRGBInputValue(cal.data('colorpicker').fields.eq(0))
                        && isValidRGBInputValue(cal.data('colorpicker').fields.eq(1))
                        && isValidRGBInputValue(cal.data('colorpicker').fields.eq(2))) {
                        cal.data('colorpicker').color = col = RGBToHSB(fixRGB({
                            r: parseInt(cal.data('colorpicker').fields.eq(0).val(), 10),
                            g: parseInt(cal.data('colorpicker').fields.eq(1).val(), 10),
                            b: parseInt(cal.data('colorpicker').fields.eq(2).val(), 10)
                        }));
                    } else {
                        // displayAlert("warning", "please enter a correct code.");
                        return false;
                    }
                }
                // if (ev) {
                    fillRGBFields(col, cal.get(0));
                    fillHexFields(col, cal.get(0));
                    fillHSBFields(col, cal.get(0));
                // }
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
                currentCal = cal;
                cal.data('colorpicker').onChange.apply(cal, [col, HSBToHex(col), HSBToRGB(col), HSBToRGBA(col), setHex(HSBToRGBA(col))]);
            },
            setOpacity = function(hsb, cal){
                var _height = defaults.height;
                if($(cal).data('height')!=undefined){
                    _height = $(cal).data('height');
                }
                var opc = parseInt(_height - _height * hsb.h/360, 10);
                var _val = ((opc / _height) * 100) / 100;
                $(cal).data('colorpicker').set_opacity = 1 - _val;
            },
            HSBToRGBA = function(hsb){
                var rgba= HSBToRGB(hsb);

                if(currentCal) {
                    rgba['a'] = currentCal.data('colorpicker').set_opacity;
                } else {
                    rgba['a'] = options.set_opacity;
                }

                return rgba;
            },
            blur = function (ev) {
                var cal = $(this).parents(".custom-colorpicker");
                cal.data('colorpicker').fields.parent().removeClass('colorpicker_focus');
            },
            focus = function () {
                charMin = this.parentNode.className.indexOf('_hex') > 0 ? 70 : 65;
                $(this).parents(".custom-colorpicker").data('colorpicker').fields.parent().removeClass('colorpicker_focus');
                $(this).parent().addClass('colorpicker_focus');
            },
            downIncrement = function (ev) {
                var field = $(this).parent().find('input').focus();
                var current = {
                    el: $(this).parent().addClass('colorpicker_slider'),
                    max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
                    y: ev.pageY,
                    field: field,
                    val: parseInt(field.val(), 10),
                    preview: $(this).parents(".custom-colorpicker").data('colorpicker').livePreview
                };
                $(document).bind('mouseup', current, upIncrement);
                $(document).bind('mousemove', current, moveIncrement);
            },
            moveIncrement = function (ev) {
                ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val + ev.pageY - ev.data.y, 10))));
                if (ev.data.preview) {
                    change.apply(ev.data.field.get(0), [true]);
                }
                return false;
            },
            upIncrement = function (ev) {
                change.apply(ev.data.field.get(0), [true]);
                ev.data.el.removeClass('colorpicker_slider').find('input').focus();
                $(document).unbind('mouseup', upIncrement);
                $(document).unbind('mousemove', moveIncrement);
                return false;
            },
            downHue = function (ev) {
                var current = {
                    cal: $(this).parents(".custom-colorpicker"),
                    y: $(this).offset().top
                };
                current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upHue);
                $(document).bind('mousemove', current, moveHue);
            },
            moveHue = function (ev) {
                var _height = defaults.height;
                if(ev.data.cal.data('height')!=undefined){
                    _height = ev.data.cal.data('height');
                }
                change.apply(
                    ev.data.cal.data('colorpicker')
                        .fields
                        .eq(4)
                        .val(parseInt(360*(_height - Math.max(0,Math.min(_height,(ev.pageY - ev.data.y))))/_height, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upHue = function (ev) {
                fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                $(document).unbind('mouseup', upHue);
                $(document).unbind('mousemove', moveHue);
                return false;
            },

            downHueOpacity = function (ev) {
                var current = {
                    cal: $(this).parents(".custom-colorpicker"),
                    y: $(this).offset().top
                };
                // current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upHueOpacity);
                $(document).bind('mousemove', current, moveHueOpacity);
            },
            upHueOpacity = function (ev) {
                // fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                // fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                $(document).unbind('mouseup', upHueOpacity);
                $(document).unbind('mousemove', moveHueOpacity);
                return false;
            },
            moveHueOpacity = function (ev) {
                // console.info(ev);
                var _height = defaults.height;
                if(ev.data.cal.data('height')!=undefined){
                    _height = ev.data.cal.data('height');
                }
                changeOpacity.apply(
                    ev.data.cal.data('colorpicker')
                        .fields
                        .eq(4)
                        .attr('data-val', parseInt(360*(_height - Math.max(0,Math.min(_height,(ev.pageY - ev.data.y))))/_height, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },



            downSelector = function (ev) {
                var current = {
                    cal: $(this).parents(".custom-colorpicker"),
                    pos: $(this).offset()
                };
                current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upSelector);
                $(document).bind('mousemove', current, moveSelector);
            },

            // new opacity bar

            downOpacity = function (ev) {
                var current = {
                    cal: $(this).parents(".custom-colorpicker"),
                    y: $(this).offset().top
                };
                // current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upOpacity);
                // $(document).bind('mousemove', current, moveOpacity);
            },
            upOpacity = function (ev) {
                // fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                // fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                $(document).unbind('mouseup', upOpacity);
                // $(document).unbind('mousemove', moveOpacity);
                return false;
            },
            // moveOpacity = function (ev) {
            //     var _height = defaults.height;
            //     if(ev.data.cal.data('height')!=undefined){
            //         _height = ev.data.cal.data('height');
            //     }
            //     change.apply(
            //         ev.data.cal.data('colorpicker')
            //             .fields
            //             .eq(4)
            //             .val(parseInt(360*(_height - Math.max(0,Math.min(_height,(ev.pageY - ev.data.y))))/_height, 10))
            //             .get(0),
            //         [ev.data.preview]
            //     );
            //     return false;
            // },

            moveSelector = function (ev) {
                var _height = defaults.height;
                if(ev.data.cal.data('height')!=undefined){
                    _height = ev.data.cal.data('height');
                }
                var _width = defaults.width;
                if(ev.data.cal.data('width')!=undefined){
                    _width = ev.data.cal.data('width');
                }
                change.apply(
                    ev.data.cal.data('colorpicker')
                        .fields
                        .eq(6)
                        .val(parseInt(100*(_height - Math.max(0,Math.min(_height,(ev.pageY - ev.data.pos.top))))/_height, 10))
                        .end()
                        .eq(5)
                        .val(parseInt(100*(Math.max(0,Math.min(_width,(ev.pageX - ev.data.pos.left))))/_width, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upSelector = function (ev) {
                fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));

                /**
                 * Start LP:Custom change
                 * A30-2549 Color Picker should have to work on click anywhere
                 * Now when user click anywhere in the box than selector will be moved to location
                 * Current color will be changed to color on mouse location
                 */
                moveSelector(ev);
                //End LP:Custom change
                $(document).unbind('mouseup', upSelector);
                $(document).unbind('mousemove', moveSelector);
                return false;
            },
            enterSubmit = function (ev) {
                $(this).addClass('colorpicker_focus');
            },
            leaveSubmit = function (ev) {
                $(this).removeClass('colorpicker_focus');
            },
            clickSubmit = function (ev) {
                var cal = $(this).parents(".custom-colorpicker");
                var col = cal.data('colorpicker').color;
                cal.data('colorpicker').origColor = col;
                setCurrentColor(col, cal.get(0));
                cal.data('colorpicker').onSubmit(col, HSBToHex(col), HSBToRGB(col), cal.data('colorpicker').el);
            },
            show = function (ev) {
                let element = $(this);
                var cal = $('#' + element.data('colorpickerId'));
                cal.data('colorpicker').onBeforeShow.apply(this, [cal.get(0)]);

                let timestamp = cal.data('colorpicker').timestamp,
                    current_timestamp = new Date().getTime();
                console.log("mousedownFired", cal.data('colorpicker').isMousedownFired, current_timestamp, timestamp, (current_timestamp - timestamp));
                if(cal.data('colorpicker').isMousedownFired && current_timestamp - timestamp < 200) {
                    cal.data('colorpicker').isMousedownFired = false;
                    return false;
                }

                //This will load RGB values from Hex code again
                fillRGBFields($(cal).data('colorpicker').color, cal);
                var pos = element.offset();
                var viewPort = getViewport();
                var top = pos.top + this.offsetHeight;
                var left = pos.left;
                var outer_height = cal.outerHeight();
                var outer_width = cal.outerWidth();

                cal.removeClass("colorpicker-up colorpicker-down");
                element.removeClass("colorpicker-up colorpicker-down");

                let opts = cal.data('colorpicker');
                if(top > outer_height) {
                    if (opts.flat && !opts.auto_show) {
                        if ((viewPort.h + viewPort.t - top) > outer_height + 50) {
                            top = this.offsetHeight - 2;
                            cal.addClass("colorpicker-down");
                            element.addClass("colorpicker-down");
                        } else {
                            top = (outer_height * -1) + 1;
                            cal.addClass("colorpicker-up");
                            element.addClass("colorpicker-up");
                        }
                        left = -(outer_width - element.outerWidth() + 1);
                    } else {
                        if (viewPort.sh - top > outer_height + 50) {
                            top -= 1;
                            cal.addClass("colorpicker-down");
                            element.addClass("colorpicker-down");
                        } else {
                            top -= this.offsetHeight + outer_height - 1;
                            cal.addClass("colorpicker-up");
                            element.addClass("colorpicker-up");
                        }

                        // if (left + outer_width > viewPort.l + viewPort.w) {
                        left -= (outer_width - element.outerWidth());
                        // }
                    }
                } else {
                    top = this.offsetHeight - 2;
                    cal.addClass("colorpicker-down");
                    element.addClass("colorpicker-down");
                    left = -(outer_width - element.outerWidth() + 1);
                }
                cal.css({left: left + 'px', top: top + 'px'});
                if (cal.data('colorpicker').onShow.apply(this, [cal.get(0)]) != false) {
                    cal.show();
                }
                $(document).bind('mousedown', {cal: cal}, hide);
                return false;
            },
            hide = function (ev) {
                if (!isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
                    $(ev.data.cal).removeClass("colorpicker-up colorpicker-down");
                    $('.custom-color-picker').removeClass("colorpicker-up colorpicker-down");
                    if (ev.data.cal.data('colorpicker').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
                        ev.data.cal.data('colorpicker').isMousedownFired = true;
                        ev.data.cal.data('colorpicker').timestamp = new Date().getTime();
                        ev.data.cal.hide();
                    }
                    $(document).unbind('mousedown', hide);
                }
            },
            isChildOf = function(parentEl, el, container) {
                if (parentEl == el) {
                    return true;
                }
                if (parentEl.contains) {
                    return parentEl.contains(el);
                }
                if ( parentEl.compareDocumentPosition ) {
                    return !!(parentEl.compareDocumentPosition(el) & 16);
                }
                var prEl = el.parentNode;
                while(prEl && prEl != container) {
                    if (prEl == parentEl)
                        return true;
                    prEl = prEl.parentNode;
                }
                return false;
            },
            getViewport = function () {
                var m = document.compatMode == 'CSS1Compat';
                return {
                    l : window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
                    t : window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
                    w : window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
                    h : window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight),
                    sh: Math.max(document.body.scrollHeight, document.documentElement.scrollHeight,
                        document.body.offsetHeight, document.documentElement.offsetHeight,
                        document.body.clientHeight, document.documentElement.clientHeight)
                };
            },
            fixHSB = function (hsb) {
                return {
                    h: Math.min(360, Math.max(0, hsb.h)),
                    s: Math.min(100, Math.max(0, hsb.s)),
                    b: Math.min(100, Math.max(0, hsb.b))
                };
            },
            fixRGB = function (rgb) {
                return {
                    r: Math.min(255, Math.max(0, rgb.r)),
                    g: Math.min(255, Math.max(0, rgb.g)),
                    b: Math.min(255, Math.max(0, rgb.b))
                };
            },
            fixHex = function (hex) {
                var len = 6 - hex.length;
                if (len > 0) {
                    var o = [];
                    for (var i=0; i<len; i++) {
                        o.push('0');
                    }
                    o.push(hex);
                    hex = o.join('');
                }
                return hex;
            },
            HexToRGB = function (hex) {
                var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
                return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
            },
            HexToHSB = function (hex) {
                return RGBToHSB(HexToRGB(hex));
            },
            /**
             * TO convert RGBA string which is stored in DB to object
             */
            StringToRGBA = function(col) {
                let color = col.split(","),
                    rgba = {
                        r: parseInt(color[0].split('(')[1]),
                        g: parseInt(color[1]),
                        b: parseInt(color[2].split(')')[0])
                    };

                //setting opacity
                if(color[3] !== undefined) {
                    rgba['a'] = color[3].split(')')[0];
                }
                return rgba;
            },

            /**
             * To get RGBA string from object
             */
            getRGBAString = function(rgba){
                if(rgba.a) {
                    rgba.a = Number(rgba.a).toFixed(2);
                }
                return 'rgba(' + rgba.r + ', ' + rgba.g + ', ' + rgba.b + ', ' + rgba.a + ')';
            },

            /**
             * This will automatically set background color, code on element where colorpicker initialized
             */
            applyCustomColor = function(cal, element) {
                let colorBackground = element.find('.custom-color-bg'),
                    colorCode = element.find('.custom-color-code'),
                    colorValue = element.find('.custom-color-value');
                if(colorBackground.length || colorValue.length){
                    currentCal = cal;
                    let rgba = HSBToRGBA(cal.data('colorpicker').color),
                        color = getRGBAString(rgba);

                    if(colorBackground.length) {
                        colorBackground.css('background', color);
                    }
                    if(colorValue.length) {
                        colorValue.val(color);
                    }
                }
                if(colorCode.length) {
                    colorCode.text("#" + cal.data('colorpicker').fields.eq(3).val());
                }
            },
            RGBToHSB = function (rgb) {
                var hsb = {
                    h: 0,
                    s: 0,
                    b: 0
                };
                var min = Math.min(rgb.r, rgb.g, rgb.b);
                var max = Math.max(rgb.r, rgb.g, rgb.b);
                var delta = max - min;
                hsb.b = max;
                if (max != 0) {

                }
                hsb.s = max != 0 ? 255 * delta / max : 0;
                if (hsb.s != 0) {
                    if (rgb.r == max) {
                        hsb.h = (rgb.g - rgb.b) / delta;
                    } else if (rgb.g == max) {
                        hsb.h = 2 + (rgb.b - rgb.r) / delta;
                    } else {
                        hsb.h = 4 + (rgb.r - rgb.g) / delta;
                    }
                } else {
                    hsb.h = -1;
                }
                hsb.h *= 60;
                if (hsb.h < 0) {
                    hsb.h += 360;
                }
                hsb.s *= 100/255;
                hsb.b *= 100/255;
                return hsb;
            },
            HSBToRGB = function (hsb) {
                // var rgb = {};
                // var h = Math.round(hsb.h);
                // var s = Math.round(hsb.s*255/100);
                // var v = Math.round(hsb.b*255/100);
                // if(s == 0) {
                //     rgb.r = rgb.g = rgb.b = v;
                // } else {
                //     var t1 = v;
                //     var t2 = (255-s)*v/255;
                //     var t3 = (t1-t2)*(h%60)/60;
                //     if(h==360) h = 0;
                //     if(h<60) {rgb.r=t1;	rgb.b=t2; rgb.g=t2+t3}
                //     else if(h<120) {rgb.g=t1; rgb.b=t2;	rgb.r=t1-t3}
                //     else if(h<180) {rgb.g=t1; rgb.r=t2;	rgb.b=t2+t3}
                //     else if(h<240) {rgb.b=t1; rgb.r=t2;	rgb.g=t1-t3}
                //     else if(h<300) {rgb.b=t1; rgb.g=t2;	rgb.r=t2+t3}
                //     else if(h<360) {rgb.r=t1; rgb.g=t2;	rgb.b=t1-t3}
                //     else {rgb.r=0; rgb.g=0;	rgb.b=0}
                // }
                // return {r:Math.round(rgb.r), g:Math.round(rgb.g), b:Math.round(rgb.b)};
                //
                let h = hsb.h,
                    s =  hsb.s / 100,
                    b = hsb.b / 100;
                const k = (n) => (n + h / 60) % 6;
                const f = (n) => b * (1 - s * Math.max(0, Math.min(k(n), 4 - k(n), 1)));
                return {r:Math.round(255 * f(5)), g:Math.round(255 * f(3)), b:Math.round(255 * f(1))};
            },
            RGBToHex = function (rgb) {
                var hex = [
                    rgb.r.toString(16),
                    rgb.g.toString(16),
                    rgb.b.toString(16)
                ];
                $.each(hex, function (nr, val) {
                    if (val.length == 1) {
                        hex[nr] = '0' + val;
                    }
                });
                return hex.join('');
            },
            HSBToHex = function (hsb) {
                return RGBToHex(HSBToRGB(hsb));
            },
            restoreOriginal = function () {
                var cal = $(this).parents(".custom-colorpicker");
                var col = cal.data('colorpicker').origColor;
                cal.data('colorpicker').color = col;
                fillRGBFields(col, cal.get(0));
                fillHexFields(col, cal.get(0));
                fillHSBFields(col, cal.get(0));
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
            };
        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt||{});
                if (typeof opt.color == 'string') {
                    if(opt.color.indexOf('rgba')>-1 || opt.color.indexOf('rgb')>-1){
                        let rgba = StringToRGBA(opt.color);
                        //setting opacity
                        if(rgba['a'] !== undefined) {
                            opt.set_opacity = rgba['a'];
                            delete rgba['a'];
                        }
                        opt.color = RGBToHSB(rgba);
                    } else {
                        opt.color = HexToHSB(opt.color);
                    }
                } else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
                    opt.color = RGBToHSB(opt.color);
                } else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
                    opt.color = fixHSB(opt.color);
                } else {
                    return this;
                }
                return this.each(function () {
                    if (!$(this).data('colorpickerId')) {
                        options = $.extend({}, opt);
                        options.origColor = opt.color;
                        var id = 'collorpicker_' + parseInt(Math.random() * 1000);
                        $(this).data('colorpickerId', id);
                        var cal = $(tpl).attr('id', id);
                        if(opt.opacity && (typeof(opt.opacityVal)=='number') ){
                            cal.find('div.colorpicker_hue')
                            opacity = opt.opacityVal;
                        }

                        if(options.width!=undefined){
                            cal.data('width', options.width);
                            cal.attr('data-width', options.width);
                        }

                        if(options.custom_class !== undefined){
                            cal.addClass(options.custom_class);
                        }

                        if(options.height!=undefined){
                            cal.data('height', options.height);
                            cal.attr('data-height', options.height);
                        }

                        if(options.outer_width!=undefined){
                            cal.data('outer_width', options.outer_width);
                            cal.attr('data-outer_width', options.outer_width);
                        }

                        if(options.outer_height!=undefined){
                            cal.data('outer_height', opt.outer_height);
                            cal.attr('data-outer_height', opt.outer_height);
                        }

                        if (options.flat) {
                            if(options.append_to !== undefined && $(this).parents(options.append_to).length) {
                                cal.appendTo($(this).parents(options.append_to));
                            } else {
                                cal.appendTo(this);
                            }
                        } else {
                            cal.appendTo(document.body);
                        }
                        cal = $($("#" + id).get(0));
                        options.fields = cal
                            .find('input')
                            .bind('keyup', keyDown)
                            .bind('change', change)
                            .bind('blur', blur)
                            .bind('focus', focus);
                        cal
                            .find('span').bind('mousedown', downIncrement).end()
                            .find('>div.colorpicker_current_color').bind('click', restoreOriginal);
                        options.selector = cal.find('div.colorpicker_color').bind('mousedown', downSelector);
                        options.selectorIndic = options.selector.find('div div');
                        options.el = this;
                        options.hue = cal.find('div.colorpicker_hue div');
                        options.hueOpcity = cal.find('div.colorpicker_opacity div');

                        cal.find('div.colorpicker_hue').bind('mousedown', downHue);
                        cal.find('div.colorpicker_opacity').bind('mousedown', downHueOpacity);
                        cal.find('div.colorpicker_opacity').bind('mousedown', downOpacity);

                        options.newColor = cal.find('div.colorpicker_new_color');
                        options.opacityNewColor = cal.find('div.colorpicker_opacity');
                        options.currentColor = cal.find('div.colorpicker_current_color');
                        cal.data('colorpicker', options);
                        cal.find('div.colorpicker_submit')
                            .bind('mouseenter', enterSubmit)
                            .bind('mouseleave', leaveSubmit)
                            .bind('click', clickSubmit);
                        fillRGBFields(options.color, cal.get(0));
                        fillHSBFields(options.color, cal.get(0));
                        fillHexFields(options.color, cal.get(0));
                        setHue(options.color, cal.get(0));
                        setSelector(options.color, cal.get(0));
                        setCurrentColor(options.color, cal.get(0));
                        setNewColor(options.color, cal.get(0));
                        setHueOpacityLoad(options.set_opacity,cal.get(0));

                        if (options.flat && options.auto_show) {
                            cal.css({
                                position: 'relative',
                                display: 'block'
                            });
                        } else {
                            $(this).bind(options.eventName, show);
                        }
                    }
                });
            },

            showPicker: function() {
                return this.each( function () {
                    if ($(this).data('colorpickerId')) {
                        show.apply(this);
                    }
                });
            },
            hidePicker: function() {
                return this.each( function () {
                    if ($(this).data('colorpickerId')) {
                        $('#' + $(this).data('colorpickerId')).hide();
                    }
                });
            },
            setColor: function(col) {
                let opacity;
                if (typeof col == 'string') {
                    if(col.indexOf('rgba')>-1 || col.indexOf('rgb')>-1){
                        let rgba = StringToRGBA(col);
                        //setting opacity
                        if(rgba['a'] !== undefined) {
                            opacity = rgba['a'];
                            delete rgba['a'];
                        }
                        col = RGBToHSB(rgba);
                    } else {
                        col = HexToHSB(col);
                    }
                } else if (col.r != undefined && col.g != undefined && col.b != undefined) {
                    col = RGBToHSB(col);
                } else if (col.h != undefined && col.s != undefined && col.b != undefined) {
                    col = fixHSB(col);
                } else {
                    return this;
                }
                return this.each(function(){
                    if ($(this).data('colorpickerId')) {
                        let element = $(this),
                            cal = $('#' + element.data('colorpickerId'));
                        cal.data('colorpicker').color = col;
                        cal.data('colorpicker').origColor = col;
                        fillRGBFields(col, cal.get(0));
                        fillHSBFields(col, cal.get(0));
                        fillHexFields(col, cal.get(0));
                        setHue(col, cal.get(0));
                        setSelector(col, cal.get(0));
                        setCurrentColor(col, cal.get(0));
                        setNewColor(col, cal.get(0));
                        if(opacity) {
                            cal.data('colorpicker').set_opacity = opacity;
                            setHueOpacityLoad(opacity, cal.get(0));
                        }
                        applyCustomColor(cal, element);
                    }
                });
            },
            setPickerOpacity: function(opacity) {
                return this.each( function () {
                    if ($(this).data('colorpickerId')) {
                        currentCal = $('#' + $(this).data('colorpickerId'));
                        currentCal.data('colorpicker').set_opacity = opacity;
                        setHueOpacityLoad(opacity, currentCal.get(0));
                    }
                });
            }
        };
    }();
    $.fn.extend({
        ColorPicker: ColorPicker.init,
        ColorPickerHide: ColorPicker.hidePicker,
        ColorPickerShow: ColorPicker.showPicker,
        ColorPickerSetColor: ColorPicker.setColor,
        ColorPickerSetOpacity: ColorPicker.setPickerOpacity
    });
})(jQuery)
