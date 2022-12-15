<span class="tcpa-privacy-wrap privacy-text{{#ifCond icon-position '==' 'Right Align'}} right{{/ifCond}}" {{#ifCond
      enable-security-message '==' 0}}style="display: none"{{/ifCond}}>
    <label class="check-label">
        <div class="checkbox-wrap" {{#ifCond tcpa_message_is_required '==' 1}}style="display: block"{{/ifCond}}>
            <input type="checkbox" class="checkbox" value="">
            <span class="check-icon"></span>
        </div>
        <span class="fake-label">
            <span class="privacy">{{{security_tcpa_messages}}}</span>
        </span>
    </label>
</span>

<div class="additional-content-text" froala-prview-size {{#ifCond enable-additional-content '==' 0}}style="display:
none;"{{/ifCond}}>
<div class="text">{{{additional-content}}}</div>
</div>
