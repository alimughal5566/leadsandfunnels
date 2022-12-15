
import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';


export default class StepsCarousal extends ViewComponent {

    init() {
        this.carousalInit();
        this.navigationInit();
        this.contentScrollInit();
    }

    carousalInit() {

        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 0,
            nav: true,
            dots: true,
            touchDrag: false,
            mouseDrag: false,
            autoHeight : true,
            items:1,
        });
    }


    navigationInit(){
        
        const $carousal = $('.owl-carousel');

        $('.lp-sticky__btn-back').on('click',function(e){
            e.preventDefault();
            $carousal.trigger('prev.owl.carousel', [300]);
        });
    }

    contentScrollInit() {
        
        $(".scroll-holder").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar :true,
            mouseWheel:{
                scrollAmount: 100
            },
        });
    }
}