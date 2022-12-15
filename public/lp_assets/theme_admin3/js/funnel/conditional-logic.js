"use strict";
/**
 *  Main object if Cl Listing
 * @type {{conditionSequence: string, active: number, conditions: {}}}
 */

var clMinDate = moment("01/01/1920","MM/DD/YYYY");
var cl_object = {
    active:0,                      //Conditions are active for funnel or not
    conditionSequence: "",      //Index IDs for conditional statements as string
    conditions: {},
}
/**
 * temp object to sustain the original state of CL_OBJECT
 * @type {{conditionSequence: string, active: string, conditions: {}}}
 */
var Funnel_Condition = {
    active:'',                      //Conditions are active for funnel or not
    conditionSequence: "",      //Index IDs for conditional statements as string
    conditions: {},
}

var vehicle_make = [];
var vehicle_model = [];
/*
For the Isbetween data values
 */
var range_data = {
    start_val:"",
    end_val:""
};

/*
For the Isbetween BD date values
 */
var bd_range_data = {
    start_val:"",
    end_val:""
};
var funnelConditions = {
    _condition: {},
    _questionCLActive:[],
    resetQuestionClAction: function(){
        let targetElement = $("[data-hbs='funnelPanel']").find(".fb-question-item");
        $.each(targetElement,function (y,ele){
            $(ele).removeClass("conditional-logic-active");
        });
        funnelConditions._questionCLActive = [];
    },
    markActiveCLQuestionIcon: function(){
        let activeQuestions = funnelConditions.getQuestionCLActive();
        if(activeQuestions.length){
            let targetElement = $("[data-hbs='funnelPanel']").find(".fb-question-item");
            $.each(targetElement,function (y,ele){
                if($(ele).data("field").indexOf("~~")){
                    let contactFields = $(ele).data("field").split("~~");
                    let findFieldCL = false;
                    for (const contactField of contactFields) {
                        if(activeQuestions.inArray(contactField)){
                            findFieldCL = true;
                            break;
                        }
                    }
                    if(findFieldCL == true){
                        $(ele).addClass("conditional-logic-active");
                    }else{
                        $(ele).removeClass("conditional-logic-active");
                    }
                }else{
                    if(activeQuestions.inArray($(ele).data("field"))){
                        $(ele).addClass("conditional-logic-active");
                    }else{
                        $(ele).removeClass("conditional-logic-active");
                    }
                }
            });
        }else{ // for the case of the delete all
            funnelConditions.resetQuestionClAction();
        }
    },
    getQuestionCLActive:function(){
        return funnelConditions._questionCLActive;
    },
    setQuestionCLActive:function(){
        funnelConditions._questionCLActive = [];
        let conditions_sequence = cl_object.conditionSequence.toString().split("-");
        if(conditions_sequence.length){
            //let regex = /\d+/;
            for (let v=0; v < conditions_sequence.length; v++  ) {
                let qId = conditions_sequence[v];
                let fbQuesObj = cl_object.conditions[qId];
                if(fbQuesObj != undefined){
                    if(fbQuesObj['terms']['t1']['actionFieldId'] != undefined && fbQuesObj['terms']['t1']['actionFieldId'] != ""){
                        //let matches = fbQuesObj['terms']['t1']['actionFieldId'].match(regex);  // creates array from matches
                        funnelConditions._questionCLActive.push(fbQuesObj['terms']['t1']['actionFieldId']);
                        let modelReg = [/^model_\d*/,/^model\d*/];
                        let isModelField = modelReg.some(rx => rx.test(fbQuesObj['terms']['t1']['actionFieldId']));    // true | false
                        if(isModelField){ // add make field against to the model field
                            let modelField = fbQuesObj['terms']['t1']['actionFieldId'];
                            let makeField = modelField.replace(/model/g,"make");
                            funnelConditions._questionCLActive.push(makeField);
                        }
                    }
                    if(fbQuesObj['actions']['action']){
                        $.each(fbQuesObj['actions']['action'],function (key,val) {
                            if(val['conditionalFieldId'] != undefined && val['conditionalFieldId'].length > 0){
                                const thenArr1= funnelConditions._questionCLActive;
                                const thenArr2= val['conditionalFieldId'];
                                const mainthenArr=thenArr1.concat(thenArr2);
                                funnelConditions._questionCLActive=mainthenArr;
                            }
                        })
                    }
                    if( fbQuesObj.alt_actions.action.at1 && fbQuesObj.alt_actions.action.at1.conditionalFieldId != undefined && fbQuesObj.alt_actions.action.at1.conditionalFieldId.length > 0){
                        const altThenArr1= funnelConditions._questionCLActive;
                        const altThenArr2= fbQuesObj.alt_actions.action.at1.conditionalFieldId;
                        const mainaltThenArr=altThenArr1.concat(altThenArr2);
                        funnelConditions._questionCLActive=mainaltThenArr;
                    }
                }
            }
            let unique_data = funnelConditions._questionCLActive.filter(onlyUnique);
            funnelConditions._questionCLActive = unique_data;
            function onlyUnique(value, index, self) {
                return self.indexOf(value) === index;
            }
            funnelConditions.markActiveCLQuestionIcon();
        }else{
            funnelConditions.resetQuestionClAction();
        }
    },
    loadModal: function(){
        $('[data-cl-init-button]').click(function (e) {
            e.preventDefault();
            if(funnelConditions._hasConditions()){
                $('#active-condition-modal').modal('show');
            }
            else{
                //this._condition = {};
                clForm.reset();
                funnelConditions.resetObject();
                $('#conditional-logic-group').modal('show');
                $('#conditional-logic-group').find('#edit_cl').prop('disabled',true);

            }
        });
    },
    getCurrentQuestionIndex: function(){
        return funnelConditions._condition.index;
    },
    setCloneCondition:function(clone_obj){
        funnelConditions._condition = clone_obj;
    },
    getCurrentCondition:function(){
        return funnelConditions._condition;
    },
    getCurrentConditionStatus:function(){
        return funnelConditions._condition.active;
    },
    _hasConditions: function(){
        return Object.keys(cl_object.conditions).length > 0;
    },
    // On resetting question, it reset Conditional Logic to Default State
    resetCL: function(clInput){
        clForm.reset();
        funnelConditions.resetObject();

        if(clInput !== "null" && clInput !== "{}" && Object.keys(JSON.parse(clInput)).length){
            cl_object = clInput;
            $(".conditional-logic-item").addClass("active");
        } else{
            cl_object = {active:"", conditionSequence: "", conditions: {}}
            $(".conditional-logic-item").removeClass("active");
        }
    },
    resetActionCondition: function(repeater_index){
        let current_condition_obj = funnelConditions._condition.actions;
        let action_type = "";
        for(const key in current_condition_obj){
            const action_type_obj = current_condition_obj[key];
            if(action_type_obj.hasOwnProperty("a"+repeater_index)){
                action_type = key;
            }
        }
        if(action_type != "" && typeof action_type != undefined){
            // remove the action condition from the main cl_obj
            if(funnelConditions._condition['actions'][action_type].hasOwnProperty("a"+repeater_index)){
                delete funnelConditions._condition['actions'][action_type]["a"+repeater_index];
            }
        }
    },
    // Reset alt action condition
    resetAltActionCondition: function(){
        let current_alt_condition_obj = funnelConditions._condition.alt_actions;
        let alt_action_type = "";
        for(const key in current_alt_condition_obj){
            const action_alt_type_obj = current_alt_condition_obj[key];
            if(action_alt_type_obj.hasOwnProperty("at1")){
                alt_action_type = key;
            }
        }
        if(alt_action_type != "" && typeof alt_action_type != undefined){
            // remove the alt action condition from the main cl_obj
            if(funnelConditions._condition['alt_actions'][alt_action_type].hasOwnProperty("at1")){
                delete funnelConditions._condition['alt_actions'][alt_action_type]["at1"];
            }
        }
    },
    // Reset Current Condition object
    resetObject: function(){
        this._condition = {
            "index": "",
            "active": 1,
            "terms": {},
            "actions": {
                "action": {},
                "thankyou": {},
                "recipient": {}
            },
            "alt_actions": {
                "action": {},
                "thankyou": {},
                "recipient": {}
            }
        };
    },
    getStatesListHTML: function(states){
        let cl_value_html = "";
        cl_value_html = '<div class="cl-zip-state-input-field-wrap"><span class="d-none empty-zip-state">Select State<span class="arrow"></span></span><span class="clear-all-states" data-cl-state-action="clear-all"><span' +
            ' class="icon-close"></span>' +
            ' Clear</span><ul' +
            ' class="list-recipeint-tags">\n';
        states.forEach(function (item) {
            cl_value_html += '<li data-cl-state-id="'+item.id+'" data-cl-state-name="'+item.name+'" >\n';
            cl_value_html += '<span class="tag-item">' + item.name + '</span>\n';
            cl_value_html += '<span class="remove-tag">×</span>\n';
            cl_value_html += '</li>\n';
        });
        cl_value_html += "<input type='hidden' id='cl-value' name='cl_value[]' value='" + JSON.stringify(states) + "'>";
        cl_value_html += '</ul></div>';
        return cl_value_html;
    },
        getModelsListHTML: function(models){
            let cl_value_html = "";
            cl_value_html = '<div class="cl-models-input-field-wrap"><span class="d-none empty-models">Select Vehicle Models<span class="arrow"></span></span><span class="clear-all-models" data-cl-model-action="clear-all"><span' +
                    ' class="icon-close"></span>' +
                    ' Clear</span><ul' +
                    ' class="list-model-tags">\n';
            models.forEach(function (item) {
                    cl_value_html += '<li data-cl-model-id="'+item.id+'" data-cl-model-name="'+item.name+'" >\n';
                    cl_value_html += '<span class="tag-item">' + item.name + '</span>\n';
                    cl_value_html += '<span class="remove-tag">×</span>\n';
                    cl_value_html += '</li>\n';
                });
            cl_value_html += "<input type='hidden' id='cl-value' name='cl_value[]' value='" + JSON.stringify(models) + "'>";
            cl_value_html += '</ul></div>';
            return cl_value_html;
        },
        getMakeListHTML: function(makes){
            let cl_value_html = "";
            cl_value_html = '<div class="cl-make-input-field-wrap"><span class="d-none empty-make">Select Vehicle Make<span class="arrow"></span></span><span class="clear-all-makes" data-cl-make-action="clear-all"><span' +
                    ' class="icon-close"></span>' +
                    ' Clear</span><ul' +
                    ' class="list-make-tags">\n';
            makes.forEach(function (item) {
                    cl_value_html += '<li data-cl-make-id="'+item.id+'" data-cl-make-name="'+item.name+'" >\n';
                    cl_value_html += '<span class="tag-item">' + item.name + '</span>\n';
                    cl_value_html += '<span class="remove-tag">×</span>\n';
                    cl_value_html += '</li>\n';
                });
            cl_value_html += "<input type='hidden' id='cl-value' name='cl_value[]' value='" + JSON.stringify(makes) + "'>";
            cl_value_html += '</ul></div>';
            return cl_value_html;
        },
    devData: function(){
        //this._condition.terms["t1"] = { actionFieldId:"typeofproperty", operator:"IsNot", value:["Townhome"] };
        /* Zipcode Question
        this._condition.terms["t1"] = { actionFieldId:"zipcode_11", operator:"ContainsExactly", value:[98001] };
        this._condition.terms["t1"] = { actionFieldId:"zipcode_11", operator:"IsFilled", value:[98001] };
        this._condition.terms["t1"] = { actionFieldId:"zipcode_11", operator:"ContainsExactly", value:['state1','state2','state3'] };*/
        //Dropdown Question
        //this._condition.terms["t1"] = { actionFieldId:"dropdown_12", operator:"Is", value:["Option 1"] };
        //this._condition.terms["t1"] = { actionFieldId:"dropdown_12", operator:"IsAnyOf", value:["Option 1", "Option 2"] };
        //this._condition.terms["t1"] = { actionFieldId:"dropdown_12", operator:"IsNoneOf", value:["Option 1", "Option 2"] };
        //this._condition.terms["t1"] = { actionFieldId:"dropdown_12", operator:"IsKnown", value:[] };
        //Text Question
        //this._condition.terms["t1"] = { actionFieldId:"text_13", operator:"IsEmpty", value:["Mortgage Home"] };
        //slider Question
        //this._condition.terms["t1"] = { actionFieldId:"slider_14", operator:"IsEqualTo", value:[100] };
        //Number Question
        //this._condition.terms["t1"] = { actionFieldId:"number_15", operator:"IsEqualTo", value:[100] };
        //this._condition.terms["t1"] = { actionFieldId:"number_15", operator:"IsBetween", value:[100,200] };
        //this._condition.terms["t1"] = { actionFieldId:"number_15", operator:"IsKnown", value:[] };
        //Menu Question
        //this._condition.terms["t1"] = { actionFieldId:"menu_16", operator:"Is", value:[ "Answer 1 Goes Here"] };
        //this._condition.terms["t1"] = { actionFieldId:"menu_16", operator:"IsAnyOf", value:[ "Answer 1 Goes Here", "Answer 2 Goes Here" ] };
        //this._condition.terms["t1"] = { actionFieldId:"menu_16", operator:"IsKnown", value:[] };
        // Slider Numeric
        //this._condition.terms["t1"] = { actionFieldId:"slider_14", operator:"IsEqualTo", value:[100] };
        //this._condition.terms["t1"] = { actionFieldId:"slider_14", operator:"IsBetween", value:[100,200] };
        //this._condition.terms["t1"] = { actionFieldId:"slider_14", operator:"IsKnown", value:[] };
        // Slider NoN Numeric
        //this._condition.terms["t1"] = { actionFieldId:"slider_22", operator:"Is", value:["Option 1"] };
        //this._condition.terms["t1"] = { actionFieldId:"slider_22", operator:"IsAnyOf", value:["Option 1", "Option 2", "Option 3" ] };
        //this._condition.terms["t1"] = { actionFieldId:"slider_22", operator:"IsKnown", value:[] };
        this._condition.actions = {
            "action": {
                /*"a1":{
                    "visibility": "Show",
                    "conditionalFieldId": ["text-13"]
                }*/
                /*"a1": {
                    "visibility": "Hide",
                    "conditionalFieldId": [
                        "dropdown-12"
                    ]
                }*/
            },
            "thankyou": {
                /*"a1": {
                    "id": "386442"
                }*/
            },
            "recipient": {
                "a1": {
                    "id": [903727,903765,903766]
                }
            }
        };
        this._condition.alt_actions = {
            "action": {
                "at1":{
                    "visibility": "Show",
                    "conditionalFieldId": ["text-13"]
                }
                /*"at1": {
                    "visibility": "Hide",
                    "conditionalFieldId": [
                        "dropdown-12"
                    ]
                }*/
            },
            "thankyou": {
                /*"at1": {
                    "id": "386442"
                }*/
            },
            "recipient": {
                /*"at1": {
                    "id": [903727,903765,903766]
                }*/
            }
        };
    },
    removeCurrentConditionActionOptionByRepeater:function(repeater_index){
        let current_condition_index = funnelConditions.getCurrentQuestionIndex();
        funnelConditions.resetActionCondition(repeater_index);
        //cl_object.conditions[current_condition_index] = funnelConditions._condition;
        /*let current_condition_obj = cl_object.conditions[current_condition_index].actions;
        let action_type = "";
        for(const key in current_condition_obj){
            const action_type_obj = current_condition_obj[key];
            if(action_type_obj.hasOwnProperty("a"+repeater_index)){
                action_type = key;
            }
        }
        if(action_type != "" && typeof action_type!= undefined){
            // remove the action condition from the main cl_obj
            if(cl_object.conditions[current_condition_index]['actions'][action_type].hasOwnProperty("a"+repeater_index)){
                delete cl_object.conditions[current_condition_index]['actions'][action_type]["a"+repeater_index];
            }
        }*/
    },
    _getActiveConditionForActionsAltActions : function(target_obj,call_for,cindex){
        let active_condition = {
            "active_for":call_for,
            "active_option":"",
            "active_data":"",
        };
        for (const key in target_obj) {
            if(Object.keys(target_obj[key]).length) {
                active_condition.active_option = key
            }
        }
        if(active_condition.active_option !="" ){
            let act_index = "a"+cindex;
            let alt_act_index = "at"+cindex;
            switch (active_condition.active_option){
                case "recipient":
                    if(call_for == "actions"){

                        if(typeof target_obj.recipient[act_index].id != undefined && target_obj.recipient[act_index].id !="" ){
                            active_condition.active_data = target_obj.recipient[act_index].id;
                        }

                    }else if(call_for == "alt_actions"){
                        if(typeof target_obj.recipient[alt_act_index].id != undefined && target_obj.recipient[alt_act_index].id !="" ){
                            active_condition.active_data = target_obj.recipient[alt_act_index].id;
                        }
                    }
                    break;
                case "thankyou":
                    if(call_for == "actions"){
                        if(typeof target_obj.thankyou[act_index].id != undefined && target_obj.thankyou[act_index].id !="" ){
                            active_condition.active_data = target_obj.thankyou[act_index].id;
                        }
                    }else if(call_for == "alt_actions"){
                        if(typeof target_obj.thankyou[alt_act_index].id != undefined && target_obj.thankyou[alt_act_index].id !="" ){
                            active_condition.active_data = target_obj.thankyou.at1.id;
                        }
                    }
                    break;
                case "action":
                    if(call_for == "actions"){
                        if(typeof target_obj.action[act_index] != undefined && Object.keys(target_obj.action[act_index]).length ){
                            active_condition.active_data = target_obj.action[act_index];
                        }
                    }else if(call_for == "alt_actions"){
                        if(typeof target_obj.action[alt_act_index] != undefined && Object.keys(target_obj.action[alt_act_index]).length ){
                            active_condition.active_data = target_obj.action[alt_act_index];
                        }
                    }

                    break;
            }
        }
        return active_condition;
    },
    getActiveObjectForActionsAltActions : function(call_for,cindex){
        switch (call_for){
            case "actions":
                return funnelConditions._getActiveConditionForActionsAltActions(funnelConditions._condition.actions,"actions",cindex);
                break;
            case "alt_actions":
                return funnelConditions._getActiveConditionForActionsAltActions(funnelConditions._condition.alt_actions,"alt_actions",cindex);
                break;
        }
    },
    trigger:{
        _set: function(key, val,type = null) {
            if(funnelConditions._condition.terms["t1"] === undefined){
                funnelConditions._condition.terms["t1"] = { actionFieldId:"", operator:"", value:[],meta:{contactActionField:"",contactActionFieldID:""} };
            }
            if(type == "contact"){
                funnelConditions._condition.terms["t1"]["meta"][key] = val;
            }else{
                if(key === "value") val = val.filter(function(n){ return n; });
                funnelConditions._condition.terms["t1"][key] = val;
            }
            funnelConditions.saveBtnState();
        },
        setFieldId: function(val){ this._set('actionFieldId', val); },
        getFieldId: function(returnDropdownValue){
            let fieldId =  funnelConditions._condition.terms["t1"] !== undefined ? funnelConditions._condition.terms.t1.actionFieldId : "";
            return (returnDropdownValue !== undefined ? funnelQuestions.getQuestionTitle(fieldId).id : fieldId);
        },
        setOperator: function(val){ this._set('operator', val); },
        getOperator: function(returnTitle){
            let op =  funnelConditions._condition.terms["t1"] !== undefined ? funnelConditions._condition.terms.t1.operator : "";
            return (returnTitle !== undefined ? questionTriggers.list[op].title : op);
        },
        resetInputs:function(){
            funnelConditions._condition.terms["t1"]['value'] = [];
            if($("#cl-value").length){
                $("#cl-value").val("");
            }
            if($("[data-input-field-type='number']").find('input').length){
                $("[data-input-field-type='number']").find('input').val("");
            }
            if($("[data-input-field-type='text-multiple']").find('input').length){
                $("[data-input-field-type='text-multiple']").find('input').val("");
            }
        },
        setInputs: function(val){
            console.trace("++ setInputs ++")
            this._set('value', funnelConditions.parseCLInputValue(val));
        },
        getInputs: function(returnValue){
            let term_val =  funnelConditions._condition.terms["t1"] !== undefined ? funnelConditions._condition.terms.t1.value : "";
            return (returnValue !== undefined ? funnelConditions._condition.terms.t1.value : term_val);

        },
        setContactField:function(val){
            console.trace('setContactField');
            this._set('contactActionField', val,'contact');
        },
        setContactFieldID:function(val){
            this._set('contactActionFieldID', val,'contact');
        },
        getContactField:function(returnValue){
            let cnt_field_val =  funnelConditions._condition.terms["t1"]["meta"]["contactActionField"] !== undefined ? funnelConditions._condition.terms.t1.meta.contactActionField : "";
            return (returnValue !== undefined ? funnelConditions._condition.terms.t1.meta.contactActionField : cnt_field_val);
        }

    },
    actions:{
        index: 1,
        _setIndex: function(rindex){
            this.index = "a"+rindex;
        },
        _reset: function(){
            if(funnelConditions._condition.actions.action.hasOwnProperty(this.index)){
                delete funnelConditions._condition.actions.action[this.index]
            }
            else if(funnelConditions._condition.actions.thankyou.hasOwnProperty(this.index)){
                delete funnelConditions._condition.actions.thankyou[this.index]
            }
            else if(funnelConditions._condition.actions.recipient.hasOwnProperty(this.index)){
                delete funnelConditions._condition.actions.recipient[this.index]
            }
        },
        _set: function(node, key, val) {
            if(node === "questions"){
                if(funnelConditions._condition.actions.action[this.index] === undefined){
                    funnelConditions._condition.actions.action[this.index] = { visibility: "", conditionalFieldId: [] };
                }
                funnelConditions._condition.actions.action[this.index][key] = val;
            }
            else if(node === "recipient") {
                if(funnelConditions._condition.actions.recipient[this.index] === undefined){
                    funnelConditions._condition.actions.recipient[this.index] = { id: "" };
                }
                funnelConditions._condition.actions.recipient[this.index].id = val;
            }else if(node === "thankyou"){
                if(funnelConditions._condition.actions.thankyou[this.index] === undefined){
                    funnelConditions._condition.actions.thankyou[this.index] = { id: "" };
                }
                funnelConditions._condition.actions.thankyou[this.index].id = val;

            }
        },
        isFilled: function(){
            return ( Object.keys(funnelConditions._condition.actions.action).length > 0 ||
                Object.keys(funnelConditions._condition.actions.recipient).length > 0 ||
                Object.keys(funnelConditions._condition.actions.thankyou).length > 0)
        },
        questionVisibility: function(rindex, action, fieldId){
            this._setIndex(rindex);
            this._reset();
            let visibility = action.replace("action.", "");
            this._set('questions', "visibility", visibility);

            if(fieldId === "") this._set('questions', "conditionalFieldId", []);
            else this._set('questions', "conditionalFieldId", fieldId);
            funnelConditions.saveBtnState();
        },
        recipient: function(rindex, index, val,mode = null){
            this._setIndex(rindex);
            this._reset();
            this._set('recipient', index, val);
            funnelConditions.saveBtnState();

        },
        Thankyou: function(rindex, index, val){
            this._setIndex(rindex);
            this._reset();
            this._set('thankyou', index, val);
            funnelConditions.saveBtnState();
        },
        getRecipients: function(rindex){
            this._setIndex(rindex);
            if(funnelConditions._condition.actions.recipient[this.index] === undefined)
                return [];
            else
                return funnelConditions._condition.actions.recipient[this.index].id;
        }
    },
    alt_actions:{
        _reset: function(){  funnelConditions._condition.alt_actions = { action: {}, thankyou: {}, recipient: {} } },
        _set: function(node, key, val) {
            if(node === "questions"){
                if(funnelConditions._condition.alt_actions.action["at1"] === undefined){
                    funnelConditions._condition.alt_actions.action["at1"] = { visibility: "", conditionalFieldId: [] };
                }
                funnelConditions._condition.alt_actions.action["at1"][key] = val;
            } else {
                if(funnelConditions._condition.alt_actions[key]["at1"] === undefined){
                    funnelConditions._condition.alt_actions[key]["at1"] = { id: "" };
                }

                funnelConditions._condition.alt_actions[key]["at1"] = { id: val };
            }
        },
        questionVisibility: function(action, fieldId){
            this._reset();
            let visibility = action.replace("action.", "");
            this._set('questions', "visibility", visibility);

            if(fieldId === "") this._set('questions', "conditionalFieldId", []);
            else this._set('questions', "conditionalFieldId", [fieldId]);
            funnelConditions.saveBtnState();
        },
        recipientOrThankyou: function(index, val){
            this._reset();
            this._set('', index, val);
            funnelConditions.saveBtnState();
        },
        getRecipients: function(){
            if(funnelConditions._condition.alt_actions.recipient["at1"] === undefined)
                return [];
            else
                return funnelConditions._condition.alt_actions.recipient["at1"].id;
        },
        isFilled: function(){
            return ( Object.keys(funnelConditions._condition.alt_actions.action).length > 0 ||
                Object.keys(funnelConditions._condition.alt_actions.recipient).length > 0 ||
                Object.keys(funnelConditions._condition.alt_actions.thankyou).length > 0)
        },
    },
    parseCLInputValue:function(cl_value_input){
        let arr;
        let val = [];
        console.log('************cl_value_input************');
        console.log(typeof cl_value_input);
        console.log(cl_value_input);
        console.log('############cl_value_input#############');

        if(typeof cl_value_input === "object"){     // for array values
            val = cl_value_input.map(function(s) { return s.trim() });
        }
        else if( typeof cl_value_input === "string") {
            if(isJson(cl_value_input)){
                arr = Object.values(JSON.parse(cl_value_input));
                if(arr.length){
                    arr.map(function(obj){
                        if(obj.hasOwnProperty('name')){
                            let name = obj.name;
                            if(typeof name =='number')name = name.toString();
                            name = name.trim();
                            val.push(name);
                        }else if(obj.hasOwnProperty('value')){
                            let value = obj.value;
                            if(typeof value =='number')value = value.toString();
                            value = value.trim();
                            val.push(value);
                        }
                    });
                }
                else{
                    val.push(cl_value_input);
                }
            }else{
                val.push(cl_value_input.trim());
            }
        }
        else{
            let clValue = cl_value_input.trim();
            val = clValue.split(",");      // to convert single value to array
        }
        return val;

    },
    /**
     * Delete the empty actions index that had no value before saivng in the DB
     */
    deleteEmptyThenActionsIndex:function(){
        if(Object.keys(funnelConditions._condition.actions.action).length > 0){
            $.each(funnelConditions._condition.actions.action, function (i, row){
                if(typeof row.conditionalFieldId === "object" && row.conditionalFieldId.length === 0){
                    delete funnelConditions._condition.actions.action[i];
                }
            });
        }
        if(Object.keys(funnelConditions._condition.actions.recipient).length > 0){
            $.each(funnelConditions._condition.actions.recipient, function (i, row){
                if(typeof row.id === "string" && row.id === ""){
                    delete funnelConditions._condition.actions.recipient[i];
                }
                else if(typeof row.id === "object" && row.id.length === 0){
                    delete funnelConditions._condition.actions.recipient[i];
                }
            });
        }
        if(Object.keys(funnelConditions._condition.actions.thankyou).length > 0){
            $.each(funnelConditions._condition.actions.thankyou, function (i, row){
                if(typeof row.id === "string" && row.id === ""){
                    delete funnelConditions._condition.actions.thankyou[i];
                }
                else if(typeof row.id === "object" && row.id.length === 0){
                    delete funnelConditions._condition.actions.thankyou[i];
                }
            });
        }
    },
    /**
     * Delete the empty alt actions index that had no value before saivng in the DB
     */
    deleteEmptyAltThenActionsIndex:function(){
        if(Object.keys(funnelConditions._condition.alt_actions.action).length > 0){
            $.each(funnelConditions._condition.alt_actions.action, function (i, row){
                if(typeof row.conditionalFieldId === "object" && row.conditionalFieldId.length === 0){
                    delete funnelConditions._condition.alt_actions.action[i];
                }
            });
        }
        if(Object.keys(funnelConditions._condition.alt_actions.recipient).length > 0){
            $.each(funnelConditions._condition.alt_actions.recipient, function (i, row){
                if(typeof row.id === "string" && row.id === ""){
                    delete funnelConditions._condition.alt_actions.recipient[i];
                }
                else if(typeof row.id === "object" && row.id.length === 0){
                    delete funnelConditions._condition.alt_actions.recipient[i];
                }
            });
        }
        if(Object.keys(funnelConditions._condition.alt_actions.thankyou).length > 0){
            $.each(funnelConditions._condition.alt_actions.thankyou, function (i, row){
                if(typeof row.id === "string" && row.id === ""){
                    delete funnelConditions._condition.alt_actions.thankyou[i];
                }
                else if(typeof row.id === "object" && row.id.length === 0){
                    delete funnelConditions._condition.alt_actions.thankyou[i];
                }
            });
        }
    },
    /**
     * Update Condition into main cl_object object
     * source_id is only required if you are using duplication of condition
     */
    updateObject: function(source_id=null){
        let increment;
        if(funnelConditions._condition.index === ""){
            // NEW Condition Case
            increment = 1;
            let sequence = 1;
            if(cl_object.conditionSequence !== ""){
                let seq_arr = cl_object.conditionSequence.toString().split("-");
                let ques_seq_arr = Object.values(seq_arr);
                increment = parseInt(Math.max(...ques_seq_arr) + 1);

                if(source_id !== null){
                    seq_arr.splice(seq_arr.indexOf(source_id.toString())+1, 0, increment);
                    sequence = seq_arr.join("-");
                } else {
                    sequence = cl_object.conditionSequence +"-" + increment;
                }
            }
            funnelConditions._condition.index = increment;
            cl_object.conditionSequence = sequence;
        }
        else {
            // UPDATE Condition Case
            if(funnelConditions._condition.active == -1) funnelConditions._condition.active = 0; // Broken condition update status to inactive on save btn
            increment = funnelConditions._condition.index;
        }
        funnelConditions.deleteEmptyThenActionsIndex();
        funnelConditions.deleteEmptyAltThenActionsIndex();
        cl_object.conditions[increment] = this._condition;
        this.resetObject();
    },
    combineActions: function(actions, recipients, thankyous){
        let all_keys = (Object.keys(actions).concat(Object.keys(recipients), Object.keys(thankyous))).sort();
        let all_actions = {};
        $.each(all_keys, function (i, key){
            if(actions.hasOwnProperty(key)) {
                all_actions[key] = JSON.parse(JSON.stringify( actions[key] ));
                all_actions[key]['type'] = "actions";
            }
            else if(recipients.hasOwnProperty(key)){
                all_actions[key] = JSON.parse(JSON.stringify( recipients[key] ));
                all_actions[key]['type'] = "recipients";
            }
            else if(thankyous.hasOwnProperty(key)){
                all_actions[key] = JSON.parse(JSON.stringify( thankyous[key] ));
                all_actions[key]['type'] = "thankyou";
            }

        });
        return all_actions
    },
    saveBtnState: function(){
        if(!clForm.pauseEvent) {
            let validated = false;
            if(clForm.validateTrigger() && clForm.validateAction()){
                validated = true;
            }

            if (validated) {
                $('#conditional-logic-group').find('#edit_cl').prop('disabled', false);
            } else {
                $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
            }
        }
    },
    refreshCL:function(){
        console.log("**************************");
        console.log("Call from the FB save btn => refreshCL");
        console.log("##########################");
        clForm.init(2)
    },
};
// Loading JSON from DB
if(conditional_json !== "null" && conditional_json !== "{}" && Object.keys(JSON.parse(conditional_json)).length){
    cl_object = JSON.parse(conditional_json);
}

const inputPlaceholders = {
    zipcode: '<textarea autocomplete="off" id="cl-value" name="cl_value[]" class="form-control-textarea" placeholder="Type in Zip Code(s)" oninput="this.value = this.value.replace(/[^0-9,]/g, \'\').replace(/(\\..*?)\\..*/g, \'$1\');"></textarea>',
    stateTextField: '<input type="text" autocomplete="off" data-type="state-text" id="cl-value" name="cl_value[]" class="form-control text-field" placeholder="Type in States" oninput="this.value = this.value.replace(/[^a-zA-Z,]/g, \'\').replace(/(\\..*?)\\..*/g, \'$1\');"/>',
    validEmailField: '<input type="text" data-cl-contact-valid-email="" autocomplete="off" data-type="text" id="cl-value" name="cl_value[]" class="form-control email-valid-field" placeholder="Type in Email"/>',
    emailField: '<input type="text" data-cl-email="" autocomplete="off" data-type="text" id="cl-value" name="cl_value[]" class="form-control email-field" placeholder="Type in Text"/>',
    textField: '<input type="text" autocomplete="off" data-type="text" id="cl-value" name="cl_value[]" class="form-control text-field" placeholder="Type in Text"/>',
    bdTextField: '<input autoComplete="off" type="text" data-cl-bd-date="" id="cl-value" name="cl_value[]" className="form-control bdtext" placeholder="MM/DD/YYYY" maxLength="10">',
    contactPhoneField: '<input type="tel" data-cl-contact-phone="" autocomplete="off" data-type="text" id="cl-value" name="cl_value[]" class="form-control number-field" placeholder="(___) ___-____"/>',
    selectQuestion: '<div class="select2_style"><span class="text">Select Question</span></div>',
    selectQuestions: '<div class="select2_style"><span class="text">Select Answers</span></div>',
    selectOption: '<div class="select2_style"><span class="text">Select Option</span></div>',
    selectActionOption: '<option value="">Select Action</option>',
    questionHtml: function(type, counter, question_text){
        return '<div class="select2_style" title="'+counter+' '+question_text+'"><span class="icon-holder"><i class="ico-'+( type.substring(0, 6) === "slider" ? "slider" : type )+'"></i></span><span class="text">'+counter+' '+question_text+'</span></div>';
    },
    questionThanAllHtml: function(type, counter, question_text){
        return '<div class="select2_style cl-select-row" title="'+counter+' '+question_text+'"><label class="fake-checkbox"><span class="text"><i class="check-icon"></i><span class="icon-holder"><i class="ico-'+( type.substring(0, 6) === "slider" ? "slider" : type )+'"></i></span>'+counter+' '+question_text+'</span></label></div>';
    }
}

const clListingMarkup = {
    getComponent:function (actions, recipients, thankyous, section) {
        let then=[];
        then['html'] = '';
        then['string'] = '';
        let visibility='';
        let includehead = true;
        let data = funnelConditions.combineActions(actions, recipients, thankyous);
        $.each(data,function (k, actiondata){
            if(includehead){
                includehead = false;
                if(section === "allcases"){
                    section = "In All Other Cases";
                } else {
                    section = "Then";
                }
                // then['string'] += section +' ' ;
                then['html'] += '<div class="text-wrap">\n' +
                    '<span class="text el-tooltip"><i class="icon ico-line"></i><span class="sub-heading">' + section + '</span></span>\n' +
                    '</div>\n';
            }
            if(actiondata['type'] === "actions"){
                visibility = actiondata['visibility'] + ' Questions';
                let title_data = new Array();

                $.each(actiondata['conditionalFieldId'],function(i,obj){

                    let ques_info  =funnelQuestions.getQuestionTitle(obj);
                    let position =ques_info['position'];
                    let quesTitle =ques_info['title'];
                    if(ques_info['type']=='vehicle' ||ques_info['type']=='contact'){
                        position =ques_info['position'].split('.')[0]+'.'
                        if(ques_info['type']=='contact'){
                            quesTitle='Contact| '+ques_info['subType']+' Step'
                        }

                    };
                    let title = position+" "+quesTitle;
                    if(i<5)title_data.push(title);
                });
                let new_title_string = title_data.join(", ");
                then['string'] += visibility+' '+new_title_string;

                then['html'] += '<div class="text-wrap">\n' +
                    '<span class="text tooltip-label cl-tooltip-label-text" title="<strong>' + visibility + '</strong> - &ldquo;<strong></strong>' + new_title_string + ' &rdquo;">\n' +
                    '<i class="icon ' + (actiondata['visibility'] === "Hide" ? 'ico-hidden' : 'ico-view') + '"></i><span class="green">' + visibility + '</span> - “<span class="num"></span>' + new_title_string + '”\n' +
                    '</span>\n' +
                    '</div>';
            }
            else if(actiondata['type'] === "recipients"){
                then['string'] +='Lead Alert Recipient: '+actiondata.id.length +' Recipients Selected ';
                then['html'] += '<div class="text-wrap">\n' +
                    '<span class="text tooltip-label cl-tooltip-label-text" title="<strong>CHANGE LEAD ALERT RECIPIENT</strong> - &ldquo;<strong>' + actiondata.id.length + '</strong> Recipients Selected &rdquo;">\n' +
                    '<i class="icon ico-client"></i><span class="orange">Change Lead Alert Recipient </span> - “<span class="num">'+ actiondata.id.length +' </span> Recipients Selected”\n' +
                    '</span>\n' +
                    '</div>';
            }
            else if(actiondata['type'] === "thankyou"){
                let thankYoutype=window.thankyouList[actiondata.id].typ_type;
                let title='';
                if(thankYoutype === "internal"){
                    title='thank_you_title';
                    if(window.thankyouList[actiondata.id][title]==null){
                        window.thankyouList[actiondata.id][title] = 'Default Success Message';
                    }

                }else{
                    title='thankyou_url';
                }

                then['string'] +=window.thankyouList[actiondata.id][title] +' '+'Show Specific Thank You Page'+' '
                then['html'] += '<div class="text-wrap">\n' +
                    '<span class="text tooltip-label cl-tooltip-label-text" title="<strong>SHOW SPECIFIC THANK YOU PAGE</strong> - &ldquo;'+ window.thankyouList[actiondata.id][title] +'&rdquo;">\n' +
                    '<i class="icon ico-heart"></i><span class="purple">Show Specific Thank You Page </span> - “'+ window.thankyouList[actiondata.id][title] +'”\n' +
                    '</span>\n' +
                    '</div>';
            }
        });
        return then;
    },

    getQuestionListingTitle: function(actionFieldId){
        let ques_info = funnelQuestions.getQuestionTitle(actionFieldId);
        let question = ques_info['title'];
        if (question === "Question OFF") {
            question = "Question # "+ques_info['position'];
        } else {
            question = ques_info['position']+" "+question;
        }
        return question;
    },

    getConditionRowHTML:function ( index, k, term, then,altAc, status) {
        let result = new Array();
        let question = clListingMarkup.getQuestionListingTitle(term['actionFieldId']);
        let term_input = term['value'].toString();
        let operatorTitle = questionTriggers.list[term['operator']].title;
        let statusClass="item-wrap";
        let disabledToggle="";
        if(status == -1){
            statusClass ="item-wrap disabled cl-warning"
            disabledToggle=" disabled "
        }
        else if(status == 0){statusClass ="item-wrap disabled"}
        else {statusClass ="item-wrap"}
        result['string']= operatorTitle +' '+ question  +' '+ term_input;
        result['index']=index;
        result['html']='                         <li class="'+statusClass+'" data-main-li-'+k+' data-cl-index="'+index+'">\n' +
            '                                        <span class="draging-item-link"><i class="ico-drag-dots"></i></span>\n' +
            '                                        <div class="checkbox-wrap">\n' +
            '                                            <label class="checkbox-label">\n' +
            '                                                <input data-cl-drag type="checkbox" value="'+index+'" class="condition-check">\n' +
            '                                                <span class="checkbox-text"><i class="icon"></i></span>\n' +
            '                                            </label>\n' +
            '                                            <span class="disable-btn"><i class="ico-ban-solid"></i></span>\n' +
            '                                        </div>\n' +
            '                                        <div class="text-area">\n' +
            '                                            <div class="text-wrap">\n' +
            '                                                <span class="text tooltip-label cl-tooltip-label el-tooltip" title=" <strong class=\'tooltip-condition-name\' > IF </strong> - &ldquo;'+ question +'&rdquo; <strong class=\'tooltip-condition-name\'>'+operatorTitle+'</strong> &ldquo;'+term_input+'&rdquo;"><i class="icon ico-arrow-thick-right"></i><span class="warning-icon-wrap el-tooltip" title=\'<div' +
            ' class="warning-tooltip">There is a problem with this condition. Go to the Edit mode to fix' +
            ' the error.</div>\'><i' +
            ' class="app-ico-warning"></i></span><span class="blue">IF</span> - “'+ question +'” <span class="blue">'+operatorTitle+'</span>'+(term_input !== "" ? ' - “'+term_input+'”' : '')+'</span>\n' +
            '                                            </div>\n' +
            '                                       <div class="condition-slide" data-then-condition-list >'+then+'' +
            '                                               '+ altAc+

            '                                               </div>\n'+
            '                                            <div class="hover-block">\n' +
            '                                                <ul class="option-hover-list">\n' +
            '                                                    <li>\n' +
            '                                                        <a href="#cl-confirmation-delete" data-value="'+index+'" data-cl-list-action="delete" data-toggle="modal" class="el-tooltip " title=\'<div class="option-tooltip">Delete</div>\'><span class="ico-cross"></span></a>\n' +
            '                                                    </li>\n' +
            '                                                    <li>\n' +
            '                                                        <a href="#" data-value="'+index+'" data-cl-list-action="copy" class="el-tooltip" title=\'<div class="option-tooltip">Copy</div>\'><span class="ico-copy"></span></a>\n' +
            '                                                    </li>\n' +
            '                                                    <li>\n' +
            '                                                        <a href="#" data-value="'+index+'" data-cl-list-action="edit" class="el-tooltip" title=\'<div class="option-tooltip">Edit</div>\'><span class="ico-edit"></span></a>\n' +
            '                                                    </li>\n' +
            '                                                </ul>\n' +
            '                                                <a href="#" class="hover-opener">\n' +
            '                                                    <i class="fbi fbi_dots">\n' +
            '                                                        <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                        <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                        <i class="fa fa-circle" aria-hidden="true"></i>\n' +
            '                                                    </i>\n' +
            '                                                </a>\n' +
            '                                            </div>\n' +
            '                                        </div>\n' +
            '                                        <div class="conidtion-status-checkbox-wrap">\n' +
            '                                           <div class="funnel-checkbox conidtion-status-checkbox">\n' +
            '                                               <label class="checkbox-label">\n' +
            '                                                   <input class="status-field-label fb-field-label" data-cl-list-action="status" '+disabledToggle+' data-value="'+index+'" data-single-status value="'+clList.getFunnelConditions().conditions[index].active +'"  type="checkbox" >\n' +
            '                                                   <span class="checkbox-area">\n' +
            '                                                       <span class="handle"></span>\n' +
            '                                                   </span>\n' +
            '                                               </label>\n' +
            '                                            </div>\n' +
            '                                         </div>\n' +
            '                                        <span class="opener-wrap">\n' +
            '                                                <a href="#" class="block-opener el-tooltip" title=\'<div class="condition-tooltip">expand condition</div>\'><i class="ico-arrow-down"></i></a>\n' +
            '                                            </span>\n' +
            '                                    </li>'  ;

        return result;
    },
    emptyCase:function (messege='No Condition Available') {
        var emptyHtml='';
        emptyHtml='                    <div data-empty-cl-list class="item-wrap condition-message-block-parent d-none">\n' +
            '                          <div class="condition-message-block">\n' +
            '                               <span class="icon-wrap"><i class="ico-search"></i></span>\n' +
            '                               <span class="condition-message-text" data-cl-empty-case-span>'+messege+'</span>\n' +
            '                         </div>\n' +
            '                      </div>';
return emptyHtml;
    },
    saveCondition: function (obj,instanSave=false) {
        let result=true;
        if(obj === undefined || obj === null){
            obj = {};
        }
        let success;
        if(obj.hasOwnProperty("success")){
            success = obj.success;
        } else {
            success = 'Your request processed successfully';
        }

        $.ajax({
            type: "POST",
            data: {
                "client_leadpop_id": $("#client_leadpop_id").val(),
                "conditional_logic": JSON.stringify(clList.getFunnelConditions())
            },
            url: $('#condition-logic-form').data('action'),
            cache: false,
            async: false,
        }).done(function (data) {
            result=true;
            if(instanSave===true){
            Object.assign(cl_object,Funnel_Condition)
            Object.assign(Funnel_Condition,clList.reSetTempObj())
            }
                displayAlert('success', success);
        }).fail(function (data) {
            result=false;
            displayAlert('danger', 'Your request was not processed. Please try again..');
        }).always(function (data) {
            // Nothing here
        });
        return result
    },
}
var questionsExcludedclForm = ['ctamessage'];
var funnelQuestions = {
    _questions: [],
    _questionsCombined: [],
    _opt_prefix: 'seq_',
    _ques_labels:{},
    _curr_ques_seq:1,
    setVehicleQuestionData:function(){
        let funnelInfo = FunnelsUtil._getFunnelInfo('local_storage');
        for (let v=0; v < funnelInfo.sequence.length; v++  ) {
            let qId = funnelInfo.sequence[v];
            let fbQuesObj = JSON.parse(JSON.stringify(funnelInfo.questions[qId]));
            if(fbQuesObj['question-type'] == "vehicle"){
                if(!vehicle_make.length){
                    let makes = funnelQuestions.getVehicleMakeModel(app_config.app.url+"/lp/vehicle/make");
                    vehicle_make = (makes.length) ? makes : [];
                }
                if(!vehicle_model.length){
                    let models = funnelQuestions.getVehicleMakeModel(app_config.app.url+"/lp/vehicle/model");
                    vehicle_model = (models.length) ? models : [];
                }
            }
        }
    },
    getQuestionCloneSequence:function(){
        let increment = 1;
        let seq_arr = cl_object.conditionSequence.toString().split("-");
        let ques_seq_arr = Object.values(seq_arr);
        increment = parseInt(Math.max(...ques_seq_arr));
        return increment;
    },
    _setQuestionSequence: function(){
        let increment = 1;
        if(cl_object.conditionSequence !== ""){
            let seq_arr = cl_object.conditionSequence.toString().split("-");
            let ques_seq_arr = Object.values(seq_arr);
            increment = parseInt(Math.max(...ques_seq_arr) + 1);
        }
        this._curr_ques_seq = increment;
    },
    getQuestionSequence: function(){
        return this._curr_ques_seq;
    },
    getEmptyQuestion: function (){
        this._questions[this._opt_prefix] = { id: 0, text: inputPlaceholders.selectQuestion, title: 'Question', type: '' };
        this._questionsCombined[this._opt_prefix] = { id: 0, text: inputPlaceholders.selectQuestion, title: 'Question', type: '' };
    },
    getQuestions: function(list_type){
        console.log(">>>>>>>>>>>>>>>>getQuestions<<<<<<<<<<<<<<<<<<<")
        console.log(this._questions);
        console.log(Object.values(this._questions));
        console.log(">>>>>>>>>>>>>>>>getQuestions<<<<<<<<<<<<<<<<<<<")

        if(list_type === undefined)
            list_type = "single";       // Possible Values: single / combined

        if(list_type === "combined")
            return Object.values(this._questionsCombined);
        else
            return Object.values(this._questions);
    },
    getQuestionTitle: function(ques_field){
        if(ques_field !== undefined)
            return this._ques_labels[ques_field];
        else
            return this._ques_labels;
    },
    getQuestionMeta: function(key){
        return this._questions[this._opt_prefix + key];
    },
    _setQuestion: function(fbQuesObj, qAnswers, qId, question_number, sub_question_num=null, contactFields=null, contactInputType=null){
        let __QuesObj =  {
            id:"",  // questionType-questionId
            text:"",
            text_thencase:"",
            title:"",
            position:"",
            type:fbQuesObj['question-type'],
            field: fbQuesObj["options"]['data-field'],   // this is for options + questions
            options: fbQuesObj["options"],   // this is for options
            answers: qAnswers,
            contactfields: contactFields,
            contact_input_type: contactInputType,
            operators: questionTriggers.getAllTriggers(fbQuesObj['question-type']),  // this is for options
        }

        if(!questionsExcludedclForm.inArray(fbQuesObj['question-type'])){
            // setting Questions
            __QuesObj.id = fbQuesObj['question-type']+"-"+qId;
            __QuesObj.position = question_number;
            let question_title = "";

            if(fbQuesObj['question-type'] == "ctamessage"){
                question_title =  FunnelsUtil.strip_tags(fbQuesObj.options["call-to-action"]);
            }
            else if (fbQuesObj['question-type'] == "vehicle"){
                question_title = FunnelsUtil.strip_tags(fbQuesObj.options['question']);
            }
            else if (fbQuesObj['question-type'] == "contact"){
                question_title = FunnelsUtil.strip_tags(fbQuesObj.options['question']);
            }
            else{
                if(fbQuesObj.options['show-question'] == 1) {
                    question_title = FunnelsUtil.strip_tags(fbQuesObj.options['question-title']);
                    if (question_title == "") {
                        question_title = FunnelsUtil.strip_tags(fbQuesObj.options['question']);
                    }

                    if(question_title == ""){
                        question_title = "Question N/A";
                    }
                }
                else{
                    question_title = "QUESTION OFF";
                }
            }
            if(sub_question_num != null){
                ++sub_question_num;
                question_number = question_number + "." + sub_question_num;
            }else{
                question_number = question_number+".";
            }
            __QuesObj.text = inputPlaceholders.questionHtml(fbQuesObj['question-type'], question_number, question_title);
            __QuesObj.text_thencase = inputPlaceholders.questionThanAllHtml(fbQuesObj['question-type'], question_number, question_title);
            __QuesObj.title = question_title;
            // Setting options
            funnelQuestions._questions[this._opt_prefix + qId] = __QuesObj;
            funnelQuestions._ques_labels[fbQuesObj["options"]['data-field']]={
                id:__QuesObj.id,
                title:question_title,
                type:fbQuesObj['question-type'],
                subType:fbQuesObj["options"]["activesteptype"]??null, //use in case of contact to detect the step
                position:question_number
            };

            // Block for Combined Question List to use in THEN & ALL OTHER CASES
            if(sub_question_num===null || sub_question_num===1){
                funnelQuestions._questionsCombined[this._opt_prefix + qId] = Object.assign({}, __QuesObj);

                // Update Labels in dropdown for Contact & Car Make & Model
                if(fbQuesObj['question-type'] === "contact"){
                    funnelQuestions._questionsCombined[this._opt_prefix + qId].text = inputPlaceholders.questionHtml(fbQuesObj['question-type'], question_number.replace(".1", "."), "Contact | "+fbQuesObj["options"]["activesteptype"]+" Step");
                    funnelQuestions._questionsCombined[this._opt_prefix + qId].text_thencase = inputPlaceholders.questionThanAllHtml(fbQuesObj['question-type'], question_number.replace(".1", "."), "Contact | "+fbQuesObj["options"]["activesteptype"]+" Step");
                }
                else if(fbQuesObj['question-type'] === "vehicle"){
                    funnelQuestions._questionsCombined[this._opt_prefix + qId].text = inputPlaceholders.questionHtml(fbQuesObj['question-type'], question_number.replace(".1", "."), question_title);
                    funnelQuestions._questionsCombined[this._opt_prefix + qId].text_thencase = inputPlaceholders.questionThanAllHtml(fbQuesObj['question-type'], question_number.replace(".1", "."), question_title);
                }
            }
        }
    },
    getVehicleMakeModel: function(endpoint){
        let data = [];
        $.ajax({
            type: "POST",
            data: {},
            cache: false,
            url: endpoint,
            error: function (e) {
                //notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').removeClass('alert-success').addClass('alert-warning');
            },
            success: function (responce) {
                console.log("*************getVehicleMakeModel*************")
                console.log(responce)
                data = responce;
                console.log("##############getVehicleMakeModel#############")
            },
            always: function (d) { },
            async: false
        });
        return data;

    },
    _getContactStepData: function(stepsData,stepType){
        let stepTypeData = "";
        stepsData.forEach(function(obj,index){
            if(stepType == obj["step-type"]){
                stepTypeData = JSON.parse(JSON.stringify(obj));
            }
        });
        return stepTypeData;
    },
    _getContactDataField: function (stepDataObj){
        let fields = new Array();
        let fieldAnswerOptions = new Array();
        let fieldsOrder = stepDataObj['field-order'];
        if(Object.keys(fieldsOrder).length){
            for (const [key, value] of Object.entries(fieldsOrder)) {
                let targetField = stepDataObj['fields'][value];
                if(Object.keys(targetField).length){
                    let targetFieldNameKey = Object.keys(targetField);
                    let targetFieldName = targetFieldNameKey[0];
                    if(targetField[targetFieldName]['value'] == 1){
                        fields.push(targetField[targetFieldName]['data-field']);
                        switch (targetFieldName){
                            case "fullname":
                                fieldAnswerOptions.push('Full Name');
                                break;
                            case "only-first-name":
                                fieldAnswerOptions.push('First Name');
                                break;
                            case "first-name":
                            case "last-name":
                                fieldAnswerOptions.push('First + Last Name');
                                break;
                            case "email":
                                fieldAnswerOptions.push('Email Address');
                                break;
                            case "phone":
                                fieldAnswerOptions.push('Phone Number');
                                break;
                        }
                        //fieldAnswerOptions.push(targetField[targetFieldName]['field-label']);
                    }
                }
            }
        }
        return {
            'fields':fields,
            'fieldAnswerOptions':fieldAnswerOptions
        };
    },
    _setupQuestions: function(){
        // emtpy value as first question
        this._questions[this._opt_prefix] = { id: 0, text: inputPlaceholders.selectQuestion, title: 'Question', type: '',field:'',answers:'',contactfields:'',operators:'' };
        this._questionsCombined[this._opt_prefix] = { id: 0, text: inputPlaceholders.selectQuestion, title: 'Question', type: '',field:'',answers:'',contactfields:'',operators:'' };

        let funnelInfo = FunnelsUtil._getFunnelInfo('local_storage');

        // Setting Questions
        let question_number = 0;
        for (let v=0; v < funnelInfo.sequence.length; v++  ) {
            question_number = v + 1;
            let qId = funnelInfo.sequence[v];
            let fbQuesObj = JSON.parse(JSON.stringify(funnelInfo.questions[qId]));
            let qAnswers = "";
            if(fbQuesObj['question-type'] == "zipcode"){
                if(fbQuesObj['options']['zip-code-only'] == 1){
                    qAnswers = [];
                }else{
                    qAnswers = this._getAnswerFields(fbQuesObj['question-type'], 'fields' in fbQuesObj["options"] ? fbQuesObj["options"].fields : [])
                }
                this._setQuestion(fbQuesObj,qAnswers,qId,question_number);
            }
            else if(fbQuesObj['question-type'] == "slider"){
                if(fbQuesObj['options']["slider-numeric"].value == 1){
                    fbQuesObj['question-type'] = "slider_numeric";
                    qAnswers = this._getAnswerFields(fbQuesObj['question-type'], 'fields' in fbQuesObj["options"] ? fbQuesObj["options"].fields : [])
                }else{
                    qAnswers = this._getAnswerFields(fbQuesObj['question-type'], 'range' in fbQuesObj["options"]['slider-non-numeric'] ? fbQuesObj["options"]['slider-non-numeric'].range : [])
                }
                this._setQuestion(fbQuesObj,qAnswers,qId,question_number);

            }
            else if(fbQuesObj['question-type'] == "vehicle"){
                let vehicleFileds = fbQuesObj["options"]['data-field'];
                let vehicleQuestions = fbQuesObj["options"]['question-title'];
                vehicleFileds.forEach(function(value,index){
                    fbQuesObj["options"]['data-field'] = "";
                    fbQuesObj["options"]['question'] = "";
                    let make_reg = [/^make_\d*/,/^make\d*/];
                    let model_reg = [/^model_\d*/,/^model\d*/];
                    let isMakeField = make_reg.some(rx => rx.test(value));    // true | false
                    let isModelField = model_reg.some(rx => rx.test(value));    // true | false
                    if(isMakeField === true){
                        let mkqId = "make-"+qId;
                        fbQuesObj["options"]['data-field'] = value;
                        fbQuesObj["options"]['question'] = vehicleQuestions[index];
                        funnelQuestions._setQuestion(fbQuesObj,vehicle_make,mkqId,question_number,index);
                    }else if(isModelField === true){
                        let mqId = "model-"+qId;
                        fbQuesObj["options"]['data-field'] = value;
                        fbQuesObj["options"]['question'] = vehicleQuestions[index];
                        funnelQuestions._setQuestion(fbQuesObj,vehicle_model,mqId,question_number,index);
                    }
                })
            }
            else if(fbQuesObj['question-type'] == "contact"){
                let activeStepType = fbQuesObj["options"]['activesteptype'];
                let allStepTypes = fbQuesObj["options"]['all-step-types'];
                let stepType = "three-step";
                let stepTypeData = "";

                stepTypeData = allStepTypes[activeStepType - 1];
                if(stepTypeData != "" && typeof stepTypeData == "object" &&  Object.keys(stepTypeData).length > 0){
                    for (const [key, value] of Object.entries(stepTypeData['steps'])) {
                        let currObj = stepTypeData['steps'][key];
                        let dataFieldData = funnelQuestions._getContactDataField(currObj);
                        let dataField = dataFieldData['fields'];
                        qAnswers = activeStepType === 3 ? [] : dataFieldData['fieldAnswerOptions'];
                        let contactQId = dataField[0];

                        fbQuesObj["options"]['data-field'] = dataField[0];
                        fbQuesObj["options"]['question'] = currObj['question-title'];
                        funnelQuestions._setQuestion(fbQuesObj,qAnswers, contactQId, question_number,key,dataFieldData['fields'], dataFieldData['fieldAnswerOptions']);
                    }
                }
            }
            else{
                qAnswers = this._getAnswerFields(fbQuesObj['question-type'], 'fields' in fbQuesObj["options"] ? fbQuesObj["options"].fields : [])
                this._setQuestion(fbQuesObj,qAnswers,qId,question_number);
            }
        }
    },
    _getAnswerFields: function(qtype, fields){
        if(qtype == "zipcode"){
            fields = ['Enter Zip Code(s)', "Select State(s) from List"]
        }
        return fields;
    },
    questionHTML: function(pre_rendered){
        if(typeof pre_render !== undefined){
            switch (pre_rendered){
                case 1:
                    return this.getQuestions("combined");
                    break;
                case 2: // when add new question on the funnel drag and drop. we need to reset the old questions and create the new once array.
                    console.log("**************************");
                    console.log("Call from the FB save btn => questionHTML");
                    console.log("##########################");
                    $('[data-dropdown-entity="cl-questions"]').select2('destroy').empty();
                    this._questions = [];
                    this._questionsCombined = [];
                    this.getEmptyQuestion();
                    break;
            }
        }

        this._setupQuestions();
        this._setQuestionSequence();
        return this.getQuestions();
    },
};

var questionTriggers = {
    input_types: {
        zipcodeMenu: "menu-zipcode",
        singleMenu: "menu-single",
        multiMenu: "menu-multiple",
        none: "none",
        text: "text",
        numberBetween: "text-multiple",
        bdText: "bd-text",
        bdBetween: "bd-text-multiple",
        bdNone: "bd-none"
    },

    list: {
        "Placeholder": {
            "title":"Select Conditional", "value":""
        },

        //Menu + Dropdown + Slider + Vechile
        "Is": {
            "title":"Is", "value":"Is"
        },
        "IsNot": {
            "title":"Is not", "value":"IsNot"
        },
        "IsAnyOf": {
            "title":"Is any of", "value":"IsAnyOf"
        },
        "IsNoneOf": {
            "title":"Is none of", "value":"IsNoneOf"
        },

        //Slider (Non Numeric)
        "IsEqualTo": {
            "title":"Is equal to", "value":"IsEqualTo"
        },
        "IsNotEqualTo": {
            "title":"Is not equal to", "value":"IsNotEqualTo"
        },
        "IsGreaterThan": {
            "title":"Is greater than", "value":"IsGreaterThan"
        },
        "IsGreaterThanEqualTo": {
            "title":"Is greater than or equal to ", "value":"IsGreaterThanEqualTo"
        },
        "IsLessThan": {
            "title":"Is less than", "value":"IsLessThan"
        },
        "IsLessThanEqualTo": {
            "title":"Is less than or equal to ", "value":"IsLessThanEqualTo"
        },

        //Zipcode + TextField + Contact + Address
        "ContainsExactly": {
            "title":"Exactly", "value":"ContainsExactly"
        },
        "DoesNotContains": {
            "title":"Doesn't Contain", "value":"DoesNotContains"
        },
        "StartsWith": {
            "title":"Starts with", "value":"StartsWith"
        },
        "DoesNotStartWith": {
            "title":"Doesn't Start with", "value":"DoesNotStartWith"
        },
        "EndsWith": {
            "title":"Ends with", "value":"EndsWith"
        },
        "DoesNotEndWith": {
            "title":"Doesn't End with", "value":"DoesNotEndWith"
        },
        "IsEmpty": {
            "title":"Is Empty", "value":"IsEmpty"
        },
        "IsFilled": {
            "title":"Is Filled", "value":"IsFilled"
        },

        //Birthday + DatePicker + TimePicker
        "IsBefore": {
            "title":"Is before", "value":"IsBefore"
        },
        "IsAfter": {
            "title":"Is after", "value":"IsAfter"
        },


        //Common
        "IsBetween": {
            "title":"Is between", "value":"IsBetween"
        },
        "IsKnown": {
            "title":"Is known", "value":"IsKnown"
        },
        "IsUnknown":{
            "title":"Is unknown", "value":"IsUnknown"
        }
    },

    getAllTriggers: function (type){
        let question_meta_data = [];
        switch (type){
            case 'zipcode':
                question_meta_data = this._filterList(['Placeholder', 'ContainsExactly', 'DoesNotContains', 'StartsWith', 'DoesNotStartWith', 'EndsWith', 'DoesNotEndWith', 'IsFilled', 'IsEmpty']);
                break;
            case 'textarea':
            case 'text':
            case 'contact':
                question_meta_data = this._filterList(['Placeholder', 'ContainsExactly', 'DoesNotContains', 'StartsWith', 'DoesNotStartWith', 'EndsWith', 'DoesNotEndWith', 'IsFilled', 'IsEmpty']);
                break;
            case 'menu':
            case 'dropdown':
            case 'slider':
            case 'vehicle':
                question_meta_data = this._filterList(['Placeholder', 'Is', 'IsNot', 'IsAnyOf', 'IsNoneOf', 'IsKnown', 'IsUnknown']);
                break;
            case 'slider_numeric':
            case 'number':
                question_meta_data = this._filterList(['Placeholder', 'IsEqualTo', 'IsNotEqualTo', 'IsGreaterThan', 'IsGreaterThanEqualTo', 'IsLessThan', 'IsLessThanEqualTo', 'IsBetween', 'IsKnown', 'IsUnknown']);
                break;
            case 'birthday':
                question_meta_data = this._filterList(['Placeholder', 'IsEqualTo', 'IsBefore', 'IsAfter','IsBetween', 'IsKnown', 'IsUnknown']);
                break;
            default:
                break;
        }
        return question_meta_data;
    },

    getInputType: function(operator, questionType){
        switch (operator) {
            case "Is":
            case "IsNot":
                this.list[operator]["answerInputType"] = questionTriggers.input_types.singleMenu;
                break;
            case "IsAnyOf":
            case "IsNoneOf":
                this.list[operator]["answerInputType"] = questionTriggers.input_types.multiMenu;
                break;
            case "IsBefore":
            case "IsAfter":
                if(questionType === "birthday"){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.bdText;
                }
                break;
            case "IsEqualTo":
            case "IsNotEqualTo":
            case "IsGreaterThan":
            case "IsGreaterThanEqualTo":
            case "IsLessThan":
            case "IsLessThanEqualTo":
                if(questionType === "zipcode"){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.zipcodeMenu;
                }else if(questionType === "birthday"){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.bdText;
                }else{
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.text
                }
                break;
            case "ContainsExactly":
            case "DoesNotContains":
            case "StartsWith":
            case "DoesNotStartWith":
            case "EndsWith":
            case "DoesNotEndWith":
                if(questionType === "zipcode")
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.zipcodeMenu;
                else
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.text;
                break;
            case "IsBetween":
                if(questionType === "birthday"){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.bdBetween;
                }else{
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.numberBetween;
                }
                break;
            case "IsKnown":
            case "IsUnknown":
            case "IsFilled":
            case "IsEmpty":
                if(questionType == 'contact'){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.text
                }else if(questionType === "birthday"){
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.bdNone;
                }else{
                    this.list[operator]["answerInputType"] = questionTriggers.input_types.none
                }
                break;
            default:
                this.list[operator]["answerInputType"] = questionTriggers.input_types.text
        }

        return this.list[operator];
    },

    _filterList: function(needles){

        let quesOperators = [];

        $.each(this.list, function( index, obj ) {
            if(needles.inArray(index)){
                quesOperators.push(obj);
            }
        });

        return quesOperators;
    },

    optionsHTML: function (operators) {
        var html = '';
        jQuery(operators).each(function (ind, opt) {
            html += '<option value="' + opt.value + '" data-question-type="' + opt.questionType + '"><label>' + opt.title + '</label></option>';
        });
        return html;
    }
}

var answerInputs =  (function () {
    // reset back to menu input type
    function _reset(qid = null){
        $('[data-input-field-type]').hide();
        $('[data-input-field-type="menu"]').show();

        if(qid !=null){
            if(funnelQuestions.getQuestionMeta(qid) !=undefined){
                let answers = funnelQuestions.getQuestionMeta(qid).answers;
                _showMenuInputs(answers);
            }
        }
        $('[data-input-field-type="menu"]').find('[data-input-markup]').addClass('disabled');
        //$('[data-input-field-type="menu"]').find("option:first").attr('selected','selected').trigger('change');
    }
    function _resetZipStatesHTML(){
        $('[data-input-field-type="text"]').find('[data-input-markup]').find(".cl-zip-state-input-field-wrap").remove();
        $('[data-input-field-type="text"]').find('[data-input-markup]').html(inputPlaceholders.zipcode);
    }
    function _resetNumber(){
        $('[data-input-field-type="number"]').find('input').val("");
    }
    function _resetTextMultiple(){
        $('[data-input-field-type="text-multiple"]').find('input').each(function(i,ele){
            $(ele).val("");
        });
    }
    function _resetBD(){
        $('[data-input-field-type="bd-text"]').find('input').val("");
    }
    function _resetBDMultiple(){
        $('[data-input-field-type="bd-text-multiple"]').find('input').each(function(i,ele){
            $(ele).val("");
        });
    }

    $('#select-vehicle-model').on('show.bs.modal', function (event) {
        $('#conditional-logic-group').modal('hide');
        vehicleMakeModel.sustainValueModel();

    });
    $('#select-vehicle-make').on('show.bs.modal', function (event) {
        $('#conditional-logic-group').modal('hide');
        vehicleMakeModel.sustainValueModel();

    });
    $('#select-vehicle-model').on('hide.bs.modal', function (event) {
        $('#conditional-logic-group').modal('show');
        $('.model-checkbox').prop("checked", false);
        setTimeout(function(){
            vehicleMakeModel.clearSearchField('model')
            funnelConditions.saveBtnState();
        },500);
    });

    $('#select-vehicle-make').on('hide.bs.modal', function (event) {
        $('#conditional-logic-group').modal('show');
        $('.make-checkbox').prop("checked", false);
        if (jQuery('.cl-make-input-field-wrap').length > 0) {
            jQuery('.cl-make-input-field-wrap').mCustomScrollbar({
                axis: "y",
                scrollInertia: 500,
            });
        }
        setTimeout(function(){
            vehicleMakeModel.clearSearchField('make')
            funnelConditions.saveBtnState();
        },500);

    });
    function _renderAnswerInputs(questionDDL, trigger){
        let container = $("[data-input-field-type='menu']").find('[data-input-markup]');
        $('.bd-field').removeClass('value-added-save');
        jQuery('.select-field').removeClass('value-added');
        if(trigger === ""){
            container.addClass('disabled');
        }
        else {
            if(questionDDL == 0) return false;

            container.removeClass('disabled');
            let questiontype_index = questionDDL.split("-");
            let question_index = questiontype_index[1];
            let question_type = questiontype_index[0];
            if(questiontype_index.length == 3){
                question_index = questiontype_index[1]+"-"+questiontype_index[2];
            }else if(questiontype_index.length == 4){
                question_index = questiontype_index[1]+"-"+questiontype_index[2]+"-"+questiontype_index[3];
            }

            let answers = funnelQuestions.getQuestionMeta(question_index).answers;
            let contactFields = funnelQuestions.getQuestionMeta(question_index).contactfields;
            let answerType = questionTriggers.getInputType(trigger, question_type)['answerInputType'];
            console.log("****************question_type=>question_index=>answerType****************");
            console.log(question_type)
            console.log(question_index)
            console.log(answerType)
            console.log("################question_type=>question_index=>answerType#################");

            $('[data-input-field-type]').hide();
            if(answerType === questionTriggers.input_types.zipcodeMenu){
                let questionOptions = funnelQuestions.getQuestionMeta(question_index)['options'];
                let isZipCodeOnly = questionOptions['zip-code-only'];
                if(isZipCodeOnly == 1){
                    console.log("****************IsZipCodeOnly****************");
                    console.log("################IsZipCodeOnly#################");
                    $('[data-input-field-type="menu"]').hide();
                    _zipcodeField(1);
                    $('[data-input-field-type="text"]').show();
                }else{
                    if(["StartsWith","DoesNotStartWith","EndsWith","DoesNotEndWith"].inArray($("[data-dropdown-entity='cl-triggers']").val())){
                        let ans = ['Enter Zip Code(s)', "Enter State(s)"];
                        answers = ans;
                    }
                    $('[data-input-field-type="menu"]').show();
                    let is_multi = answerType === questionTriggers.input_types.multiMenu ? true : false;
                    _showMenuInputs(answers, is_multi);
                }
            }
            else if(answerType === questionTriggers.input_types.singleMenu || answerType === questionTriggers.input_types.multiMenu){
                // $('[data-input-field-type="menu"]').show();
                let is_multi = answerType === questionTriggers.input_types.multiMenu ? true : false;
                 _showMenuInputs(answers, is_multi);
                let qSubtype=  question_index.split('-')[0];
                if(is_multi){
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').prop('type','checkbox');
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').addClass('vehicle-modal-checkbox').removeClass('vehicle-modal-radio');
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').parents('.check-area').addClass('vehicle-modal-checkbox-parent').removeClass('vehicle-modal-radio-parent');
                }else {
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').prop('type','radio').attr('name', 'radio-vehicle');
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').addClass('vehicle-modal-radio').removeClass('vehicle-modal-checkbox');
                    $('[data-input-checkbox-vehicle="'+qSubtype+'"]').parents('.check-area').addClass('vehicle-modal-radio-parent').removeClass('vehicle-modal-checkbox-parent');

                }
                if(question_type==='vehicle' && qSubtype==='model'){
                    $('[data-input-field-type="select-vehicle-model"]').show();
                }else if(question_type==='vehicle' && qSubtype==='make'){
                    $('[data-input-field-type="select-vehicle-make"]').show();
                }else{
                    $('[data-input-field-type="menu"]').show();
                    _showMenuInputs(answers, is_multi);
                }
            }
            else if(answerType === questionTriggers.input_types.text){
                console.log('test-6');
                answerInputs.resetZipStatesHTML();
                answerInputs.resetTextMultiple();
                answerInputs.resetNumber();
                answerInputs.resetBD();
                answerInputs.resetBDMultiple();
                if(question_type === "contact"){
                    let contactInputType = funnelQuestions.getQuestionMeta(question_index).contact_input_type;
                    let answerInputType = question_index.split("_");
                    let answerInput = (typeof answerInputType[0] != undefined) ? answerInputType[0] : answerType;

                    if(answers.length > 1 ){
                        $('[data-input-field-type="menu"]').show();
                        let uniqueAnswers = [...new Set(answers)];
                        let uniqueFields = [...new Set(contactFields)];
                        _showMenuContact(uniqueAnswers,uniqueFields);
                    }
                    else{
                        if(answerInput == "phone" || answerInput == "primaryphone"){
                            if(["ContainsExactly","DoesNotContains"].inArray(trigger)){
                                _contactPhoneField();
                                $('[data-input-field-type="text"]').show();
                                $('[data-input-field-type="text"]').find('[data-cl-contact-phone]').inputmask({"mask": "(999) 999-9999"});
                            }
                            else if (!["IsEmpty","IsFilled"].inArray(trigger)){
                                _textField();
                                $('[data-input-field-type="text"]').show();
                            }
                            dropdownInputs.setContactFieldIDWithLabelThreeStep(answerInput,contactFields);
                        }
                        else if(answerInput == "email" || answerInput == "primaryemail"){
                            if(["ContainsExactly","DoesNotContains"].inArray(trigger)){
                                _emailField(true);
                                $('[data-input-field-type="text"]').show();
                            }
                            else if (!["IsEmpty","IsFilled"].inArray(trigger)){
                                _emailField(false);
                                $('[data-input-field-type="text"]').show();
                            }
                            dropdownInputs.setContactFieldIDWithLabelThreeStep(answerInput,contactFields);
                        }
                        else{
                            if (!["IsEmpty","IsFilled"].inArray(trigger)){
                                _textField();
                                $('[data-input-field-type="text"]').show();
                                dropdownInputs.setContactFieldIDWithLabelThreeStep(answerInput,contactFields);
                            }
                        }
                    }
                }
                else if(question_type === "number" || question_type === "slider_numeric" )  {
                    console.log('test-9');
                    _numberField();
                    $('[data-input-field-type="number"]').show();
                }
                else {
                    console.log('test-10');
                    _textField();
                    $('[data-input-field-type="text"]').show();
                }
            }
            else if(answerType === questionTriggers.input_types.numberBetween){
                console.log('test-11');
                answerInputs.resetTextMultiple();
                answerInputs.resetText();
                answerInputs.resetNumber();
                answerInputs.resetBD();
                answerInputs.resetBDMultiple();
                $('[data-input-field-type="text-multiple"]').show();
            }
            else if(answerType === questionTriggers.input_types.none || answerType === questionTriggers.input_types.bdNone ){
                answerInputs.resetZipStatesHTML();
                answerInputs.resetTextMultiple();
                answerInputs.resetNumber();
                answerInputs.resetBD();
                answerInputs.resetBDMultiple();
                $('[data-input-field-type]').hide();
            }
            else if(answerType === questionTriggers.input_types.bdText){
                console.log("questionTriggers.input_types.bdText >>>")
                answerInputs.resetZipStatesHTML();
                answerInputs.resetTextMultiple();
                answerInputs.resetNumber();
                answerInputs.resetBD();
                answerInputs.resetBDMultiple();
                //_bdText();
                $('[data-input-field-type="bd-text"]').show();
                $('[data-input-field-type="bd-text"]').find('[data-cl-bd-date]').inputmask("99/99/9999",{ "placeholder": "MM/DD/YYYY" });
                //$('[data-input-field-type="bd-text"]').find('[data-cl-bd-date]').inputmask({"mask": "MM/DD/YYYY"});
            }
            else if(answerType === questionTriggers.input_types.bdBetween){
                console.log("questionTriggers.input_types.bd-text-multiple **** ~~~ >>>")
                answerInputs.resetZipStatesHTML();
                answerInputs.resetTextMultiple();
                answerInputs.resetNumber();
                answerInputs.resetBD();
                answerInputs.resetBDMultiple();
                //_bdText();
                $('[data-input-field-type="bd-text-multiple"]').show();
                $('[data-input-field-type="bd-text-multiple"]').find('[data-cl-bw-bd-date="start"]').inputmask("99/99/9999",{ "placeholder": "MM/DD/YYYY" });
                $('[data-input-field-type="bd-text-multiple"]').find('[data-cl-bw-bd-date="end"]').inputmask("99/99/9999",{ "placeholder": "MM/DD/YYYY" });
            }
            else{
                alert("This case is not developed yet!")
            }
            $('[data-input-field-type="menu"] input').prop('readonly',true);

        }
    }

    function _select2FormatContact(uniqueAnswers,uniqueFields,is_multiple = null){
        let html;
        if(is_multiple)
            html = '<div class="select2_style"><label class="fake-checkbox"><span class="text"><i class="check-icon"></i>~LABEL~</span> </label></div>';
        else
            html = '<div class="select2_style"><span class="text">~LABEL~</span></div>';

        let options = [];

        options.push({ id: "none", title: 'Answer Options', text: '<div class="select2_style"><span' +
                ' class="text">Select Answer</span></div>' });

        $.each(uniqueAnswers, function( index, opt ) {
            options.push({id: opt, title: opt, contactFieldPosition:index,contactField:uniqueFields[index], text:'<div class="select2_style"><span class="text">'+html.replace("~LABEL~", opt)+'</span></div>'});
        });

        return options;

    }

    function _select2Format(opts, is_multiple){
        let html;
        if(is_multiple)
            html = '<div class="select2_style"><label class="fake-checkbox"><span class="text"><i class="check-icon"></i>~LABEL~</span> </label></div>';
        else
            html = '<div class="select2_style"><span class="text">~LABEL~</span></div>';

        let options = [];
        options.push({ id: "none", title: 'Answer Options', text: '<div class="select2_style"><span' +
                ' class="text">Select Answer</span></div>' });

        $.each(opts, function( index, opt ) {
            options.push({id: opt, title: opt, text:'<div class="select2_style"><span class="text">'+html.replace("~LABEL~", opt)+'</span></div>'});
        });

        return options;
    }

    function _showMenuContact(uniqueAnswers,uniqueFields){
        var menu_list = {
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select-answer-parent'),
            data: _select2FormatContact(uniqueAnswers,uniqueFields),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); }
        };
        menu_list['multiple'] = false;
        menu_list['closeOnSelect'] = true;
        menu_list['placeholder'] = 'Select Answers';
        $('.select-answer').select2('destroy').empty().select2(menu_list);
    }

    function _showMenuInputs(answers, is_multiple){
        if(is_multiple === undefined) is_multiple = false;

        var menu_list = {
            minimumResultsForSearch: -1,
            width: '100%', // need to override the changed default
            dropdownParent: $('.select-answer-parent'),
            data: _select2Format(answers, is_multiple),
            templateResult: function (d) { return $(d.text); },
            templateSelection: function (d) { return $(d.text); }
        };
        if(is_multiple) {
            menu_list['multiple'] = true;
            menu_list['closeOnSelect'] = false;
            menu_list['placeholder'] = 'Select Answers';
        } else {
            $('.select-answer').removeAttr("multiple");
        }

        $('.select-answer').select2('destroy').empty().select2(menu_list);
    }

    function _zipcodeField(isziponly){
        if(typeof isziponly != undefined && isziponly == 1){
            $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.zipcode);
        }else if(typeof isziponly != undefined && isziponly == 2){
            $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.stateTextField);
        }else{
            $("[data-input-field-type='text']").find("[data-input-markup] textarea").attr("placeholder", "Type in Zip Code(s)").attr("data-type", "zipcode");
        }
    }

    function _numberField(){
        $("[data-input-field-type='number']").find("[data-input-markup] input").attr("placeholder", "Type in Number").attr("data-type", "numeric");
    }
    function _textField(){
        //$("[data-input-field-type='text']").find("[data-input-markup] textarea").attr("placeholder", "Type in Text").attr("data-type", "text");
        $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.textField);
    }
    function _bdText(){
        $("[data-input-field-type='bd-text']").find("[data-input-markup]").html(inputPlaceholders.bdTextField);
    }
    function _emailField(is_email_validation){
        if(is_email_validation === true){
            $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.validEmailField);
        }else{
            $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.emailField);
        }
    }
    function _contactPhoneField(){
        $("[data-input-field-type='text']").find("[data-input-markup]").html(inputPlaceholders.contactPhoneField);
    }

    function _resetText(){
        $('[data-input-field-type="text"]').find('textarea').val("");
    }

    function _notStartWithZeroYear(year){
        let val = year;
        if(typeof year == "number"){
            val = year.toString();
        }
        console.log("_notStartWithZeroYear typeof", typeof val);
        console.log("_notStartWithZeroYear",val);
        if(!val.startsWith("0")){ // year value not start with 0
            return true;
        }
        return false;
    }

    function _isValidYear(value){
        console.log("_isValidYear >>>>",value);
        if(_notStartWithZeroYear(value)){ // year value not start with 0
            return (value >= 1920 ? true : false);
        }
        return false;
    }

    function _isValidDate(dateInput){
        let today = new Date();
        today.setHours(0, 0, 0, 0);
        let dateParse = dateInput.split('/');
        if (dateParse.length < 3)
            return false;
        else {
            let month = parseInt(dateParse[0]);
            let day = parseInt(dateParse[1]);
            let year = parseInt(dateParse[2]);
            if (isNaN(day) || isNaN(month) || isNaN(year)) {
                return false;
            }
            if (day < 1 || year < 1)
                return false;
            if(month>12||month<1)
                return false;
            if ((month == 1 || month == 3 || month == 5 || month == 7 || month == 8 || month == 10 || month == 12) && day > 31)
                return false;
            if ((month == 4 || month == 6 || month == 9 || month == 11 ) && day > 30)
                return false;
            if (month == 2) {
                if (((year % 4) == 0 && (year % 100) != 0) || ((year % 400) == 0 && (year % 100) == 0)) {
                    if (day > 29)
                        return false;
                } else {
                    if (day > 28)
                        return false;
                }
            }
            let inputDate = new Date(dateInput);
            if (isNaN(inputDate)) {
                return false;
            }else{
                if(_isValidYear(inputDate.getFullYear()) === false) return false;
                let today = new Date();
                today.setHours(0, 0, 0, 0);
                inputDate.setHours(0, 0, 0, 0);
                if (inputDate <= today) {
                    console.log("Enter date is valid and less then or equal to the current date value");
                    return true;
                }else if (inputDate > today) {
                    console.log(">>>>>@@@@###### Enter date is Not valid >>>>>@@@@######");
                    return false;
                }
            }

            return true;
        }
    }
    function _validateBDRange(startDate,endDate){
        let stDate = new Date(startDate);
        let enDate = new Date(endDate);
        if(_isValidYear(stDate.getFullYear()) === false || _isValidYear(enDate.getFullYear()) === false ) return false;
        return (enDate >= stDate) ? true : false;
    }
    function _validateBD(value){
        let isValid = value.match(/^(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])\/\d\d\d\d$/);
        if(isValid){
            let bdData = value.split("/");
            if(bdData[2] != undefined){
                if(_notStartWithZeroYear(bdData[2])){ // year value not start with 0
                    return _isValidDate(value);
                }
            }
        }
        return false;
    }
    function _BDQuestionEvents(value){
        console.log('>>>>>>>>>>>>>>>>>>>','_BDQuestionEvents data-cl-bd-date value','<<<<<<<<<<<<<<<<<<<<<<<<<');
        console.log(value);
        //let isValid = value.match(/^\d\d?\/\d\d?\/\d\d\d\d$/);
        let isValid = answerInputs.validateBD(value);
        if(isValid){
            console.log('#####################','e.target.value data-cl-bd-date','############################');
            funnelConditions.trigger.setInputs(value);
            funnelConditions.saveBtnState();
        }else{
            $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
        }
    }
    function _BDQuestionEventsForMulti(){
        console.log("_BDQuestionEventsForMulti >>> ",bd_range_data);
        if(bd_range_data.start_val != "" && bd_range_data.end_val != ""){
            let rdata = [];
            rdata.push(bd_range_data.start_val);
            rdata.push(bd_range_data.end_val);
            if(!answerInputs.validateBD(bd_range_data.start_val)){
                $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
            }
            if(!answerInputs.validateBD(bd_range_data.end_val)){
                $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
            }
            if(answerInputs.validateBD(bd_range_data.start_val) == true && answerInputs.validateBD(bd_range_data.end_val) == true){
                if(answerInputs.validateBDRange(bd_range_data.start_val,bd_range_data.end_val)){
                    funnelConditions.trigger.setInputs(rdata);
                    funnelConditions.saveBtnState();
                }else{
                    $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
                }
            }
        }else{
            funnelConditions.saveBtnState();
        }
    }

    return {
        render: _renderAnswerInputs,
        resetToMenu: _reset,

        zipcodeField: _zipcodeField,

        numberField: _numberField,
        resetNumber: _resetNumber,

        textField: _textField,
        resetText: _resetText,

        resetBD: _resetBD,
        resetBDMultiple: _resetBDMultiple,
        validateBD: _validateBD,
        validateBDRange: _validateBDRange,
        isValidDate: _isValidDate,

        contPhoneField: _contactPhoneField,
        emailField: _emailField,

        resetTextMultiple: _resetTextMultiple,
        resetZipStatesHTML: _resetZipStatesHTML,
        BDQuestionEvents: _BDQuestionEvents,
        BDQuestionEventsForMulti: _BDQuestionEventsForMulti,
        notStartWithZeroYear: _notStartWithZeroYear,
        bindBDQuestionEvents:function(){
            $(document).on('input','[data-cl-bd-date]', function (e) {
                _BDQuestionEvents(e.target.value);
            });
            $('[data-input-field-type="bd-text-multiple"]').find('input').each(function(i,ele){
                $(ele).on('input', function () {
                    let start_val = 0;
                    let end_val = 0;
                    if($(this).data("cl-bw-bd-date") == "start"){
                        start_val = $(this).val();
                        bd_range_data.start_val = start_val;
                    }
                    if($(this).data("cl-bw-bd-date") == "end"){
                        end_val = $(this).val();
                        bd_range_data.end_val = end_val;
                    }
                    _BDQuestionEventsForMulti();
                });
            });


        },
        bindContactQuestionEvents:function(){
            $(document).on('input','[data-cl-contact-phone]', function (e) {
                console.log('>>>>>>>>>>>>>>>>>>>','e.target.value Phone','<<<<<<<<<<<<<<<<<<<<<<<<<');
                console.log(e.target.value);
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
                console.log('#####################','e.target.value Phone','############################');
                funnelConditions.saveBtnState();
            });
            $(document).on('input','[data-cl-email], [data-cl-contact-valid-email]', function (e) {
                console.log('>>>>>>>>>>>>>>>>>>>','e.target.value Email','<<<<<<<<<<<<<<<<<<<<<<<<<');
                console.log(e.target.value);
                funnelConditions.saveBtnState();
                console.log('#####################','e.target.value Email','############################');
            });
        },
        bindTextChangeEvents: function(){
            $(document).on('input', '[data-input-field-type="text"] #cl-value', FunnelsUtil.debounce(function () {
                funnelConditions.trigger.setInputs($(this).val().split(","));
            }, 750));

            $('.textarea-field, .number-field, .text-field, .email-field, .email-valid-field').on('input', FunnelsUtil.debounce(function () {
                funnelConditions.trigger.setInputs($(this).val().split(","));
            },750))

            $('[data-input-field-type="text-multiple"]').find('input').each(function(i,ele){
                $(ele).on('input', function () {
                    let start_val = 0;
                    let end_val = 0;
                    if($(this).data("cl-range") == "start"){
                        start_val = $(this).val();
                        range_data.start_val = start_val;
                    }
                    if($(this).data("cl-range") == "end"){
                        end_val = $(this).val();
                        range_data.end_val = end_val;
                    }
                    if(range_data.start_val != "" && range_data.end_val != ""){
                        let rdata = [];
                        rdata.push(range_data.start_val);
                        rdata.push(range_data.end_val);
                        funnelConditions.trigger.setInputs(rdata);
                    }else{
                        funnelConditions.saveBtnState();
                    }
                });
            });
        }

    }
})();

var clActions = (function (){
    let actionTypes = {
        showQuestion: "action.Show",
        hideQuestion: "action.Hide",
        thankYou: "thankyou",
        leadRecipient: "recipient"
    };

    function get_Question(){
        let list = [{ id:"", text:inputPlaceholders.selectQuestions, title: 'Select Questions'}];
        list.push({
            id: i,
            text: '<div class="select2_style cl-select-row"><label class="fake-checkbox"><span class="text"><i class="check-icon"></i><span class="icon-holder"><i class="ico-zipcode"></i></span>Location</span></label></div>',
        });
        return list;
    }

    function _getThankyouPages(){
        let list = [{ id:"", text:inputPlaceholders.selectOption, title: 'Select Option'}];
        $.each(window.thankyouList, function(i, data){
            let thankYouTitle = "";
            if(data.typ_type === "external"){
                thankYouTitle = (data.thankyou_url) ? data.thankyou_url: "";
            }else{
                thankYouTitle = (data.thank_you_title) ? data.thank_you_title: "Default Success Message";
            }
            list.push({
                id: i,
                text: '<div class="select2_style" title="'+(data.typ_type === "external" ? data.type : thankYouTitle)+'"><span class="icon-holder"><i class="'+(data.typ_type === "external" ? 'ico-link' : 'ico-heart-page')+'"></i></span><span class="text">'+thankYouTitle+'</span></div>',
            });
        });
        return list;
    }

    /**
     * Get the action options by the type i.e show,hide,thankyou and lead recepient
     * @param action_type
     */
    function _getDropdownOptions(action_type){
        switch (action_type){
            case actionTypes.showQuestion:
            case actionTypes.hideQuestion:
                return funnelQuestions.questionHTML(1);
                break;
            case actionTypes.thankYou:
                return _getThankyouPages();
                break;
            case actionTypes.leadRecipient:
                return [];
                break;
        }
    }

    return {
        type: actionTypes,
        resetOptionsDropdown:function(elem){
            if(!clForm.pauseEvent) {
                // Check Select2 Instance exist?
                if (elem.hasClass("select2-hidden-accessible")) {
                    console.log("func:resetOptionsDropdown - Destroy Instance")

                    elem.select2('destroy').empty();
                    elem.unbind("change");
                    elem.removeAttr("multiple");
                    elem.removeAttr("aria-hidden");
                }
            }
        },
        hideRecipient: function(elem){
            elem.parents('.conditional-select-wrap').find('.recipients-slide').hide();
        },
        showRecipient: function(elem){
            elem.parents('.conditional-select-wrap').find('.recipients-slide').show();
        },
        hideQuestions: function(elem){
            elem.parents('.conditional-select-wrap').find('.show-queston-slide').hide();
        },
        showQuestions: function(elem){
            elem.parents('.conditional-select-wrap').find('.show-queston-slide').show();
        },
        getDataForSelect2: _getDropdownOptions

    }

})();

var dropdownInputs = {
    /**
     * This function will render all select2 drop instances which are not directly connected to Questions
     *    - cl-triggers
     *    - recipient-search
     *    - carrier
     *    - cl-search
     */
    renderSelect2: function(){
        $( '[data-dropdown="select2"]' ).each(function( index ) {
            dropdownInputs._initSelect2($(this), $(this).parent());
        });
    },

    _initSelect2: function(_selector, _parent){
        var amIclosing = false;
        var dropdownEntity = _selector.data('dropdown-entity');
        _selector.select2({
            minimumResultsForSearch: -1,
            dropdownParent: _parent,
            width: '100%'
        })
        .on('change',function () {
            console.log(" >> EMPTY CHANGE EVENT << ")
        })
        .on('select2:opening', function() {
            _parent.find('.select2-selection__rendered').css('opacity', '0');
        })
        .on('select2:open', function() {
            var _selectoptions = _parent.find('.select2-results__options');
            var _selectdropdown = _parent.find('.select2-dropdown');

            _selectoptions.css('pointer-events', 'none');

            setTimeout(function() {
                _selectoptions.css('pointer-events', 'auto');
            }, 300);

            _selectdropdown.hide();
            _selectdropdown.css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
            _parent.find('.select2-selection__rendered').hide();
            lpUtilities.niceScroll();
            setTimeout(function () {
                _parent.find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                    this.style.setProperty( 'opacity', '1', 'important' );
                    var getindex = _selector.find(':selected').index();
                    var defaultHeight = 44;
                    var scrolledArea = getindex * defaultHeight;
                    $(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                    this.style.setProperty( 'opacity', '1', 'important' );
                });
            }, 100);
        })
        .on('select2:closing', function(e) {
            if(!amIclosing) {
                e.preventDefault();
                amIclosing = true;

                _parent.find('.select2-dropdown').attr('style', '');

                setTimeout(function () {
                    _selector.select2("close");
                }, 200);
            } else {
                amIclosing = false;
            }
        })
        .on('select2:close', function() {
            _parent.find('.select2-selection__rendered').show();
            _parent.find('.select2-selection__rendered').css('opacity', '1');
            _parent.find('.select2-results__options').css('pointer-events', 'none');
        });

        if (dropdownEntity === 'carrier') {
            _selector.on('change', function () {
                $("#edit-rcpt").trigger("click");
            });
        }

        else if(dropdownEntity === "cl-triggers"){
            _selector.on('change', function () {
                let selectedQuestion = $('[data-dropdown-entity="cl-questions"]').val();
                // question is set then proceed other don't execute block
                if(selectedQuestion !== "0") {
                    let selectedOperator = $(this).val();
                    let questionType = selectedQuestion.split("-")[0];
                    $('[data-dropdown-entity="answers-options"]').parent().removeClass('selected-active');
                    answerInputs.render(selectedQuestion, selectedOperator);
                    height_check_modal();
                    if (questionType === "birthday") {
                        $('.bd-field').removeClass('value-added');
                        jQuery('.select-field').removeClass('value-added');
                    }
                    if (!clForm.pauseEvent) {

                        // Reset the contact meta fileds in any case of the questions e.x Shift contact to the Zipcode, Contact to the contact for case of the fileds (FullName to email etc)
                        funnelConditions.trigger.setContactField("");
                        funnelConditions.trigger.setContactFieldID("");

                        //reset the term value for the case of the Is known,Is unknown,Is Empty,Is Filled.
                        funnelConditions.trigger.resetInputs();
                        funnelConditions.trigger.setOperator(selectedOperator);

                        /*
                         DISCUSSION:
                            Zain/Ali: Why we are calling saveBtnState button again here its already executed in setOperator function
                            Jaz: Commenting this for now
                         */
                        // funnelConditions.saveBtnState();
                    }
                }
            });
        }

        else if (dropdownEntity === 'recipient-search') {
            _selector.on('change', function () {
                if($(this).val() == '1') {
                    $('.recipient-search').attr('placeholder', 'Type in the Recipient Name...');
                }
                else if($(this).val() ==  "2") {
                    $('.recipient-search').attr('placeholder', 'Type in the Recipient Email...');
                }
                setTimeout(function () {
                    $('.recipient-search').focus();
                }, 500);
            });
        }

        else if (dropdownEntity === 'cl-search') {
            _selector.on('change', function () {
                setTimeout(function () {
                    $('.query-search').focus();
                }, 500);
            });
        }
    },

    renderTriggerQuestions: function(){
        $('[data-dropdown-entity="cl-questions"]' ).select2Dropdown({
            dropdownEntity: "cl-questions",
            optionData: funnelQuestions.getQuestions(),
            onChange: function() {
                console.log("+++++ renderTriggerQuestions +++++", $(this).val() +" == "+ $(this).attr("id"))
                let userInput = $(this).val().split("-");   // questionType - questionSequence
                console.log("*************** Question value *****************");
                console.log(typeof userInput);
                console.log(userInput);
                console.log("*************** Question value *****************");
                if(userInput.length > 1) {
                    let question_type = userInput[0];
                    let question_index = userInput[1];
                    if(userInput.length == 3){
                        question_index = userInput[1]+"-"+userInput[2];
                    }else if(userInput.length == 4){
                        question_index = userInput[1]+"-"+userInput[2]+"-"+userInput[3];
                    }

                    if(!clForm.pauseEvent){
                        answerInputs.resetToMenu(question_index);
                        let actionFieldId = funnelQuestions.getQuestionMeta(question_index).field;
                        funnelConditions.trigger.setFieldId(actionFieldId);
                    }

                    dropdownInputs._changeTriggersList(question_type, question_index);
                }
                else{
                    $("[data-dropdown-entity='cl-triggers']").html('<option value=""><label>Select Conditional</label></option>').trigger('change');
                }
                $(this).parents('.modal-body-wrap').find('[data-dropdown-entity="cl-triggers"]').parent().removeClass('selected-active');
                // $(this).parents('.modal-body-wrap').find('[data-dropdown-entity="cl-triggers"]').parent().removeClass('selected-active'));
            }
        });
    },

    renderOptionsDropdown: function (){
        $('[data-dropdown-entity="answers-options"]' ).select2Dropdown({
            dropdownEntity: "answers-options",
            onChange: function() {
                $(this).parents('.select-area').addClass('chnage-active');

                // for ZIP CODE Question only
                let current_ques = $('[data-dropdown-entity="cl-questions"]' ).val().split("-");
                console.log('>>>>>>>>>>>>>>>>>>>>','answers-options change','>>>>>>>>>>>>>>>>>>>>>>>');
                console.log(current_ques);
                console.log($(this).val());
                console.log('>>>>>>>>>>>>>>>>>>>>','answers-options change','>>>>>>>>>>>>>>>>>>>>>>>');
                if(current_ques[0] === "zipcode") {
                    let isStateText = ($(this).val() == "Enter State(s)") ? 2 : undefined;
                    if ($(this).val() == 'Enter Zip Code(s)' || $(this).val() == "Enter State(s)") {
                        $('.select-code-field-slide').hide();
                        $('[data-input-field-type="text"]').show();
                    } else if ($(this).val() == "Select State(s) from List") {
                        $('[data-input-field-type="text"]').hide();
                        $('.select-code-field-slide').show();
                    }
                    answerInputs.resetZipStatesHTML();
                    answerInputs.zipcodeField(isStateText);
                    funnelConditions.saveBtnState();
                }else if(current_ques[0] === "contact"){
                    if(["First Name","Full Name","First + Last Name"].inArray($(this).val())){
                        if (!["IsEmpty","IsFilled"].inArray(funnelConditions.trigger.getOperator())){
                            answerInputs.textField();
                            $('[data-input-field-type="text"]').show();
                        }
                    }else if(["Email Address"].inArray($(this).val())){
                        if(["ContainsExactly","DoesNotContains"].inArray(funnelConditions.trigger.getOperator())){
                            answerInputs.emailField(true);
                            $('[data-input-field-type="text"]').show();
                            //$('[data-input-field-type="text"]').find('[data-cl-contact-valid-email]').inputmask("email");
                        }else if (!["IsEmpty","IsFilled"].inArray(funnelConditions.trigger.getOperator())){
                            answerInputs.emailField(false);
                            $('[data-input-field-type="text"]').show();
                        }
                    }else if(["Phone Number"].inArray($(this).val())){
                        if(["ContainsExactly","DoesNotContains"].inArray(funnelConditions.trigger.getOperator())){
                            answerInputs.contPhoneField();
                            $('[data-input-field-type="text"]').show();
                            $('[data-input-field-type="text"]').find('[data-cl-contact-phone]').inputmask({"mask": "(999) 999-9999"});
                        }else if (!["IsEmpty","IsFilled"].inArray(funnelConditions.trigger.getOperator())){
                            answerInputs.textField();
                            $('[data-input-field-type="text"]').show();
                        }
                    }
                    funnelConditions.saveBtnState();
                }
            },
            onClose: function(evt) {
                jQuery(this).parent().find('.select2-selection__rendered').show();
                jQuery(this).parent().find('.select2-results__options').css('pointer-events', 'none');

                // save selection in condition object
                let current_ques = $('[data-dropdown-entity="cl-questions"]' ).val().split("-");
                if(current_ques[0] !== "zipcode") {
                    if(current_ques[0] == "contact"){
                        dropdownInputs.setContactFieldIDWithLabel($(this).val());
                    }else{
                        funnelConditions.trigger.setInputs($(this).val());
                    }
                }
            },
            onUnselect: function(evt) {
                let current_ques = $('[data-dropdown-entity="cl-questions"]' ).val().split("-");
                if(current_ques[0] !== "zipcode" || current_ques[0] !== "contact" ) return;
                if (!evt.params.originalEvent) {
                    return;
                }
                evt.params.originalEvent.stopPropagation();
            },
        });
    },

    _changeTriggersList: function (questionType, questionID){
        if(questionType != "zipcode") {
            $('.select-code-field-slide').hide();
            $('[data-input-field-type="text"]').hide();
        }

        let quesMeta = funnelQuestions.getQuestionMeta(questionID);
        console.log(">>>>>>>>>>>>>>>>",'quesMeta',"<<<<<<<<<<<<<<<<<<<<<<<<<<<<")
        console.log(questionID);
        console.log(quesMeta);
        console.log(quesMeta.operators);
        console.log(clForm.pauseEvent);
        console.log(">>>>>>>>>>>>>>>>",'quesMeta',"<<<<<<<<<<<<<<<<<<<<<<<<<<<<")

        if(quesMeta !== undefined) {
            let triggersDDL = $("[data-dropdown-entity='cl-triggers']");
            triggersDDL.parent("div").removeClass('disabled');

            // Change Operators List based on Selected Question
            let operators = quesMeta.operators;
            if(questionType == "slider_numeric" || questionType == "slider" ) {
                let filtered = operators.filter(function(obj,index,arr){
                    if(!['IsKnown','IsUnknown'].inArray(obj.value)){
                        return obj;
                    }
                });
                operators = filtered;
            }
            var optionsHTML = questionTriggers.optionsHTML(operators);

            if(!clForm.pauseEvent) {
                triggersDDL.html(optionsHTML).trigger('change');
            } else {
                triggersDDL.html(optionsHTML);
            }
        }
    },

    renderActionList: function(then_elem) {
        then_elem.select2Dropdown({
            dropdownEntity: "cl-actions",
            preOpts:true,
            onChange: function() {
                height_check_modal();
                $(this).parents('[data-repeater]').find('[data-cl-then-recipient]').removeClass('recipient-active');
                $(this).parents('.select-area').addClass('chnage-active');
                let node = $(this).attr("data-actiontype");
                let action_value = $(this).val();
                console.log('Reapter # ',$(this).parents('.conditional-select-wrap').data("repeater"),'******** ACTION TYPE ********', node, action_value);

                if (node === "actions") {
                    height_check_modal();
                    if(!clForm.pauseEvent){
                        let r = $(this).parents('.conditional-select-wrap').data("repeater");
                        funnelConditions.resetActionCondition(r);

                        let repeaterThenElement = $("[data-repeater='"+r+"']");
                        repeaterThenElement.find("[data-cl-then-recipient]").text("Select Recipients");
                        repeaterThenElement.find("[data-cl-then-action-recipients]").val(JSON.stringify([]));

                        if (action_value === clActions.type.leadRecipient)
                            funnelConditions.actions.recipient(r, action_value, "")
                        else if (action_value === clActions.type.thankYou)
                            funnelConditions.actions.Thankyou(r, action_value, "")
                        else
                            funnelConditions.actions.questionVisibility(r, action_value, "")
                    }
                }
                else if (node === "alt_actions") {
                    height_check_modal();
                    $('[data-receipient-opener="allcases"] [data-cl-all-recipient]').removeClass('recipient-active');
                    if(!clForm.pauseEvent){
                        console.log("allother action combo chage event *********",$(this));
                        funnelConditions.resetAltActionCondition();
                        $("[data-cl-all-recipient]").text("Select Recipients");
                        $("[data-cl-all-action-recipients]").val(JSON.stringify([]));

                        if (action_value === clActions.type.leadRecipient || action_value === clActions.type.thankYou)
                            funnelConditions.alt_actions.recipientOrThankyou(action_value, "")
                        else
                            funnelConditions.alt_actions.questionVisibility(action_value, "")
                    }
                }


                if(action_value == clActions.type.leadRecipient) {
                    clActions.showRecipient($(this));
                    clActions.hideQuestions($(this));
                }
                else{
                    // Show + Hide + Thank you
                    clActions.hideRecipient($(this));
                    clActions.showQuestions($(this));
                    height_check_modal();

                    let action_options = clActions.getDataForSelect2(action_value);
                    let config_obj = {
                        minimumResultsForSearch: null,
                        multiple:false,
                        closeOnSelect:true,
                        placeholder:null,
                        theme:null
                    };

                    if (action_options !== undefined) {
                        let than_all_options = new Array();

                        if([clActions.type.showQuestion,clActions.type.hideQuestion].inArray(action_value)){
                            if (node === "actions") {
                                let options_data = JSON.stringify(Object.assign({},action_options));
                                // let  than_all_options_title = { id: 0, text: inputPlaceholders.selectQuestions, title: 'Question', type: '',field:'',answers:'',operators:'' };
                                // than_all_options.push(than_all_options_title);
                                $.each(JSON.parse(options_data), function (i, obj){
                                    let new_obj = obj;
                                    if(new_obj.hasOwnProperty('text_thencase')){
                                        new_obj.text = new_obj.text_thencase;
                                        delete new_obj['text_thencase'];
                                        than_all_options.push(new_obj);
                                    }
                                });
                                config_obj.minimumResultsForSearch = 1;
                                config_obj.multiple = true;
                                config_obj.multipleSearch = true;
                                config_obj.closeOnSelect = false;

                                config_obj.theme = "cl-action-multi-select";
                                config_obj.placeholder = 'Select Questions';
                                $('.show-question-parent').addClass('hide-show-parent');
                            }
                            else{
                                than_all_options = action_options;
                            }
                        }
                        else if(clActions.type.thankYou == action_value){
                            if (node === "actions") {
                                config_obj.minimumResultsForSearch = -1;
                                config_obj.multiple = false;
                                config_obj.multipleSearch = false;
                                config_obj.closeOnSelect = true;
                                $('.show-question-parent').removeClass('hide-show-parent');
                            }
                            than_all_options = action_options;
                        }
                        else{
                            than_all_options = action_options;
                        }

                        /*
                        console.log("~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Than All other cases Render Question ~~~~~~~~~~~~~~~~~~~~~~~~");
                        console.log(typeof action_options);
                        console.log(action_options);
                        console.log(typeof than_all_options);
                        console.log(than_all_options);
                        console.log("^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ Than All other cases Render Question ^^^^^^^^^^^^^^^^^^^^^^^^^");
                         */

                        let actionOptionsParent = $(this).parents('.conditional-select-wrap');
                        let actionOptionsDropdown = actionOptionsParent.find('[ data-dropdown-entity="cl-actions-questions"]');
                        clActions.resetOptionsDropdown(actionOptionsDropdown);

                        actionOptionsParent.find('span.btn-wrap').addClass("disabled");

                        $(actionOptionsDropdown).select2Dropdown({
                            dropdownEntity: "cl-actions-questions",
                            optionData: than_all_options,
                            minimumResultsForSearch: config_obj.minimumResultsForSearch,
                            multiple:config_obj.multiple,
                            multipleSearch:config_obj.multipleSearch,
                            closeOnSelect:config_obj.closeOnSelect,
                            placeholder:config_obj.placeholder,
                            onChange: function () {
                                let action_option_value = $(this).val();
                                if (action_option_value) {
                                    let action_option_id = $(this).attr("id");
                                    console.log('******** ACTION SELECTED ********', node, action_value, '******** ACTION VALUES ********', action_option_id, action_option_value);

                                    if (node === "alt_actions") {
                                        if (action_value === clActions.type.leadRecipient || action_value === clActions.type.thankYou) {
                                            funnelConditions.alt_actions.recipientOrThankyou(action_value, action_option_value)
                                        }
                                        else {
                                            console.log("<<<<<*****>>>>>", action_option_value);
                                            let selected_all_question = new Array();
                                            /*$.each(action_option_value,function(i,obj){
                                                selected_all_question.push(field_id);
                                            });*/
                                            let userInput = action_option_value.split("-");
                                            if(userInput.length > 1) {
                                                let question_index = userInput[1];
                                                let question_type = userInput[0];
                                                if(userInput.length == 3){
                                                    question_index = userInput[1]+"-"+userInput[2];
                                                }else if(userInput.length == 4){
                                                    question_index = userInput[1]+"-"+userInput[2]+"-"+userInput[3];
                                                }
                                                let field_id = funnelQuestions.getQuestionMeta(question_index).field;
                                                console.log("<<<<< selected_all_question @#$#$$$#@@>>>>>", field_id);
                                                funnelConditions.alt_actions.questionVisibility(action_value, field_id)
                                            }
                                            /*let total_all_question = action_option_value.length;
                                            let ques_all_text = (total_all_question.length > 1) ? " Questions Selected ":" Question Selected ";*/
                                            //$(this).next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_all_question + '</strong>' + ques_all_text + '</span>');
                                        }
                                    }
                                    else {
                                        let btnStatus = false;
                                        let repeater_index = $(this).parents('.conditional-select-wrap').data("repeater");
                                        if (action_value === clActions.type.leadRecipient) {
                                            funnelConditions.actions.recipient(repeater_index, action_value, action_option_value)
                                        }
                                        else if (action_value === clActions.type.thankYou) {
                                            btnStatus = true;
                                            funnelConditions.actions.Thankyou(repeater_index, action_value, action_option_value)
                                            /*if( $("[data-repeater]:visible").length == 4){
                                                clForm.disableEnableShowHideThankYouComboThanOption($("[data-repeater]:last").data("repeater"));
                                            }*/
                                            $("[data-repeater='"+repeater_index+"']").find('span.btn-wrap').removeClass("disabled");
                                            clForm.actionOptionChangeManageBtnStatus(repeater_index,'thankyou',btnStatus);
                                        }
                                        else {
                                            console.log("<<<<<*****Type of than action>>>>>", typeof action_option_value);
                                            console.log("<<<<<*****Data than action>>>>>", action_option_value);
                                            btnStatus = Object.keys(action_option_value).length ? true : false;
                                            let selected_question = new Array();
                                            $.each(action_option_value,function(i,obj){
                                                let userInput = obj.split("-");
                                                if(userInput.length > 1) {
                                                    let question_index = userInput[1];
                                                    let question_type = userInput[0];
                                                    if(userInput.length == 3){
                                                        question_index = userInput[1]+"-"+userInput[2];
                                                    }else if(userInput.length == 4){
                                                        question_index = userInput[1]+"-"+userInput[2]+"-"+userInput[3];
                                                    }
                                                    let field_id = funnelQuestions.getQuestionMeta(question_index).field;
                                                    selected_question.push(field_id);
                                                }
                                            });
                                            let total_question = action_option_value.length;
                                            let ques_text = (total_question > 1) ? " Questions Selected ":" Question Selected ";
                                            console.log("<<<<< selected_question @#$#$$$#@@>>>>>", selected_question);
                                            funnelConditions.actions.questionVisibility(repeater_index, action_value, selected_question)
                                            /*if( $("[data-repeater]:visible").length == 4){
                                                clForm.disableEnableShowHideThankYouComboThanOption($("[data-repeater]:last").data("repeater"));
                                            }*/
                                            $("[data-repeater='"+repeater_index+"']").find('span.btn-wrap').removeClass("disabled");
                                            $("[data-repeater='"+repeater_index+"']").find("[data-dropdown-entity='cl-actions-questions']").next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_question + '</strong>' + ques_text + '</span>');
                                            clForm.actionOptionChangeManageBtnStatus(repeater_index,'showHide',btnStatus);
                                        }
                                        clForm.manageDeleteActionRepeater();
                                    }
                                }
                            }
                        });
                    }
                }
            }
        });
    },

    setContactFieldIDWithLabelThreeStep: function(answerInput,contactFields){
        console.log("type of answerInput", typeof answerInput);
        console.log("answerInput", answerInput);
        console.log("type of contactFields", typeof contactFields);
        console.log("contactFields", contactFields);
        let fileds = new Array();
        if(typeof contactFields == "object"){
            $.each(contactFields,function(k,ans){
                fileds.push(contactFields[k])
            });
            funnelConditions.trigger.setContactField(answerInput);
            funnelConditions.trigger.setContactFieldID(fileds.join("~~"));
        }
    },
    setContactFieldIDWithLabel: function(val){
        let questiontype_index = $('[data-dropdown-entity="cl-questions"]' ).val().split("-");
        let question_index = questiontype_index[1];
        let question_type = questiontype_index[0];
        if(questiontype_index.length == 3){
            question_index = questiontype_index[1]+"-"+questiontype_index[2];
        }else if(questiontype_index.length == 4){
            question_index = questiontype_index[1]+"-"+questiontype_index[2]+"-"+questiontype_index[3];
        }
        let answers = funnelQuestions.getQuestionMeta(question_index).answers;
        let contactFields = funnelQuestions.getQuestionMeta(question_index).contactfields;
        console.log("@###$(this).val()",val);
        funnelConditions.trigger.setContactField(val);
        if(["First + Last Name"].inArray(val)){
            let first_last_fileds = new Array();
            $.each(answers,function(k,ans){
                if(ans == "First + Last Name"){
                    first_last_fileds.push(contactFields[k])
                }
            });
            funnelConditions.trigger.setContactFieldID(first_last_fileds.join("~~"));
        }else{
            let curr_ans_val = val;
            let contactFieldID = "";
            $.each(answers,function(k,ans){
                if(ans == curr_ans_val){
                    contactFieldID = contactFields[k];
                }
            });
            funnelConditions.trigger.setContactFieldID(contactFieldID);
            //funnelConditions.trigger.setContactFieldID($(this).select2('data')[0]['contactField']);
        }
    }
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

/**
 * Show hide the state model values by search
 * @param term
 */
function showStatesBySearch(term){
    // Declare variables
    let get_length = $('#cl-state-search-txt').val().trim().length;
    if (get_length > 0) {
        $('#cl-state-search-txt').parent().addClass('states-search-active');
    }
    else {
        $('#cl-state-search-txt').parent().removeClass('states-search-active');
    }
    let input, filter, ul, li, a, i, txtValue;
    input = term.trim();
    filter = input.toUpperCase();
    ul = document.getElementById("cl-state-list");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("span")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
    clForm.emptyCheckStates('No results were found for this search. Try something else.');
    clForm.checkAllcheckboxes();
}

var clForm = {
    pauseEvent: true,
    init: function(call_for = null){
        funnelQuestions.setVehicleQuestionData();
        funnelQuestions.questionHTML(call_for);
        dropdownInputs.renderSelect2();
        dropdownInputs.renderTriggerQuestions();
        dropdownInputs.renderOptionsDropdown();
        dropdownInputs.renderActionList($('.conditional-select-wrap').not('.hidden').find('[data-dropdown-entity="cl-actions"]'));
        //dropdownInputs.renderAlternateList();
        //this.preFill();
        answerInputs.bindTextChangeEvents();
        answerInputs.bindContactQuestionEvents();
        answerInputs.bindBDQuestionEvents();
        clForm.pauseEvent=false;
    },
    preFill: function(){
        if(funnelConditions.trigger.getFieldId()){
            $('[data-dropdown-entity="cl-questions"]' ).val(funnelConditions.trigger.getFieldId(true)).trigger('change');
        }

        if(funnelConditions.trigger.getOperator()){
            $('[data-dropdown-entity="cl-triggers"]').val(funnelConditions.trigger.getOperator()).trigger('change');
        }

        if(funnelConditions.trigger.getInputs()){

            let question_info = funnelConditions.trigger.getFieldId(true).split("-");

            let question_index = question_info[1];
            if(question_info.length == 3){
                question_index = question_info[1]+"-"+question_info[2];
            }else if(question_info.length == 4){
                question_index = question_info[1]+"-"+question_info[2]+"-"+question_info[3];
            }

            let question_type = funnelQuestions.getQuestionMeta(question_index).type;

            let question_operator = funnelConditions.trigger.getOperator();

            let question_value = funnelConditions.trigger.getInputs(true);

            switch (question_type){
                case "zipcode":
                    switch (question_operator){
                        case "ContainsExactly":
                        case "DoesNotContains":
                        case "StartsWith":
                        case "DoesNotStartWith":
                        case "EndsWith":
                        case "DoesNotEndWith":
                            let zipcode_value =  question_value[0];
                            let number_reg = /^\d+$/;
                            let zip_val_type = "string";
                            //let isBreak = cl_object.conditions[question_index].active
                            /**
                             *   Edit section if condition is break the value must be empty
                             */
                            let isBreak = cl_object.conditions[funnelConditions.getCurrentQuestionIndex()].active
                            if(isBreak == -1){
                                question_value=[]; // local cl value variable set to empty
                                cl_object.conditions[funnelConditions.getCurrentQuestionIndex()].terms.t1.value=[]; // Main cl listing condition term value set to empty
                                funnelConditions._condition.terms.t1.value=[]; // Current cl condition term value set to empty
                                zip_val_type = "number";
                            }else{
                                if(number_reg.test(zipcode_value) === true) {
                                    zip_val_type = "number";
                                }
                            }
                            switch (zip_val_type){
                                case "number":
                                    $('[data-dropdown-entity="answers-options"]').val("Enter Zip Code(s)").trigger('change');
                                    $('[data-input-field-type="text"]').find('[data-type="zipcode"]').val(question_value.join());
                                    break;
                                case "string":
                                    if(["StartsWith","DoesNotStartWith","EndsWith","DoesNotEndWith"].inArray(question_operator)){
                                        $('[data-dropdown-entity="answers-options"]').val("Enter State(s)").trigger('change');
                                        $('[data-input-field-type="text"]').find('[data-type="state-text"]').val(question_value.join());
                                    }else{
                                        $('[data-dropdown-entity="answers-options"]').val("Select State(s) from List").trigger('change');
                                        let states = [];
                                        question_value.forEach(function (value, index) {
                                            let selected_state_obj = {
                                                "id": value,
                                                "name": value
                                            };
                                            states.push(selected_state_obj);
                                        });
                                        let state_html = funnelConditions.getStatesListHTML(states);
                                        $('.select-code-field-slide').hide();
                                        $("[data-input-field-type='text']").find("[data-input-markup]").html(state_html);
                                        $('[data-input-field-type="text"]').show();
                                        if (jQuery('.cl-zip-state-input-field-wrap').length > 0) {
                                            jQuery('.cl-zip-state-input-field-wrap').mCustomScrollbar({
                                                axis: "y",
                                                scrollInertia: 500,
                                            });
                                        }
                                    }
                                    break;
                            }
                            break;
                        case "IsEmpty":
                        case "IsFilled":
                            break;
                    }
                    break;
                case "dropdown":
                case "menu":
                case "slider":
                case "vehicle":
                    switch (question_operator){
                        case "Is":
                        case "IsNot":
                        case "IsAnyOf":
                        case "IsNoneOf":
                            $('[data-dropdown-entity="answers-options"]').val(question_value).trigger('change');
                           console.log('question_info',question_info)
                            if(question_info[0]=="vehicle"){
                            let vehicleData = [];
                            question_value.forEach(function (value, index) {
                                let selected_vehicle_obj = {
                                    "id": value,
                                    "name": value
                                };
                                vehicleData.push(selected_vehicle_obj);
                            });
                            console.log('question_info[1]==make',question_info[1]=='make');
                            console.log('question_info[1]',question_info[1]);
                            let vehicle_html;
                            let type='';
                            if(question_info[1]=='make'){
                                        type="make";
                                     vehicle_html = funnelConditions.getMakeListHTML(vehicleData);
                                }else {
                                type="model";
                                     vehicle_html = funnelConditions.getModelsListHTML(vehicleData);
                                }
                            $('[data-input-field-type="select-vehicle-'+type+'"]').hide();
                            $("[data-input-field-type='text']").find("[data-input-markup]").html(vehicle_html);
                            $('[data-input-field-type="text"]').show();
                            // add the scroll of zip code stats tags
                            if (jQuery('.cl-zip-state-input-field-wrap').length > 0) {
                                jQuery('.cl-zip-state-input-field-wrap').mCustomScrollbar({
                                    axis: "y",
                                    scrollInertia: 500,
                                });
                            }

                            // add the scroll vehicle question make tags
                            if (jQuery('.cl-make-input-field-wrap').length > 0) {
                                jQuery('.cl-make-input-field-wrap').mCustomScrollbar({
                                    axis: "y",
                                    scrollInertia: 500,
                                });
                            }

                            // add the scroll vehicle question models tags
                            if (jQuery('.cl-models-input-field-wrap').length > 0) {
                                jQuery('.cl-models-input-field-wrap').mCustomScrollbar({
                                    axis: "y",
                                    scrollInertia: 500,
                                });
                            }

                            }else {
                                $('[data-dropdown-entity="answers-options"]').val(question_value).trigger('change');
                                $("[data-input-field-type='text']").find("[data-input-markup]").html(question_value);

                            }
                            break;
                        case "IsKnown":
                        case "IsUnknown":
                            break;
                    }
                    break;
                case "text":
                case "textarea":
                case "contact":
                    switch (question_operator){
                        case "ContainsExactly":
                        case "DoesNotContains":
                        case "StartsWith":
                        case "DoesNotStartWith":
                        case "EndsWith":
                        case "DoesNotEndWith":
                        case "IsEmpty":
                        case "IsFilled":
                            let term_value = (!["IsEmpty","IsFilled"].inArray(question_operator))?question_value[0]:"";
                            let number_reg = /^\d+$/;
                            let term_val_type = "string";
                            if(number_reg.test(term_value) === true){
                                term_val_type = "number";
                            }
                            console.log('>>>>>>>>>>>>>>>>>>>>>>>','contact term_value','>>>>>>>>>>>>>>>>>>>>>>');
                            console.log(term_value);
                            console.log(term_val_type);
                            console.log('>>>>>>>>>>>>>>>>>>>>>>>','contact term_value','>>>>>>>>>>>>>>>>>>>>>>');
                            let contactFieldRender = false;
                            if(funnelConditions.trigger.getContactField(true) != "" || funnelConditions.trigger.getContactField(true) != null){
                                if(typeof funnelConditions.trigger.getContactField(true) == "object"){
                                    if(Object.keys(funnelConditions.trigger.getContactField(true)).length > 0) contactFieldRender = true;
                                }else if(typeof funnelConditions.trigger.getContactField(true) == "string"){
                                    contactFieldRender = true;
                                }
                            }
                            if(contactFieldRender){
                                $('[data-dropdown-entity="answers-options"]').val(funnelConditions.trigger.getContactField(true)).trigger('change');
                            }
                            switch (term_val_type){
                                case "string":
                                case "number":
                                    if(!["IsEmpty","IsFilled"].inArray(question_operator)){
                                        $('[data-input-field-type="text"]').find('[data-type="text"]').val(question_value[0]);
                                    }
                                break;
                            }
                            break;
                    }
                    break;
                case "slider_numeric":
                case "number":
                    switch (question_operator){
                        case "IsEqualTo":
                        case "IsNotEqualTo":
                        case "IsGreaterThan":
                        case "IsGreaterThanEqualTo":
                        case "IsLessThan":
                        case "IsLessThanEqualTo":
                            switch (typeof question_value[0]){
                                case "string":
                                case "number":
                                    $('[data-input-field-type="number"]').find('input[type="text"]').val(question_value[0]);
                                    break;
                            }
                            break;
                        case "IsBetween":
                            switch (typeof question_value[0]){
                                case "string":
                                case "number":
                                    range_data['start_val'] = question_value[0];
                                    range_data['end_val'] = question_value[1];
                                    $('[data-input-field-type="text-multiple"]').find('input[data-cl-range="start"]').val(question_value[0]);
                                    $('[data-input-field-type="text-multiple"]').find('input[data-cl-range="end"]').val(question_value[1]);
                                    break;
                            }

                            break;

                        case "IsKnown":
                        case "IsUnknown":
                            break;

                    }
                    break;
                case "birthday":
                    switch (question_operator){
                        case "IsEqualTo":
                        case "IsBefore":
                        case "IsAfter":
                            switch (typeof question_value[0]){
                                case "string":
                                case "number":
                                    $('[data-input-field-type="bd-text"]').find('input[type="text"]').addClass('value-added-save');
                                    $('[data-input-field-type="bd-text"]').find('input[type="text"]').val(question_value[0]);
                                    $('[cl-datepicker]').val(question_value[0]);
                                    $('[cl-datepicker]').trigger("keyup");
                                    break;
                            }
                            break;
                        case "IsBetween":
                            switch (typeof question_value[0]){
                                case "string":
                                case "number":
                                    bd_range_data['start_val'] = question_value[0];
                                    bd_range_data['end_val'] = question_value[1];
                                    $('[data-input-field-type="bd-text-multiple"]').find('input[data-cl-bw-bd-date="start"]').addClass('value-added-save');
                                    $('[data-input-field-type="bd-text-multiple"]').find('input[data-cl-bw-bd-date="end"]').addClass('value-added-save');
                                    $('[data-input-field-type="bd-text-multiple"]').find('input[data-cl-bw-bd-date="start"]').val(question_value[0]);
                                    $('[data-input-field-type="bd-text-multiple"]').find('input[data-cl-bw-bd-date="end"]').val(question_value[1]);
                                    $('[cl-start-datepicker]').val(question_value[0]);
                                    $('[cl-start-datepicker]').trigger("keyup");
                                    $('[cl-end-datepicker]').val(question_value[1]);
                                    $('[cl-end-datepicker]').trigger("keyup");
                                    break;
                            }
                            break;
                        case "IsKnown":
                        case "IsUnknown":
                            break;
                    }
                    break;
            }
        }

        if(funnelConditions.actions.isFilled()){
            let actions_list = funnelConditions.combineActions(funnelConditions._condition.actions.action, funnelConditions._condition.actions.recipient, funnelConditions._condition.actions.thankyou);
            if(actions_list){
                //$('[data-repeater=1]').nextAll('div.conditional-select-wrap').remove();
                $('[data-repeater]').remove();
                let action_node_length = Object.keys(actions_list).length; // for the case of the only one node no need to disable , Last node always enable as per rule
                $.each(actions_list, function( i, action ) {
                    var cindex = i.replace("a", "");
                    console.log('');
                    console.log('<><><><><><> LOOP START ('+i+') <><><><><><>');
                    console.log('cindex/action', cindex, action);

                    // repeater is greater than 1 then add fields first dynamically to repeat
                    //if(new Number(cindex) > 1){
                        var ClonedItem = $('.conditional-select-wrap.hidden').clone().removeClass('hidden').attr("data-repeater", cindex);
                        $('.conditional-select-area.then-cases').append(ClonedItem);

                        dropdownInputs.renderActionList($('[data-repeater="'+cindex+'"]' ).find('[data-dropdown-entity="cl-actions"]'));
                    //}

                    switch (action.type){
                        case "recipients":
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("recipient").trigger('change');
                            let total_recip = action.id.length;
                            let sel_text = (total_recip.length > 1) ? " Recipients Selected":" Recipient Selected";
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-recipient]").html('<strong>'+total_recip+'</strong>'+sel_text);
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-recipient]").addClass('recipient-active');
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-action-recipients]").val(JSON.stringify(action.id));
                            setTimeout(function(node_length){
                                if(node_length > 1){
                                    clForm.disableEnableRecipientComboThanOption(cindex);
                                }
                            },1000,action_node_length)
                            break;
                        case "thankyou":
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("thankyou").trigger('change');
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").val(action.id).trigger('change');
                            if(action_node_length > 1){
                                clForm.disableEnableShowHideThankYouComboThanOption(cindex);
                            }
                            break;

                        case "actions":
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("action."+action.visibility).trigger('change');
                            let dropdown_value = new Array();
                            $.each(action.conditionalFieldId,function(i,obj){
                                console.log("action.conditionalFieldId",obj)
                                let ques_id = funnelQuestions.getQuestionTitle(obj).id;
                                dropdown_value.push(ques_id);
                            });
                            let total_question = action.conditionalFieldId.length;
                            let ques_text = (total_question > 1) ? " Questions Selected ":" Question Selected ";
                            console.log(">>>>>>> new_title_string",dropdown_value);
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").val(dropdown_value).trigger('change');
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_question + '</strong>' + ques_text + '</span>');
                            if(action_node_length > 1 ){
                                clForm.disableEnableShowHideThankYouComboThanOption(cindex);
                            }
                            break;
                    }

                    console.log('<><><><><><> LOOP END <><><><><><>');
                });
                setTimeout(function(){
                    clForm.manageDeleteActionRepeater('edit_open');
                },1000)
            }
        }

        if(funnelConditions.alt_actions.isFilled()){
            let actions_list = funnelConditions.combineActions(funnelConditions._condition.alt_actions.action, funnelConditions._condition.alt_actions.recipient, funnelConditions._condition.alt_actions.thankyou);
            if(actions_list){
                $.each(actions_list, function( i, action ) {
                    var cindex = i.replace("at", "");
                    switch (action.type){
                        case "recipients":
                            $(".other-case-parent").find("[data-dropdown-entity='cl-actions']").val("recipient").trigger('change');

                            let total_recip = action.id.length;
                            let sel_text = (total_recip.length > 1) ? " Recipients Selected":" Recipient Selected";
                            // $("[data-cl-all-recipient]").text(total_recip+sel_text);
                            $("[data-cl-all-recipient]").html('<strong>'+total_recip+'</strong>'+sel_text);
                            $("[data-cl-all-recipient]").addClass('recipient-active');
                            $("[data-cl-all-action-recipients]").val(JSON.stringify(action.id));
                            break;
                        case "thankyou":
                            $(".other-case-parent").find("[data-dropdown-entity='cl-actions']").val("thankyou").trigger('change');
                            $(".other-case-parent").find("[data-dropdown-entity='cl-actions-questions']").val(action.id).trigger('change');
                            break;
                        case "actions":
                            $(".other-case-parent").find("[data-dropdown-entity='cl-actions']").val("action."+action.visibility).trigger('change');
                            let dropdown_value = new Array();
                            $.each(action.conditionalFieldId,function(i,obj){
                                console.log("altaction.conditionalFieldId[0]",obj)
                                let ques_id = funnelQuestions.getQuestionTitle(obj).id;
                                dropdown_value.push(ques_id);
                            });
                            let total_question = action.conditionalFieldId.length;
                            let ques_text = (total_question > 1) ? " Questions Selected ":" Question Selected ";
                            console.log(">>>>>>> new_title_string alt action",dropdown_value);
                            $(".other-case-parent").find("[data-dropdown-entity='cl-actions-questions']").val(dropdown_value).trigger('change');
                            //$(".other-case-parent").find("[data-dropdown-entity='cl-actions-questions']").next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_question + '</strong>' + ques_text + '</span>');
                            break;
                    }
                });
            }
        }
    },
    reset: function( call_for = null){
        clForm.pauseEvent=true;

        //Button active
        $('[conditional-logic-checkbox]').attr("checked",true);

        //Question
        $('[data-dropdown-entity="cl-questions"]' ).val(0).trigger('change');

        //Trigger
        $('[data-dropdown-entity="cl-triggers"]' ).val("").trigger('change');
        $('[data-dropdown-entity="cl-triggers"]').parent("div").addClass('disabled');

        //Answer
        answerInputs.resetToMenu(FunnelsUtil._getFunnelInfo('local_storage').sequence[0]);
        if(call_for != null && call_for != undefined && call_for == "add_condition"){
            console.log("add_condition >>>>>>",$('[data-repeater]').length)
            $('[data-repeater]').remove();
        }else{
            let first_rep_num = $("[data-repeater]:visible:first").data("repeater");
            //THEN
            if($('[data-repeater="'+first_rep_num+'"]').length){
                $('[data-repeater="'+first_rep_num+'"]').find('[data-dropdown-entity="cl-actions"]').val("").trigger('change')
                $('[data-repeater="'+first_rep_num+'"]').find('.show-queston-slide').hide();
                $('[data-repeater="'+first_rep_num+'"]').find('.recipients-slide').hide();
                $('[data-repeater="'+first_rep_num+'"]').nextAll('div.conditional-select-wrap').remove();
            }
        }
        //ALL Other Cases
        $('.conditional-select-area.other-case-parent').find('[data-dropdown-entity="cl-actions"]').val("").trigger('change')
        $('.conditional-select-area.other-case-parent').find('.show-queston-slide').hide();
        $('.conditional-select-area.other-case-parent').find('.recipients-slide').hide();

        clForm.pauseEvent=false;
    },
    validateEmail:function(value){
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(value)) {
            return false;
        } else {
            return true;
        }
    },
    validateTrigger:function (){
        console.trace("++ validateTrigger ++")
        let validated = true;
        if(funnelConditions.trigger.getFieldId() === "" || funnelConditions.trigger.getOperator() === ""){
            // Case-1: checking Trigger FieldId OR Operator is set its not blank
            validated = false;
        }
        else if(!["IsKnown","IsUnknown","IsEmpty","IsFilled"].inArray(funnelConditions.trigger.getOperator()) ) {
            // Validate Inputs
            let selectedQuestion = $('[data-dropdown-entity="cl-questions"]').val();
            if(selectedQuestion === "0") return false;
            let questionType = selectedQuestion.split("-")[0];
            let triggerInputs = funnelConditions.trigger.getInputs();

            if ((typeof triggerInputs === "object" && triggerInputs.length === 0) || (typeof triggerInputs === "string" && triggerInputs === "")) {
                // Case-2: Checking Trigger Input values are not blank
                validated = false;
            }
            else if(!["menu", "slider", "dropdown"].inArray(questionType) ) {
                // Case-3: Answer inputs not empty but we need additional validation inputs based on question types
                if(questionType === "zipcode"){
                    let zipcode_value =  triggerInputs[0];
                    let number_reg = /^\d+$/;
                    let zip_val_type = "string";
                    if(number_reg.test(zipcode_value) === true){
                        zip_val_type = "number";
                    }
                    if(zip_val_type == "number"){
                        let inputVal = $('[data-input-field-type="text"] #cl-value').val();
                        if(inputVal.endsWith(",")) validated = false;
                        triggerInputs = inputVal.split(",");
                        if(validated){
                            $.each(triggerInputs,function(k,val){
                                if(!(/(^\d{5}$)/).test(val)){
                                    validated = false;
                                    return false;
                                }
                            })
                        }
                    }
                }
                else if((questionType === "number" || questionType === "slider_numeric" )){
                    // Between Case
                    if(triggerInputs.length > 1){
                        let start_val = triggerInputs[0];
                        let end_val = triggerInputs[1];
                        if( start_val!="" && end_val !="" ){
                            if(parseInt(end_val) < parseInt(start_val)){
                                validated = false;
                            }
                        }
                    }
                }
                else if(questionType === "birthday"){
                    if(triggerInputs.length === 1){
                        let bdValue = triggerInputs[0];
                        let bdData = bdValue.split("/");
                        if(bdData[2] != undefined){
                            if(answerInputs.notStartWithZeroYear(bdData[2])){ // year value not start with 0
                                validated = answerInputs.isValidDate(bdValue);
                            }
                        }
                    }
                    else if(triggerInputs.length === 2){
                        let start_val = triggerInputs[0];
                        let end_val = triggerInputs[1];
                        if(start_val!="" && end_val !="" ){
                            let stBdData = start_val.split("/");
                            let enBdData = end_val.split("/");
                            if(stBdData[2] != undefined && enBdData[2] != undefined ){
                                if(answerInputs.notStartWithZeroYear(stBdData[2]) && answerInputs.notStartWithZeroYear(enBdData[2]) ) { // year value not start with 0
                                    if(answerInputs.isValidDate(start_val) &&  answerInputs.isValidDate(end_val)){
                                        if(answerInputs.validateBDRange(start_val,end_val)){
                                            validated = true;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                else if(questionType === "contact"){
                    if(["primaryemail","email","Email Address"].inArray(funnelConditions.trigger.getContactField())) {
                        validated = clForm.validateEmail(triggerInputs[0].trim());
                    }
                    else if(["primaryphone","phone","Phone Number"].inArray(funnelConditions.trigger.getContactField())) {
                        validated = triggerInputs[0].trim().search("_") == -1 ? true : false;
                    }
                }
            }
        }
        return validated;
    },
    validateAction:function (){
        let validated = false;
        if(!funnelConditions.actions.isFilled()){
            validated = false;
        }
        else{
            if(Object.keys(funnelConditions._condition.actions.action).length > 0){
                $.each(funnelConditions._condition.actions.action, function (i, row){
                    if(typeof row.conditionalFieldId === "object" && row.conditionalFieldId.length != 0){
                        validated = true;
                        return false;
                    }
                });
            }

            if(!validated && Object.keys(funnelConditions._condition.actions.recipient).length > 0){
                /*let recipient_index = Object.keys(funnelConditions._condition.actions.recipient).sort();
                let recipient_row = funnelConditions._condition.actions.recipient[recipient_index[0]];*/
                $.each(funnelConditions._condition.actions.recipient, function (i, row){
                    if(typeof row.id === "string" && row.id != ""){
                        validated = true;
                        return false;
                    }
                    else if(typeof row.id === "object" && row.id.length != 0){
                        validated = true;
                        return false;
                    }
                });
            }

            if(!validated && Object.keys(funnelConditions._condition.actions.thankyou).length > 0){
                /*let thankyou_index = Object.keys(funnelConditions._condition.actions.thankyou).sort();
                let thankyou_row = funnelConditions._condition.actions.thankyou[thankyou_index[0]];*/
                $.each(funnelConditions._condition.actions.thankyou, function (i, row){
                    if(typeof row.id === "string" && row.id != ""){
                        validated = true;
                        return false;
                    }
                    else if(typeof row.id === "object" && row.id.length != 0){
                        validated = true;
                        return false;
                    }
                });
            }
        }
        return validated;
    },
    bindCancelEvent: function(){
        $('#cancel-cl-form').click(function (e) {
            $('[data-repeater]').remove();
            $('#conditional-logic-group').modal('hide');
            if(funnelConditions.getCurrentQuestionIndex() !== ""){
                // Edit Condition Case
                $('#active-condition-modal').modal('show');
            }

            clForm.reset();
            funnelConditions.resetObject();
        });
    },
    bindSubmitEvent: function(){
        $('._add_cl_btn').click(function (e) {
            e.preventDefault();
            let validated = clForm.validateTrigger();
            if(!validated){
                displayAlert('danger', 'Something went wrong while setting IF criteria for condition.');
                return false;
            }
            else{
                let validated = clForm.validateAction();
                if(!validated){
                    displayAlert('danger', 'THEN criteria is required to setup condition.');
                    return false;
                }
            }

            if(!validated){
                displayAlert('danger', 'Something went wrong while saving condition.');
            } else {
                funnelConditions.updateObject();
                clForm.saveCondition();
                if (!$(".conditional-logic-item").hasClass("active")) {
                    if (cl_object.active) $(".conditional-logic-item").addClass('active');
                }
                funnelConditions.setQuestionCLActive();
            }
        });
    },
    saveCondition:function(){
        if(Object.keys(cl_object.conditions).length===1 && cl_object.conditions[1].active){cl_object.active=1};

        $.ajax({
            type: "POST",
            data: {
                "client_leadpop_id": $("#client_leadpop_id").val(),
                "conditional_logic": JSON.stringify(cl_object)
            },
            url: $('#condition-logic-form').data('action'),
            error: function (e) {
                //notifyElem.html('Your request was not processed. Please try again.').removeClass('hide').removeClass('alert-success').addClass('alert-warning');
            },
            success: function (responce) {
                $('[data-repeater]').remove();
                console.debug(responce)
                $('#active-condition-modal').modal('show');

                clForm.reset();
                funnelConditions.resetObject();
                //notifyElem.html('Processing your request').removeClass('hide').removeClass('alert-warning alert-danger').addClass('hide');
            },
            always: function (d) { },
            cache: false,
            async: true
        });
    },
    _filterValue: function(obj, key, value){
        return obj.find(function(v){
            return v[key] === value
        });
    },
    _filterValues: function(arr, key, value){
        const filter_data = arr.filter(function(obj){
            if(obj[key] === value){
                return obj;
            }
        });
        return filter_data;
        //return Object.values(filter_data).map((g) => g.value);
    },
    filterReduce: function(arr, key, value){
        let data_arr = [];
        const output = arr.reduce(function(acc,curr){
            if(curr[key] === value){
                data_arr.push(curr.value);
            }
        },[]);
        return data_arr;
    },
    _fetchFormData: function(input_field){
        let name_values = $(input_field).map(function(){return $(this).val();}).get();
        if(typeof name_values == "object"){
            return Object.values(name_values);
        }else if(typeof name_values == "string"){
            let str_obj = JSON.parse(name_values);
            return Object.entries(str_obj);
        }
    },
    stateSustain:function(){
        let states = funnelConditions.trigger.getInputs(true);
        if(!states.length){
            $('.state-all-checked').prop("checked", false);
            $('.state-checkbox').prop("checked", false);
        }else{
            $.each($('#select-state-modal').find("#cl-state-list").find("li input[type=checkbox]"),function(index,obj){
                let state_name = $(obj).val();
                if(states.inArray(state_name)){
                    $(obj).prop("checked", true);
                    $(obj).attr("data-last-saved-state", 1);

                }else {
                    $(obj).prop("checked", false);
                    $(obj).removeAttr("data-last-saved-state");
                }
            });
            let total= $('.select-state-modal').find('.state-checkbox').length;
            if(total === states.length){
                $('.state-all-checked').prop("checked", true);
            }else{
                $('.state-all-checked').prop("checked", false);
            }
        }
        $('.state-save-btn').prop("disabled", true);
    },
    emptyCheckStates:function (message='No states Available') {

            if($('.state-checkbox:visible').length > 0 ){
                $('[data-empty-states]').addClass('d-none');
                $('[data-state-top-box]').removeClass('d-none');
            }else{
                $('[data-empty-states]').removeClass('d-none');
                $('[data-state-top-box]').addClass('d-none');
            }
            $('[data-states-empty-case-span]').text(message);
    },
    checkAllcheckboxes:function () {
        if($('.state-checkbox:visible:not(:checked)').length){
            $('.state-all-checked').prop("checked", false);
        }else{
            $('.state-all-checked').prop("checked", true);
        }
    },
    statesSaveButton:function(){
        if($('.state-checkbox:checked').length > 0 && $("[data-last-saved-state]").length != $(".state-checkbox:checked").length){
            $('.state-save-btn').prop("disabled", false);    }
        else if($('.state-checkbox:checked').length > 0 && $("[data-last-saved-state]").length === $(".state-checkbox:checked").length &&
            $("[data-last-saved-state]").length !== $("[data-last-saved-state]:checked").length){
            $('.state-save-btn').prop("disabled", false);    }
        else{
            $('.state-save-btn').prop("disabled", true);
        }
    },
    getAllThanOptionsData: function(rep_index,action = null){
        let than_all_options = [clActions.type.showQuestion,clActions.type.hideQuestion,clActions.type.thankYou,clActions.type.leadRecipient];
        let last_rep_num = $("[data-repeater]:visible:last").data("repeater");
        let render_options = new Array();
        let data_than_nodes = $("[data-repeater]:visible");
        /*if(action == "add"){
            data_than_nodes = $("[data-repeater]:visible:not([data-repeater='"+rep_index+"'])");
        }*/
        $.each(data_than_nodes,function(index,obj){
            let cur_rep_num = $(obj).data("repeater");
            if(cur_rep_num == last_rep_num){
                if($("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').val() != null){
                    let action_value = $("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').val();
                    if( action_value != ""){
                        switch (action_value){
                            case "action.Show":
                            case "action.Hide":
                            case "thankyou":
                                if(action == "add"){
                                    if(Object.keys($("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions-questions"]').val()).length){
                                        render_options.push($(obj).find('[data-dropdown-entity="cl-actions"]').val());
                                    }
                                }
                                break;
                            case "recipient":
                                if(action == "add"){
                                    if(Object.values(funnelConditions._condition.actions.recipient[Object.keys(funnelConditions._condition.actions.recipient)]).length){
                                        render_options.push($(obj).find('[data-dropdown-entity="cl-actions"]').val());
                                    }
                                }
                                break;
                        }
                    }
                }
            }else{
                render_options.push($(obj).find('[data-dropdown-entity="cl-actions"]').val());
            }
        });
        let filter_options = than_all_options.filter(x => !render_options.includes(x));
        console.log("than_all_options>>>>>>>>",than_all_options);
        console.log("render_options>>>>>>>>",render_options);
        console.log("filter_options>>>>>>>>",filter_options);
        let new_options_data = [];
        let new_option_html = inputPlaceholders.selectActionOption;
        $.each(filter_options,function(y,value){
            let opt_text = "";
            switch (value){
                case "action.Show":
                    opt_text = "Show Questions";
                    break;
                case "action.Hide":
                    opt_text = "Hide Questions";
                    break;
                case "thankyou":
                    opt_text = "Show Specific Thank You Page";
                    break;
                case "recipient":
                    opt_text = "Change Lead Alert Recipient";
                    break;
            }
            new_options_data.push({
                id: value,
                text: opt_text
            })
            new_option_html +="<option value='"+value+"'>"+opt_text+"</option>";
        });
        return {
            data: new_options_data,
            html: new_option_html
        };
    },
    getTotalTHENActionsNodes: function(){
        return $("[data-repeater]:visible").length;
        //return Object.keys(funnelConditions._condition.actions.action).length + Object.keys(funnelConditions._condition.actions.thankyou).length + Object.keys(funnelConditions._condition.actions.recipient).length;
    },
    disableEnableShowHideThankYouComboThanOption:function(repeater_index, action = null){
        if(action != null && action != undefined && action == "enable" ){
            $("[data-repeater='"+repeater_index+"']").find('div.select-action-parent').removeClass("disabled").addClass("selected-active");
            $("[data-repeater='"+repeater_index+"']").find('div.show-question-parent').removeClass("disabled").addClass("selected-active");
        }else{
            $("[data-repeater='"+repeater_index+"']").find('div.select-action-parent').removeClass("selected-active").addClass("disabled");
            $("[data-repeater='"+repeater_index+"']").find('div.show-question-parent').removeClass("selected-active").addClass("disabled");
        }
    },
    disableEnableRecipientComboThanOption:function(repeater_index, action = null){
        if(action != null && action != undefined && action == "enable" ){
            $("[data-repeater='"+repeater_index+"']").find('div.select-action-parent').removeClass("disabled").addClass("selected-active");
            $("[data-repeater='"+repeater_index+"']").find('[data-receipient-opener="thencase"]').parent().removeClass("disabled");
        }else{
            $("[data-repeater='"+repeater_index+"']").find('div.select-action-parent').removeClass("selected-active").addClass("disabled");
            $("[data-repeater='"+repeater_index+"']").find('[data-receipient-opener="thencase"]').parent().addClass("disabled");
        }
    },
    enableDisableThanOptionSelect:function(repeater_index,action){
        let target_option_val = $('[data-repeater="'+repeater_index+'"]' ).find('[data-dropdown-entity="cl-actions"]').val();
        switch (target_option_val){
            case clActions.type.showQuestion:
            case clActions.type.hideQuestion:
            case clActions.type.thankYou:
                clForm.disableEnableShowHideThankYouComboThanOption(repeater_index,action);
                break;
            case clActions.type.leadRecipient:
                clForm.disableEnableRecipientComboThanOption(repeater_index,action);
                break;
        }
    },
    _disabelPlusBtnDeleteAction: function(){
        let last_rep_obj = $("[data-repeater]:visible:last");
        $.each($(last_rep_obj).find(".btn-wrap:visible").children(),function(i,btn){
            if($(btn).data("repeater-then") == "add"){
                if($(btn).css('visibility') == "visible" && $(btn).css('opacity') == 1){
                    $(btn).parent().addClass("disabled");
                }
            }
        });
    },
    manageDeleteActionRepeater:function(mode = null){
        let rep_len = $("[data-repeater]:visible").length;
        let first_rep_obj = $("[data-repeater]:visible:first");
        let last_rep_obj = $("[data-repeater]:visible:last");

        /*
        console.log("%%%%rep_len%%%%",rep_len);
        console.log("%%%%first_rep_obj%%%%",first_rep_obj);
        console.log("%%%%last_rep_obj%%%%",last_rep_obj);
        */

        if(mode == "edit_open"){
            if($("[data-repeater]:visible").find(".btn-wrap.disabled").length){
                //console.log("%%%%.btn-wrap.disabled find%%%%",$("[data-repeater]:visible").find(".btn-wrap.disabled").length);
                $("[data-repeater]:visible").find(".btn-wrap").removeClass("disabled");
            }
        }
        if(rep_len == 1){
            //console.log("%%%%rep_len == 1 %%%%",rep_len);
            first_rep_obj.find('[data-repeater-then="remove"]:visible').css({
                opacity: 0,
                visibility: "hidden"
            });
            first_rep_obj.find('[data-repeater-then="add"]:visible').css({
                opacity: 1,
                visibility: "visible"
            });

        }else if(rep_len > 1 && rep_len < 4){
           // console.log("%%%%rep_len > 1 && rep_len < 4%%%%",rep_len);
            last_rep_obj.find('[data-repeater-then="remove"]:visible').css({
                opacity: 0,
                visibility: "hidden"
            });
            last_rep_obj.find('[data-repeater-then="add"]:visible').css({
                opacity: 1,
                visibility: "visible"
            });
        }else{
            //console.log("%%%%rep_len == 4 full length < 4%%%%",rep_len);
            last_rep_obj.find('[data-repeater-then="remove"]:visible').parent("span").removeClass("disabled");
            last_rep_obj.find('[data-repeater-then="remove"]:visible').css({
                opacity: 1,
                visibility: "visible"
            });
            last_rep_obj.find('[data-repeater-then="add"]:visible').css({
                opacity: 0,
                visibility: "hidden"
            });
        }
        if(mode == "edit_open"){
            if(!clForm.pauseEvent) clForm.pauseEvent = true;
            if( $("[data-repeater]:visible").length > 3){
                last_rep_obj.find('span.btn-wrap').addClass("d-none").parents('.select-area').addClass("only-field");
            }
            let action_value = $("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').val();
            let option_data = clForm.getAllThanOptionsData(last_rep_obj.data("repeater"),"edit");
            $("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').html(option_data.html);
            let action_option_value = clForm.getLastRepeaterActionOptionsValue(action_value);
            clForm.thenLastNodeActionWithOptionsRerender(action_value,action_option_value,mode);
            clForm.enableDisableThanOptionSelect(last_rep_obj.data("repeater"),'enable');
            if(clForm.pauseEvent) clForm.pauseEvent = false;
        }
    },
    showCrossHidePlus:function(ele_obj){
        ele_obj.css({
            opacity: 0,
            visibility: "hidden"
        });
        ele_obj.next().css({
            opacity: 1,
            visibility: "visible"
        });
    },
    getOptionDataBYAction: function (type,action = null){
        let action_options = funnelConditions.combineActions(funnelConditions._condition.actions.action, funnelConditions._condition.actions.recipient, funnelConditions._condition.actions.thankyou);
        let target_obj;
        console.log("getOptionDataBYAction===> type====> ation",type,action)
        $.each(action_options,function(i,obj){
            console.log("action_options ===> obj.type ====> obj.visibility",obj.type,obj.visibility)
            if(type == obj.type){
                if(action != null){
                    if(obj.visibility == action){
                        target_obj = obj;
                        return false;
                    }
                }else{
                    target_obj = obj;
                    return false;
                }
            }
        })
        return (target_obj != undefined) ? target_obj : false;
    },
    getLastRepeaterActionOptionsValue: function(action_value){
        let action_option_value = false;
        if( action_value != ""){
            switch (action_value){
                case "action.Show":
                case "action.Hide":
                case "thankyou":
                    if(Object.keys($("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions-questions"]').val()).length){
                        action_option_value = true;
                    }
                    break;
                case "recipient":
                    if(Object.values(funnelConditions._condition.actions.recipient[Object.keys(funnelConditions._condition.actions.recipient)])){
                        let is_recipient = false;
                        $.each(Object.values(funnelConditions._condition.actions.recipient[Object.keys(funnelConditions._condition.actions.recipient)]),function(i,val){
                            if(val != ""){
                                is_recipient = true;
                                return false;
                            }
                        });
                        action_option_value = is_recipient;
                    }
                    break;
            }
        }
        console.log("action_option_value >>>>>> cross btn",action_option_value)
        return action_option_value;

    },
    removeClUpdateActionOptions: function(rep_action_index,action){
        let option_data = clForm.getAllThanOptionsData(rep_action_index,action);
        let action_value = $("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').val();
        console.log("action_value >>>>> Cross btn",action_value)
        let action_option_value = clForm.getLastRepeaterActionOptionsValue(action_value);
        if(action_option_value){
            $("[data-repeater]:visible:last").find('span.btn-wrap').removeClass("disabled d-none").parents('.select-area').removeClass("only-field");
        }else {
            $("[data-repeater]:visible:last").find('span.btn-wrap').addClass("disabled").removeClass("d-none").parents('.select-area').removeClass("only-field");
        }
        $("[data-repeater]:visible:last").find('[data-repeater-then="remove"]:visible').css({
            opacity: 0,
            visibility: "hidden"
        });
        $("[data-repeater]:visible:last").find('[data-repeater-then="add"]:visible').css({
            opacity: 1,
            visibility: "visible"
        });
        $("[data-repeater]:visible:last").find('[data-dropdown-entity="cl-actions"]').html(option_data.html);
        clForm.thenLastNodeActionWithOptionsRerender(action_value,action_option_value);
    },
    thenLastNodeActionWithOptionsRerender : function(action_value,action_option_value,mode = null){
        let cindex = $("[data-repeater]:visible:last").data("repeater");
        let action_options;
        if( action_value != ""){
            switch (action_value){
                case "action.Show":
                    action_options = clForm.getOptionDataBYAction("actions","Show");
                    if(action_options != undefined && action_options != false){
                        $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("action.Show").trigger('change');
                        if(action_option_value === true){
                            let dropdown_value = new Array();
                            $.each(action_options.conditionalFieldId,function(i,obj){
                                console.log("action.conditionalFieldId del>>>>>>",obj)
                                let ques_id = funnelQuestions.getQuestionTitle(obj).id;
                                dropdown_value.push(ques_id);
                            });
                            let total_question = action_options.conditionalFieldId.length;
                            let ques_text = (total_question > 1) ? " Questions Selected ":" Question Selected ";
                            console.log(">>>>>>> new_title_string",dropdown_value);
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").val(dropdown_value).trigger('change');
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_question + '</strong>' + ques_text + '</span>');
                        }
                    }
                    break;
                case "action.Hide":
                    action_options = clForm.getOptionDataBYAction("actions","Hide");
                    if(action_options != undefined && action_options != false){
                        $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("action.Hide").trigger('change');
                        if(action_option_value === true){
                            let dropdown_value = new Array();
                            $.each(action_options.conditionalFieldId,function(i,obj){
                                console.log("action.conditionalFieldId del>>>>>>",obj)
                                let ques_id = funnelQuestions.getQuestionTitle(obj).id;
                                dropdown_value.push(ques_id);
                            });
                            let total_question = action_options.conditionalFieldId.length;
                            let ques_text = (total_question > 1) ? " Questions Selected ":" Question Selected ";
                            console.log(">>>>>>> new_title_string",dropdown_value);
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").val(dropdown_value).trigger('change');
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").next("span.select2").find("span.select2-selection").addClass('item-selected').html('<span class="selected-value-wrap"><strong>'+total_question + '</strong>' + ques_text + '</span>');
                        }
                    }
                    break;
                case "thankyou":
                    action_options = clForm.getOptionDataBYAction("thankyou");
                    if(action_options != undefined && action_options != false){
                        $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("thankyou").trigger('change');
                        if(action_option_value === true){
                            $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions-questions']").val(action_options.id).trigger('change');
                        }
                    }
                    break;
                case "recipient":
                    action_options = clForm.getOptionDataBYAction("recipients");
                    if(action_options != undefined && action_options != false){
                        $("[data-repeater='"+cindex+"']").find("[data-dropdown-entity='cl-actions']").val("recipient").trigger('change');
                        if(action_option_value === true){
                            let total_recip = action_options.id.length;
                            let sel_text = (total_recip.length > 1) ? " Recipients Selected":" Recipient Selected";
                            funnelConditions.actions.recipient(cindex, clActions.type.leadRecipient, action_options.id,mode)
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-recipient]").html('<strong>'+total_recip+'</strong>'+sel_text);
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-recipient]").addClass('recipient-active');
                            $("[data-repeater='"+cindex+"']").find("[data-cl-then-action-recipients]").val(JSON.stringify(action_options.id));
                        }
                    }
                    break;
            }
        }

    },
    actionOptionChangeManageBtnStatus: function(repeater_index,action,btnStatus){
        let obj = $("[data-repeater='"+repeater_index+"']");
        if(btnStatus === true){
            $(obj).find(".btn-wrap").removeClass("disabled");
        }else if(btnStatus === false){
            $(obj).find(".btn-wrap").addClass("disabled");
        }
    },
    reRenderInputByQuestionOperator: function(answerOption = null){
        let selectedQuestion = $('[data-dropdown-entity="cl-questions"]').val();
        let selectedOperator = $('[data-dropdown-entity="cl-triggers"]').val();
        answerInputs.render(selectedQuestion, selectedOperator);
        if(answerOption != null){
            $('[data-dropdown-entity="answers-options"]').val(answerOption).trigger('change');
        }
    }
}

var clList = {
    searchStr:{},
    mainHtml:"",
    updateCounter: function(){
        let cl_keys = cl_object.conditionSequence.toString().split("-");
        cl_keys = cl_keys.filter(item => item);
        $("#cl_total").html(cl_keys.length);

        $("#cl_total_inactive").html($(".item-wrap.disabled").length);
        $("#cl_total_active").html(cl_keys.length - $(".item-wrap.disabled").length);
    },
    returnConditionalListing:function (keyword=''){
        let rowHtml = "";
        let thenHtml = "";
        let altAcHtml = "";
        let active = 0;
        let inactive = 0;
        clList.mainHtml='';
        // console.log('this is empty status',$('[data-show-condition-list]').empty());
        if(clList.getFunnelConditions().conditionSequence !== "") {
            let cl_keys = clList.getFunnelConditions().conditionSequence.toString().split("-");
            $("#cl_total").html(cl_keys.length);
            if (cl_keys.length > 0) {
                $('[data-condition-list-global-controls]').css('display', 'flex');
                if(clList.getFunnelConditions().active){
                    $("[cl-listing-checkbox]").prop("checked", true);
                } else {
                    $("[cl-listing-checkbox]").prop("checked", false);
                }
                $('[data-check-all-cl]').removeClass('d-none');
                $.each(cl_keys, function (k, seqKey) {
                    let term =clList.getFunnelConditions().conditions[seqKey]['terms']["t1"];
                    let ques_info = funnelQuestions.getQuestionTitle(term['actionFieldId']);

                    let action =clList.getFunnelConditions().conditions[seqKey]['actions']['action'];
                    let recipient = clList.getFunnelConditions().conditions[seqKey]['actions']['recipient'];
                    let thankyou = clList.getFunnelConditions().conditions[seqKey]['actions']['thankyou'];

                    let altAction = clList.getFunnelConditions().conditions[seqKey]['alt_actions']['action'];
                    let altRecipient = clList.getFunnelConditions().conditions[seqKey]['alt_actions']['recipient'];
                    let altThankyou = clList.getFunnelConditions().conditions[seqKey]['alt_actions']['thankyou'];
                    thenHtml = clListingMarkup.getComponent(action, recipient, thankyou, 'then');
                    altAcHtml = clListingMarkup.getComponent(altAction, altRecipient, altThankyou, 'allcases');
                    rowHtml = clListingMarkup.getConditionRowHTML(seqKey, k, term, thenHtml.html, altAcHtml.html, clList.getFunnelConditions().conditions[seqKey]['active']);

                    // console.log($('input[data-single-status]').is('[value="1"]'));
                    // if($('input[data-single-status]').is('[value="1"]')){
                    //     $(this).prop('checked',true);
                    // }else{
                    //     $(this).prop('checked',false);
                    // }
                    if(clList.getFunnelConditions().conditions[seqKey]['active'])
                        active++;

                    else
                        inactive++;

                    clList.searchStr[k] = rowHtml['string']+' '+thenHtml['string']+' '+altAcHtml['string'];
                    clList.mainHtml += rowHtml.html;

                });

                $("#cl_total_active").html(active);
                $("#cl_total_inactive").html(inactive);
                $('[data-show-condition-list]').html(clList.mainHtml+clListingMarkup.emptyCase());
            }
            else {
                $('[data-show-condition-list]').html(clList.mainHtml+clListingMarkup.emptyCase())
                clList.getFunnelConditions().conditionSequence = ""
                $('[data-empty-cl-list]').removeClass('d-none');
                $('[data-check-all-cl]').addClass('d-none');
            }
           ;
        }
        else{
            $('[data-show-condition-list]').html(clList.mainHtml+clListingMarkup.emptyCase())
            if(!funnelConditions._hasConditions()){
                $('[data-empty-cl-list]').removeClass('d-none');
                $('[data-check-all-cl]').addClass('d-none');
            }
        }
        clList.updateCounter();
        $('.el-tooltip').tooltipster({
            contentAsHTML:true,
            debug:false
        });
        $('.cl-tooltip-label-text').tooltipster({
            contentAsHTML:true,
            debug:false
        });
    clList.singleClStatus();
    $('.draging-item-link').removeClass('draging-disable');
    },
    conditionListingSearch:function (keyword=''){
        let rowHtml="";
        keyword=keyword.toLowerCase();
         $.each(clList.searchStr,function (key,value) {
                if(value.toLowerCase().includes(keyword)){
                    $('[data-main-li-'+key+']').removeClass('d-none');
                }
                else {
                    $('[data-main-li-'+key+']').addClass('d-none');
                }
            });
        if(keyword !== "" && $(".active-condition-list li.item-wrap").not('.d-none').length === 0){
            let message='No results were found for this search. Try something else.';
            $('[data-empty-cl-list]').removeClass('d-none');
            $('[data-check-all-cl]').addClass('d-none');
            $('[data-condition-list-global-controls]').addClass('d-none');
            $('[data-cl-empty-case-span]').text(message);
        }else{
            $('[data-empty-cl-list]').addClass('d-none');
            $('[data-check-all-cl]').removeClass('d-none');
            $('[data-condition-list-global-controls]').removeClass('d-none');
        }

        setTimeout(clList.clDeleteButtonShow() ,
                clList.clSelectAllCheckbox(),2000 );
        },
    clDeleteButtonShow:function () {
        if($('.condition-check:checked:visible').length >0 && $('.condition-check:visible').length === $('.condition-check').length){
            $('[data-deletebtn]').show();
        }else {
            $('[data-deletebtn]').hide();
        }

    },
    clSelectAllCheckbox:function () {
        if($('.condition-check:checked:visible').length >0 && $('.condition-check:checked:visible').length === $('.condition-check:visible').length){
            $('.condition-all-checked').prop('checked', true);
        }else {
            $('.condition-all-checked').prop('checked', false);
        }

    },
    getFunnelConditions:function(){
       if(Funnel_Condition.conditionSequence===''){
        return cl_object;
       }else {
           return Funnel_Condition;
       }
    },
    cloneClObj:function(){
        if(Funnel_Condition.conditionSequence===''){
            Funnel_Condition = jQuery.extend(true, {}, cl_object);
            return Funnel_Condition;
        }
    },
    clListSaveHandle:function (){
            if(JSON.stringify(clList.getFunnelConditions()) != JSON.stringify(cl_object))
            {
                $('#edit-rcpt').prop('disabled',false)
            }else {
                $('#edit-rcpt').prop('disabled',true)
            }

    },

    singleClStatus:function (){
        $("input[data-single-status][value=1]").attr('checked', true);
        $("input[data-single-status][value=0]").attr('checked', false);

    },
    singleClStatusChange:function (elem){
       clList.cloneClObj()
       let index= $(elem).data('value');
       let val= $(elem).val();
       console.log(index,val)
       if(val==='1'){
           clList.getFunnelConditions().conditions[index].active=0
           $(elem).prop('checked',false);
           $(elem).val('0');
           $(elem).parents('.active-condition-list > li').addClass('disabled');
       }else {
           clList.getFunnelConditions().conditions[index].active=1
           $(elem).prop('checked',true);
           $(elem).val('1');
           $(elem).parents('.active-condition-list > li').removeClass('disabled');

       }
       clList.clListSaveHandle()
    },
    reSetTempObj:function () {
        Funnel_Condition = {
            active:'',
            conditionSequence: "",
            conditions: {},
        }
    },
    addNewCLCondition: function(element){ // ADD NEW CONDITON Button event on listing page
        clForm.reset();
        funnelConditions.resetObject();
        $('#conditional-logic-group').modal('show');
        let clQuestionValue = $(element).data("cl-question-value");
        if(clQuestionValue.indexOf("~~")){
            clQuestionValue = $(element).data("cl-question-value").split("~~");
            clQuestionValue = clQuestionValue[0];
        }
        $('[data-dropdown-entity="cl-questions"]').val(clQuestionValue).trigger('change');
        $('.select2-parent').removeClass('selected-active')
        $('#conditional-logic-group').find('#edit_cl').prop('disabled',true);
    }
}
var leadRecipient = {
    bindActionsEvent: function(){
        // Save logic for lead Recipient
        $(document).on('click', "[data-recipient-caller]", function(e){
            e.preventDefault();
            if(!clForm.pauseEvent) clForm.pauseEvent = true;
            let element = $(this);
            let caller = $(this).attr("data-recipient-caller");
            let recipents_objs = $("#select-recipient-modal").find('.recipient-checkbox:checked');
            let selected_data = [];
            $.each(recipents_objs, function( i, ele ) {
                if($(ele).val() !== "") {
                    let parent = $(ele).parents("ul[data-recipientList]");
                    // let obj_data = {
                    //     "id": $(ele).val(),
                    //     "name": parent.data("recipientname"),
                    //     "email": parent.data('recipientemail')
                    // }
                    selected_data.push($(ele).val());
                }
            });

            if(selected_data.length){
                let sel_text = (selected_data.length > 1)? " Recipients Selected":" Recipient Selected";
                if(caller === "thencase"){
                    funnelConditions.actions.recipient(element.attr("data-recipient-num"), clActions.type.leadRecipient, selected_data)
                    console.log(".conditional-select-wrap:visible",$(".conditional-select-wrap:visible").length);
                    console.log("[data-repeater]:visible",$("[data-repeater]:visible").length);
                    console.log("[data-repeater]:last data(repeater)",$("[data-repeater]:last").data("repeater"));
                    setTimeout(function () {
                        /*if( $("[data-repeater]:visible").length == 4){
                            console.log("[data-repeater]:visible",$("[data-repeater]:visible").length);
                            console.log("[data-repeater]:last data(repeater)",$("[data-repeater]:last").data("repeater"));
                            clForm.disableEnableRecipientComboThanOption($("[data-repeater]:last").data("repeater"));
                        }*/
                        clForm.manageDeleteActionRepeater();
                    }, 1000);
                    $("[data-repeater='"+element.attr("data-recipient-num")+"']").find("[data-cl-then-recipient]").html('<strong >'+selected_data.length+'</strong>'+sel_text);
                    $("[data-repeater='"+element.attr("data-recipient-num")+"']").find('span.btn-wrap').removeClass("disabled");
                    //$("[data-repeater='"+element.attr("data-recipient-num")+"']").find("[data-cl-then-recipient]").addClass('recipient-active');
                    $("[data-repeater='"+element.attr("data-recipient-num")+"']").find("[data-cl-then-action-recipients]").val(JSON.stringify(selected_data));
                }
                else if (caller === "allcases"){
                    funnelConditions.alt_actions.recipientOrThankyou(clActions.type.leadRecipient, selected_data)
                    // $("[data-cl-all-recipient]").text(selected_data.length+sel_text);
                    $("[data-cl-all-recipient]").html('<strong>'+selected_data.length+'</strong>'+sel_text);
                    $("[data-cl-all-recipient]").addClass('recipient-active');

                    $("[data-cl-all-action-recipients]").val(JSON.stringify(selected_data));
                }
            }
            $('#select-recipient-modal').modal('hide');
            $('#conditional-logic-group').modal('show');
            setTimeout(function (repeater) {
                /*let btnStatus = (selected_data.length) ? true : false;
                clForm.actionOptionChangeManageBtnStatus(element.attr("data-recipient-num"),'recipient',btnStatus);*/
                $("#conditional-logic-group").find('.modal-body').mCustomScrollbar("scrollTo","[data-repeater='"+repeater+"']",{
                    axis: "y",
                    scrollInertia: 500,
                });
                funnelConditions.saveBtnState();
            }, 1000,element.attr("data-recipient-num"));
            if(clForm.pauseEvent) clForm.pauseEvent = false;
            /*console.debug('***************selected_data******************');
            console.debug(typeof selected_data);
            console.debug(selected_data);
            console.debug('###############selected_data###################');*/

        });
    },
    emptyCase:function () {
        return'                    <div data-empty-case class="condition-message-block-parent d-none">\n' +
            '                          <div class="condition-message-block">\n' +
            '                               <span class="icon-wrap"><i class="ico-search"></i></span>\n' +
            '                               <span class="condition-message-text" data-empty-case-span>No results were found for this search. Try something else.</span>\n' +
            '                         </div>\n' +
            '                      </div>';

    },
}

function pressEnterSearch(e){
    e.preventDefault();
    if (e.which == 13){
        $('[data-search-btn-leadrecipient]').click();
    }
};

$(document).on('keyup','[search-field-conidition-lisiting]',function (e) {
    e.preventDefault();
    if($(this).val().length === 0){
        $('[data-empty-cl-list]').addClass('d-none');
        $('[data-cl-index]').removeClass('d-none');
        $('[clear-search-conidition]').click();
    };
    clList.clDeleteButtonShow();
    clList.clSelectAllCheckbox()
    if (e.which == 13){
        $('[search-btn-conidition-lisiting]').click();

    }


});
function recipientCheckBox(){
    if($('.recipient-checkbox:visible:not(:checked)').length){
        $('.recipient-all-checked').prop("checked", false);
    }else{
        $('.recipient-all-checked').prop("checked", true);
    }


}

function recipientSaveButton(){
    if($('.recipient-checkbox:checked').length > 0 && $("[data-last-saved]").length != $(".recipient-checkbox:checked").length){
        $('.recipient-save-btn').prop("disabled", false);    }
    else if($('.recipient-checkbox:checked').length > 0 && $("[data-last-saved]").length === $(".recipient-checkbox:checked").length && $("[data-last-saved]").length !== $("[data-last-saved]:checked").length){
        $('.recipient-save-btn').prop("disabled", false);    }
    else{
        $('.recipient-save-btn').prop("disabled", true);
    }
}

function searchRecipients(e) {
    e.preventDefault()
    var get_length = jQuery('[data-recipients_search_field]').val().trim().length;
    if (get_length > 0) {
        jQuery('[data-recipients_search_field]').parent().addClass('recipient-search-active');
    }
    else {
        jQuery('[data-recipients_search_field]').parent().removeClass('recipient-search-active');
    }
    let recipients_search_field= $('[data-recipients_search_field]').val().trim();
    $('[data-recipientList]').each((key, item) => {
        if (recipients_search_field) {
            let elementdata = recipients_search_field.toLowerCase();
            let currentelement = item.getAttribute('data-recipientname').toLowerCase()+' '+item.getAttribute('data-recipientemail').toLowerCase();
            if (currentelement.includes(elementdata)) {
                item.classList.remove('d-none');
            } else {
                item.classList.add('d-none');
            };
        }else {
            item.classList.remove('d-none');
        }
        if(!$('[data-recipientList]').is(':visible')){
            $('[data-empty-case]').removeClass('d-none');
            $('.check-area').addClass('empty-case-active');
        }else {
            $('[data-empty-case]').addClass('d-none');
            $('.check-area').removeClass('empty-case-active')
        }
    });
    recipientCheckBox();

}

/**
 *vehicle make and model
 * @type {{makeSearch: vehicleMakeModel.makeSearch, clearMakeSearch: vehicleMakeModel.clearMakeSearch, clearSearchBoxBtn: vehicleMakeModel.clearSearchBoxBtn, modelSearch: vehicleMakeModel.modelSearch, pressEnterSearch: vehicleMakeModel.pressEnterSearch}}
 */
var vehicleMakeModel ={

    clearSearchField:function (type){
            $('[data-vehicle_'+type+'_search_field]').val('');
            $('[data-vehicle_'+type+'_search_btn]').click();
            $('[data-vehicle_'+type+'_search_field]').parent().removeClass('states-search-active');
    },
    makeAndModelSearch:function (e,type){
        e.preventDefault()
        let makeAndModel_search_field= $('[data-vehicle_'+type+'_search_field]').val().trim();

        $("ul#cl-"+type+"-list li[data-"+type+"-list]").addClass('d-none');
        $("ul#cl-"+type+"-list li:regex(data-"+type+"-list,"+makeAndModel_search_field+")").removeClass('d-none');

        if(!$('[data-'+type+'-list]').is(':visible')){
            $('[data-empty-'+type+']').removeClass('d-none');
            $('.check-area').addClass('empty-case-active');
        }else {
            $('[data-empty-'+type+']').addClass('d-none');
            $('.check-area').removeClass('empty-case-active')
        }
        vehicleMakeModel.clearSearchBoxBtn(type);
        },
    pressEnterSearch: function(e,type){
        e.preventDefault();
        let value = $('[data-vehicle_'+type+'_search_field]').val().trim().length
        if (e.which == 13 || e.key === "Enter"){
           $('[data-vehicle_'+type+'_search_btn]').click();
        }
        if(value == 0){
            vehicleMakeModel.clearSearchField(type)
        }
    },
    clearSearchBoxBtn:function (type) {
           let value= $('[data-vehicle_'+type+'_search_field]').val().trim().length;
            if(value>0){
                $('[data-vehicle_'+type+'_search_field]').parent().addClass('states-search-active');
            }
    },

    sustainValueModel:function(){
        let Type = funnelConditions.trigger.getFieldId(true).split("-")[1];
        let states = funnelConditions.trigger.getInputs(true);
        let Operator=funnelConditions.trigger.getOperator();
        let inputType='';
        (Operator==='IsNot'||Operator==='Is')?inputType='radio': inputType='checkbox'
        if(!states.length){
            $('.'+Type+'-checkbox').prop("checked", false);
            $('.'+Type+'-checkbox').removeAttr("data-last-saved-value-"+Type+"");
        }else{
            $.each($('#select-vehicle-'+Type+'').find("#cl-"+Type+"-list" ).find("li input[type="+inputType+"]"),function(index,obj){
                let state_name = $(obj).val();
                if(states.inArray(state_name)){
                    $(obj).prop("checked", true);
                    $(obj).attr("data-last-saved-value-"+Type+"", 1);

                }else {
                    $(obj).removeAttr("data-last-saved-value-"+Type+"");
                }
            });
        }
        $('.'+Type+'-save-btn').prop("disabled", true);
    },
    makeSaveButton:function(Type){
        if($('.'+Type+'-checkbox:checked').length > 0 && $("[data-last-saved-value-"+Type+"]").length != $("."+Type+"-checkbox:checked").length){
            $('.'+Type+'-save-btn').prop("disabled", false);    }
        else if($('.'+Type+'-checkbox:checked').length > 0 && $("[data-last-saved-value-"+Type+"]").length === $("."+Type+"-checkbox:checked").length &&
            $("[data-last-saved-value-"+Type+"]").length !== $("[data-last-saved-value-"+Type+"]:checked").length){
            $('.'+Type+'-save-btn').prop("disabled", false);    }
        else{
            $('.'+Type+'-save-btn').prop("disabled", true);
        }
    },
    modelSaveButton:function(Type){
        if($('.model-checkbox:checked').length > 0 && $("[data-last-saved-value-"+Type+"]").length != $(".model-checkbox:checked").length){
            $('.model-save-btn').prop("disabled", false);    }
        else if($('.make-checkbox:checked').length > 0 && $("[data-last-saved-value-"+Type+"]").length === $(".model-checkbox:checked").length &&
            $("[data-last-saved-value-"+Type+"]").length !== $("[data-last-saved-value-"+Type+"]:checked").length){
            $('.model-save-btn').prop("disabled", false);    }
        else{
            $('.model-save-btn').prop("disabled", true);
        }
    },

};

//check save make button
$('.make-checkbox').change(function () {
    vehicleMakeModel.makeSaveButton('make');
});
//check save  model button
$('.model-checkbox').change(function () {
    vehicleMakeModel.makeSaveButton('model');
});
// Binding Event to Save Model
$(document).on('click', "#cl-model-save-btn", function (e) {
    let models = [];
    let cl_value_input_filed = $("[data-input-field-type='text']").find("[data-input-markup]");
    let cl_value_html = inputPlaceholders.textField;

    $('.model-checkbox:checked').each(function (index, obj) {
        let selected_model_obj = {
            "id": $(obj).val(),
            "name": $(obj).next('span.checkbox-text').text()
        };
        models.push(selected_model_obj);
    });
    if (models.length) {
        cl_value_html = funnelConditions.getModelsListHTML(models);
        $('#conditional-logic-group').modal('show');
        $('#select-vehicle-model').modal('hide');
        $('[data-input-field-type="select-vehicle-model"]').hide();
        $('.select-code-field-slide').hide();
        funnelConditions.trigger.setInputs(JSON.stringify(models));
        cl_value_input_filed.html(cl_value_html);
        $('[data-input-field-type="text"]').show();
        if (jQuery('.cl-models-input-field-wrap').length > 0) {
            jQuery('.cl-models-input-field-wrap').mCustomScrollbar({
                axis: "y",
                scrollInertia: 500,
            });
        }
    } else {
        cl_value_input_filed.html(cl_value_html);
        $('[data-input-field-type="text"]').hide();
        $('.select-code-field-slide').show();
    }
    funnelConditions.saveBtnState();
    //$("#conditional-logic-group").trigger("change");

});
// Binding Event to Save make
$(document).on('click', "#cl-make-save-btn", function (e) {
    let makes = [];
    let cl_value_input_filed = $("[data-input-field-type='text']").find("[data-input-markup]");
    let cl_value_html = inputPlaceholders.textField;

    $('.make-checkbox:checked').each(function (index, obj) {
        let selected_make_obj = {
            "id": $(obj).val(),
            "name": $(obj).next('span.checkbox-text').text()
        };
        makes.push(selected_make_obj);
    });
    if (makes.length) {
        cl_value_html = funnelConditions.getMakeListHTML(makes);
        $('#conditional-logic-group').modal('show');
        $('#select-vehicle-make').modal('hide');
        $('[data-input-field-type="select-vehicle-make"]').hide();
        $('.select-code-field-slide').hide();
        funnelConditions.trigger.setInputs(JSON.stringify(makes));
        cl_value_input_filed.html(cl_value_html);
        $('[data-input-field-type="text"]').show();
        if (jQuery('.cl-make-input-field-wrap').length > 0) {
            jQuery('.cl-make-input-field-wrap').mCustomScrollbar({
                axis: "y",
                scrollInertia: 500,
            });
        }
    } else {
        cl_value_input_filed.html(cl_value_html);
        $('[data-input-field-type="text"]').hide();
        $('.select-code-field-slide').show();
    }
    funnelConditions.saveBtnState();
    $("#conditional-logic-group").trigger("change");

});
//keyup on vehicle make search field
$(document).on('keyup','[data-vehicle_make_search_field]',function (e) {
    let elem = $(this);
    vehicleMakeModel.pressEnterSearch(e ,'make');
})

// //keyup on vehicle model search field
$(document).on('keyup','[data-vehicle_model_search_field]',function (e) {
    let elem = $(this);
    vehicleMakeModel.pressEnterSearch(e ,'model');
})


/**
 * old Status function
 */

$(document).on('change','[data-single-status]',function (e) {
    e.preventDefault();
   clList.singleClStatusChange(this);
    if($('[data-single-status]').not(':checked').length === $('[data-single-status]').length){
        clList.getFunnelConditions().active=0;
        $(".conditional-logic-item").removeClass("active");
        $("[cl-listing-checkbox]").prop('checked',false);
    }
})

function conidtionEmptyState(){
    if ($('.item-wrap').hasClass('condition-message-block-parent')) {
        $('.item-wrap').parents('.modal-body').addClass('empty-state-active');
        $('[data-condition-list-global-controls]').addClass('d-none');
    } else {
        $('.item-wrap').parents('.modal-body').removeClass('empty-state-active');
        $('[data-condition-list-global-controls]').removeClass('d-none');
    }

    if ($('.active-condition-list > li').length <= 0) {
        $('.modal-body').addClass('condition-item-hide');
        $('[data-condition-list-global-controls]').addClass('d-none');
    } else {
        $('.modal-body').removeClass('condition-item-hide');
        $('[data-condition-list-global-controls]').removeClass('d-none');
    }

    jQuery(".active-condition-list > li").hover(function () {
        jQuery('body').toggleClass('item-wrap-hover');
    });
}

function ClearSearch(){
    // jQuery('.query-search').keyup(function (e) {
    //     var get_length = jQuery(this).val().trim().length;
        // if (get_length > 0) {
        //     jQuery(this).parent().addClass('condition-search-active');
        // }
        // else {
        //     jQuery(this).parent().removeClass('condition-search-active');
        // }
    // });

    jQuery('[clear-search-conidition]').click(function (e) {
        e.preventDefault();
        var _this = jQuery(this).parents('.input-holder');
        _this.find('.query-search').val('');
        if($('[data-cl-index]').length > 0){
            $('[data-cl-index]').removeClass('d-none');
            $('[data-check-all-cl]').removeClass('d-none');
            $('[data-empty-cl-list]').addClass('d-none');
            $('[data-condition-list-global-controls]').removeClass('d-none');
        }else{
            $('[data-empty-cl-list]').removeClass('d-none');
        }
        clList.clDeleteButtonShow();
        clList.clSelectAllCheckbox()
        _this.removeClass('condition-search-active');
    });

    jQuery('[clear-search-recipient]').click(function (e) {
        e.preventDefault();
        if($('.recipient-checkbox').length>0){
            $('.check-head').parent().removeClass('empty-case-active');
        }
        var _this = jQuery(this).parents('.input-holder');
        _this.find('.recipient-search').val('');
        $('[data-recipientList]').removeClass('d-none');
        $('[data-empty-case]').addClass('d-none');
        _this.removeClass('recipient-search-active');
        recipientCheckBox();
        clList.clDeleteButtonShow();
        clList.clSelectAllCheckbox()
    });
}

$(document).on('click','[clear-search-states]',function (e) {
    e.preventDefault();
    var _this = jQuery(this).parents('.input-holder');
    _this.find('#cl-state-search-txt').val('');
    $('[data-states-list]').show();
    clForm.emptyCheckStates();
    clForm.checkAllcheckboxes();
    _this.removeClass('states-search-active');
})

function sortingCondtion(){

    if(jQuery(".check-body-sorting").length > 0) {
        jQuery(".check-body-sorting").mCustomScrollbar({
            axis:"y",
            scrollInertia: 500,
        });
    }

    $('.active-condition-list').sortable({
        axis: "y",
        revert: true,
        cursor: "move",
        handle: ".draging-item-link",

       change: function (e, ui) {
            var h=ui.helper.outerHeight(true),
                elem=$(".check-body-sorting .mCustomScrollBox"),
                elemHeight=elem.height(),
                moveBy=$(".active-condition-list > li").outerHeight(true)*3,
                mouseCoordsY=e.pageY-elem.offset().top;
            if(mouseCoordsY<h){
                $(".check-body-sorting").mCustomScrollbar("scrollTo","+="+moveBy);
            }else if(mouseCoordsY>elemHeight-h){
                $(".check-body-sorting").mCustomScrollbar("scrollTo","-="+moveBy);

            }
        },

        update: function (event, ui) {
            let new_seq=[];
            console.log($(this));
            $.each($('[data-cl-drag]'),function (key ,data) {
                new_seq[key] = data.value;
            });
            clList.cloneClObj();
            clList.getFunnelConditions().conditionSequence = new_seq.join("-");
            clList.clListSaveHandle()
        }
    });
}

/**
 * Conditional Logic handler variable for all the calander uses.
 *
 * @type {{setDateRangePickerValue: _setDateRangePickerValue}}
 */
var clDateRangePicker = (function () {

    /**
     *
     * @param target_ele
     * @param value
     * @private
     */
    function _setDateRangePickerValue(target_ele,value){ // set the target date range picker instance value
        $(target_ele).val(value);
        $(target_ele).trigger("keyup");
    }
    /**
     *
     * @param target_val
     * @param picker_val
     * @param target_ele
     * @param value
     * @private
     */
    function _setDateRangePickerValueONHide(target_val,picker_val,target_ele){
        let isValid = true;
        if(answerInputs.isValidDate(target_val) == false){
            isValid = false
        }
        if(isValid === true){
            _setDateRangePickerValue(target_ele,picker_val);
        }
    }
    return {
        setDateRangePickerValue: _setDateRangePickerValue,
        setDateRangePickerValueONHide: _setDateRangePickerValueONHide
    }
})();


// Initialize Calendar
function cl_datepicker(){
    var start = moment();
    var cl_start = moment().subtract(29, 'days');
    var cl_init_start = cl_start;
    var end = moment();
    var init_end = end;
    var dateFormat = "MM/DD/YYYY";

    // default calendar
    $('[cl-datepicker]').val(start.format(dateFormat));
    $('[cl-datepicker]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1920,
            autoApply: true,
            parentEl:'[date-picker-wrapper]',
            opens:'down',
            locale: {
                format: dateFormat
            }
        },
        function(start, end, label) {
            $('[cl-datepicker]').val(start.format(dateFormat));
        }
    ).on('show.daterangepicker', function(ev, picker) {
        $('.conditional-logic-group-modal').addClass('date-picker-active');
        if($(this).val() == ""){
            clDateRangePicker.setDateRangePickerValue('[cl-datepicker]',start.format(dateFormat));
            answerInputs.BDQuestionEvents(start.format(dateFormat));
        }
    }).on('hide.daterangepicker', function(ev, picker) {
        clDateRangePicker.setDateRangePickerValueONHide(ev.target.value,picker.startDate.format('MM/DD/YYYY'),'[cl-datepicker]');
        $('.conditional-logic-group-modal').removeClass('date-picker-active');
    }).on('apply.daterangepicker', function(ev, picker) {
        $('[cl-datepicker]').addClass('value-added');
        answerInputs.BDQuestionEvents(ev.target.value);
    });


    // calnedar start date
    $('[cl-start-datepicker]').val(cl_init_start.format(dateFormat));
    $('[cl-start-datepicker]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1920,
            autoApply: true,
            parentEl:'[cl-start-datepicker-wrapper]',
            opens:'down',
            locale: {
                format: dateFormat
            }
        },
        function(start, end, label) {
            $('[cl-start-datepicker]').val(start.format(dateFormat));
        }
    ).on('show.daterangepicker', function(ev, picker) {
        $('.conditional-logic-group-modal').addClass('date-picker-active');
        if($(this).val() == ""){
            clDateRangePicker.setDateRangePickerValue('[cl-start-datepicker]',start.format(dateFormat));
            bd_range_data.start_val = start.format(dateFormat);
        }
    }).on('hide.daterangepicker', function(ev, picker) {
        clDateRangePicker.setDateRangePickerValueONHide(ev.target.value,picker.startDate.format('MM/DD/YYYY'),'[cl-start-datepicker]');
        $('.conditional-logic-group-modal').removeClass('date-picker-active');
    }).on('apply.daterangepicker', function(ev, picker) {
        let start_val = 0;
        start_val = ev.target.value;
        bd_range_data.start_val = start_val;
        answerInputs.BDQuestionEventsForMulti();
        $('[cl-start-datepicker]').addClass('value-added');
    });

    // calnedar end date
   $('[cl-end-datepicker]').val(init_end.format(dateFormat));
   $('[cl-end-datepicker]').daterangepicker({
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1920,
            autoApply: true,
            parentEl:'[cl-end-datepicker-wrapper]',
            opens:'down',
            locale: {
                format: dateFormat
            }
        },
        function(start, end, label) {
            $('[cl-end-datepicker]').val(end.format(dateFormat));
        }
    ).on('show.daterangepicker', function(ev, picker) {
       $('.conditional-logic-group-modal').addClass('date-picker-active');
       if($(this).val() == ""){
           clDateRangePicker.setDateRangePickerValue('[cl-end-datepicker]',start.format(dateFormat));
           bd_range_data.end_val = start.format(dateFormat);

       }
    }).on('hide.daterangepicker', function(ev, picker) {
       clDateRangePicker.setDateRangePickerValueONHide(ev.target.value,picker.startDate.format('MM/DD/YYYY'),'[cl-end-datepicker]');
       $('.conditional-logic-group-modal').removeClass('date-picker-active');
    }).on('apply.daterangepicker', function(ev, picker) {
       let end_val = 0;
       end_val = $(this).val();
       bd_range_data.end_val = ev.target.value;
       answerInputs.BDQuestionEventsForMulti();
       $('[cl-end-datepicker]').addClass('value-added');
   });
}


// Initialize Height check modal Function
function height_check_modal(){
    if (jQuery('.conditional-modal-quick-scroll .modal-body-inner').height() < 400) {
        jQuery('body').addClass('small-screen');
    }
    else {
        jQuery('body').removeClass('small-screen');
    }
}

jQuery(document).ready(function () {
    var amIclosing = false;
    funnelConditions.resetObject();
    clForm.init();
    clForm.bindCancelEvent();
    clForm.bindSubmitEvent();
    funnelConditions.loadModal();
    funnelConditions.setQuestionCLActive();
    leadRecipient.bindActionsEvent();
    cl_datepicker();


    /*
    ---------------------------------------------
    -          STATES MODAL EVENTS
    ---------------------------------------------
    */

    // Binding Event to Save States
    $(document).on('click', "#cl-state-save-btn", function (e) {
        let states = [];
        let cl_value_input_filed = $("[data-input-field-type='text']").find("[data-input-markup]");
        let cl_value_html = inputPlaceholders.zipcode;

        $('.state-checkbox:checked').each(function (index, obj) {
            let selected_state_obj = {
                "id": $(obj).val(),
                "name": $(obj).next('span.checkbox-text').text()
            };
            states.push(selected_state_obj);
        });
        if (states.length) {
            cl_value_html = funnelConditions.getStatesListHTML(states);
            $('#conditional-logic-group').modal('show');
            $('#select-recipient-modal').find('#edit_cl').prop('disabled',true);
            $('#select-state-modal').modal('hide');
            $('.select-code-field-slide').hide();
            funnelConditions.trigger.setInputs(JSON.stringify(states));
            cl_value_input_filed.html(cl_value_html);
            $('[data-input-field-type="text"]').show();
            if (jQuery('.cl-zip-state-input-field-wrap').length > 0) {
                jQuery('.cl-zip-state-input-field-wrap').mCustomScrollbar({
                    axis: "y",
                    scrollInertia: 500,
                });
            }
        } else {
            cl_value_input_filed.html(cl_value_html);
            $('[data-input-field-type="text"]').hide();
            $('.select-code-field-slide').show();
        }
        // funnelConditions.saveBtnState();
    });

    // Binding Event to Search States
    $(document).on('click', "#cl-state-search-btn", function () {

        showStatesBySearch(jQuery("#cl-state-search-txt").val());
    });

    $(document).on('keyup',"#cl-state-search-txt",function (e) {
        let keyWord=jQuery(this).val();
        keyWord=keyWord.trim();
        if(jQuery(this).val().length===0){
            $('#cl-state-search-btn').click();
        }
        if (keyWord.length !=0 && e.key === 'Enter' || e.keyCode === 13) {
            showStatesBySearch(jQuery(this).val());
        }
        clForm.emptyCheckStates('No results were found for this search. Try something else.');
    });

    $(document).on('click', '.select-states-opener', function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-state-modal').modal('show');
    });

    /**
     * Add this class when we selected the option from select dropdown need to remove this class when we
     * reset it and add this class when we edit the condition
     * */
    $(document).on('click', '.select2-parent .select2-results__options > li', function () {
        jQuery(this).parents('.select2-parent').addClass('selected-active');
    });

    $(document).on('click', '.state-modal-close', function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#select-state-modal').modal('hide');
    });

    $('.state-all-checked').change(function () {
        if (this.checked) {
            $(this).parents('.select-state-modal').find('.state-checkbox:visible').prop("checked", true);
        } else {
            $(this).parents('.select-state-modal').find('.state-checkbox:visible').prop("checked", false);
        }
        clForm.statesSaveButton();
    });

    $('.state-reset-btn').click(function (e) {
        e.preventDefault();
        if(funnelConditions.getCurrentQuestionIndex()){
            $('.state-all-checked').prop("checked", false);
            $('.state-checkbox').prop("checked", false);
            funnelConditions.saveBtnState();
        }else{
            $(this).parents('.select-state-modal').find('.state-checkbox').prop("checked", false);
            $(this).parents('.select-state-modal').find('.state-all-checked').prop("checked", false);

        }
        $("#cl-state-search-txt").val("");
        showStatesBySearch("");
        clForm.emptyCheckStates();
        clForm.stateSustain();
        clForm.statesSaveButton();
    });

    $('.state-checkbox').change(function () {
        if ($('.state-checkbox:checked').length <= 0) {
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", true);
        } else {
            $(this).parents('.select-state-modal').find('.state-save-btn').prop("disabled", false);
        }

       clForm.checkAllcheckboxes();
        clForm.statesSaveButton();
    });

    $('#select-state-modal').on('show.bs.modal', function (event) {
        $('.states-search').focus();
        if(funnelConditions.getCurrentQuestionIndex()){
            clForm.stateSustain();
            funnelConditions.saveBtnState();
        }else{
            $('.state-checkbox').prop("checked", false);
            $('.state-all-checked').prop("checked", false);
            $('.state-save-btn').prop("disabled", true);
            clForm.stateSustain();
        }
    });


    //$('#active-condition-modal').on('hide.bs.modal', function (event) {
    $('[data-condition-modal-close]').on('click', function (event) {
        $('[clear-search-conidition]').click();
        if($('[data-single-status]').not(':checked').length === $('[data-single-status]').length){ // all the cl is inactive so main toggle must be inactive
            if(cl_object.active){
                $(".conditional-logic-item").addClass('active');
            }else{
                $(".conditional-logic-item").removeClass('active');
            }
        }else if($('[data-single-status]:checked').length){
            if(cl_object.active){
                $(".conditional-logic-item").addClass('active');
            }else{
                $(".conditional-logic-item").removeClass('active');
            }
        }else{
            if(clList.getFunnelConditions().active)
                $(".conditional-logic-item").addClass('active');
            else
                $(".conditional-logic-item").removeClass('active');
        }
        Object.assign(Funnel_Condition,clList.reSetTempObj())
        $('#active-condition-modal').modal('hide');
    });

    $('#select-recipient-modal').on('hide.bs.modal', function (event) {
        $('[clear-search-recipient]').click();
    });

    $('#select-state-modal').on('hide.bs.modal', function () {
        $('[clear-search-states]').click();
        setTimeout(function(){
            funnelConditions.saveBtnState();
        },500);
    });

    /*
    ---------------------------------------------
    -          RECIPIENTS MODAL EVENTS
    ---------------------------------------------
    */

    // CL Form Modal: Rendering Data on Recipient Model
    $(document).on('click', '[data-receipient-opener]', function (e) {
        e.preventDefault();
        displayToastAlert('loading', 'Please Wait... Processing your request...', 2);

        var btn_obj = $('#select-recipient-modal').find(".recipient-save-btn");
        btn_obj.attr("data-recipient-caller", $(this).data('receipient-opener'));

        let selected_recipients = [];
        if ($(this).data('receipient-opener') === "thencase") {
            let r = $(this).parents('.conditional-select-wrap').data("repeater")
            btn_obj.attr("data-recipient-num", r);
            selected_recipients = funnelConditions.actions.getRecipients(r);
        } else {
            selected_recipients = funnelConditions.alt_actions.getRecipients();
        }

        var url = $(this).data('url');
        $.get(url, function (data) {
        }).done(res => {
            let myHtml = "";
            res.forEach(item => {
                //let checked_html = selected_recipients.inArray(item.id) ? " checked" : "";
                let fullName = "";
                if(item.full_name == null || item.full_name == undefined || item.full_name==""){
                    item.full_name='N/A';
                }
                fullName =item.full_name.trim();
                myHtml += ` <ul data-recipientList
                                    data-recipient-id="` + item.id + `"
                                    data-recipientname="` + item.full_name + `"
                                    data-recipientemail="` + item.email_address + `" class="check-list forsearch">
                                    <li>
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-label">
                                                <input type="checkbox" value="` + item.id + `" class="recipient-checkbox">
                                                <span  class="checkbox-text"><i class="icon"></i>` + item.full_name + `</span>
                                            </label>
                                        </div>
                                        <span class="email">` + item.email_address + `</span>
                                    </li>
                             </ul> `;
            });
            $('#conditional-logic-group').modal('hide');
            $('[data-recipients-html]').html(myHtml+leadRecipient.emptyCase());
            if(!res.length>0){
                $('[data-empty-case]').removeClass('d-none');
                $('[data-empty-case-span]').text('No Recipient Available');
            }

            setTimeout(function () {
                $.each(selected_recipients, function (k, val) {
                    $('[data-recipients-html]').find("input[type=checkbox][value=" + val + "]").prop("checked", true);
                    $('[data-recipients-html]').find("input[type=checkbox][value=" + val + "]").attr('data-last-saved',1);
                });
            }, 150);
            let total= $('.select-recipient-modal').find('.recipient-checkbox').length;
            $('#select-recipient-modal').modal('show');
            if(total === selected_recipients.length){
                $('[data-all-checked]').prop("checked", true)
            }
        })
    });

    $(document).on('click','.recipient-reset-btn',function (e) {
        e.preventDefault();
        let prev_saved_list;
        var _self = $(this).parents('.select-recipient-modal');
        let caller = $(".recipient-save-btn").attr("data-recipient-caller");
        if(caller === "thencase"){
            let r = $(".recipient-save-btn").attr("data-recipient-num");
            prev_saved_list = funnelConditions.actions.getRecipients(r);
        }
        else if (caller === "allcases"){
            prev_saved_list = funnelConditions.alt_actions.getRecipients();
        }

        _self.find('.recipient-checkbox').prop("checked", false);
        if(prev_saved_list.length > 0){
            $.each(prev_saved_list, function (k, val) {
                $('[data-recipients-html]').find("input[type=checkbox][value=" + val + "]").prop("checked", true);
            });
        }

        if(_self.find('.recipient-checkbox').length === _self.find('.recipient-checkbox:checked').length){
            _self.find('.recipient-all-checked').prop("checked", true);
        } else {
            _self.find('.recipient-all-checked').prop("checked", false);
        }

        _self.find('.recipient-save-btn').prop("disabled", true);
    });

    $('#select-recipient-modal').on('show.bs.modal', function (event) {
        $('.recipient-search').focus();
        $('.recipient-checkbox').prop("checked", false);
        $('.recipient-all-checked').prop("checked", false);
        $('.recipient-save-btn').prop("disabled", true);
        ClearSearch();
    });

    $('#select-recipient-modal').on('shown.bs.modal', function () {
        $('.recipient-search').focus();
    });

    /* recipient Search field */
    $('.select-recipient-modal .form-control').keyup(function (e) {
        var inputValue = jQuery(this).val();
        if(inputValue == ""){
            $('[data-search-btn-leadrecipient]').click();
            if($('.recipient-checkbox').length === $('.recipient-checkbox:checked').length){
                $('.recipient-all-checked').prop("checked", true);
            } else {
                $('.recipient-all-checked').prop("checked", false);
            }
        }
    });

    // Recipient Listing Modal: Select all checkbox event
    $(document).on('change','.recipient-all-checked',function () {

        if (this.checked) {
            $('.recipient-checkbox:visible').prop("checked", true);
        } else {
            $('.recipient-checkbox:visible').prop("checked", false);
        }
        recipientCheckBox();
        recipientSaveButton();
    });

    // Recipient Listing Modal: Single Checkbox
    $(document).on('change', '.recipient-checkbox', function (e) {
        e.preventDefault();
        recipientCheckBox();
        recipientSaveButton()
    });

    // Recipient Listing Modal: New Recipient Modal open event
    $(document).on('click', '.new-recipient-opener', function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-recipient-modal').modal('hide');
        $('#lead-recipients-modal').modal('show');
    });

    // Recipient Listing Modal: Close event
    $(document).on('click', '.recipient-modal-close', function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('show');
        $('#select-recipient-modal').modal('hide');
    });

    // New Recipient Modal: Close event
    $(document).on('click', '.lead-recipients-modal-close', function (e) {
        e.preventDefault();
        $('#conditional-logic-group').modal('hide');
        $('#select-recipient-modal').modal('show');
        $('#lead-recipients-modal').modal('hide');
    });

    $('.celphone-radio').change(function (e) {

        if ($(this).val() == 'y') {
            $(".cell-number-slide").slideDown();
            $('.lead-recipient-form').find('#cel-number').focus();
        } else {
            $(".cell-number-slide").slideUp();
            $('.lead-recipient-form').find('#cel-number').blur();
        }
    });

    $('#cel-number').inputmask({"mask": "(999) 999-9999"});

    $('#lead-recipients-form').on('submit', (e) => {
        e.preventDefault();
        var $form = $('#lead-recipients-form');
        var is_valid = true;
        var error = [];
        $.validator.addMethod("phoneValid", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Please enter a valid phone number.");

        $.validator.addMethod('emailValid', function (val, elem) {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(val)) {
                return false;
            } else {
                return true;
            }
        }, 'Please enter a valid email address.');
        $form.validate({
            rules: {
                full_name: {
                    required: false,
                },
                cell_number: {
                    required: true,
                    phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                },
                newemail: {
                    required: true,
                    email: true,
                    emailValid: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                },
                carrier: {
                    required: true
                },
            },
            messages: {
                full_name: {
                    required: "Please enter your first name."
                },
                cell_number: {
                    required: "Mobile number is required to receive text alerts."
                },
                carrier: {
                    required: "You must select a Carrier to receive text alerts."
                },

                newemail: {
                    required: "Please enter your email address."
                }
            },
        });
        if ($form.valid() === true) {
            let url = $('#lead-recipients-form').data('actionmain');
            let data = $('#lead-recipients-form').serialize()
            displayToastAlert('loading', 'Please Wait... Processing your request...', 3);
            $.post(url, data, function (result) {
            }).done(res => {
                let myHtml = "";
                // console.debug(res.result.data);
                if (res.result.data == 'new-duplicate') {
                    displayToastAlert('danger', 'This email address already exists in the list', 2);
                } else {
                    let fullName =res.result.data.full_name.trim();
                    if(fullName==null||fullName==undefined||fullName==""){
                        res.result.data.full_name='N/A'
                    }
                    myHtml = ` <ul data-recipientList
                                data-recipient-id="` + res.result.data.id + `"
                                data-recipientname="` + res.result.data.full_name + `"
                                data-recipientemail="` + res.result.data.email_address + `" class="check-list forsearch">
                                <li>
                                    <div class="checkbox-wrap">
                                        <label class="checkbox-label">
                                            <input type="checkbox" value="` + res.result.data.id + `" class="recipient-checkbox">
                                            <span class="checkbox-text" ><i class="icon"></i>` + res.result.data.full_name + `</span>
                                        </label>
                                    </div>
                                    <span class="email" >` + res.result.data.email_address + `</span>
                                </li>
                         </ul> `;
                    $('[data-recipients-html]').append(myHtml);
                    $('#lead-recipients-modal').modal('hide');
                    $('#lead-recipients-form')[0].reset();
                    $('#select-recipient-modal').modal('show');
                }
            });
        } else {
            return $form.valid()
        }

    });

    $('#email_address').on('blur', (e) => {
        e.preventDefault();
        var $form = $('#lead-recipients-form');
        var is_valid = true;
        var error = [];
        $.validator.addMethod("phoneValid", function (value, element, regexpr) {
            return regexpr.test(value);
        }, "Please enter a valid phone number.");

        $.validator.addMethod('emailValid', function (val, elem) {
            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (!filter.test(val)) {
                return false;
            } else {
                return true;
            }
        }, 'Please enter a valid email address.');
        $form.validate({
            rules: {
                full_name: {
                    required: false,
                },
                cell_number: {
                    required: true,
                    phoneValid: /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/
                },
                newemail: {
                    required: true,
                    email: true,
                    emailValid: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                },
                carrier: {
                    required: true
                },
            },
            messages: {
                full_name: {
                    required: "Please enter your first name."
                },
                cell_number: {
                    required: "Mobile number is required to receive text alerts."
                },
                carrier: {
                    required: "You must select a Carrier to receive text alerts."
                },

                newemail: {
                    required: "Please enter your email address."
                }
            },
        });


        return   $form.valid()

    });

    $('.lead-recipients-modal .form-control').keyup(function () {
        var inputValue = jQuery(this).val();
        var _self = $(this).parents('.lead-recipients-modal').find('.button-primary');
        if (inputValue == "") {
            _self.prop("disabled", true);
        } else {
            _self.prop("disabled", false);
        }
    });

    $('#lead-recipients-modal').on('shown.bs.modal', function (event) {
        $('.lead-recipient-form').find('#full_name').focus();
    });

    $('#lead-recipients-modal').on('show.bs.modal', function (event) {
        $('.button-primary').prop("disabled", true);
        $('.lead-recipients-modal').find('select').each(function () {
            $(this).find("option:first").attr('selected', 'selected').trigger('change');
        });
    });

    $('#lead-recipients-modal').on('hidden.bs.modal', function (event) {
        $(this).find(".form-control.error").removeClass("error");
        $('label.error').hide();
        $(".cell-number-slide").slideUp();
        $('#cell-text-yes').prop("checked", false);
        $("#cell-text-no").prop("checked", true);
        $('.lead-recipient-form').find('#cel-number').blur();
        $(this).find('.form-control').val('');
    });

    $('#select-recipient-modal').on('hidden.bs.modal', function (event) {
        $(this).find('.form-control').val('');
        $(this).find('.check-list').removeClass('forsearch d-none');
    });

    /*
    ---------------------------------------------
    -          CL FORM EVENTS
    ---------------------------------------------
    */

    $(document).on('click', '[data-repeater-then="add"]', function (e) {
        e.preventDefault();
        clForm.enableDisableThanOptionSelect($(this).parents('.conditional-select-wrap').data("repeater"),"add_then_node");
        let i = new Number($("[data-repeater]:last").data("repeater")) + 1;
        console.log("[data-repeater]:last",i);
        var ClonedItem = $('.conditional-select-wrap.hidden').clone().removeClass('hidden').attr("data-repeater", i);
        console.log("ClonedItem >>>>>",ClonedItem);
        let option_data = clForm.getAllThanOptionsData(jQuery(this).parents('.conditional-select-wrap').data("repeater"),'add');
        if( $("[data-repeater]:visible").length >= 3){
            ClonedItem.find('span.btn-wrap').addClass("d-none").parents('.select-area').addClass("only-field");
        }else{
            ClonedItem.find('span.btn-wrap').removeClass("d-none").parents('.select-area').removeClass("only-field");
        }
        ClonedItem.find('[data-dropdown-entity="cl-actions"]').html(option_data.html);
        //ClonedItem.find('[data-dropdown-entity="cl-actions"]').select2('destroy').empty().select2({data: option_data.data});
        $(this).parents('.conditional-select-area').append(ClonedItem);
        $('[data-repeater="'+i+'"]' ).find('[data-dropdown-entity="cl-actions"]');
        $('[data-repeater="'+i+'"]' ).find('.select2-parent').removeClass('selected-active');
        dropdownInputs.renderActionList($('[data-repeater="'+i+'"]' ).find('[data-dropdown-entity="cl-actions"]'));
        clForm.showCrossHidePlus($(this));
        height_check_modal();
    });
    $(document).on('click', '[data-repeater-then="remove"]', function (e) {
        e.preventDefault();
        let rep_action_index = jQuery(this).parents('.conditional-select-wrap').data("repeater");
        clForm.pauseEvent = true;
        if(funnelConditions.getCurrentQuestionIndex()){
            funnelConditions.removeCurrentConditionActionOptionByRepeater(rep_action_index);
        }else{
            funnelConditions.resetActionCondition(rep_action_index);
        }
        clForm.pauseEvent = false;
        let action_option = jQuery(this).parents('.conditional-select-wrap').find('[data-dropdown-entity="cl-actions"]').val();
        //jQuery(this).parents('.conditional-select-wrap').hide();
        jQuery(this).parents('.conditional-select-wrap').remove();
        setTimeout(function(){
            clForm.removeClUpdateActionOptions(rep_action_index,'remove')
            if(funnelConditions.getCurrentQuestionIndex()){
                clForm.manageDeleteActionRepeater("remove_edit");
            }else{
                clForm.manageDeleteActionRepeater();
            }
            //clForm._disabelPlusBtnDeleteAction();
            funnelConditions.saveBtnState();
        },500);


        //$("#conditional-logic-group").trigger("change");
    });

    /*
    ---------------------------------------------
    -          CONDITIONS LISTING EVENTS
    ---------------------------------------------
    */

    /* Active Conditions Listing: Open Active Conditons Modal */
    $('.active-condition-link').click(function (e) {
        e.preventDefault();
        $('[data-repeater]').remove();
        clForm.reset();
        funnelConditions.resetObject();
        clList.returnConditionalListing();
        $('#conditional-logic-group').modal('hide');

        $('#active-condition-modal').modal('show');
    });

    /* Active Conditions Listing: Event Binding for Listings on Active Conditions Link */
    $('#active-condition-modal').on('show.bs.modal', function () {

        clList.returnConditionalListing();
        $('.query-search').focus();
        if($('[data-single-status]').not(':checked').length === $('[data-single-status]').length){
            clList.getFunnelConditions().active=0;
            $(".conditional-logic-item").removeClass("active");
            $("[cl-listing-checkbox]").prop('checked',false);
        }
    });

    $('[search-btn-conidition-lisiting]').on('click',function (e) {
        e.preventDefault();
         var get_length = jQuery('.query-search').val().trim().length;
        if (get_length > 0) {
            jQuery(this).parent().addClass('condition-search-active');
        }
        else {
            jQuery(this).parent().removeClass('condition-search-active');
        }
        let keyword = $('[search-field-conidition-lisiting]').val();
        keyword=$.trim(keyword);
        let obj=cl_object.conditions;
        if(keyword && !$.isEmptyObject(obj)){
            clList.conditionListingSearch(keyword);
        }
    });

    // Disable Save button on modal load
    $('#conditional-logic-group').on('show.bs.modal', function (){
        console.log("show.bs.modal");
        console.log(!$('[data-repeater]').length);
        if(!$('[data-repeater]').length){
            var ClonedItem = $('.conditional-select-wrap.hidden').clone().removeClass('hidden').attr("data-repeater", "1");
            $('.conditional-select-area.then-cases').append(ClonedItem);
            dropdownInputs.renderActionList($('[data-repeater="1"]' ).find('[data-dropdown-entity="cl-actions"]'));
        }
        if($('[data-actiontype="alt_actions"]').val()===''){
            $('[data-actiontype="alt_actions"]').parents().removeClass('selected-active')
        };

        $('#conditional-logic-group').find('#edit_cl').prop('disabled',true);

        // Birthday Field question style funcation
        var bd_value = $('.bd-field').val();
        if (bd_value != '') {
            jQuery('.bd-field').addClass('value-added');
        } else {
            jQuery('.bd-field').removeClass('value-added');
            jQuery('.select-field').removeClass('value-added');
        }
        $('.bd-field').keyup(function () {
            if (jQuery(this).val() != '') {
                jQuery(this).addClass('value-added');
            } else {
                jQuery(this).removeClass('value-added value-added-save');
                jQuery('.select-field').removeClass('value-added');
            }
        });

        height_check_modal();
    });
    /* Active Conditions Listing: Finish Button */
    $('.cl_btn_finish').click(function (e) {
        if(clListingMarkup.saveCondition({},true)){
            if($('[data-single-status]').not(':checked').length === $('[data-single-status]').length){ // all the cl is inactive so main toggle must be inactive
                $(".conditional-logic-item").removeClass('active');
            }else if($('[data-single-status]:checked').length){
                if($("[cl-listing-checkbox]").is(":checked")){
                    $(".conditional-logic-item").addClass('active');
                }else{
                    $(".conditional-logic-item").removeClass('active');
                }
            }else{
                if(clList.getFunnelConditions().active)
                    $(".conditional-logic-item").addClass('active');
                else
                    $(".conditional-logic-item").removeClass('active');
            }
            $('#active-condition-modal').modal('hide');
        }
    });
    $(document).on('change','[cl-listing-checkbox]',function () {

        clList.cloneClObj();
        if($("[cl-listing-checkbox]").is(":checked")) {

            clList.getFunnelConditions().active = 1;

        } else {

            clList.getFunnelConditions().active = 0;

        }
        clList.clListSaveHandle();
    })

    /* Active Conditions Listing: DELETE CONFIRMATION MODEL */
    $(document).on('click', '[data-cl-list-action="delete"], #multi-delete-btn', function (e) {
        e.preventDefault();
        $('[data-no-never-mind-btn]').removeData("from")
        $('[data-no-never-mind-btn]').attr('data-from','main')

        let attr = $(this).attr('data-cl-list-action');

        if(typeof attr !== 'undefined' && attr !== false){
            /* SET VALUES ON MODEL for Delete Confirmation  */
            $('[data-span-value]').attr('data-value',$(this).data('value'));
            $("#delete-condition-btn").addClass("single-delete")
            $("#delete-condition-btn").removeClass("multi-delete")
        }
        else {
            $('[data-span-value]').attr('data-value',$(this).data('value'));
            $("#delete-condition-btn").removeClass("single-delete")
            $("#delete-condition-btn").addClass("multi-delete")
        }

        $('#active-condition-modal').modal('hide');
    });

    /* Active Conditions Listing: MULTI-DELETE CONDITION */
    $(document).on('click','.multi-delete',function (e) {
        e.preventDefault();
        let seq_arr = cl_object.conditionSequence.toString().split("-");

        $.each($('.condition-check:checked'), function (k, elem) {
            delete cl_object.conditions[$(elem).val()];
            console.log($(elem).val(), typeof $(elem).val());
            seq_arr.splice(seq_arr.indexOf($(elem).val().toString()), 1);
            cl_object.conditionSequence = seq_arr.join("-");
        });

        if(seq_arr.length === 0){
            let main = clListingMarkup.emptyCase();
            $('[data-show-condition-list]').html(main);
            if(typeof clList.getFunnelConditions().active != undefined){
                clList.getFunnelConditions().active = 0;
                $("[cl-listing-checkbox]").prop("checked",false);
                $("li.conditional-logic-item").removeClass("active");
            }
            funnelConditions.resetQuestionClAction();
        }

        $('#multi-delete-btn').hide();
        conidtionEmptyState();
        clList.updateCounter();
        funnelConditions.setQuestionCLActive();

        $('#cl-confirmation-delete').modal('hide');
        $('#active-condition-modal').modal('show');

        let res = clListingMarkup.saveCondition({ success: 'Conditions deleted successfully.' });
        if(res === true){
            $(this).parents('.active-condition-modal').find('.check-parent-active').hide();
            $(this).parents('.active-condition-modal').find('.condition-all-checked').prop("checked", false);
        }

    });

    /* Active Conditions Listing: SINGLE-DELETE CONDITION */
    $(document).on('click','.single-delete, .status-delete-condition',function (e) {
        e.preventDefault();
        let seq_arr = cl_object.conditionSequence.toString().split("-");
        let remove_id = $(this).attr('data-value').toString();
        let remove_index = seq_arr.indexOf(remove_id)
        if(remove_index < 0){
            return; // index not found then skip
        }

        delete cl_object.conditions[remove_id];
        console.log("Remove Condition # "+remove_id+" from sequance array index "+remove_index);

        seq_arr.splice(remove_index, 1);
        console.log("Remaining Array Sequence",seq_arr);
        console.log("Remaining Conditions",cl_object.conditions);

        cl_object.conditionSequence = seq_arr.join("-");
        let parent_li=$(this).data('value');

        $('.active-condition-modal').find('[data-cl-index="'+parent_li+'"]').remove();

        if(seq_arr.length===0){
            let main = clListingMarkup.emptyCase();
            $('[data-show-condition-list]').html(main);
            if(typeof clList.getFunnelConditions().active != undefined){
                clList.getFunnelConditions().active = 0;
                $("[cl-listing-checkbox]").prop("checked",false);
                $("li.conditional-logic-item").removeClass("active");
            }
            funnelConditions.resetQuestionClAction();
        }
        conidtionEmptyState();
        clList.updateCounter();
        funnelConditions.setQuestionCLActive();

        $('#cl-confirmation-delete').modal('hide');
        $('#active-condition-modal').modal('show');

        clListingMarkup.saveCondition({ success: 'Condition deleted successfully.' });
    });

    $('#cl-status-delete').on('click',  function (e) {
        e.preventDefault();
        $('[data-no-never-mind-btn]').removeData("from");
        $('[data-no-never-mind-btn]').attr('data-from','status');

        let datavalue=$(this).attr('data-index');

        $(' #delete-condition-btn').attr('data-value',datavalue);
        $('#delete-condition-btn').addClass('single-delete');

        $('#condition-modal-status').modal('hide');
    });

    /*DELETE MODEL RE-DIRECT*/
    $(document).on('click', '[data-no-never-mind-btn]', function (e) {
        e.preventDefault();
        if( $(this).data('from')==='status'){
            $('#condition-modal-status').modal('show');
        }
        else if( $(this).data('from')==='main'){
            $('#active-condition-modal').modal('show');
        }else{
            $('#cl-confirmation-delete').modal('hide');
        }
    });
    /* EDIT event binding */
    $(document).on("click",'[data-cl-list-action="edit"]',function(e){
        e.preventDefault();
        let cond_index = $(this).data("value");
        let conditionToString = JSON.stringify(Object.assign({}, cl_object.conditions[cond_index]));  // convert array to string
        funnelConditions._condition = JSON.parse(conditionToString);
        clForm.pauseEvent = true;
        $('#active-condition-modal').modal('hide');
        $('#conditional-logic-group').modal('show');
        let is_checked = funnelConditions._condition.active == 1 ? true : false;
        $('[conditional-logic-checkbox]').attr('data-prev-state', funnelConditions._condition.active);
        $('[conditional-logic-checkbox]').prop("checked",is_checked);
        clForm.preFill();
        $('.select2-parent').addClass('selected-active');
        //setTimeout(function(){ $('#conditional-logic-group').find('#edit_cl').prop('disabled', true); },3000);
        $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
        //funnelConditions.saveBtnState();
        if($('[data-actiontype="alt_actions"]').val()===''){
            $('[data-actiontype="alt_actions"]').parent().removeClass('selected-active');
        }
        clForm.pauseEvent = false;
    });

    // Duplicate/Copy Condition
    $(document).on("click",'[data-cl-list-action="copy"]',function(e){
        let current_index = $(this).attr("data-value");
        let next_seq = funnelQuestions.getQuestionCloneSequence() + 1;

        let clone_condition = "";
        let data_src = "";

        // HTML Rendering
        clone_condition = $(this).parents("[data-cl-index='" + current_index + "']").clone().attr("data-cl-index", next_seq).addClass('item-wrap disabled');
        clone_condition.find('[data-cl-list-action="move"]').attr("data-value", next_seq);
        clone_condition.find('[data-cl-list-action="copy"]').attr("data-value", next_seq);
        clone_condition.find('[data-cl-list-action="edit"]').attr("data-value", next_seq);
        clone_condition.find('[data-cl-list-action="status"]').attr("data-value", next_seq);
        clone_condition.find('[data-cl-list-action="status"]').val(0);
        clone_condition.find('[data-cl-list-action="status"]').prop("checked", false);
        clone_condition.find('[data-cl-list-action="delete"]').attr("data-value", next_seq);
        clone_condition.find('.condition-check').val(next_seq);

        //$(clone_condition).insertAfter("[data-cl-index='"+current_index+"']")
        $('[data-show-condition-list]').append(clone_condition);

        // Update JSON Structure
        //data_src = Object.assign({}, cl_object.conditions[current_index]);
        data_src = JSON.parse(JSON.stringify(cl_object.conditions[current_index]));
        data_src['index'] = "";
        data_src['active'] = 0;

        funnelConditions.setCloneCondition(data_src);
        funnelConditions.updateObject();

        clList.updateCounter();
        clListingMarkup.saveCondition({ success: 'Condition copied and saved successfully.' });
       clList.singleClStatus();
        $(".check-body-sorting").mCustomScrollbar("scrollTo","bottom");
    });

    $('.form-control-textarea').keyup(function () {
        if (jQuery(this).val() != '') {
            jQuery(this).addClass('empty');
        } else {
            jQuery(this).removeClass('empty');
        }
    });

    $(document).on('click', '.status-modal-opener', function (e) {
        e.preventDefault();
        $('#condition-modal-status').modal('show');
        $('#active-condition-modal').modal('hide');
    });

    $(document).on('click', '.status-modal-close', function (e) {
        e.preventDefault();
        $('#condition-modal-status').modal('hide');
        $('#active-condition-modal').modal('show');
    });

    $(document).on('click', '.block-opener', function (e) {
        e.preventDefault();
        $(this).parents('.item-wrap').toggleClass('slide-active');
        $(this).toggleClass('active');
        $(this).parents('.item-wrap').find('.condition-slide').slideToggle(function () {
            setTimeout(function (){
                $('.cl-tooltip-label-text').each(function (key, val) {

                    if ($(this).outerWidth() > 591) {
                        $(this).tooltipster('enable');
                    } else {
                        $(this).tooltipster('disable');
                    }
                });

            },500);
        });

        if ($(this).hasClass('active')) {
            $(this).tooltipster('content', '<div class="condition-tooltip">Collapsed Condition</div>');
        } else {
            $(this).tooltipster('content', '<div class="condition-tooltip">Expand Condition</div>');
        }
    });


    $(document).on('click','.cl-model-reopener',function(e){
        e.preventDefault();
        let current_ques = $('[data-dropdown-entity="cl-questions"]' ).val().split("-");
        if(current_ques[0] === "zipcode") {
            if ($('[data-dropdown-entity="answers-options"]' ).val() == "Select State(s) from List") {
                $('#conditional-logic-group').modal('hide');
                $('#select-state-modal').modal('show');
            }
        }
        else if(current_ques[0]=="vehicle"){
        switch (current_ques[1]){
            case 'model':
                $('#conditional-logic-group').modal('hide');
                $('#select-vehicle-model').modal('show');
                break;
            case 'make':
                $('#conditional-logic-group').modal('hide');
                $('#select-vehicle-make').modal('show');
                break;
        }
        }
    })
    $(document).on('click', '[data-cl-state-action="clear-all"]', function (e) {
        e.stopPropagation();
        $('.clear-all-states').addClass('d-none');
        $('.empty-zip-state').removeClass('d-none');
        $(this).parents('.cl-zip-state-input-field-wrap').addClass('states-item-remove');
        $('.list-recipeint-tags li').each(function(ind,ele){
            $(ele).remove();
        });
        clForm.reRenderInputByQuestionOperator($('[data-dropdown-entity="answers-options"]').val());
        let states = [];
        $(".list-recipeint-tags").find('input[type="hidden"]').val(JSON.stringify(states));
        funnelConditions.trigger.setInputs('');
        //funnelConditions.saveBtnState();
    });
    $(document).on('click', '[data-cl-make-action="clear-all"]', function (e) {
        e.stopPropagation();
        $('.clear-all-makes').addClass('d-none');
        $('.empty-zip-state').removeClass('d-none');
        $(this).parents('.cl-make-input-field-wrap').addClass('states-item-remove');
        $('.list-make-tags li').each(function(ind,ele){
            $(ele).remove();
        });
        clForm.reRenderInputByQuestionOperator();
        let make = [];
        $(".list-make-tags").find('input[type="hidden"]').val(JSON.stringify(make));
        funnelConditions.trigger.setInputs("");
        //$("#conditional-logic-group").trigger("change");
        funnelConditions.saveBtnState();
    });
    $(document).on('click', '[data-cl-model-action="clear-all"]', function (e) {
        e.stopPropagation();
        $('.clear-all-models').addClass('d-none');
        $('.empty-zip-state').removeClass('d-none');
        $(this).parents('.cl-models-input-field-wrap').addClass('states-item-remove');
        $('.list-model-tags li').each(function(ind,ele){
            $(ele).remove();
        });
        clForm.reRenderInputByQuestionOperator();
        let models = [];
        $(".list-model-tags").find('input[type="hidden"]').val(JSON.stringify(models));
        funnelConditions.trigger.setInputs("");
        //$("#conditional-logic-group").trigger("change");
        funnelConditions.saveBtnState();
    });
    $(document).on('click', '.list-recipeint-tags .remove-tag', function (e) {
        e.stopPropagation();
        if($('.list-recipeint-tags li').length===1){
            $('.empty-zip-state').removeClass('d-none');
            $('.clear-all-states').addClass('d-none');
            $(this).parents('.cl-zip-state-input-field-wrap').addClass('states-item-remove');
            clForm.reRenderInputByQuestionOperator($('[data-dropdown-entity="answers-options"]').val());
        }
        else {
            $(this).parents('.cl-zip-state-input-field-wrap').removeClass('states-item-remove');
        }
        $(this).parent().remove();
        let states = [];
        $('.list-recipeint-tags li').each(function(ind,ele){
            let selected_state_obj = {
                "id": $(ele).data("cl-state-id"),
                "name": $(ele).data("cl-state-name")
            };
            states.push(selected_state_obj);
        });
        $(".list-recipeint-tags").find('input[type="hidden"]').val(JSON.stringify(states));
        let sVal = (states.length) ? JSON.stringify(states) : "";
        funnelConditions.trigger.setInputs(sVal);
        //$("#conditional-logic-group").trigger("change");
        funnelConditions.saveBtnState();
    });

    $(document).on('click', '.list-model-tags .remove-tag', function (e) {
        e.stopPropagation();
        if($('.list-model-tags li').length===1){
            $('.empty-models').removeClass('d-none');
            $('.list-model-tags').addClass('d-none');
            $(this).parents('.cl-models-input-field-wrap').addClass('states-item-remove');
            clForm.reRenderInputByQuestionOperator();
        }
        else {
            $(this).parents('.cl-models-input-field-wrap').removeClass('states-item-remove');
        }
        $(this).parent().remove();
        let models = [];
        $('.list-model-tags li').each(function(ind,ele){
            let selected_model_obj = {
                "id": $(ele).data("cl-model-id"),
                "name": $(ele).data("cl-model-name")
            };
            models.push(selected_model_obj);
        });
        $(".list-model-tags").find('input[type="hidden"]').val(JSON.stringify(models));
        let mVal = (models.length) ? JSON.stringify(models) : "";
        funnelConditions.trigger.setInputs(mVal);
        //$("#conditional-logic-group").trigger("change");
        funnelConditions.saveBtnState();
    });

    $(document).on('click', '.list-make-tags .remove-tag', function (e) {
        e.stopPropagation();
        if($('.list-make-tags li').length===1){
            $('.empty-make').removeClass('d-none');
            $('.clear-all-makes').addClass('d-none');
            $(this).parents('.cl-make-input-field-wrap').addClass('states-item-remove');
            clForm.reRenderInputByQuestionOperator();
        }
        else {
            $(this).parents('.cl-make-input-field-wrap').removeClass('states-item-remove');
        }
        $(this).parent().remove();
        let makes = [];
        $('.list-make-tags li').each(function(ind,ele){
            let selected_make_obj = {
                "id": $(ele).data("cl-make-id"),
                "name": $(ele).data("cl-make-name")
            };
            makes.push(selected_make_obj);
        });
        $(".list-make-tags").find('input[type="hidden"]').val(JSON.stringify(makes));
        let mVal = (makes.length) ? JSON.stringify(makes) : "";
        funnelConditions.trigger.setInputs(mVal);
        //$("#conditional-logic-group").trigger("change");
        funnelConditions.saveBtnState();
    });
    $('.add-condition-link').click(function (e) {
        e.preventDefault();
        clForm.reset("add_condition");
        //clForm.reset();
        setTimeout(function(){
            $('#conditional-logic-group').modal('show');
        },250);
        funnelConditions.resetObject();
        $('.select2-parent').removeClass('selected-active')
        $('#conditional-logic-group').find('#edit_cl').prop('disabled',true);
        $('#active-condition-modal').modal('hide');
    });

    $('.condition-all-checked').change(function () {
        if (this.checked) {
            $('.condition-check:visible').prop("checked", true);
            $(this).parents('.active-condition-modal').find('.item-wrap').addClass('check-parent-active');
        } else {

            $('.condition-check:visible').prop("checked", false);
            $(this).parents('.active-condition-modal').find('.item-wrap').removeClass('check-parent-active');
        }
        clList.clDeleteButtonShow()
        clList.clSelectAllCheckbox()
    });

    $(document).on('change','.condition-check',function () {

        if (this.checked) {
            $(this).parents('.item-wrap').addClass('check-parent-active');
        } else {
            $(this).parents('.item-wrap').removeClass('check-parent-active');
        }
        clList.clDeleteButtonShow();
        clList.clSelectAllCheckbox()
    });

    $(document).on('change','#toggle-status',function (e){
        e.preventDefault();
        let obj = cl_object;
        // let index=$(this).attr("data-index");
        let value=$(this).val();
        if($('#condition-modal-status').is(':visible')){
            switch (value) {
                case '0':
                    value ='1'
                    break;
                case '1':
                    value ='0'
                    break;
            }
            $('#status-save-btn').prop('disabled',false);
        }

        // obj.conditions[index].active=value;
        $(this).val(value);
        // clList.updateCounter();

    });

    $('[conditional-logic-checkbox]').change(function () {
        let is_changed = 0
        if (this.checked) {
            funnelConditions._condition.active = 1;
        } else {
            funnelConditions._condition.active = 0;
        }
            if($(this).attr("data-prev-state") == funnelConditions._condition.active){
               if(funnelConditions._condition.index!="") {
                   $('#conditional-logic-group').find('#edit_cl').prop('disabled', true);
               }
            } else {
                  if(funnelConditions._condition.index!="") {
                      $('#conditional-logic-group').find('#edit_cl').prop('disabled', false);
                  }
            }
    });

    $('#active-condition-modal').on('show.bs.modal', function (event) {

        $('.condition-all-checked').prop("checked", false);
        $('[cl_btn_finish]').prop("disabled", true);
        $('.condition-check').prop("checked", false);
        $('.delete-select-btn').hide();
        $('.item-wrap').removeClass('check-parent-active').show();
        $('#conditional-logic-group').modal('hide');
        conidtionEmptyState();
        sortingCondtion();
        ClearSearch();
        $('#edit-rcpt').prop("disabled", true);
        setTimeout(function (){
            $('.cl-tooltip-label').each(function (key, val) {

                if ($(this).outerWidth() > 591) {
                    $(this).tooltipster('enable');
                } else {
                    $(this).tooltipster('disable');
                }
            });

            $('.cl-tooltip-label-text').each(function (key, val) {

                if ($(this).outerWidth() > 591) {
                    $(this).tooltipster('enable');
                } else {
                    $(this).tooltipster('disable');
                }
            });

        },500);
    });
});

(function($){
    $.fn.select2.amd.define("CLMultiSelectCustomAdapter", [
        "select2/utils",
        "select2/selection/multiple",
        "select2/selection/placeholder",
        "select2/selection/eventRelay",
        "select2/selection/single",
    ],
    function (Utils, MultipleSelection, Placeholder, EventRelay, SingleSelection) {
            let adapter = Utils.Decorate(MultipleSelection, Placeholder);
            adapter = Utils.Decorate(adapter, EventRelay);
            adapter.prototype.render = function () {
                let $selection = SingleSelection.prototype.render.call(this);
                return $selection;
            };
            adapter.prototype.update = function (data) {
                this.clear();
                let $rendered = this.$selection.find('.select2-selection__rendered');
                let noItemsSelected = data.length === 0;
                let formatted = "";

                if (noItemsSelected) {
                    formatted = this.options.get("placeholder") || "";
                } else {
                    let itemsData = {
                        selected: data || [],
                        all: this.$element.find("option") || []
                    };
                    // Pass selected and all items to display method
                    // which calls templateSelection
                    formatted = this.display(itemsData, $rendered);
                }

                $rendered.empty().append(formatted);
                $rendered.prop('title', formatted);
            };
            return adapter;
        });

    $.fn.select2.amd.define("CLMultiSelectDropdownAdapter", [
        "select2/utils",
        "select2/dropdown",
        "select2/dropdown/attachBody",
        "select2/dropdown/search",
        "select2/dropdown/minimumResultsForSearch",
        "select2/dropdown/closeOnSelect",
    ],
    function(Utils, Dropdown, AttachBody, Search, MinimumResultsForSearch, CloseOnSelect) {
            let dropdownWithSearch = Utils.Decorate(Dropdown, Search);
            dropdownWithSearch.prototype.render = function() {
                var $rendered = Dropdown.prototype.render.call(this);
                let placeholder = this.options.get("placeholderForSearch") || "Search for Questions";
                var $search = $(
                    '<strong class="select2-label">Select Questions</strong>' +
                    '<span class="select2-search select2-search--dropdown">' +
                    '<input class="select2-search__field" placeholder="' + placeholder + '" type="search"' +
                    ' tabindex="-1" autocomplete="off" autocorrect="off" autocapitalize="off"' +
                    ' spellcheck="false" role="textbox" />' +
                    '<span class="submit-wrap"><i class="ico-search"></i></span>' +
                    '</span>'
                );
                this.$searchContainer = $search;
                this.$search = $search.find('input');

                $rendered.prepend($search);
                return $rendered;
            };
            let adapter = Utils.Decorate(dropdownWithSearch, AttachBody);
            return adapter;
        });

    $.fn.select2Dropdown = function(settings){
        var defaults = {
            minimumResultsForSearch: null,
            multiple:false,
            multipleSearch:false,
            setParentContainer:true,
            closeOnSelect:null,
            placeholder:null,
            theme:null,
            optionData:null,
            preOpts: false,
            onOpening: null,
            onOpen: null,
            onClosing: null,
            onClose: null,
            onUnselecting: null,
            onUnselect: null,
            onChange: null
        }
        settings = $.extend({},defaults,settings);

        console.log("++++++++", settings);

        this.each(function() {
            var config = {
                width: '100%' // need to override the changed default
            }

            if(settings.setParentContainer){
                config['dropdownParent'] = $(this).parents('.select2-parent')
            }

            if(settings.optionData !== null){
                config['data'] = settings.optionData
            }

            if(settings.minimumResultsForSearch != null && settings.minimumResultsForSearch > 0){
                config['minimumResultsForSearch'] = settings.minimumResultsForSearch;
            } else {
                config['minimumResultsForSearch'] = -1;
            }

            if(settings.multiple !== false){
                config['multiple'] = settings.multiple;
            }

            if(settings.multipleSearch !== false){
                config['selectionAdapter'] = $.fn.select2.amd.require('CLMultiSelectCustomAdapter');
                config['dropdownAdapter'] = $.fn.select2.amd.require('CLMultiSelectDropdownAdapter');
            }

            if(settings.closeOnSelect != null){
                config['closeOnSelect'] = settings.closeOnSelect;
            }

            if(settings.placeholder != null){
                config['placeholder'] = settings.placeholder;
            }
            if(settings.theme != null){
                config['theme'] = settings.theme;
            }

            if(!settings.preOpts){
                config['templateResult'] = function (d) { return $(d.text); };
                config['templateSelection'] = function (d) { return $(d.text); };
            }

            console.log("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&")
            //console.log("Select2 Config",settings, config);
            console.log("Select2 Config", config);
            console.log("%%%%%%%%%%%%%%%%%%%%%%%%%%%%%&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&")

            var amIclosing = false;
            $(this).select2(config)
                .on('select2:opening', function() {
                    //$(this).parent().find('.select2-selection__rendered').css('opacity', '0');
                })
                .on('select2:open', function() {
                    var _self = jQuery(this);
                    _self.parent().find('.select2-results__options').css('pointer-events', 'none');

                    setTimeout(function() {
                        _self.parent().find('.select2-results__options').css('pointer-events', 'auto');
                    }, 300);

                    if(settings.setParentContainer){
                        _self.parent().find('.select2-dropdown').hide();
                        _self.parent().find('.select2-dropdown').css({'display': 'block', 'opacity': '1', 'transform': 'scale(1, 1)'});
                        _self.parent().find('.select2-selection__rendered').hide();
                    }

                    lpUtilities.niceScroll();

                    setTimeout(function () {
                        _self.parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                            this.style.setProperty( 'opacity', '1', 'important' );
                            var getindex = _self.find(':selected').index();
                            var defaultHeight = 34;
                            var scrolledArea = getindex * defaultHeight;
                            _self.parent().find(".select2-results__options").getNiceScroll(0).doScrollTop(scrolledArea);
                            this.style.setProperty( 'opacity', '1', 'important' );
                        });
                    }, 400);
                })
                .on('select2:closing', function(e) {
                    if(!amIclosing) {
                        e.preventDefault();

                        var _self = jQuery(this);
                        amIclosing = true;
                        _self.parent().find('.select2-dropdown').attr('style', '');

                        setTimeout(function () {
                            _self.select2("close");
                        }, 200);
                    } else {
                        amIclosing = false;
                    }

                    jQuery(this).parent().find('.select2-dropdown .nicescroll-rails-vr').each(function () {
                        this.style.setProperty( 'opacity', '0', 'important' );
                    });
                })
                .on('select2:close', function() {
                    if (typeof settings.onClose === "function" && settings.onClose){
                        settings.onClose.call(this);
                    }
                    else {
                        jQuery(this).parent().find('.select2-selection__rendered').show();
                        jQuery(this).parent().find('.select2-results__options').css('pointer-events', 'none');
                    }
                })
                .on('select2:unselecting', function() {
                    if (typeof settings.onUnselecting === "function" && settings.onUnselecting){
                        settings.onUnselecting.call(this);
                    }
                })
                .on('select2:unselect', function() {
                    if (typeof settings.onUnselect === "function" && settings.onUnselect){
                        settings.onUnselect.call(this);
                    }
                })
                .on('change', function() {
                    if (typeof settings.onChange === "function" && settings.onChange){
                        settings.onChange.call(this);
                    }
                })
        });
    }
})(jQuery);
