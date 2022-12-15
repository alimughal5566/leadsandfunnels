<div class="question-preview-parent__title">
    {{#ifCond show-question '==' 1 }}
    {{#ifCond question '!==' ''}}
    <h1 class="question-heading-text" froala-prview-size>
        {{{question}}}
    </h1>
    {{/ifCond}}
    {{/ifCond}}
    {{#ifCond show-description '==' 1 }}
    {{#ifCond description '!==' ''}}
    <div class="question-description-text" froala-prview-size>
        {{{description}}}
    </div>
    {{/ifCond}}
    {{/ifCond}}
</div>