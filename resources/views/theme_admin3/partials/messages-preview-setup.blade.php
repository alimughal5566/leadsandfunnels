@push('footerScripts')
<script>
    var preview_module = {};
    var defaultLocalStoragePrefix = "module_";
    var defaultFunnelhash = "{{ @$view->data->currenthash }}";
    var defaultIframeHolder = "#preview_iframe";
    var defaultIframeSrc = "{{$view->data->questionPreview->iframeSrc}}";

    var previewIframe = {
        localStoragePrefix: "{{@$iframeProps["localStoragePrefix"]}}" || defaultLocalStoragePrefix,
        currenthash: "{{@$iframeProps["currenthash"]}}" || defaultFunnelhash,
        iframeHolder: "{{@$iframeProps["iframeHolder"]}}" || defaultIframeHolder,
        iframeSrc: "{{@$iframeProps["iframeSrc"]}}" || defaultIframeSrc,
        showCtaMessages: "{{@$iframeProps["showCtaMessages"]}}" || 1,
        showFeatureImage: "{{@$iframeProps["showFeatureImage"]}}" || 1,

        /**
         * Create Iframe OR sends data to iframe with post-message
         * @param createIframe
         * @param funnelInfo
         */
        reloadIframe: function (createIframe = false, funnelInfo = false, postMessageParam= false) {
            let postMessage = postMessageParam? postMessageParam: 'refresh-data';
            var funnelData = funnelInfo ? funnelInfo : JSON.stringify(preview_module.funnelInfo);
            previewIframe._removeLocalStorageKey(previewIframe.localStoragePrefix);
            localStorage.setItem(previewIframe.localStoragePrefix + previewIframe.currenthash, funnelData);

            if (createIframe) {
                $(previewIframe.iframeHolder).html('<div class="tcpa-security-preview-iframe-holder"><iframe class="tcpa-security-preview-iframe" id="my-iframe" src=' + previewIframe.iframeSrc + ' frameborder="0" width="100%" scrolling="no"></iframe></div>');
            } else {
                const frame = document.getElementById("my-iframe");
                frame.contentWindow.postMessage(postMessage, '*');
            }
        },

        _removeLocalStorageKey: function (pref) {
            for (var key in localStorage) {
                if (key.indexOf(pref) == 0) {
                    localStorage.removeItem(key);
                }
            }
        }
    };

    $(document).ready(function () {
        var funnel_questions = '{!! addslashes(@$view->data->questionPreview->funnel_questions) !!}';
        var first_question = '{{  @$view->data->questionPreview->required_question_no }}';
        if (funnel_questions && funnel_questions !== "null") {
            funnel_questions = jQuery.parseJSON(funnel_questions);
            var id = '{{@$tcpaMessage['id']}}';
            var messages = [
                {
                    id: id,
                    tcpa_text: `{!!  @$tcpaMessage['tcpa_text'] !!}`,
                    tcpa_title: '{{@$tcpaMessage['tcpa_title'] ?? ""}}',
                    is_required: '{{@$tcpaMessage['is_required'] ?? ""}}',
                    icon: '{!! addslashes(@$tcpaMessage['icon']) !!}',
                    tcpa_text_style: '{!! addslashes(@$tcpaMessage['tcpa_text_style']) !!}'
                }
            ];

            preview_module.funnelInfo = {
                hidden_fields: null,
                question_value: "",
                questions: funnel_questions,
                sequence: ["1"],
                cta_main_message: previewIframe.showCtaMessages == 1? `{{ trim(textCleaner(@$view->data->questionPreview->cta_settings->homePageMessageMainMessage)) }}` : "",
                cta_main_message_style:  previewIframe.showCtaMessages == 1?  `{{ @$view->data->questionPreview->cta_settings->messageStyle }}` : "",
                cta_description:  previewIframe.showCtaMessages == 1?  `{{ trim(@$view->data->questionPreview->cta_settings->homePageMessageDescription) }}` : "",
                cta_description_style:  previewIframe.showCtaMessages == 1?   `{{ @$view->data->questionPreview->cta_settings->dmessageStyle }}` : "",
                feature_image:  previewIframe.showFeatureImage == 1?  `{{@$view->data->questionPreview->featured_image}}` : "",
                tcpa_messages: messages,
                meta:{}
            };

            previewIframe.reloadIframe(true);
        }
    });
</script>
@endpush
