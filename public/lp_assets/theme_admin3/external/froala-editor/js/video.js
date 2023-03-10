/*!
 * froala_editor v4.0.5 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2021 Froala Labs
 */

!(function (e, t) {
    "object" == typeof exports && "undefined" != typeof module ? t(require("froala-editor")) : "function" == typeof define && define.amd ? define(["froala-editor"], t) : t(e.FroalaEditor);
})(this, function (we) {
    "use strict";
    (we = we && we.hasOwnProperty("default") ? we["default"] : we),
        Object.assign(we.POPUP_TEMPLATES, { "video.insert": "[_BUTTONS_][_BY_URL_LAYER_][_EMBED_LAYER_][_UPLOAD_LAYER_][_PROGRESS_BAR_]", "video.edit": "[_BUTTONS_]", "video.size": "[_BUTTONS_][_SIZE_LAYER_]" }),
        Object.assign(we.DEFAULTS, {
            videoAllowedTypes: ["mp4", "webm", "ogg", "mp3", "mpeg", "url"],
            videoAllowedProviders: [".*"],
            videoDefaultAlign: "center",
            videoDefaultDisplay: "block",
            videoDefaultWidth: 600,
            videoEditButtons: ["videoReplace", "videoRemove", "videoDisplay", "videoAlign", "videoSize", "autoplay"],
            videoInsertButtons: ["videoBack", "|", "videoByURL", "videoEmbed", "videoUpload"],
            videoMaxSize: 52428800,
            videoMove: !0,
            videoResize: !0,
            videoResponsive: !1,
            videoSizeButtons: ["videoBack", "|"],
            videoSplitHTML: !1,
            videoTextNear: !0,
            videoUpload: !0,
            videoUploadMethod: "POST",
            videoUploadParam: "file",
            videoUploadParams: {},
            videoUploadToS3: !1,
            videoUploadToAzure: !1,
            videoUploadURL: null,
            isVideoInsertByUrlIFrame: true,
            videoInsertByUrlFromat: "<a href='{url}' target='_blank'><img src='https://images.lp-images1.com/default/images/play-icon.png' width='100'></a>"
        }),
        (we.VIDEO_PROVIDERS = [
            {
                test_regex: /^.*((youtu.be)|(youtube.com))\/((v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))?\??v?=?([^#\&\?]*).*/,
                url_regex: /(?:https?:\/\/)?(?:www\.)?(?:m\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=|embed\/)?([0-9a-zA-Z_\-]+)(.+)?/g,
                url_text: "https://www.youtube.com/embed/$1?$2",
                html: '<iframe width="640" height="360" src="{url}&wmode=opaque&rel=0" frameborder="0" allowfullscreen></iframe>',
                provider: "youtube",
            },
            {
                test_regex: /^.*(?:vimeo.com)\/(?:channels(\/\w+\/)?|groups\/*\/videos\/\u200b\d+\/|video\/|)(\d+)(?:$|\/|\?)/,
                url_regex: /(?:https?:\/\/)?(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:[a-zA-Z0-9_\-]+)?(\/[a-zA-Z0-9_\-]+)?/i,
                url_text: "https://player.vimeo.com/video/$1",
                html: '<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',
                provider: "vimeo",
            },
            {
                test_regex: /^.+(dailymotion.com|dai.ly)\/(video|hub)?\/?([^_]+)[^#]*(#video=([^_&]+))?/,
                url_regex: /(?:https?:\/\/)?(?:www\.)?(?:dailymotion\.com|dai\.ly)\/(?:video|hub)?\/?(.+)/g,
                url_text: "https://www.dailymotion.com/embed/video/$1",
                html: '<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',
                provider: "dailymotion",
            },
            {
                test_regex: /^.+(screen.yahoo.com)\/[^_&]+/,
                url_regex: "",
                url_text: "",
                html: '<iframe width="640" height="360" src="{url}?format=embed" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>',
                provider: "yahoo",
            },
            {
                test_regex: /^.+(rutube.ru)\/[^_&]+/,
                url_regex: /(?:https?:\/\/)?(?:www\.)?(?:rutube\.ru)\/(?:video)?\/?(.+)/g,
                url_text: "https://rutube.ru/play/embed/$1",
                html: '<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>',
                provider: "rutube",
            },
            {
                test_regex: /^(?:.+)vidyard.com\/(?:watch)?\/?([^.&/]+)\/?(?:[^_.&]+)?/,
                url_regex: /^(?:.+)vidyard.com\/(?:watch)?\/?([^.&/]+)\/?(?:[^_.&]+)?/g,
                url_text: "https://play.vidyard.com/$1",
                html: '<iframe width="640" height="360" src="{url}" frameborder="0" allowfullscreen></iframe>',
                provider: "vidyard",
            },
        ]),
        (we.VIDEO_EMBED_REGEX = /^\W*((<iframe(.|\n)*>(\s|\n)*<\/iframe>)|(<embed(.|\n)*>))\W*$/i),
        (we.PLUGINS.video = function (w) {
            var s,
                p,
                f,
                E,
                i,
                o,
                A = w.$,
                C = "https://i.froala.com/upload",
                c = 2,
                v = 3,
                u = 4,
                S = 5,
                U = 6,
                r = {};
            function g() {
                var e = w.popups.get("video.insert");
                e.find(".fr-video-by-url-layer input").val("").trigger("change");
                var t = e.find(".fr-video-embed-layer textarea");
                t.val("").trigger("change"), (t = e.find(".fr-video-upload-layer input")).val("").trigger("change");
            }
            function a() {
                var e = w.popups.get("video.edit");
                if (
                    (e ||
                    (e = (function n() {
                        var e = "";
                        if (0 < w.opts.videoEditButtons.length) {
                            w.opts.videoResponsive &&
                            (-1 < w.opts.videoEditButtons.indexOf("videoSize") && w.opts.videoEditButtons.splice(w.opts.videoEditButtons.indexOf("videoSize"), 1),
                            -1 < w.opts.videoEditButtons.indexOf("videoDisplay") && w.opts.videoEditButtons.splice(w.opts.videoEditButtons.indexOf("videoDisplay"), 1),
                            -1 < w.opts.videoEditButtons.indexOf("videoAlign") && w.opts.videoEditButtons.splice(w.opts.videoEditButtons.indexOf("videoAlign"), 1));
                            var t = { buttons: (e += '<div class="fr-buttons"> \n      '.concat(w.button.buildList(w.opts.videoEditButtons), " \n      </div>")) },
                                o = w.popups.create("video.edit", t);
                            return (
                                w.events.$on(w.$wp, "scroll.video-edit", function () {
                                    E && w.popups.isVisible("video.edit") && (w.events.disableBlur(), y(E));
                                }),
                                    o
                            );
                        }
                        return !1;
                    })()),
                        e)
                ) {
                    w.popups.setContainer("video.edit", w.$sc), w.popups.refresh("video.edit");
                    var t = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video")),
                        o = t.offset().left + t.outerWidth() / 2,
                        i = t.offset().top + t.outerHeight(),
                        r = t.get(0).src ? t.get(0).src : t.get(0).currentSrc,
                        a = !(!(r = (r = r.split("."))[r.length - 1]).includes("pdf") && !r.includes("txt"));
                    t.hasClass("fr-file") || a || E.find("audio").get(0)
                        ? (document.getElementById("autoplay-".concat(w.id)) && (document.getElementById("autoplay-".concat(w.id)).style.display = "none"),
                        document.getElementById("videoReplace-".concat(w.id)) && (document.getElementById("videoReplace-".concat(w.id)).style.display = "none"))
                        : (document.getElementById("autoplay-".concat(w.id)) && (document.getElementById("autoplay-".concat(w.id)).style.display = ""),
                        document.getElementById("videoReplace-".concat(w.id)) && (document.getElementById("videoReplace-".concat(w.id)).style.display = "")),
                        w.popups.show("video.edit", o, i, t.outerHeight(), !0);
                }
            }
            function n(e) {
                if (e) return w.popups.onRefresh("video.insert", g), w.popups.onHide("video.insert", J), !0;
                var t = "";
                w.opts.videoUpload || -1 === w.opts.videoInsertButtons.indexOf("videoUpload") || w.opts.videoInsertButtons.splice(w.opts.videoInsertButtons.indexOf("videoUpload"), 1);
                var o = w.button.buildList(w.opts.videoInsertButtons);
                "" !== o && (t = '<div class="fr-buttons">' + o + "</div>");
                var i,
                    r = "",
                    a = w.opts.videoInsertButtons.indexOf("videoUpload"),
                    n = w.opts.videoInsertButtons.indexOf("videoByURL"),
                    s = w.opts.videoInsertButtons.indexOf("videoEmbed");
                if (0 <= n) {
                    (i = " fr-active"), ((a < n && 0 <= a) || (s < n && 0 <= s)) && (i = "");
                    r = '<div class="fr-video-by-url-layer fr-layer'
                        .concat(i, '" id="fr-video-by-url-layer-')
                        .concat(w.id, '"><div class="fr-input-line"><input id="fr-video-by-url-layer-text-')
                        .concat(w.id, '" type="text" placeholder="')
                        .concat(
                            w.language.translate("Paste in a video URL"),
                            '" tabIndex="1" aria-required="true"></div><div class="fr-action-buttons"><span style=\'float:left\'><div class="fr-checkbox-line fr-autoplay-margin"><label class="fr-checkbox-area"><span class="fr-checkbox"> <input id=\'videoPluginAutoplay\'' +
                            ' data-checked="_blank"' +
                            ' type="checkbox"><strong class="label-text"><strong class="icon-wrap"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="10" viewBox="0 0 32 32"><path d="M27 4l-15 15-7-7-5 5 12 12 20-20z" fill="#FFF"></path></svg></strong>Autoplay</strong><span></label>'
                        )
                        .concat(
                            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="10" height="10" viewBox="0 0 32 32"><path d="M27 4l-15 15-7-7-5 5 12 12 20-20z" fill="#FFF"></path></svg>',
                            '</span></span> <label class="sub-label-video" id="fr-label-target-'
                        )
                        .concat(w.id, '">Autoplay</label></div> </span><button type="button" class="fr-command fr-submit" data-cmd="videoInsertByURL" tabIndex="2" role="button">')
                        .concat(w.language.translate("Insert"), "</button></div></div>");
                }
                var d = "";
                0 <= s &&
                ((i = " fr-active"),
                ((a < s && 0 <= a) || (n < s && 0 <= n)) && (i = ""),
                    (d = '<div class="fr-video-embed-layer fr-layer'
                        .concat(i, '" id="fr-video-embed-layer-')
                        .concat(w.id, '"><div class="fr-input-line"><textarea id="fr-video-embed-layer-text')
                        .concat(w.id, '" type="text" placeholder="')
                        .concat(
                            w.language.translate("Embedded Code"),
                            '" tabIndex="1" aria-required="true" rows="5"></textarea></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="videoInsertEmbed" tabIndex="2" role="button">'
                        )
                        .concat(w.language.translate("Insert"), "</button></div></div>")));
                var l = "";
                0 <= a &&
                ((i = " fr-active"),
                ((s < a && 0 <= s) || (n < a && 0 <= n)) && (i = ""),
                    (l = '<div class="fr-video-upload-layer fr-layer'
                        .concat(i, '" id="fr-video-upload-layer-')
                        .concat(w.id, '"><strong>')
                        .concat(w.language.translate("Drop video"), "</strong><br>(")
                        .concat(w.language.translate("or click"), ')<div class="fr-form"><input type="file" accept="video/')
                        .concat(w.opts.videoAllowedTypes.join(", video/").toLowerCase(), '" tabIndex="-1" aria-labelledby="fr-video-upload-layer-')
                        .concat(w.id, '" role="button"></div></div>')));
                var p = {
                        buttons: t,
                        by_url_layer: r,
                        embed_layer: d,
                        upload_layer: l,
                        progress_bar:
                            '<div class="fr-video-progress-bar-layer fr-layer"><h3 tabIndex="-1" class="fr-message">Uploading</h3><div class="fr-loader"><span class="fr-progress"></span></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-dismiss" data-cmd="videoDismissError" tabIndex="2" role="button">OK</button></div></div>',
                    },
                    f = w.popups.create("video.insert", p);
                return (
                    (function c(i) {
                        w.events.$on(
                            i,
                            "dragover dragenter",
                            ".fr-video-upload-layer",
                            function () {
                                return A(this).addClass("fr-drop"), !1;
                            },
                            !0
                        ),
                            w.events.$on(
                                i,
                                "dragleave dragend",
                                ".fr-video-upload-layer",
                                function () {
                                    return A(this).removeClass("fr-drop"), !1;
                                },
                                !0
                            ),
                            w.events.$on(
                                i,
                                "drop",
                                ".fr-video-upload-layer",
                                function (e) {
                                    e.preventDefault(), e.stopPropagation(), A(this).removeClass("fr-drop");
                                    var t = e.originalEvent.dataTransfer;
                                    if (t && t.files) {
                                        var o = i.data("instance") || w;
                                        o.events.disableBlur(), o.video.upload(t.files), o.events.enableBlur();
                                    }
                                },
                                !0
                            ),
                        w.helpers.isIOS() &&
                        w.events.$on(
                            i,
                            "touchstart",
                            '.fr-video-upload-layer input[type="file"]',
                            function () {
                                A(this).trigger("click");
                            },
                            !0
                        );
                        w.events.$on(
                            i,
                            "change",
                            '.fr-video-upload-layer input[type="file"]',
                            function () {
                                if (this.files) {
                                    var e = i.data("instance") || w;
                                    e.events.disableBlur(), i.find("input:focus").blur(), e.events.enableBlur(), e.video.upload(this.files);
                                }
                                A(this).val("");
                            },
                            !0
                        );
                    })(f),
                        f
                );
            }
            function d(e) {
                w.events.focus(!0), w.selection.restore();
                var t = !1;
                if ((E && (q(), (t = !0)), w.opts.trackChangesEnabled)) {
                    w.edit.on(), w.events.focus(!0), w.selection.restore(), w.undo.saveStep(), w.markers.insert(), w.html.wrap();
                    var o = w.$el.find(".fr-marker");
                    w.node.isLastSibling(o) && o.parent().hasClass("fr-deletable") && o.insertAfter(o.parent()),
                        o.replaceWith('<span contenteditable="false" draggable="true" class="fr-jiv fr-video fr-deletable">'.concat(e, "</span>")),
                        w.selection.clear();
                } else w.html.insert('<span contenteditable="false" draggable="true" class="fr-jiv fr-video fr-deletable">'.concat(e, "</span>"), !1, w.opts.videoSplitHTML);
                w.popups.hide("video.insert");
                var i = w.$el.find(".fr-jiv");
                i.removeClass("fr-jiv"),
                    i.toggleClass("fr-rv", w.opts.videoResponsive),
                    Z(i, w.opts.videoDefaultDisplay, w.opts.videoDefaultAlign),
                    i.toggleClass("fr-draggable", w.opts.videoMove),
                    w.events.trigger(t ? "video.replaced" : "video.inserted", [i]);
            }
            function h() {
                var e = A(this);
                w.popups.hide("video.insert"), e.removeClass("fr-uploading"), e.parent().next().is("br") && e.parent().next().remove(), y(e.parent()), w.events.trigger("video.loaded", [e.parent()]);
            }
            function R(s, e, d, l, p) {
                w.edit.off(), m("Loading video"), e && (s = w.helpers.sanitizeURL(s));
                var f = function f() {
                    var e, t;
                    if (l) {
                        w.undo.canDo() || l.find("video").hasClass("fr-uploading") || w.undo.saveStep();
                        var o = l.find("video").data("fr-old-src"),
                            i = l.data("fr-replaced");
                        if ((l.data("fr-replaced", !1), 0 < l.find("iframe").length)) l.remove(), (e = I(s, d, h));
                        else {
                            w.$wp ? ((e = l.clone(!0)).find("video").removeData("fr-old-src").removeClass("fr-uploading"), e.find("video").off("canplay"), o && l.find("video").attr("src", o), l.replaceWith(e)) : (e = l);
                            for (var r = e.find("video").get(0).attributes, a = 0; a < r.length; a++) {
                                var n = r[a];
                                0 === n.nodeName.indexOf("data-") && e.find("video").removeAttr(n.nodeName);
                            }
                            if (void 0 !== d) for (t in d) d.hasOwnProperty(t) && "link" != t && e.find("video").attr("data-".concat(t), d[t]);
                            e.find("video").on("canplay", h), e.find("video").attr("src", s);
                        }
                        w.edit.on(), O(), w.undo.saveStep(), w.$el.blur(), w.events.trigger(i ? "video.replaced" : "video.inserted", [e, p]);
                    } else (e = I(s, d, h)), O(), w.undo.saveStep(), w.events.trigger("video.inserted", [e, p]);
                };
                x("Loading video"), f();
            }
            function x(e) {
                var t = w.popups.get("video.insert");
                if ((t || (t = n()), t.find(".fr-layer.fr-active").removeClass("fr-active").addClass("fr-pactive"), t.find(".fr-video-progress-bar-layer").addClass("fr-active"), t.find(".fr-buttons").hide(), E)) {
                    var o = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video"));
                    w.popups.setContainer("video.insert", w.$sc);
                    var i = o.offset().left,
                        r = o.offset().top + o.height();
                    w.popups.show("video.insert", i, r, o.outerHeight());
                }
                void 0 === e && m(w.language.translate("Uploading"), 0);
            }
            function l(e) {
                var t = w.popups.get("video.insert");
                if (
                    t &&
                    (t.find(".fr-layer.fr-pactive").addClass("fr-active").removeClass("fr-pactive"), t.find(".fr-video-progress-bar-layer").removeClass("fr-active"), t.find(".fr-buttons").show(), e || w.$el.find("video.fr-error").length)
                ) {
                    if ((w.events.focus(), w.$el.find("video.fr-error").length && (w.$el.find("video.fr-error").parent().remove(), w.undo.saveStep(), w.undo.run(), w.undo.dropRedo()), !w.$wp && E)) {
                        var o = E;
                        V(!0), w.selection.setAfter(o.find("video").get(0)), w.selection.restore();
                    }
                    w.popups.hide("video.insert");
                }
            }
            function m(e, t) {
                var o = w.popups.get("video.insert");
                if (o) {
                    var i = o.find(".fr-video-progress-bar-layer");
                    i.find("h3").text(e + (t ? " ".concat(t, "%") : "")),
                        i.removeClass("fr-error"),
                        t ? (i.find("div").removeClass("fr-indeterminate"), i.find("div > span").css("width", "".concat(t, "%"))) : i.find("div").addClass("fr-indeterminate");
                }
            }
            function b(e) {
                x();
                var t = w.popups.get("video.insert").find(".fr-video-progress-bar-layer");
                t.addClass("fr-error");
                var o = t.find("h3");
                o.text(e), w.events.disableBlur(), o.focus();
            }
            function y(e) {
                t.call(e.get(0));
            }
            function _(e, t, o) {
                m("Loading video");
                var i = this.status,
                    r = this.response,
                    a = this.responseXML,
                    n = this.responseText;
                try {
                    if (w.opts.videoUploadToS3 || w.opts.videoUploadToAzure)
                        if (201 == i) {
                            var s;
                            if (w.opts.videoUploadToAzure) {
                                if (!1 === w.events.trigger("video.uploadedToAzure", [this.responseURL, o, r], !0)) return w.edit.on(), !1;
                                s = t;
                            } else
                                s = (function l(e) {
                                    try {
                                        var t = A(e).find("Location").text(),
                                            o = A(e).find("Key").text();
                                        return !1 === w.events.trigger("video.uploadedToS3", [t, o, e], !0) ? (w.edit.on(), !1) : t;
                                    } catch (i) {
                                        return F(u, e), !1;
                                    }
                                })(a);
                            s && R(s, !1, [], e, r || a);
                        } else F(u, r || a);
                    else if (200 <= i && i < 300) {
                        var d = (function p(e) {
                            try {
                                if (!1 === w.events.trigger("video.uploaded", [e], !0)) return w.edit.on(), !1;
                                var t = JSON.parse(e);
                                return t.link ? t : (F(c, e), !1);
                            } catch (o) {
                                return F(u, e), !1;
                            }
                        })(n);
                        d && R(d.link, !1, d, e, r || n);
                    } else F(v, r || n);
                } catch (f) {
                    F(u, r || n);
                }
            }
            function B() {
                F(u, this.response || this.responseText || this.responseXML);
            }
            function D(e) {
                if (e.lengthComputable) {
                    var t = ((e.loaded / e.total) * 100) | 0;
                    m(w.language.translate("Uploading"), t);
                }
            }
            function k() {
                w.edit.on(), l(!0);
            }
            function I(e, t, o) {
                var i,
                    r = "";
                if (t && void 0 !== t) for (i in t) t.hasOwnProperty(i) && "link" != i && (r += " data-".concat(i, '="').concat(t[i], '"'));
                var a = w.opts.videoDefaultWidth;
                a && "auto" != a && (a = "".concat(a, "px")), w.helpers.isMobile() && w.browser.safari && (r += " autoplay playsinline");
                var n = A(document.createElement("span"))
                    .attr("contenteditable", "false")
                    .attr("draggable", "true")
                    .attr("class", "fr-video fr-dv" + w.opts.videoDefaultDisplay[0] + ("center" != w.opts.videoDefaultAlign ? " fr-fv" + w.opts.videoDefaultAlign[0] : ""))
                    .html('<video src="' + e + '" ' + r + (a ? ' style="width: ' + a + ';" ' : "") + " controls>" + w.language.translate("Your browser does not support HTML5 video.") + "</video>");
                n.toggleClass("fr-draggable", w.opts.videoMove), w.edit.on(), w.events.focus(!0), w.selection.restore(), w.undo.saveStep(), w.opts.videoSplitHTML ? w.markers.split() : w.markers.insert(), w.html.wrap();
                var s = w.$el.find(".fr-marker");
                return (
                    w.node.isLastSibling(s) && s.parent().hasClass("fr-deletable") && s.insertAfter(s.parent()),
                        s.replaceWith(n),
                        w.selection.clear(),
                        n.find("video").get(0).readyState > n.find("video").get(0).HAVE_FUTURE_DATA || w.helpers.isIOS() ? o.call(n.find("video").get(0)) : n.find("video").on("canplaythrough load", o),
                        n
                );
            }
            function T(e) {
                if (!w.core.sameInstance(f)) return !0;
                e.preventDefault(), e.stopPropagation();
                var t = e.pageX || (e.originalEvent.touches ? e.originalEvent.touches[0].pageX : null),
                    o = e.pageY || (e.originalEvent.touches ? e.originalEvent.touches[0].pageY : null);
                if (!t || !o) return !1;
                if ("mousedown" == e.type) {
                    var i = w.$oel.get(0).ownerDocument,
                        r = i.defaultView || i.parentWindow,
                        a = !1;
                    try {
                        a = r.location != r.parent.location && !(r.$ && r.$.FE);
                    } catch (n) {}
                    a && r.frameElement && ((t += w.helpers.getPX(A(r.frameElement).offset().left) + r.frameElement.clientLeft), (o = e.clientY + w.helpers.getPX(A(r.frameElement).offset().top) + r.frameElement.clientTop));
                }
                w.undo.canDo() || w.undo.saveStep(), (p = A(this)).data("start-x", t), p.data("start-y", o), s.show(), w.popups.hideAll(), Y();
            }
            function z(e) {
                if (!w.core.sameInstance(f)) return !0;
                if (p) {
                    e.preventDefault();
                    var t = e.pageX || (e.originalEvent.touches ? e.originalEvent.touches[0].pageX : null),
                        o = e.pageY || (e.originalEvent.touches ? e.originalEvent.touches[0].pageY : null);
                    if (!t || !o) return !1;
                    var i = p.data("start-x"),
                        r = p.data("start-y");
                    p.data("start-x", t), p.data("start-y", o);
                    var a = t - i,
                        n = o - r,
                        s = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video")),
                        d = s.width(),
                        l = s.height();
                    (p.hasClass("fr-hnw") || p.hasClass("fr-hsw")) && (a = 0 - a),
                    (p.hasClass("fr-hnw") || p.hasClass("fr-hne")) && (n = 0 - n),
                        s.css("width", d + a),
                        s.css("height", l + n),
                        s.removeAttr("width"),
                        s.removeAttr("height"),
                        M();
                }
            }
            function P(e) {
                if (!w.core.sameInstance(f)) return !0;
                p && E && (e && e.stopPropagation(), (p = null), s.hide(), M(), a(), w.undo.saveStep());
            }
            function $(e) {
                return '<div class="fr-handler fr-h'.concat(e, '"></div>');
            }
            function L(e, t, o, i) {
                return (e.pageX = t), (e.pageY = t), T.call(this, e), (e.pageX = e.pageX + o * Math.floor(Math.pow(1.1, i))), (e.pageY = e.pageY + o * Math.floor(Math.pow(1.1, i))), z.call(this, e), P.call(this, e), ++i;
            }
            function O() {
                var e,
                    t = Array.prototype.slice.call(w.el.querySelectorAll("video, .fr-video > *")),
                    o = [];
                for (e = 0; e < t.length; e++)
                    o.push(t[e].getAttribute("src")),
                        A(t[e]).toggleClass("fr-draggable", w.opts.videoMove),
                    "" === t[e].getAttribute("class") && t[e].removeAttribute("class"),
                    "" === t[e].getAttribute("style") && t[e].removeAttribute("style");
                if (i) for (e = 0; e < i.length; e++) o.indexOf(i[e].getAttribute("src")) < 0 && w.events.trigger("video.removed", [A(i[e])]);
                i = t;
            }
            function M() {
                f ||
                (function n() {
                    var e;
                    if (
                        (w.shared.$video_resizer
                            ? ((f = w.shared.$video_resizer),
                                (s = w.shared.$vid_overlay),
                                w.events.on(
                                    "destroy",
                                    function () {
                                        A("body").first().append(f.removeClass("fr-active"));
                                    },
                                    !0
                                ))
                            : ((w.shared.$video_resizer = A(document.createElement("div")).attr("class", "fr-video-resizer")),
                                (f = w.shared.$video_resizer),
                                w.events.$on(
                                    f,
                                    "mousedown",
                                    function (e) {
                                        e.stopPropagation();
                                    },
                                    !0
                                ),
                            w.opts.videoResize &&
                            (f.append($("nw") + $("ne") + $("sw") + $("se")),
                                (w.shared.$vid_overlay = A(document.createElement("div")).attr("class", "fr-video-overlay")),
                                (s = w.shared.$vid_overlay),
                                (e = f.get(0).ownerDocument),
                                A(e).find("body").first().append(s))),
                            w.events.on(
                                "shared.destroy",
                                function () {
                                    f.html("").removeData().remove(), (f = null), w.opts.videoResize && (s.remove(), (s = null));
                                },
                                !0
                            ),
                        w.helpers.isMobile() ||
                        w.events.$on(A(w.o_win), "resize.video", function () {
                            V(!0);
                        }),
                            w.opts.videoResize)
                    ) {
                        (e = f.get(0).ownerDocument),
                            w.events.$on(f, w._mousedown, ".fr-handler", T),
                            w.events.$on(A(e), w._mousemove, z),
                            w.events.$on(A(e.defaultView || e.parentWindow), w._mouseup, P),
                            w.events.$on(s, "mouseleave", P);
                        var i = 1,
                            r = null,
                            a = 0;
                        w.events.on("keydown", function (e) {
                            if (E) {
                                var t = -1 != navigator.userAgent.indexOf("Mac OS X") ? e.metaKey : e.ctrlKey,
                                    o = e.which;
                                (o !== r || 200 < e.timeStamp - a) && (i = 1),
                                    (o == we.KEYCODE.EQUALS || (w.browser.mozilla && o == we.KEYCODE.FF_EQUALS)) && t && !e.altKey
                                        ? (i = L.call(this, e, 1, 1, i))
                                        : (o == we.KEYCODE.HYPHEN || (w.browser.mozilla && o == we.KEYCODE.FF_HYPHEN)) && t && !e.altKey && (i = L.call(this, e, 2, -1, i)),
                                    (r = o),
                                    (a = e.timeStamp);
                            }
                        }),
                            w.events.on("keyup", function () {
                                i = 1;
                            });
                    }
                })(),
                    (w.$wp || w.$sc).append(f),
                    f.data("instance", w);
                var e = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video")),
                    t = 0,
                    o = 0;
                w.opts.iframe && ((o = w.helpers.getPX(w.$wp.find(".fr-iframe").css("padding-top"))), (t = w.helpers.getPX(w.$wp.find(".fr-iframe").css("padding-left")))),
                    f
                        .css("top", (w.opts.iframe ? e.offset().top + o - 1 : e.offset().top - w.$wp.offset().top - 1) + w.$wp.scrollTop())
                        .css("left", (w.opts.iframe ? e.offset().left + t - 1 : e.offset().left - w.$wp.offset().left - 1) + w.$wp.scrollLeft())
                        .css("width", e.get(0).getBoundingClientRect().width)
                        .css("height", e.get(0).getBoundingClientRect().height)
                        .addClass("fr-active");
            }
            function t(e) {
                if (e && "touchend" == e.type && o) return !0;
                if (e && w.edit.isDisabled()) return e.stopPropagation(), e.preventDefault(), !1;
                if (w.edit.isDisabled()) return !1;
                for (var t = 0; t < we.INSTANCES.length; t++) we.INSTANCES[t] != w && we.INSTANCES[t].events.trigger("video.hideResizer");
                w.toolbar.disable(),
                w.helpers.isMobile() && (w.events.disableBlur(), w.$el.blur(), w.events.enableBlur()),
                    w.$el.find(".fr-video.fr-active").removeClass("fr-active"),
                    (E = A(this)).addClass("fr-active"),
                w.opts.iframe && w.size.syncIframe(),
                    te(),
                    M(),
                    a(),
                    w.selection.clear(),
                    w.button.bulkRefresh(),
                    w.events.trigger("image.hideResizer");
            }
            function V(e) {
                E &&
                ((function t() {
                        return w.shared.vid_exit_flag;
                    })() ||
                    !0 === e) &&
                (f.removeClass("fr-active"), w.toolbar.enable(), E.removeClass("fr-active"), (E = null), Y());
            }
            function N() {
                w.shared.vid_exit_flag = !0;
            }
            function Y() {
                w.shared.vid_exit_flag = !1;
            }
            function H(e) {
                var t = e.originalEvent.dataTransfer;
                if (t && t.files && t.files.length) {
                    var o = t.files[0];
                    if (o && o.type && -1 !== o.type.indexOf("video")) {
                        if (!w.opts.videoUpload) return e.preventDefault(), e.stopPropagation(), !1;
                        w.markers.remove(), w.markers.insertAtPoint(e.originalEvent), w.$el.find(".fr-marker").replaceWith(we.MARKERS), w.popups.hideAll();
                        var i = w.popups.get("video.insert");
                        return (
                            i || (i = n()),
                                w.popups.setContainer("video.insert", w.$sc),
                                w.popups.show("video.insert", e.originalEvent.pageX, e.originalEvent.pageY),
                                x(),
                                0 <= w.opts.videoAllowedTypes.indexOf(o.type.replace(/video\//g, "")) ? K(t.files) : F(U),
                                e.preventDefault(),
                                e.stopPropagation(),
                                !1
                        );
                    }
                }
            }
            function K(e) {
                if (void 0 !== e && 0 < e.length) {
                    if (!1 === w.events.trigger("video.beforeUpload", [e])) return !1;
                    var t,
                        o = e[0];
                    if (!((null !== w.opts.videoUploadURL && w.opts.videoUploadURL != C) || w.opts.videoUploadToS3 || w.opts.videoUploadToAzure))
                        return (
                            (function y(i) {
                                E && E.find("iframe") && E.find("iframe").length && q();
                                var r = new FileReader();
                                (r.onload = function () {
                                    r.result;
                                    for (var e = atob(r.result.split(",")[1]), t = [], o = 0; o < e.length; o++) t.push(e.charCodeAt(o));
                                    R(window.URL.createObjectURL(new Blob([new Uint8Array(t)], { type: i.type })), !1, null, E);
                                }),
                                    x(),
                                    r.readAsDataURL(i);
                            })(o),
                                !1
                        );
                    if (o.size > w.opts.videoMaxSize) return F(S), !1;
                    if (w.opts.videoAllowedTypes.indexOf(o.type.replace(/video\//g, "")) < 0) return F(U), !1;
                    if ((w.drag_support.formdata && (t = w.drag_support.formdata ? new FormData() : null), t)) {
                        var i;
                        if (!1 !== w.opts.videoUploadToS3)
                            for (i in (t.append("key", w.opts.videoUploadToS3.keyStart + new Date().getTime() + "-" + (o.name || "untitled")),
                                t.append("success_action_status", "201"),
                                t.append("X-Requested-With", "xhr"),
                                t.append("Content-Type", o.type),
                                w.opts.videoUploadToS3.params))
                                w.opts.videoUploadToS3.params.hasOwnProperty(i) && t.append(i, w.opts.videoUploadToS3.params[i]);
                        for (i in w.opts.videoUploadParams) w.opts.videoUploadParams.hasOwnProperty(i) && t.append(i, w.opts.videoUploadParams[i]);
                        t.append(w.opts.videoUploadParam, o);
                        var r,
                            a,
                            n = w.opts.videoUploadURL;
                        w.opts.videoUploadToS3 && (n = w.opts.videoUploadToS3.uploadURL ? w.opts.videoUploadToS3.uploadURL : "https://".concat(w.opts.videoUploadToS3.region, ".amazonaws.com/").concat(w.opts.videoUploadToS3.bucket));
                        var s = w.opts.videoUploadMethod;
                        w.opts.videoUploadToAzure &&
                        ((n = w.opts.videoUploadToAzure.uploadURL
                            ? "".concat(w.opts.videoUploadToAzure.uploadURL, "/").concat(o.name)
                            : encodeURI("https://".concat(w.opts.videoUploadToAzure.account, ".blob.core.windows.net/").concat(w.opts.videoUploadToAzure.container, "/").concat(o.name))),
                            (r = n),
                        w.opts.videoUploadToAzure.SASToken && (n += w.opts.videoUploadToAzure.SASToken),
                            (s = "PUT"));
                        var d = w.core.getXHR(n, s);
                        if (w.opts.videoUploadToAzure) {
                            var l = new Date().toUTCString();
                            if (!w.opts.videoUploadToAzure.SASToken && w.opts.videoUploadToAzure.accessKey) {
                                var p = w.opts.videoUploadToAzure.account,
                                    f = w.opts.videoUploadToAzure.container;
                                if (w.opts.videoUploadToAzure.uploadURL) {
                                    var c = w.opts.videoUploadToAzure.uploadURL.split("/");
                                    (f = c.pop()), (p = c.pop().split(".")[0]);
                                }
                                var v = "x-ms-blob-type:BlockBlob\nx-ms-date:".concat(l, "\nx-ms-version:2019-07-07"),
                                    u = encodeURI("/" + p + "/" + f + "/" + o.name),
                                    g = s + "\n\n\n" + o.size + "\n\n" + o.type + "\n\n\n\n\n\n\n" + v + "\n" + u,
                                    h = w.cryptoJSPlugin.cryptoJS.HmacSHA256(g, w.cryptoJSPlugin.cryptoJS.enc.Base64.parse(w.opts.videoUploadToAzure.accessKey)).toString(w.cryptoJSPlugin.cryptoJS.enc.Base64),
                                    m = "SharedKey " + p + ":" + h;
                                (a = h), d.setRequestHeader("Authorization", m);
                            }
                            for (i in (d.setRequestHeader("x-ms-version", "2019-07-07"),
                                d.setRequestHeader("x-ms-date", l),
                                d.setRequestHeader("Content-Type", o.type),
                                d.setRequestHeader("x-ms-blob-type", "BlockBlob"),
                                w.opts.videoUploadParams))
                                w.opts.videoUploadParams.hasOwnProperty(i) && d.setRequestHeader(i, w.opts.videoUploadParams[i]);
                            for (i in w.opts.videoUploadToAzure.params) w.opts.videoUploadToAzure.params.hasOwnProperty(i) && d.setRequestHeader(i, w.opts.videoUploadToAzure.params[i]);
                        }
                        (d.onload = function () {
                            _.call(d, E, r, a);
                        }),
                            (d.onerror = B),
                            (d.upload.onprogress = D),
                            (d.onabort = k),
                            x(),
                            w.events.disableBlur(),
                            w.edit.off(),
                            w.events.enableBlur();
                        var b = w.popups.get("video.insert");
                        b &&
                        A(b.off("abortUpload")).on("abortUpload", function () {
                            4 != d.readyState && d.abort();
                        }),
                            d.send(w.opts.videoUploadToAzure ? o : t);
                    }
                }
            }
            function F(e, t) {
                w.edit.on(), E && E.find("video").addClass("fr-error"), b(w.language.translate("Something went wrong. Please try again.")), w.events.trigger("video.error", [{ code: e, message: r[e] }, t]);
            }
            function X() {
                if (E) {
                    var e = w.popups.get("video.size"),
                        t = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video"));
                    e
                        .find('input[name="width"]')
                        .val(t.get(0).style.width || t.attr("width"))
                        .trigger("change"),
                        e
                            .find('input[name="height"]')
                            .val(t.get(0).style.height || t.attr("height"))
                            .trigger("change");
                }
            }
            function G(e) {
                if (e) return w.popups.onRefresh("video.size", X), !0;
                var t = {
                        buttons: '<div class="fr-buttons fr-tabs">'.concat(w.button.buildList(w.opts.videoSizeButtons), "</div>"),
                        size_layer: '<div class="fr-video-size-layer fr-layer fr-active" id="fr-video-size-layer-'
                            .concat(w.id, '"><div class="fr-video-group"><div class="fr-input-line"><input id="fr-video-size-layer-width-')
                            .concat(w.id, '" type="text" name="width" placeholder="')
                            .concat(w.language.translate("Width"), '" tabIndex="1"></div><div class="fr-input-line"><input id="fr-video-size-layer-height-')
                            .concat(w.id, '" type="text" name="height" placeholder="')
                            .concat(w.language.translate("Height"), '" tabIndex="1"></div></div><div class="fr-action-buttons"><button type="button" class="fr-command fr-submit" data-cmd="videoSetSize" tabIndex="2" role="button">')
                            .concat(w.language.translate("Update"), "</button></div></div>"),
                    },
                    o = w.popups.create("video.size", t);
                return (
                    w.events.$on(w.$wp, "scroll", function () {
                        E && w.popups.isVisible("video.size") && (w.events.disableBlur(), y(E));
                    }),
                        o
                );
            }
            function j(e) {
                if ((void 0 === e && (e = E), e)) {
                    if (e.hasClass("fr-fvl")) return "left";
                    if (e.hasClass("fr-fvr")) return "right";
                    if (e.hasClass("fr-dvb") || e.hasClass("fr-dvi")) return "center";
                    if ("block" == e.css("display")) {
                        if ("left" == e.css("text-algin")) return "left";
                        if ("right" == e.css("text-align")) return "right";
                    } else {
                        if ("left" == e.css("float")) return "left";
                        if ("right" == e.css("float")) return "right";
                    }
                }
                return "center";
            }
            function W(e) {
                void 0 === e && (e = E);
                var t = e.css("float");
                return e.css("float", "none"), "block" == e.css("display") ? (e.css("float", ""), e.css("float") != t && e.css("float", t), "block") : (e.css("float", ""), e.css("float") != t && e.css("float", t), "inline");
            }
            function q() {
                if (E && !1 !== w.events.trigger("video.beforeRemove", [E])) {
                    var e = E;
                    if ((w.popups.hideAll(), V(!0), w.opts.trackChangesEnabled && (!e[0].parentNode || "SPAN" !== e[0].parentNode.tagName || !e[0].parentNode.hasAttribute("data-tracking")))) return void w.track_changes.removeSpecialItem(e);
                    w.selection.setBefore(e.get(0)) || w.selection.setAfter(e.get(0)), e.remove(), w.selection.restore(), w.html.fillEmptyBlocks();
                }
            }
            function J() {
                l();
            }
            function Z(e, t, o) {
                !w.opts.htmlUntouched && w.opts.useClasses
                    ? (e.removeClass("fr-fvl fr-fvr fr-dvb fr-dvi"), e.addClass("fr-fv".concat(o[0], " fr-dv").concat(t[0])))
                    : "inline" == t
                        ? (e.css({ display: "inline-block" }), "center" == o ? e.css({ float: "none" }) : "left" == o ? e.css({ float: "left" }) : e.css({ float: "right" }))
                        : (e.css({ display: "block", clear: "both" }), "left" == o ? e.css({ textAlign: "left" }) : "right" == o ? e.css({ textAlign: "right" }) : e.css({ textAlign: "center" }));
            }
            function Q() {
                var e = w.$el.find("video").filter(function () {
                    return 0 === A(this).parents("span.fr-video").length;
                });
                if (0 != e.length) {
                    e.wrap(A(document.createElement("span")).attr("class", "fr-video fr-deletable").attr("contenteditable", "false")),
                        w.$el
                            .find("embed, iframe")
                            .filter(function () {
                                if ((w.browser.safari && this.getAttribute("src") && this.setAttribute("src", this.src), 0 < A(this).parents("span.fr-video").length)) return !1;
                                for (var e = A(this).attr("src"), t = 0; t < we.VIDEO_PROVIDERS.length; t++) {
                                    var o = we.VIDEO_PROVIDERS[t];
                                    if (o.test_regex.test(e) && new RegExp(w.opts.videoAllowedProviders.join("|")).test(o.provider)) return !0;
                                }
                                return !1;
                            })
                            .map(function () {
                                return 0 === A(this).parents("object").length ? this : A(this).parents("object").get(0);
                            })
                            .wrap(A(document.createElement("span")).attr("class", "fr-video").attr("contenteditable", "false"));
                    for (var t, o, i, r, a = w.$el.find("span.fr-video, video"), n = 0; n < a.length; n++) {
                        var s = A(a[n]);
                        !w.opts.htmlUntouched && w.opts.useClasses
                            ? ((r = s).hasClass("fr-dvi") || r.hasClass("fr-dvb") || (r.addClass("fr-fv".concat(j(r)[0])), r.addClass("fr-dv".concat(W(r)[0]))), w.opts.videoTextNear || s.removeClass("fr-dvi").addClass("fr-dvb"))
                            : w.opts.htmlUntouched ||
                            w.opts.useClasses ||
                            (void 0,
                                (o = (t = s).hasClass("fr-dvb") ? "block" : t.hasClass("fr-dvi") ? "inline" : null),
                                (i = t.hasClass("fr-fvl") ? "left" : t.hasClass("fr-fvr") ? "right" : j(t)),
                                Z(t, o, i),
                                t.removeClass("fr-dvb fr-dvi fr-fvr fr-fvl"));
                    }
                    a.toggleClass("fr-draggable", w.opts.videoMove);
                }
            }
            function ee(e) {
                document.getElementById("autoplay-".concat(w.id)).style.cssText = "background:".concat(e);
            }
            function te() {
                if (E) {
                    w.selection.clear();
                    var e = w.doc.createRange();
                    e.selectNode(E.get(0)), w.selection.get().addRange(e);
                }
            }
            return (
                (r[1] = "Video cannot be loaded from the passed link."),
                    (r[c] = "No link in upload response."),
                    (r[v] = "Error during file upload."),
                    (r[u] = "Parsing response failed."),
                    (r[S] = "File is too large."),
                    (r[U] = "Video file type is invalid."),
                    (r[7] = "Files can be uploaded only to same domain in IE 8 and IE 9."),
                    (w.shared.vid_exit_flag = !1),
                    {
                        _init: function oe() {
                            w.opts.videoResponsive && (w.opts.videoResize = !1),
                                (function e() {
                                    w.events.on("drop", H, !0),
                                        w.events.on("mousedown window.mousedown", N),
                                        w.events.on("window.touchmove", Y),
                                        w.events.on("mouseup window.mouseup", V),
                                        w.events.on("commands.mousedown", function (e) {
                                            0 < e.parents(".fr-toolbar").length && V();
                                        }),
                                        w.events.on("video.hideResizer commands.undo commands.redo element.dropped", function () {
                                            V(!0);
                                        });
                                })(),
                            w.helpers.isMobile() &&
                            (w.events.$on(w.$el, "touchstart", "span.fr-video", function () {
                                o = !1;
                            }),
                                w.events.$on(w.$el, "touchmove", function () {
                                    o = !0;
                                })),
                                w.events.on("html.set", Q),
                                Q(),
                                w.events.$on(w.$el, "mousedown", "span.fr-video", function (e) {
                                    e.stopPropagation(), (w.browser.msie || w.browser.edge) && (e.target.innerText || (e.target.dragDrop(), t.call(this, e)));
                                }),
                                w.events.$on(w.$el, "click touchend", "span.fr-video", function (e) {
                                    if (e.target.innerText.length || "false" == A(this).parents("[contenteditable]").not(".fr-element").not(".fr-img-caption").not("body").first().attr("contenteditable")) return !0;
                                    t.call(this, e);
                                }),
                                w.events.on(
                                    "keydown",
                                    function (e) {
                                        var t = e.which;
                                        return !E || (t != we.KEYCODE.BACKSPACE && t != we.KEYCODE.DELETE)
                                            ? E && t == we.KEYCODE.ESC
                                                ? (V(!0), e.preventDefault(), !1)
                                                : E && t != we.KEYCODE.F10 && !w.keys.isBrowserAction(e)
                                                    ? (e.preventDefault(), !1)
                                                    : void 0
                                            : (e.preventDefault(), q(), w.undo.saveStep(), !1);
                                    },
                                    !0
                                ),
                                w.events.on(
                                    "toolbar.esc",
                                    function () {
                                        if (E) return w.events.disableBlur(), w.events.focus(), !1;
                                    },
                                    !0
                                ),
                                w.events.on(
                                    "toolbar.focusEditor",
                                    function () {
                                        if (E) return !1;
                                    },
                                    !0
                                ),
                                w.events.on("keydown", function () {
                                    w.$el.find("span.fr-video:empty").remove();
                                }),
                            w.$wp && (O(), w.events.on("contentChanged", O)),
                                n(!0),
                                G(!0);
                        },
                        showInsertPopup: function ie() {
                            var e = w.$tb.find('.fr-command[data-cmd="insertVideo"]'),
                                t = w.popups.get("video.insert");
                            if ((t || (t = n()), l(), !t.hasClass("fr-active")))
                                if ((w.popups.refresh("video.insert"), w.popups.setContainer("video.insert", w.$tb), e.isVisible())) {
                                    var o = w.button.getPosition(e),
                                        i = o.left,
                                        r = o.top;
                                    w.popups.show("video.insert", i, r, e.outerHeight());
                                } else w.position.forSelection(t), w.popups.show("video.insert");

                            // START :: LP custom code
                            let videoUpload = jQuery(".fr-buttons").find('#videoUpload-1');
                            jQuery('#videoUpload-1').next().remove('.fa-bamboo-btn-wrap');
                            if(videoUpload.length) {
                                videoUpload.after('<button data-title="If you\'re adding a BombBomb video, be sure to paste the full-length URL below, not the shortened version." type="button" class="fr-command fr-btn' +
                                    ' fa-bamboo-btn-wrap"><span class="fa-bamboo"' +
                                    '>&nbsp;</span></button>');
                                jQuery(".fa-bamboo-btn-wrap").hover(function () {
                                    jQuery('body').toggleClass('froala-tooltip-active');
                                });
                            }
                            // END :: LP custom code
                        },
                        showLayer: function re(e) {
                            var t,
                                o,
                                i = w.popups.get("video.insert");
                            if (!E && !w.opts.toolbarInline) {
                                var r = w.$tb.find('.fr-command[data-cmd="insertVideo"]');
                                (t = r.offset().left), (o = r.offset().top + (w.opts.toolbarBottom ? 10 : r.outerHeight() - 10));
                            }
                            w.opts.toolbarInline && ((o = i.offset().top - w.helpers.getPX(i.css("margin-top"))), i.hasClass("fr-above") && (o += i.outerHeight())),
                                i.find(".fr-layer").removeClass("fr-active"),
                                i.find(".fr-".concat(e, "-layer")).addClass("fr-active"),
                                w.popups.show("video.insert", t, o, 0),
                                w.accessibility.focusPopup(i);
                        },
                        refreshByURLButton: function ae(e) {
                            var t = w.popups.get("video.insert");
                            t && t.find(".fr-video-by-url-layer").hasClass("fr-active") && e.addClass("fr-active").attr("aria-pressed", !0);
                        },
                        refreshEmbedButton: function ne(e) {
                            var t = w.popups.get("video.insert");
                            t && t.find(".fr-video-embed-layer").hasClass("fr-active") && e.addClass("fr-active").attr("aria-pressed", !0);
                        },
                        refreshUploadButton: function se(e) {
                            var t = w.popups.get("video.insert");
                            t && t.find(".fr-video-upload-layer").hasClass("fr-active") && e.addClass("fr-active").attr("aria-pressed", !0);
                        },
                        upload: K,
                        insertByURL: function de(e) {
                            var t = !!document.getElementById("videoPluginAutoplay") && document.getElementById("videoPluginAutoplay").checked;
                            void 0 === e && (e = (w.popups.get("video.insert").find('.fr-video-by-url-layer input[type="text"]').val() || "").trim());
                            var o = null;
                            if ((/^http/.test(e) || (e = "https://".concat(e)), w.helpers.isURL(e)))
                                if(w.opts.isVideoInsertByUrlIFrame) {
                                    for (var i = 0; i < we.VIDEO_PROVIDERS.length; i++) {
                                        var r = we.VIDEO_PROVIDERS[i],
                                            a = "autoplay=1&mute=1";
                                        if (r.html.includes("autoplay=1") && document.getElementById("videoPluginAutoplay").checked) (r.html = r.html), (document.getElementById("videoPluginAutoplay").checked = !1);
                                        else if (t) {
                                            var n = r.html.indexOf("{url}") + 5;
                                            (r.html = [r.html.slice(0, n), a, r.html.slice(n)].join("")), (t = !1), (document.getElementById("videoPluginAutoplay").checked = !1);
                                        } else (r = we.VIDEO_PROVIDERS[i]).html = r.html.replace(a, "");
                                        if (r.test_regex.test(e) && new RegExp(w.opts.videoAllowedProviders.join("|")).test(r.provider)) {
                                            (o = e.replace(r.url_regex, r.url_text)), (o = r.html.replace(/\{url\}/, o));
                                            break;
                                        }
                                    }
                                } else {
                                    o = w.opts.videoInsertByUrlFromat.replace(/\{url\}/,e);
                                }
                            o ? d(o) : (b(w.language.translate("Something went wrong. Please try again.")), w.events.trigger("video.linkError", [e]));
                        },
                        insertEmbed: function le(e) {
                            void 0 === e && (e = w.popups.get("video.insert").find(".fr-video-embed-layer textarea").val() || ""),
                                0 !== e.length && we.VIDEO_EMBED_REGEX.test(e) ? d(e) : (b(w.language.translate("Something went wrong. Please try again.")), w.events.trigger("video.codeError", [e]));
                        },
                        insert: d,
                        align: function pe(e) {
                            E.removeClass("fr-fvr fr-fvl"), !w.opts.htmlUntouched && w.opts.useClasses ? ("left" == e ? E.addClass("fr-fvl") : "right" == e && E.addClass("fr-fvr")) : Z(E, W(), e), te(), M(), a(), w.selection.clear();
                        },
                        refreshAlign: function fe(e) {
                            if (!E) return !1;
                            e.find(">*")
                                .first()
                                .replaceWith(w.icon.create("video-align-".concat(j())));
                        },
                        refreshAlignOnShow: function ce(e, t) {
                            E && t.find('.fr-command[data-param1="'.concat(j(), '"]')).addClass("fr-active").attr("aria-selected", !0);
                        },
                        display: function ve(e) {
                            E.removeClass("fr-dvi fr-dvb"), !w.opts.htmlUntouched && w.opts.useClasses ? ("inline" == e ? E.addClass("fr-dvi") : "block" == e && E.addClass("fr-dvb")) : Z(E, e, j()), te(), M(), a(), w.selection.clear();
                        },
                        refreshDisplayOnShow: function ue(e, t) {
                            E && t.find('.fr-command[data-param1="'.concat(W(), '"]')).addClass("fr-active").attr("aria-selected", !0);
                        },
                        remove: q,
                        hideProgressBar: l,
                        showSizePopup: function ge() {
                            var e = w.popups.get("video.size");
                            e || (e = G()), l(), w.popups.refresh("video.size"), w.popups.setContainer("video.size", w.$sc);
                            var t = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video")),
                                o = t.offset().left + t.outerWidth() / 2,
                                i = t.offset().top + t.height();
                            w.popups.show("video.size", o, i, t.height(), !0);
                        },
                        replace: function he() {
                            var e = w.popups.get("video.insert");
                            e || (e = n()), w.popups.isVisible("video.insert") || (l(), w.popups.refresh("video.insert"), w.popups.setContainer("video.insert", w.$sc));
                            var t = E.offset().left + E.outerWidth() / 2,
                                o = E.offset().top + E.height();
                            w.popups.show("video.insert", t, o, E.outerHeight(), !0);
                        },
                        back: function e() {
                            E ? (w.events.disableBlur(), E[0].click()) : (w.events.disableBlur(), w.selection.restore(), w.events.enableBlur(), w.popups.hide("video.insert"), w.toolbar.showInline());
                        },
                        setSize: function me(e, t) {
                            if (E) {
                                var o = w.popups.get("video.size"),
                                    i = E.find("iframe, embed, ".concat(E.find("iframe, embed, audio").get(0) ? "audio" : "video"));
                                i.css("width", e || o.find('input[name="width"]').val()),
                                    i.css("height", t || o.find('input[name="height"]').val()),
                                i.get(0).style.width && i.removeAttr("width"),
                                i.get(0).style.height && i.removeAttr("height"),
                                    o.find("input:focus").blur(),
                                    setTimeout(
                                        function () {
                                            E.trigger("click");
                                        },
                                        w.helpers.isAndroid() ? 50 : 0
                                    );
                            }
                        },
                        get: function be() {
                            return E;
                        },
                        showProgressBar: x,
                        _editVideo: y,
                        setAutoplay: function ye() {
                            var e;
                            if (E.find("iframe, embed, audio").get(0))
                                (e = E.find("iframe, embed, audio")).get(0).src.includes("autoplay=1&mute=1") ? (ee("#FFFFFF"), (e.get(0).src = e.get(0).src.replace("&autoplay=1&mute=1", ""))) : (ee("#D6D6D6"), (e.get(0).src = e.get(0).src + "&autoplay=1&mute=1"));
                            else if ((e = E.find("iframe, embed, video")).get(0).outerHTML.includes("autoplay")) ee("#FFFFFF"), (e.get(0).outerHTML = e.get(0).outerHTML.replace("autoplay", ""));
                            else {
                                ee("#D6D6D6");
                                var t = e.get(0).outerHTML.indexOf("class") - 1;
                                e.get(0).outerHTML = [e.get(0).outerHTML.slice(0, t), "autoplay", e.get(0).outerHTML.slice(t)].join("");
                            }
                        },
                    }
            );
        }),
        we.RegisterCommand("insertVideo", {
            title: "Insert Video",
            undo: !1,
            focus: !0,
            refreshAfterCallback: !1,
            popup: !0,
            callback: function () {
                this.popups.isVisible("video.insert") ? (this.$el.find(".fr-marker").length && (this.events.disableBlur(), this.selection.restore()), this.popups.hide("video.insert")) : this.video.showInsertPopup();
            },
            plugin: "video",
        }),
        we.DefineIcon("insertVideo", { NAME: "video-camera", FA5NAME: "camera", SVG_KEY: "insertVideo" }),
        we.DefineIcon("videoByURL", { NAME: "link", SVG_KEY: "insertLink" }),
        we.RegisterCommand("videoByURL", {
            title: "By URL",
            undo: !1,
            focus: !1,
            toggle: !0,
            callback: function () {
                this.video.showLayer("video-by-url");
            },
            refresh: function (e) {
                this.video.refreshByURLButton(e);
            },
        }),
        we.DefineIcon("videoEmbed", { NAME: "code", SVG_KEY: "codeView" }),
        we.RegisterCommand("videoEmbed", {
            title: "Embedded Code",
            undo: !1,
            focus: !1,
            toggle: !0,
            callback: function () {
                this.video.showLayer("video-embed");
            },
            refresh: function (e) {
                this.video.refreshEmbedButton(e);
            },
        }),
        we.DefineIcon("videoUpload", { NAME: "upload", SVG_KEY: "upload" }),
        we.RegisterCommand("videoUpload", {
            title: "Upload Video",
            undo: !1,
            focus: !1,
            toggle: !0,
            callback: function () {
                this.video.showLayer("video-upload");
            },
            refresh: function (e) {
                this.video.refreshUploadButton(e);
            },
        }),
        we.RegisterCommand("videoInsertByURL", {
            undo: !0,
            focus: !0,
            callback: function () {
                this.video.insertByURL();
                // remove some class to fix design issue
                if(!this.opts.isVideoInsertByUrlIFrame) {
                    let el = this.selection.get();
                    if(el && el.anchorNode) {
                        jQuery(el.anchorNode).removeClass("fr-rv fr-fvc");
                    }
                }
            },
        }),
        we.RegisterCommand("videoInsertEmbed", {
            undo: !0,
            focus: !0,
            callback: function () {
                this.video.insertEmbed();
            },
        }),
        we.DefineIcon("videoDisplay", { NAME: "star", SVG_KEY: "star" }),
        we.RegisterCommand("videoDisplay", {
            title: "Display",
            type: "dropdown",
            options: { inline: "Inline", block: "Break Text" },
            callback: function (e, t) {
                this.video.display(t);
            },
            refresh: function (e) {
                this.opts.videoTextNear || e.addClass("fr-hidden");
            },
            refreshOnShow: function (e, t) {
                this.video.refreshDisplayOnShow(e, t);
            },
        }),
        we.DefineIcon("video-align", { NAME: "align-left", SVG_KEY: "align Left" }),
        we.DefineIcon("video-align-left", { NAME: "align-left", SVG_KEY: "alignLeft" }),
        we.DefineIcon("video-align-right", { NAME: "align-right", SVG_KEY: "alignRight" }),
        we.DefineIcon("video-align-center", { NAME: "align-justify", SVG_KEY: "alignJustify" }),
        we.DefineIcon("videoAlign", { NAME: "align-center", SVG_KEY: "alignCenter" }),
        we.RegisterCommand("videoAlign", {
            type: "dropdown",
            title: "Align",
            options: { left: "Align Left", center: "None", right: "Align Right" },
            html: function () {
                var e = '<ul class="fr-dropdown-list" role="presentation">',
                    t = we.COMMANDS.videoAlign.options;
                for (var o in t)
                    t.hasOwnProperty(o) &&
                    (e += '<li role="presentation"><a class="fr-command fr-title" tabIndex="-1" role="option" data-cmd="videoAlign" data-param1="'
                        .concat(o, '" title="')
                        .concat(this.language.translate(t[o]), '">')
                        .concat(this.icon.create("video-align-".concat(o)), '<span class="fr-sr-only">')
                        .concat(this.language.translate(t[o]), "</span></a></li>"));
                return (e += "</ul>");
            },
            callback: function (e, t) {
                this.video.align(t);
            },
            refresh: function (e) {
                this.video.refreshAlign(e);
            },
            refreshOnShow: function (e, t) {
                this.video.refreshAlignOnShow(e, t);
            },
        }),
        we.DefineIcon("videoReplace", { NAME: "exchange", FA5NAME: "exchange-alt", SVG_KEY: "replaceImage" }),
        we.RegisterCommand("videoReplace", {
            title: "Replace",
            undo: !1,
            focus: !1,
            popup: !0,
            refreshAfterCallback: !1,
            callback: function () {
                this.video.replace();
            },
        }),
        we.DefineIcon("videoRemove", { NAME: "trash", SVG_KEY: "remove" }),
        we.RegisterCommand("videoRemove", {
            title: "Remove",
            callback: function () {
                this.video.remove();
            },
        }),
        we.DefineIcon("autoplay", { NAME: "autoplay", SVG_KEY: "autoplay" }),
        we.RegisterCommand("autoplay", {
            undo: !1,
            focus: !1,
            popup: !0,
            title: "Autoplay",
            callback: function () {
                this.video.setAutoplay();
            },
        }),
        we.DefineIcon("videoSize", { NAME: "arrows-alt", SVG_KEY: "imageSize" }),
        we.RegisterCommand("videoSize", {
            undo: !1,
            focus: !1,
            popup: !0,
            title: "Change Size",
            callback: function () {
                this.video.showSizePopup();
            },
        }),
        we.DefineIcon("videoBack", { NAME: "arrow-left", SVG_KEY: "back" }),
        we.RegisterCommand("videoBack", {
            title: "Back",
            undo: !1,
            focus: !1,
            back: !0,
            callback: function () {
                this.video.back();
            },
            refresh: function (e) {
                this.video.get() || this.opts.toolbarInline ? (e.removeClass("fr-hidden"), e.next(".fr-separator").removeClass("fr-hidden")) : (e.addClass("fr-hidden"), e.next(".fr-separator").addClass("fr-hidden"));
            },
        }),
        we.RegisterCommand("videoDismissError", {
            title: "OK",
            undo: !1,
            callback: function () {
                this.video.hideProgressBar(!0);
            },
        }),
        we.RegisterCommand("videoSetSize", {
            undo: !0,
            focus: !1,
            title: "Update",
            refreshAfterCallback: !1,
            callback: function () {
                this.video.setSize();
            },
        });
});
