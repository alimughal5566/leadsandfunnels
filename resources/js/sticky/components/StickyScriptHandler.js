
import $ from '@/jQueryCache';
import ViewComponent from '@/ViewComponent';
import {notify, selectText} from '@/utils';


export default class StickyScriptHandler extends ViewComponent {

    initEvents(){
        $('.btn-copy').click(this.callback(this.copyCode))
        $('#code-block').click(this.callback(this.selectTextOnClick))
    }

    copyCode(e, {view}) {
            
        e.preventDefault();

        var $temp = $("<input>");
        $("body").append($temp);
        
        const script = $('#code-block').text().replace(/\>\s+\</g,'><').replace(/\s+/g, ' ');

        $temp.val(script).select();
        
        document.execCommand("copy");
        
        $temp.remove();
        
        notify.success('Sticky Bar code has been copied to the clipboard.')

    }

    selectTextOnClick(e){
        selectText('code-block');
    }

}
