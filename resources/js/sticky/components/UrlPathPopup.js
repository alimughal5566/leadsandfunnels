
import $ from '@/jQueryCache';
import $_ from 'jquery';
import {validateUrlPath} from '@/utils';
import ViewComponent from '@/ViewComponent';


export default class UrlPathPopup extends ViewComponent {

    init() {
        this.popupOpenCloseInit();
        this.contentScrollInit();
        this.closeFieldButtonInit();
        this.cancelFieldButtonInit();
    }

    initEvents(){
        $('.sticky-popup-wrap').on('click', '.add-url-btn', this.callback(this.addUrlField))
                               .on('input paste', '.input-url-path', this.callback(this.resetUrlPathError))

        $('.sticky-popup-wrap').on('change input paste', '.input-url-path', this.onFieldsChange);
        $('.sticky-popup-wrap').on('click', '#sticky-homepage-path-checkbox, .add-url-btn, .remove-url', this.onFieldsChange);
        $('.sticky-popup-wrap').on('change', '#sticky-homepage-path-checkbox', this.callback(this.onCheckboxChange));

        $('.sticky-popup-wrap').on('click', '.remove-url', this.callback(this.onRemoveUrlPathField));
    }

    onFieldsChange(){
        $(document).trigger('lp:sticky:stateChanged');
    }

    popupOpenCloseInit() {

        $('.switcher__link').click(function () {
            $('#sticky-url-popup-website').text($('#url').val());
            $(this).parents('.sticky-side').addClass('url-active');
        });

        $('.back-url').click(function () {
            $(this).parents('.sticky-side').removeClass('url-active');
        });
    }

    contentScrollInit() {

        $(".url-slide__wrap").mCustomScrollbar({
            axis:"y",
            autoExpandScrollbar: true,
            autoHideScrollbar :true,
            mouseWheel:{
                scrollAmount: 100
            },
        });

        $(".url-slide__wrap").mCustomScrollbar("update");
    }

    onCheckboxChange(e, {view}){
        view.validateAllFields()
    }

    validateAllFields(){
        let allValid = true
        let urlPaths = []
        const view = this

        $_('.url-fields-wrap .input-url-path').each(function (){

            if( !view.validatePathField( $(this), urlPaths ) ){
                allValid = false;
            }

            urlPaths = urlPaths.filter((val, index, arr) => arr.indexOf(val) === index)
        })

        return allValid
    }

    addUrlField(e, {view}){

        e.preventDefault();

        const allValid = view.validateAllFields()

        if(allValid){
            const $newField = $_(view.getNewFieldHtml());
            $(this).parents('.url-slide__detail').find('.url-fields-wrap').append($newField)
            $newField.slideDown(() => {
                $newField.find('input').focus()
            });
        }

    }

    resetUrlPathError(e){
        $(this).parents('.url-add-field').removeClass('has-error')
    }

    validatePathField(element, urlPaths){

        const $element = $(element);

        const $urlField = $element.parents('.url-add-field');

        const $errorMessage = $urlField.find('.error-message');

        const value = $element.val();
        const valid = validateUrlPath(value);

        if(!value){
            $errorMessage.text('This field is required.');
            $urlField.addClass('has-error');

            return false
        } else if (!valid){
            $errorMessage.text('Please enter a valid path.');
            $urlField.addClass('has-error');

            return false
        } else if (urlPaths.indexOf(value.trim()) > -1 || ($('#sticky-homepage-path-checkbox').prop('checked') && value.trim() == '/')) {
            $errorMessage.text('This path is already used, try another.');
            $urlField.addClass('has-error');

            return false
        } else {
            urlPaths.push(value.trim())
            $urlField.removeClass('has-error');
        }

        return true
    }


    closeFieldButtonInit() {
        $('.sticky-popup-wrap').on('click', '.close-field', function(e){
            e.preventDefault();
            var _self = $(this);
            _self.parents('.url-add-field').addClass('active');
        });
    }

    cancelFieldButtonInit() {
        $('.sticky-popup-wrap').on('click', '.active-url', function(e){
            e.preventDefault();
            var _self = $(this);
            _self.parents('.url-add-field').removeClass('active');
        });
    }

    onRemoveUrlPathField(e){
        e.preventDefault();
        const $field = $(this).parents('.url-add-field');
        $field.slideUp(() => $field.remove());
    }

    getNewFieldHtml() {
        return `<div class="url-add-field" style="display: none;">
                    <div class="field">
                        <label><i class="ico-link"></i></label>
                        <input class="form-control input-url-path" name="pages[]" type="text" placeholder="/url-path-goes-here">
                        <a href="#" class="close-field"><i class="ico-cross"></i></a>
                        <span class="error-message">Please Enter a valid Path</span>
                    </div>
                    <div class="url-message">
                        <span class="text">Are you sure you want to delete this path?</span>
                        <ul class="url-option">
                            <li><a href="#" class="remove-url">YES</a></li>
                            <li><a href="#" class="active-url">NO</a></li>
                        </ul>
                    </div>
                </div>`
    }

}
