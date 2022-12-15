var hbar = {
    debug : true,
    active_precompiled_tpl : true,  // Handlebar templates are precomfiled with command <npm install -g handlebars>
    _template_dir: "/resources/handlebars/theme_admin3/",
    _json_dir: "/lp_assets/theme_admin3/handlebars/json/",
    _cachedTemplates : {},
    _cachedAjaxedJson : {},

    renderTemplate: async function (templateFile, handlebarContainer, json, callback) {
        return await hbar.load_handlebar_tpl(templateFile, handlebarContainer, json, callback);
    },

    load_handlebar_tpl: function (templateFile, handlebarContainer, json, callback) {
        var jsonData;
        if (json === undefined) jsonData = {}
        else jsonData = this.getJson(json)

        if(this.active_precompiled_tpl){
            // Loading from precomplied JS files
            var container = (typeof handlebarContainer == 'string') ? $('[data-hbs="'+handlebarContainer+'"]') : handlebarContainer;

            // execute the compiled template
            try {
                Handlebars.partials = window['FunnelBuilder']['templates'];
                var preCompiledTemplate = window['FunnelBuilder']['templates'][templateFile.substring(-1, templateFile.length-4)];
                container.html(preCompiledTemplate(jsonData));
                if (callback) {
                    callback();
                }
            }
            catch (jserror){
                console.error(templateFile, " >> ", jserror)
            }
        }
        else {
            // Loading via AJAX call from external files
            this._getTemplate(templateFile, function (compiledTemplate) {
                var container = (typeof handlebarContainer == 'string') ? $('[data-hbs="'+handlebarContainer+'"]') : handlebarContainer;

                // execute the compiled template
                try {
                    container.html(compiledTemplate(jsonData));
                    if (callback) {
                        callback();
                    }
                }
                catch (jserror){
                    console.error(templateFile, " >> ", jserror)
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
                    this._log('getTemplate via AJAX');

                    // compile the template
                    var compiledTemplate = Handlebars.compile(rawTemplate);

                    hbar._cachedTemplates[templatePath] = compiledTemplate;
                    if (callbackEvent) callbackEvent(compiledTemplate);
                }
            });
        }
    },


    /**
     * Get JSON from external file or convert string to json object
     *
     * @param file_str can be json string or file name
     * @returns object
     */
    getJson: function(file_str){
        if ("string" === typeof file_str) {
            var extension = file_str.substring(file_str.length-5, file_str.length);
            var json = {};
            // Filename provided to get ajax data
            if(".json" === extension){
                if(hbar._cachedAjaxedJson.hasOwnProperty(file_str)){
                    json = hbar._cachedAjaxedJson[file_str];
                    this._log('Cached JSON loaded');
                } else {
                    json = JSON.parse($.getJSON({'url': this._json_dir + file_str, 'async': false}).responseText);
                    hbar._cachedAjaxedJson[file_str] = json;
                    this._log('JSON loaded via ajax');
                }
            }
            else{
                // JSON stringed parsed into object
                this._log('JSON stringed parsed into object');
                json = JSON.parse(file_str);
            }
            return json;
        }
        else{
            // already a JSON object
            this._log('already a JSON object');
            return file_str;
        }
    },

    _log: function(args, label){
        if(this.debug){
            if(label === undefined) console.log(args);
            else console.log(args, label);
        }
    },
};
