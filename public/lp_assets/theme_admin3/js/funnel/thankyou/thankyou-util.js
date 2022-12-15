var thankyou_hbar = {
    debug : true,
    _template_dir: "/resources/handlebars/theme_admin3/thankyou/",
    templtate: 'thankyou-pages.hbs',
    renderThankyouTemplate: async function (templateFile, handlebarContainer, json) {
        return await thankyou_hbar.load_handlebar_tpl(templateFile, handlebarContainer, json);
    },

    load_handlebar_tpl: function (templateFile, handlebarContainer, json) {
        var jsonData;
        if (json === undefined) jsonData = {}
        else jsonData = json
            // after save new thank you JS files
        var container = (typeof handlebarContainer == 'string') ? $('[data-hbs="'+handlebarContainer+'"]') : handlebarContainer;
        // execute the compiled template
        try {
            Handlebars.partials = window['FunnelBuilder']['templates'];
            var preCompiledTemplate = window['FunnelBuilder']['templates'][templateFile.substring(-1, templateFile.length-4)];
            container.html(preCompiledTemplate({'data':jsonData}));
        }
        catch (jserror){
            console.error(templateFile, " >> ", jserror)
        }
    }
};

Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {

    switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
        case '!=':
            return (v1 != v2) ? options.fn(this) : options.inverse(this);
        case '!==':
            return (v1 !== v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});
