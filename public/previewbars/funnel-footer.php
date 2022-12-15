<div class="funnel-footer">
    <div class="funnel-footer__holder">
        <ul class="logo-list-mobile">
            {{#each ../meta.footer_mobile_logos}}
                <li>
                    <div class="image-wrap">
                        <img src="{{this}}">
                    </div>
                </li>
            {{/each}}
        </ul>
        <div class="funnel-footer__info">
            <ul class="funnel-footer-links">
                {{#each ../meta.footer_links}}
                <li><a href="javascript:void(0)" title="{{{this}}}">{{{this}}}</a></li>
                {{/each}}
            </ul>
        </div>
        <div class="funnel-footer__wrap">
            <div class="funnel-footer__copyright">
                <ul class="funnel-footer-copyright-logo">
                    {{#each ../meta.footer_logos}}
                        <li class="funnel-footer-logo">
                            <div class="image-wrap">
                                <img src="{{this}}">
                            </div>
                        </li>
                    {{/each}}
                </ul>
                <span class="text">{{{../meta.footer_copyright}}}</span>
            </div>
            <ul class="bab-aime-logo-desktop">
                {{#each ../meta.footer_bab_logos}}
                <li class="bab-aime-logo">
                    <img src="{{this}}">
                </li>
                {{/each}}
            </ul>
        </div>
    </div>
</div>
