
import $ from '@/jQueryCache';
import $_ from 'jquery';
import ViewComponent from '@/ViewComponent';


export default class Tooltip extends ViewComponent {

    init() {
        this.tooltipInit();
    }

    tooltipInit() {

        const $tooltips = $('.tooltipster')

        $tooltips.each(function (){
            
            const $self = $(this);
            
            const config = {
                trigger: 'hover',
                animation: 'fade',
                contentAsHTML: true,
                maxWidth: 300,
                delay: 100,
                contentCloning: true,
                interactive: true
            }

            const templateId = $self.attr('data-tooltip-html-content-id');

            if(templateId){
                config.content = $_($( '#' + templateId ).html());
            }

            const cssClass = $self.attr('data-tooltip-css-class');
            
            if(cssClass){
                config.theme = cssClass
            }

            $self.tooltipster(config);

            const tooltip = $self.tooltipster('instance');
            
            tooltip.on('created', function (e){
                $self.addClass('hovering');
            })
            
            tooltip.on('close', function (e){
                $self.removeClass('hovering');
            })
        })
    }

}