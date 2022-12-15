var hbar = {
    debug : true,
    active_precompiled_tpl : true,  // Handlebar templates are precomfiled with command <npm install -g handlebars>
    _template_dir: "assets/templates/questions/",
    _json_dir: "assets/json/",
    _cachedTemplates : {},

    renderTemplate: function (templateFile, handlebarContainer, jsonString, callback) {
        var jsonData;
        if (jsonString === undefined) jsonData = {}
        else jsonData = this._getJson(jsonString)

        if(this.active_precompiled_tpl){
            // Loading from precomplied JS files

            if(hbar._cachedTemplates.hasOwnProperty(templateFile)){
                var compiledTemplate = hbar._cachedTemplates[templateFile];
            }
            else{
                var compiledTemplate = Handlebars.templates[templateFile];
                hbar._cachedTemplates[templateFile] = compiledTemplate;
            }

            var container = (typeof handlebarContainer == 'string') ? $('[data-hbs="'+handlebarContainer+'"]') : handlebarContainer;

            // execute the compiled template
            container.html(compiledTemplate(jsonData));
            if (callback) {
                callback();
            }
        }
        else {
            // Loading via AJAX call from external files
            this._getTemplate(templateFile, function (compiledTemplate) {
                var container = (typeof handlebarContainer == 'string') ? $('[data-hbs="'+handlebarContainer+'"]') : handlebarContainer;

                // execute the compiled template
                container.html(compiledTemplate(jsonData));
                if (callback) {
                    callback();
                }
            })
        }
    },

    _getTemplate: function (templatePath, callbackEvent) {
        if(hbar._cachedTemplates.hasOwnProperty(templatePath)){
            var cachedTemplate = hbar._cachedTemplates[templatePath];
            if (callbackEvent) callbackEvent(cachedTemplate);
        }
        else{
            $.ajax({
                url: this._template_dir + templatePath,
                dataType: "html",
                success: function (rawTemplate) {
                    if(this.debug) console.log('getTemplate');

                    // compile the template
                    var compiledTemplate = Handlebars.compile(rawTemplate);

                    hbar._cachedTemplates[templatePath] = compiledTemplate;
                    if (callbackEvent) callbackEvent(compiledTemplate);
                }
            });
        }
    },

    _getJson: function(jsonString){
        if ("string" === typeof jsonString) {
            var extension = jsonString.substring(jsonString.length-5, jsonString.length);
            if(".json" === extension){
                var json = JSON.parse($.getJSON({'url': this._json_dir + jsonString, 'async': false}).responseText);
            }
            else{
                json = JSON.parse(jsonString);
            }
            return json;
        }
        else{
            return jsonString;
        }
    },
};
