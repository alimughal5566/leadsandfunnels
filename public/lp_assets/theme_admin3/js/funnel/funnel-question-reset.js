$(document).ready(function () {
    $('#resetQuestionsToDefaultBtn').on('click', function () {

        var currentHash = $('input[name="current_hash"]').val();

        $.ajax( {
            type : "POST",
            url : "/lp/funnel-builder/reset-default-provided-questions",
            data : {current_hash: currentHash},
            dataType : "json",
            success : function(ret) {
                console.log(ret);
                if(ret.status) {
                   var  funnel_questions = ret.result.funnel_questions;
                   var question_sequence = ret.result.question_sequence;
                    FunnelsUtil.loadDBQuestion(JSON.parse(funnel_questions), question_sequence.split("-"));
                    FunnelsUtil.debug = true;
                    displayToastAlert("success", ret.message);
                    $("#reset-default-pop").modal('hide');
                    FunnelActions.loadQuestions(false);
                    FunnelActions.disableFunnelSaveBtn();

                    //resetting conditional logic
                    funnelConditions.resetCL(ret.result.conditional_logic);
                    //resetting conditional logic questions
                    funnelConditions.refreshCL();
                }
            },
            cache : false,
            async : false
        });

    });

});
