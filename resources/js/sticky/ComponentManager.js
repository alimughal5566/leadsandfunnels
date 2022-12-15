import StepsCarousal from '@components/StepsCarousal'
import CtaFields from '@components/CtaFields/View'
import AdvancedSetings from '@components/AdvancedSettings/View'
import SettingsPanel from '@components/SettingsPanel'
import StackOrder from '@components/StackOrder/View'
import StickyPreview from '@components/StickyPreview'
import StickyScriptHandler from '@components/StickyScriptHandler'
import Tooltip from '@components/Tooltip'
import UrlHandler from '@components/UrlHandler/View'
import UrlPathPopup from '@components/UrlPathPopup'
import UrlPreview from '@components/UrlPreview/View'
import SaveButtonHandler from '@components/SaveButtonHandler/View'
import AttributesUpdater from '@components/AttributesUpdater'
import InstructionModal from '@components/InstructionModal'




export default class ComponentManager {
    
    constructor(store, data, $element, funnelObj){
        this.store = store;
        this.data = data;
        this.$element = $element;
        this.funnelObj = funnelObj;
    }

    init(){
        let store = this.store;
        let data = this.data;
        let $el = this.$element;
        let funnelObj = this.funnelObj;

        new SettingsPanel(store, data, $el, funnelObj);
        new StepsCarousal(store, data, $el, funnelObj);
        new CtaFields(store, data, $el, funnelObj);
        new AdvancedSetings(store, data, $el, funnelObj);
        new StackOrder(store, data, $el, funnelObj);
        new StickyPreview(store, data, $el, funnelObj);
        new StickyScriptHandler(store, data, $el, funnelObj);
        new Tooltip(store, data, $el, funnelObj);
        new UrlHandler(store, data, $el, funnelObj);
        new UrlPathPopup(store, data, $el, funnelObj);
        new UrlPreview(store, data, $el, funnelObj);
        new SaveButtonHandler(store, data, $el, funnelObj);
        new AttributesUpdater(store, data, $el, funnelObj);
        new InstructionModal(store, data, $el, funnelObj);
    }
}