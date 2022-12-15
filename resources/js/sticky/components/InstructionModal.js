import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';


export default class InstructionModal extends ViewComponent {

    init() {
        this.instructionModalInit();
    }

    instructionModalInit() {

        $(".quick-scroll").mCustomScrollbar({
            axis: "y",
            autoExpandScrollbar: true,
            autoHideScrollbar: false,
            mouseWheel: {
                scrollAmount: 100
            },
        });
    }

}
