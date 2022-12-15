<!-- when cta message active need to add class (cta-message-active) on mobile-preview-->
{{#ifCond ../cta-main-message '!=' ''}}
<div class="cta-message-wrap">
    <div class="cta-message">
        <h1 class="cta-message-heading" style="{{../cta-main-message-style}}">{{breaklines ../cta-main-message}}</h1>
    </div>
    <div class="cta-description">
        <strong class="description-text" style="{{../cta-description-style}}">{{breaklines ../cta-description}}</strong>
    </div>
</div>
{{/ifCond}}
