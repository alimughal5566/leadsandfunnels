
/* a simple UI for allowing users to generate css gradients to style their elements and optionally set other background properties to tweak their creations */
/*
	* IcanStyle Gradient Editor
	*
	* a simple UI for allowing users to generate and edit css gradients to style their elements and 
	* optionally set other background properties such as background-size and background-attachment
	*
	* (c) 2015 David O'Sullivan, YouSitePro
	*
	* Plugin web:			http://yousitepro.com/ics-gradient-editor
	* Licenses: 			http://codecanyon.net/licenses/
	* Version 1.3.2
*/
/*Change Log*/
/* 1.0 
Initial Build */
/* 1.1
* Update to Latest ICS Build
* Updated Spectrum to 1.6.1 to remove error 'The specified value '!' does not conform to the required format.  The format is '#rrggbb' where rr, gg, bb are two-digit hexadecimal numbers'
* Included the option to use the tool for setting background images and associated parameters
* Modified the background template to include a background preview */
/* 1.2
/*Update to latest ics build
/*General Clean up*/
/*1.3
/*Changed the nam of some options for better user experience*/
/*1.3.1
/* made sure all parseInt has the radix specified*/
/*1.3.2
/*removed a trailing comma*/
if (!String.prototype.trim) {
  (function() {
    // Make sure we trim BOM and NBSP
    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    String.prototype.trim = function() {
      return this.replace(rtrim, '');
    };
  })();
}
(function (factory) {
    "use strict";

    if (typeof define === 'function' && define.amd) { // AMD
        define(['jquery'], factory);
    }
    else if (typeof exports == "object" && typeof module == "object") { // CommonJS
        module.exports = factory;
    }
    else { // Browser
        factory(jQuery);
    }
})
(function($, undefined) {
    "use strict";
	if (typeof console === 'undefined' || typeof console.log === 'undefined') {
    	console = {};
    	console.log = function() {};
  	}
	var defaultOpts = {
	  	// Callbacks
        beforeShow: noop,
        move: noop,
        change: noop,
        show: noop,
        hide: noop,
		//would also like options for 
		interface : ['gradient','swatches','background'], //can be 'gradient','swatches','background','toolbar', TODO make sure these look right when reordered css wise
		defaultGradient : 'linear-gradient(160deg, rgba(95, 30, 0, 0.8) 0%, rgba(255, 175, 73, 0.6) 100%)', //the default gradient to show when the interface starts for the first time with no startingGradient
		mode: 'gradient',
		showBgPreview : true,
		startingGradient : false, //in this is false the interface will load the last edited gradient (if set) or the default gradient
		startingImage : false, //Image Mode: the interface will be initialised with this image if set else will show the image chooser button
		startingBgProps : false, //an object containing background properties to use when initializing the editor
		targetElement : false, //an element to apply styles to
		targetInputElement : false, //an input to set the css value to
		targetCssOutput : 'noprefix', //could be all applies cross browser css or 'noprefix'
		targetBgInputElement : false, //could also be a seperate input/textarea or an object containing seperate inputs for each desired property
		colorpickerToUse : 'spectrum', //we could possibly allow users to use their own colorpickers
		colorpickerInitOptions : false, //the code to call when calling the specified colorpicker?
		colorpickerDestination :false, //a DOM element to put the colorpicker into if not using spectrum? Wold allow the picker to overflow the editor
		defaultCssSwatches : 
		["linear-gradient(0deg,rgba(30, 87, 153, 0.45) 0%,rgba(41, 137, 216, 0.59) 47.8%,rgba(36, 92, 140, 0.74) 47.8%,rgba(125, 185, 232, 0.53) 100%)",
		"repeating-linear-gradient(to bottom right,rgba(0, 165, 223,0.5) 0%,rgba(62, 20, 123,0.5) 20%,rgba(226, 0, 121,0.5) 40%,rgba(223, 19, 44,0.5) 60%,rgba(243, 239, 21,0.5) 80%,rgba(0, 152, 71,0.5) 100%)",
		"linear-gradient(to bottom,rgba(255, 255, 255, 0.71) 0%,rgba(197, 197, 197, 0.53) 100%)",
		"linear-gradient(to bottom,rgba(135, 224, 253, 0.63) 0%,rgba(83, 203, 241, 0.67) 40%,rgba(2, 146, 192, 0.63) 100%)",
		"linear-gradient(to bottom,rgba(240, 249, 255, 0.66) 0%,rgba(203, 235, 255, 0.63) 47%,rgba(161, 219, 255, 0.67) 100%)",
		"repeating-linear-gradient(to bottom right,rgba(254, 158, 150, 0.7) 0%,rgba(172, 79, 115, 0.71) 100%)",
		"linear-gradient(to bottom, rgba(0,0,0,0.65) 0%,rgba(0,0,0,0) 100%)",
		"repeating-linear-gradient(to bottom right,rgba(125,125,255,0.5) 0%,rgba(125,125,255,0.5) 9%,rgba(0, 0, 0, 0) 10%,rgba(0, 0, 0, 0) 19%,rgba(125,125,255,0.5) 20%,rgba(125,125,255,0.5) 29%,rgba(0, 0, 0, 0) 30%,rgba(0, 0, 0, 0) 39%,rgba(125,125,255,0.5) 40%,rgba(125,125,255,0.5) 49%,rgba(0, 0, 0, 0) 50%,rgba(0, 0, 0, 0) 59%,rgba(125,125,255,0.5) 60%,rgba(125,125,255,0.5) 69%,rgba(0, 0, 0, 0) 70%,rgba(0, 0, 0, 0) 79%,rgba(125,125,255,0.5) 80%,rgba(125,125,255,0.5) 89%,rgba(0, 0, 0, 0) 90%,rgba(0, 0, 0, 0) 100%)",
		"linear-gradient(to bottom, rgba(242,246,248,1) 0%,rgba(216,225,231,1) 50%,rgba(181,198,208,1) 51%,rgba(224,239,249,1) 100%)",
		"linear-gradient(171deg,rgb(222, 169, 43) 0%,rgb(255, 247, 133) 47%,rgb(227, 135, 24) 48%,rgb(252, 195, 48) 57.6%,rgb(152, 102, 0) 100%)",
		"linear-gradient(to bottom,rgb(199, 207, 212) 0%,rgb(255, 255, 255) 47.2%,rgb(128, 125, 123) 47.2%,rgb(197, 193, 183) 57.6%,rgb(120, 118, 114) 100%)",
		"linear-gradient(to bottom,rgb(171, 214, 247) 0%,rgb(255, 255, 255) 47.2%,rgb(145, 73, 40) 47.2%,rgb(200, 161, 70) 57.6%,rgb(100, 75, 16) 100%)",
		"repeating-radial-gradient(ellipse farthest-corner at 15% 15%,rgb(243, 239, 21) 0%,rgb(0, 72, 19) 100%)",
		"linear-gradient(to bottom, #fcecfc 0%,#fba6e1 50%,#fd89d7 51%,#ff7cd8 100%)",
		"linear-gradient(to bottom, rgba(252,255,244,1) 0%,rgba(233,233,206,1) 100%)",
		"repeating-radial-gradient(circle 10em at 51% 0%,rgb(190, 43, 43) 0%,rgb(149, 8, 8) 49.3%,rgb(160, 22, 22) 50%,rgb(187, 72, 72) 100%)",
		"repeating-linear-gradient(to bottom,rgb(72, 85, 108) 0%,rgb(27, 33, 43) 50%,rgb(20, 25, 34) 51%,rgb(53, 59, 69) 100%)",
		"repeating-linear-gradient(to bottom,rgb(226, 226, 226) 0%,rgb(219, 219, 219) 50%,rgb(209, 209, 209) 51%,rgb(254, 254, 254) 100%)",
		"linear-gradient(to bottom right,rgb(249, 73, 182) 0%,rgb(255, 139, 139) 100%)",
		"linear-gradient(to bottom, rgba(255,48,25,1) 0%,rgba(207,4,4,1) 100%)",
		"linear-gradient(to bottom, rgba(203,96,179,1) 0%,rgba(173,18,131,1) 50%,rgba(222,71,172,1) 100%)",
		"linear-gradient(to bottom, rgba(254,252,234,1) 0%,rgba(241,218,54,1) 100%)","linear-gradient(to bottom, rgba(255,255,255,1) 0%,rgba(246,246,246,1) 47%,rgba(237,237,237,1) 100%)"
		]
  	  },
	  icsges = [],
	  markup = {
		  outerHtml : (function() { return [
			'<div class="ics-ge-container clearfix">',
		'</div>',
		  ].join("");})(),
		  gradient : (function() { return ['<div class="ics-ge-colorpicker-container icc-opt-norm"><input type="text" class="ics-ge-colorpicker"/></div><div class="ics-ge-preview-panel">',
				'<div class="gradient-properties">',
					'<div class="gradient-preferences-advanced">',
						'<div class="ics-ge-preferences">',
							'<div class="css-gradient-type">',
								'<label>Type:</label>',
								'<div class="btn-group">',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_type" data-name="gradient_type" data-value="linear">linear</button>',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_type" data-name="gradient_type" data-value="radial">radial</button>',
								'</div>',
							'</div>',
							'<div class="css-gradient-repeating">',
								'<label>Repeating:</label>',
								'<div class="btn-group">',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="repeat" data-name="gradient_repeat" data-value="on">on</button>',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="repeat" data-name="gradient_repeat" data-value="off">off</button>',
								'</div>',
							'</div>',
							'<div class="ics-ge-preview-container">',
								'<div class="ics-ge-preview">',
									'<div class="ajax-loader"></div>',
								'</div>',
								'<div class="ics-ge-linear-preferences ics-ge-prefrences-overlay">',
									'<div class="ics-ge-linear-direction-implicit top">',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="top left"><i class="fa fa-arrow-up fa-rotate-315"></i>',
										'</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top" data-control-group="linear-direction" data-name="gradient_direction" data-value="top"><i class="fa fa-arrow-up"></i>',
										'</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="top right"><i class="fa fa-arrow-up fa-rotate-45"></i>',
										'</button>',
									'</div>',
									'<div class="ics-ge-linear-direction-implicit mid">',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="left"><i class="fa fa-arrow-left"></i>',
										'</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="right"><i class="fa fa-arrow-right"></i>',
										'</button>',
									'</div>',
									'<div class="ics-ge-linear-direction-implicit bot">',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom left"><i class="fa fa-arrow-down fa-rotate-45"></i>',
										'</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom"><i class="fa fa-arrow-down"></i>',
										'</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom right"><i class="fa fa-arrow-down fa-rotate-315"></i>',
										'</button>',
									'</div>',
									'<div class="ics-ge-linear-direction-explicit">',
										'<span class="ics-ge-controller ics-ge-direction-angle" data-control-group="linear-direction" data-name="gradient_direction" data-value="angle"><span></span></span>',
										'<span class="ics-ge-controller ics-ge-direction-angle-input" data-control-group="linear-direction" data-name="gradient_direction" data-value="angle"><input type="text" name="angle" class="input-sm"></span>',
									'</div>',
								'</div>',
								'<div class="ics-ge-radial-preferences ics-ge-prefrences-overlay">',
									'<div class="ics-ge-radial-position-dragarea">',
										'<div class="ics-ge-radial-position-draggable">',
											'<div class="ics-ge-radial-position-target"></div>',
											'<div class="ics-ge-radial-position-hairs"></div>',
										'</div>',
									'</div>',
									'<div class="ics-ge-radial-position-inputs">',
										'<div class="ics-ge-radial-position-inputs-toggle"><i class="fa fa-caret-down"></i>',
										'</div>',
										'<div class="ics-ge-radial-position-inputs-holder">',
											'<div class="form-group ics-ge-radial-position">',
												'<label>Radial Center:</label>',
												'<div class="controls">',
													'<span class="ics-ge-controller ics-ge-position-horizontal-explicit" data-control-group="gradient_position_horizontal" data-name="gradient_position_horizontal" data-value="explicit"><input type="text" name="gradient_position_horizontal" data-units=\'["%","px"]\' class="input-sm"></span>',
													'<span class="ics-ge-controller ics-ge-position-vertical-explicit" data-control-group="gradient_position_vertical" data-name="gradient_position_vertical" data-value="explicit"><input type="text" name="gradient_position_vertical" data-units=\'["px","%"]\' class="input-sm"></span>',
												'</div>',
											'</div>',
											'<div class="form-group ics-ge-radial-shape">',
												'<label>Shape:</label>',
												'<div class="btn-group">',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_shape" data-name="gradient_shape" data-value="circle">circle</button>',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_shape" data-name="gradient_shape" data-value="ellipse">ellipse</button>',
												'</div>',
											'</div>',
	
											'<div class="form-group ics-ge-radial-size">',
												'<label>Size:</label>',
												'<div class="controls">',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_size" data-name="gradient_size" data-value="closest-side">close-side</button>',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_size" data-name="gradient_size" data-value="closest-corner">close-corner</button>',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_size" data-name="gradient_size" data-value="farthest-side">far-side</button>',
													'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_size" data-name="gradient_size" data-value="farthest-corner">far-corner</button>',
												'</div>',
												'<div class="controls">',
													'<span class="span ics-ge-controller ics-ge-size-explicit" data-control-group="gradient_size" data-name="gradient_size" data-value="explicit"><input type="text" name="gradient_size" data-units=\'["%","px"]\' class="input-sm"> <input type="text" name="gradient_size_major" data-units=\'["%","px"]\' class="input-sm"></span>',
												'</div>',
											'</div>',
										'</div>',
									'</div>',
								'</div>',
							'</div>',
						'</div>',
						'<div class="ics-ge-linear-preview">',
							'<div class="ics-ge-preview">',
								'<div></div>',
							'</div>',
							'<div class="ics-ge-colorstops-easy">',
								'<div class="ics-ge-stopeditor">',
									'<span></span>',
									'<div class="ics-ge-stoppointmarkers"></div>',
								'</div>',
							'</div>',
						'</div>',
						'<div class="ics-ge-colorstops-advanced clearfix">',
							'<div class="ics-ge-stoppointlist"></div>',
						'</div>',
					'</div>',
				'</div>',
			'</div>'].join("");})(),
		  swatches : (function() { return ['<div class="ics-ge-swatches-wrapper ics-ge-control-block">',
				'<div class="ics-ge-swatches-wrapper-heading">',
					'<label>Presets</label>',
				'</div>',
				'<div class="ics-ge-swatches-wrapper-swatches panel-body">',
					'<div class="content ics-ge-swatches">',
						'<button type="button" class="btn btn-default btn-sm ics-ge-save" title="Add gradient to swatches"><i class="fa fa-plus-circle"></i></button>',
						'<ul class="ics-ge-swatches-list"></ul>',
					'</div>',
				'</div>',
			'</div>'
			].join("");})(),
		  background : (function() { return ['<div class="ics-ge-background-options ics-ge-control-block">',
					'<div class="ics-ge-background-options-inputs-toggle"><label>Position and Size<i class="fa fa-caret-down"></i></label></div>',
					'<div class="ics-ge-background-options-inputs">',
						'<div class="ics-bg">',
							'<div class="ics-bg-preview-wrapper"><div class="ics-bg-preview-holder">',
								'<div class="ics-bg-chooser-buts"><div class="ics-bg-chooseimage"><input type="hidden" class="ics-bg-img"/></div><div class="ics-bg-changeimage"><div class="btn-group"><button class="btn btn-default btn-sm change">Change</button><button class="btn btn-danger btn-sm remove">remove</button></div></div></div>',
								'<div class="ics-bg-preview-el">',
								'</div>',
								'<div class="ics-bg-preview-img">',
									'<div class="ics-bg-position-ctrl"><i class="fa fa-arrows"></i>',
										'<div class="ics-bg-size-ctrl tl"></div><div class="ics-bg-size-ctrl tm"></div><div class="ics-bg-size-ctrl tr"></div><div class="ics-bg-size-ctrl ml"></div><div class="ics-bg-size-ctrl mr"></div><div class="ics-bg-size-ctrl bl"></div><div class="ics-bg-size-ctrl bm"></div><div class="ics-bg-size-ctrl br"></div>',
									'</div>',
								'</div>',
							'</div></div>',								
							'<div class="form-group ics-ge-background-size-implicit">',
								'<label>Size:</label><!-- if attachment is fixed this is relative to the window else it is relative to the element-->',
								'<div class="controls">',
									'<div class="btn-group">',
										'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_size" data-name="background_size" data-value="auto auto">auto</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_size" data-name="background_size" data-value="cover">cover</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_size" data-name="background_size" data-value="contain">contain</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_size" data-name="background_size" data-value="100% 100%">stretch</button>',
										'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_size" data-name="background_size" data-value="explicit">custom</button>',
									'</div>',
								'</div>',
							'</div>',
							'<div class="form-group ics-ge-background-repeat ics-bg-repeat">',
								'<label>Repeat:</label>',
								'<div class="btn-group">',
									'<span class="ics-stylable-group-switch ics-switch mini"><input type="checkbox" class="ics-switch-checkbox ics-background-repeat-x" checked="checked"><label class="ics-switch-label"><div class="ics-switch-inner"></div><div class="ics-switch-switch"></div></label></span>',
									'<span class="ics-stylable-group-switch ics-switch mini"><input type="checkbox" class="ics-switch-checkbox ics-background-repeat-y" checked="checked"><label class="ics-switch-label"><div class="ics-switch-inner"></div><div class="ics-switch-switch"></div></label></span>',
								'</div>',
							'</div>',
							'<div class="form-group ics-ge-background-size-explicit">',
								'<label>Custom Size:</label><!-- if attachment is fixed this is relative to the window else it is relative to the element-->',
								'<div class="controls">',
									'<span class="span ics-ge-controller ics-ge-background-size-explicit" data-control-group="background_size" data-name="background_size" data-value="explicit"><input type="text" name="background_size_horizontal" data-units=\'["%","px"]\' class="input-sm"> <input type="text" name="background_size_vertical" data-units=\'["%","px"]\' class="input-sm"></span>',
								'</div>',
							'</div>',
							'<div class="form-group ics-ge-background-position">',
								'<label>Position:</label>',
								'<div class="controls">',
									'<span class="span ics-ge-controller ics-ge-background-position-explicit" data-control-group="background_position" data-name="background_position" data-value="explicit"><input type="text" name="background_position_horizontal" data-units=\'["%","px"]\' class="input-sm"> <input type="text" name="background_position_vertical" data-units=\'["%","px"]\' class="input-sm"></span>',
								'</div>',
							'</div>',
							'<div class="form-group ics-ge-background-attachment ics-bg-attachment">',
								'<label>Attachment:</label>',
								'<div class="btn-group">',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_attachment" data-name="background_attachment" data-value="scroll">scroll</button>',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_attachment" data-name="background_attachment" data-value="fixed">fixed</button>',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="background_attachment" data-name="background_attachment" data-value="local">local</button>',
								'</div>',
							'</div>',
							'<div class="form-group ics-ge-background-origin ics-bg-origin" style="display:inline-block">',
								'<label>Origin:</label>',
								'<select class="ics-bg-origin-select" data-name="background_origin">',
									'<option>border-box</option>',
									'<option>padding-box</option>',
									'<option>content-box</option>',
								'</select>',
							'</div>',
							'<div class="form-group ics-ge-background-clip ics-bg-clip" style="display:inline-block">',
								'<label>Clip:</label>',
								'<select class="ics-bg-clip-select" data-name="background_clip">',
									'<option>border-box</option>',
									'<option>padding-box</option>',
									'<option>content-box</option>',
								'</select>',
							'</div>',
						'</div>',
					'</div>',
				'</div>'].join("");})(),
		  toolbar : (function() { return ['<div class="ics-ge-toolbar ics-ge-control-block">',
				'<button type="button" class="btn btn-default btn-sm ics-ge-getcss" title="Get generated css" data-show-popup="" data-target="#cssoutmodal"><i class="fa fa-code"></i> Get Css</button>',
				 '<button type="button" class="btn btn-default btn-sm ics-ge-import" title="Import gradient from css" data-show-popup="" data-target="#importmodal"><i class="fa fa-clipboard"></i> Paste Css</button>',
			'</div>',
			'<div class="ics-ge-optionbox" id="cssoutmodal" role="dialog">',
				'<div class="ics-ge-optionbox-content">',
					'<div class="ics-ge-optionbox-header">',
						'<button type="button" class="close close-icon" data-dismiss="modal" aria-hidden="true">&times;</button>',
						'<span class="ics-ge-optionbox-title">Generated CSS</span>',
					'</div>',
					'<div class="ics-ge-optionbox-body">',
						'<div class="ics-ge-cssoutput-container">',
							'<pre class="ics-ge-cssoutput"></pre>',
						'</div>',
					'</div>',
					'<div class="ics-ge-optionbox-footer">',
						'<button type="button" class="btn btn-default close" data-dismiss="modal">Close</button>',
					'</div>',
				'</div>',
			'</div>',
			'<div class="ics-ge-optionbox" id="importmodal" role="dialog">',
				'<div class="ics-ge-optionbox-content">',
					'<div class="ics-ge-optionbox-header">',
						'<button type="button" class="close close-icon" data-dismiss="modal" aria-hidden="true">&times;</button>',
						'<span class="ics-ge-optionbox-title">Import Gradient</span><br><small>Paste any gradient css in here to load it into the editor.</small>',
					'</div>',
					'<div class="ics-ge-optionbox-body">',
						'<textarea class="ics-ge-textarea-import"></textarea>',
					'</div>',
					'<div class="ics-ge-optionbox-footer">',
						'<button type="button" class="btn btn-default import-css" data-dismiss="modal">Import</button>',
					'</div>',
				'</div>',
			'</div>'].join("");})()
	  };
	  function instanceOptions(o, callbackContext) {
		var opts = $.extend({}, defaultOpts, o);
		opts.callbacks = {
			'move': bind(opts.move, callbackContext),
			'change': bind(opts.change, callbackContext),
			'show': bind(opts.show, callbackContext),
			'hide': bind(opts.hide, callbackContext),
			'beforeShow': bind(opts.beforeShow, callbackContext)
			};
			
		return opts;
		}
		function generateMarkup(opts, markup, doc){
			var thiscontainer;
			if(!opts.interface)
				{
				if(opts.mode == 'gradient')
					{
					opts.interface = ['gradient','swatches'];
					}
				else
					{
					opts.interface = ['background'];	
					}
				}
			else
				{
				if(opts.mode == 'image')
					{
					var optsInterface = [];
					jQuery.each(opts.interface,function(index,value){
						if(value == 'background' || value == 'toolbar')
							{
							optsInterface.push(value);	
							}
					});
					if(optsInterface.indexOf('background') < 0)
						{
						optsInterface.push('background');	
						}
					opts.interface = optsInterface;	
					}
				}
			thiscontainer = jQuery(markup.outerHtml, doc);
			jQuery.each(opts.interface, function(index,value){
				if(markup[value] != '')
				thiscontainer.append(markup[value]);
			});
			return thiscontainer;
		}
		function icsge(element, o) {

			var opts = instanceOptions(o, element),
				MIN = -3000,
				MAX = 3000,
				_throttleDelay = 100,
				_scrollThrottleTimer = null,
				_lastScrollHandlerRun = 0,
				layout = 2,
				cssoutput = '',
				gradientAutosave = false,
				updateInputTargets = true;
			if(opts.mode == 'gradient')
				{
				var colorStops = [],
					lastSelectedColor = '#c30000',
					lastunit = '%',
					colorStopIndex = 0,
					stopPointDragTarget = false,
					stopPointDragging = false,
					angleMoving = false,
					radialMoving = false,
					colorpickerShowing = false,
					_selectedStopIndex = -1,
					swatches = [],
					cssSwatches = [],
					currentgradient,
					gradientready = false,
					supportedrendermodes = {
						noprefix: false,
						svg: false,
						oldwebkit: false,
						filter: false
					}
				};
			if(opts.mode == 'image' || opts.interface.indexOf('background') > -1)
				{
				var bgInMove = false,
					bgInMoveStartPos = false,
					backgroundOptionsActive = true,
					backgroundOptionsSet = false
				};
				
			var doc = element.ownerDocument,
            	body = doc.body,
            	boundElement = $(element),
				container = $(element),
				thiscontainer = generateMarkup(opts, markup, doc),
				elements = {
					cssTarget : false,
					cssInputTarget : false,
					cssoutput : thiscontainer.find('.ics-ge-cssoutput'),
					get_css : thiscontainer.find('.ics-ge-getcss')
					},
				settings = {};
			if(opts.mode == 'gradient')
				{
				elements.colorpickerholder = thiscontainer.find('.ics-ge-colorpicker-container');
				elements.colorpicker = thiscontainer.find('.ics-ge-colorpicker');
				elements.markersarea= thiscontainer.find('.ics-ge-stoppointmarkers');
				elements.radialpositionercontainer = thiscontainer.find('.ics-ge-radial-position-dragarea');
				elements.radialpositioner = thiscontainer.find('.ics-ge-radial-position-draggable');
				elements.radialposinputh = thiscontainer.find('input[name=gradient_position_horizontal]');
				elements.radialposinputv = thiscontainer.find('input[name=gradient_position_vertical]');
				elements.radialinputstoggle = thiscontainer.find('.ics-ge-radial-position-inputs-toggle');
				elements.anglecontroller= thiscontainer.find('.ics-ge-controller.ics-ge-direction-angle');
				elements.angleline= thiscontainer.find('.ics-ge-controller.ics-ge-direction-angle span');
				elements.angleinput= thiscontainer.find('span.ics-ge-direction-angle-input input');
				elements.previewcontainer= thiscontainer.find('.ics-ge-preview-container');
				elements.previewarea= thiscontainer.find('.ics-ge-preview');
				elements.preview= thiscontainer.find('.ics-ge-preview div');
				elements.gradientstopeditor= thiscontainer.find('.ics-ge-stopeditor span');
				elements.linearpreview= thiscontainer.find('.ics-ge-linear-preview .ics-ge-preview div');
				elements.colorstopslist= thiscontainer.find('.ics-ge-stoppointlist');
				//elements.cssoutput= thiscontainer.find('.ics-ge-cssoutput');
				elements.importmodal= thiscontainer.find('#importmodal');
				//elements.configmodal= thiscontainer.find('#configmodal');
				elements.importtextarea= thiscontainer.find('.ics-ge-textarea-import');
				elements.actualswatch= false;
				elements.swatchescontainer= thiscontainer.find('.ics-ge-swatches');
				elements.swatches= thiscontainer.find('.ics-ge-swatches ul');
				elements.swatches_add= thiscontainer.find('.ics-ge-save');
				//elements.get_css= thiscontainer.find('.ics-ge-getcss');
				elements.gradientpreferencesadvanced= thiscontainer.find('.gradient-preferences-advanced');
				thiscontainer.find('.ics-ge-import').css('display','');
				}
			if(opts.mode == 'image' || opts.interface.indexOf('background') > -1)
				{	
				elements.cssBgInputTarget = false; //could be an input element or an object containing seperated input elements
				elements.bgPreviewEl = false;
				elements.bgPreviewImg = false;
				elements.bgpreviewholder = false;
				elements.bgpositionctrl = false;
				elements.bgsizectrl = false;
				elements.bgposinputh = false;
				elements.bgposinputv = false;
				elements.bgsizeinputh =false;
				elements.bgsizeinputv =false;
				if(opts.mode == 'image')
				thiscontainer.find('.ics-ge-import').css('display','none');
				}
			if(opts.mode == 'gradient')
				{	
				settings.localStoragePrefix= 'icsge';
				settings.defaultCssSwatches = opts.defaultSwatches;
				settings.remove_distance= 50;
				settings.positiondecimals= 1;
				settings.gradient_type= 'linear';
				settings.gradient_direction= 'bottom right';
				settings.gradient_size= 'farthest-corner';
				settings.gradient_size_value= '40';
				settings.gradient_size_unit= 'px';
				settings.gradient_size_major_value= '40';
				settings.gradient_size_major_unit= 'px';
				settings.gradient_repeat= 'off';
				settings.gradient_shape= 'ellipse';
				settings.linear_gradient_angle= '0';
				settings.gradient_position_horizontal= 'left';
				settings.gradient_position_horizontal_value= '15';
				settings.gradient_position_horizontal_unit= '%';
				settings.gradient_position_vertical= 'top';
				settings.gradient_position_vertical_value= '15';
				settings.gradient_position_vertical_unit= '%';
				var defaultconfig = {
					config_colorformat: 'rgb',
					config_colorpicker_hsl: true,
					config_colorpicker_rgb: true,
					config_colorpicker_cie: false,
					config_colorpicker_opacity: true,
					config_colorpicker_swatches: false,
					config_previewwidth: '',
					config_previewheight: '',
					config_mixedstoppointunits: 'enabled',
					config_generation_bgcolor: true,
					config_generation_iefilter: true,
					config_generation_svg: true,
					config_generation_oldwebkit: true,
					config_generation_webkit: true,
					config_generation_ms: true,
					config_cssselector: '.gradient'
				  };
				}
			if(opts.mode == 'image' || opts.interface.indexOf('background') > -1)
				{
				if (opts.background_size != false) {
					settings.background_size = opts.background_size;
					settings.background_size_horizontal_value = opts.background_size_horizontal_value;
					settings.background_size_horizontal_unit = opts.background_size_horizontal_unit;
					settings.background_size_vertical_value = opts.background_size_vertical_value;
					settings.background_size_vertical_unit = opts.background_size_vertical_unit;
					settings.background_position = opts.background_position;
					settings.background_position_horizontal_value = opts.pos_horizontal_value;
					settings.background_position_horizontal_unit = opts.pos_horizontal_unit;
					settings.background_position_vertical_value = opts.pos_vertical_value;
					settings.background_position_vertical_unit = opts.pos_vertical_unit;
					settings.background_repeat = opts.background_repeat;
					settings.background_attachment = 'scroll';
					settings.background_origin = opts.mode == 'image' ? 'padding-box' : 'border-box';
					settings.background_clip = 'border-box';
				}else{
					
				}
				
					
				// settings.background_size = 'auto auto';
				// settings.background_size_horizontal_value = '75';
				// settings.background_size_horizontal_unit = '%';
				// settings.background_size_vertical_value = '75';
				// settings.background_size_vertical_unit = '%';
				// settings.background_position = 'explicit';
				// settings.background_position_horizontal_value = '50';
				// settings.background_position_horizontal_unit = '%';
				// settings.background_position_vertical_value = '50';
				// settings.background_position_vertical_unit = '%';
				// settings.background_repeat = 'no-repeat';
				// settings.background_attachment = 'scroll';
				// settings.background_origin = opts.mode == 'image' ? 'padding-box' : 'border-box';
				// settings.background_clip = 'border-box';
				}
			function getRenderModes() {
				supportedrendermodes.css = detectGradientMode();
				if (svgSupported()) {
				  supportedrendermodes.svg = true;
				}
			  }
			function getCurrentRenderMode() {
				if (supportedrendermodes.css) {
				  if (supportedrendermodes.css === 'filter' && supportedrendermodes.svg) {
					return 'svg';
				  }
				  else {
					return supportedrendermodes.css;
				  }
				}
				else if (supportedrendermodes.svg) {
				  return 'svg';
				}
				else {
				  return 'averagebgcolor';
				}
			  }
			  
			function setInputPreference(input) {
				var name = input.attr('name');
				setPreference(name + '_value', input.val());
				setPreference(name + '_unit', input.next('.bootstrap-touchspin-postfix').text());
			  }
			function setCssTargets() {
				if(opts.targetElement)
					{
					if(!opts.targetElement instanceof jQuery)
						{
						opts.targetElement = jQuery(opts.targetElement);	
						}
					if(opts.targetElement.length > 0 && !opts.targetElement.is('input') && !opts.targetElement.is('textarea'))
						{
						elements.cssTarget = opts.targetElement;	
						}
					else
						{
						elements.cssTarget = false;	
						}
					}
				else
					{
					elements.cssTarget = false;	
					}
				//opts.targetInputElement
				if(opts.targetInputElement)
					{
					if(!opts.targetInputElement instanceof jQuery)
						{
						opts.targetInputElement = jQuery(opts.targetInputElement);	
						}
					if(opts.targetInputElement.length > 0 && (opts.targetInputElement.is('input') || opts.targetInputElement.is('textarea')))
						{
						elements.cssInputTarget = opts.targetInputElement;	
						}
					else 
						{
						elements.cssInputTarget = false;	
						}
					}
				else
					{
					elements.cssInputTarget = false;	
					}
				//if we are using background properties set where these are outputted to if this is specified
				if(backgroundOptionsActive)
					{
					if(opts.targetBgInputElement)
						{
						if(typeof opts.targetBgInputElement === 'object')
							{
							jQuery.each(opts.targetBgInputElement, function(index, value){
								if(!value instanceof jQuery)
									{
									if(jQuery(value).length > 0)
									opts.targetBgInputElement[index] = jQuery(value);
									else
									delete  opts.targetBgInputElement[index];	
									}
							});
							elements.cssBgInputTarget = opts.targetBgInputElement;
							}
						else
							{
							if(!opts.targetBgInputElement instanceof jQuery)
								{
								opts.targetBgInputElement = jQuery(opts.targetBgInputElement);	
								}
							if(opts.targetBgInputElement.length > 0 && (opts.targetBgInputElement.is('input') || opts.targetBgInputElement.is('textarea')))
								{
								elements.cssBgInputTarget = opts.targetBgInputElement;
								}
							}
						}
					}
			}
			function init() {

				if( jQuery().tooltip)
				thiscontainer.find('[title]').tooltip({
				  animation: false,
				  //container: thiscontainer.closest('.ics-styling-panel'),
				  html: true
				});
				if(opts.mode == 'gradient') thiscontainer.addClass('gradientmode');
				if(opts.mode == 'image') {

					thiscontainer.addClass('imagemode');
					if(opts.imageChooserBut.length > 0)
						{

						opts.imageChooserBut.appendTo(thiscontainer.find('.ics-bg-chooseimage'));
						
						opts.imageChooserBut.find('input').hide().on('change', function(ev){
							var newImg = jQuery(this).val();
							if(newImg.indexOf('url(') == -1 && newImg.indexOf('url (') == -1 && newImg != 'none' && newImg != '')
								{
								newImg = 'url('+newImg+')';	

								}
							setPreference('background_image',newImg);
							updateVisibleOptions();
							renderOutput();
						});
						thiscontainer.find('.ics-bg-changeimage button.change').on('click', function(ev) {
							ev.preventDefault();
				  			ev.stopPropagation();
							opts.imageChooserBut.trigger('click');
						});
						thiscontainer.find('.ics-bg-changeimage button.remove').on('click', function(ev) {
							ev.preventDefault();
				  			ev.stopPropagation();
							opts.imageChooserBut.find('input').val('none').trigger('change')
						});
						}
				}
				//are we using background options
				if(opts.interface.indexOf('background') > -1)
					{
					backgroundOptionsActive = true;
					if(opts.showBgPreview)
						{
						elements.bgPreviewEl = thiscontainer.find('.ics-bg-preview-el');
						elements.bgPreviewImg = thiscontainer.find('.ics-bg-preview-img');
						elements.bgpreviewwrapper = thiscontainer.find('.ics-bg-preview-wrapper');
						elements.bgpreviewholder = thiscontainer.find('.ics-bg-preview-holder');
						elements.bgpositionctrl = thiscontainer.find('.ics-bg-position-ctrl');
						elements.bgsizectrl = thiscontainer.find('.ics-bg-size-ctrl');
						elements.bgposinputh = thiscontainer.find('input[name=background_position_horizontal]');
						elements.bgposinputv = thiscontainer.find('input[name=background_position_vertical]');
						elements.bgsizeinputh = thiscontainer.find('input[name=background_size_horizontal]');
						elements.bgsizeinputv = thiscontainer.find('input[name=background_size_vertical]');
						}
					}
				
				setCssTargets();
				
				show();
				
				if(opts.mode == 'gradient')
					{
					//initColorPicker();
					getRenderModes();
					var mostRecent = getMostRecent();
					if(opts.startingGradient && parseGradient(opts.startingGradient))
						{
						initData(opts.startingGradient);
						}
					else if(mostRecent)
						{
						initData(mostRecent);
						}
					else 
						{
					  	initData(opts.defaultGradient);
						}
					}
				else
					{
					initData();//should be sending current values	
					}
				bindEvents();

				if(opts.mode == 'gradient')
					{
					jQuery('input[name="angle"]',thiscontainer).val(getPreference('linear_gradient_angle')).TouchSpin({
					  postfix: '<sup>o</sup>',
					  min: 0,
					  max: 359
					}).on('change touchspin.on.stopspin', function(ev) {
					  setPreference('linear_gradient_angle', jQuery(this).val() % 360);
					  jQuery(this).closest('.ics-ge-controller').trigger('mousedown');
					  renderAngle(false);
					  renderOutput();
					  if (ev.type === 'touchspin') {
						   updateToolbar();
						   updateCssOutput();
						   }
					});
				
					jQuery('input[name="gradient_size"]', thiscontainer).val(getPreference('gradient_size_value')).TouchSpin({
					  postfix: getPreference('gradient_size_unit'),
					  min: 0,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  if (ev.type === 'touchspin') {
						   updateToolbar();
						   updateCssOutput();
						   }
					});
				
					jQuery('input[name="gradient_size_major"]', thiscontainer).val(getPreference('gradient_size_major_value')).TouchSpin({
					  postfix: getPreference('gradient_size_major_unit'),
					  min: 0,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  if (ev.type === 'touchspin') {
						   updateToolbar();
						   updateCssOutput();
						   }
					});
				
					jQuery('input[name="gradient_position_horizontal"]', thiscontainer).val(getPreference('gradient_position_horizontal_value')).TouchSpin({
					  postfix: getPreference('gradient_position_horizontal_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  if (ev.type === 'touchspin') {
						   updateToolbar();
						   updateCssOutput();
						   }
					});
				
					jQuery('input[name="gradient_position_vertical"]',thiscontainer).val(getPreference('gradient_position_vertical_value')).TouchSpin({
					  postfix: getPreference('gradient_position_vertical_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  if (ev.type === 'touchspin') {
						   updateToolbar();
						   updateCssOutput();
						   }
					});
					}
				
				if(opts.mode == 'image' || backgroundOptionsActive)
					{
					jQuery('input[name="background_size_horizontal"]',thiscontainer).val(getPreference('background_size_horizontal_value')).TouchSpin({
					  postfix: getPreference('background_size_horizontal_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  renderOutput();
					  if (ev.type === 'touchspin') {
						   if(opts.mode == 'gradient')updateCssOutput();
						   }
					});
					jQuery('input[name="background_size_vertical"]',thiscontainer).val(getPreference('background_size_vertical_value')).TouchSpin({
					  postfix: getPreference('background_size_vertical_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  renderOutput();
					  if (ev.type === 'touchspin') {
						   if(opts.mode == 'gradient')updateCssOutput();
						   }
					});
					jQuery('input[name="background_position_horizontal"]',thiscontainer).val(getPreference('background_position_horizontal_value')).TouchSpin({
					  postfix: getPreference('background_position_horizontal_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  renderOutput();
					  if (ev.type === 'touchspin') {
						   if(opts.mode == 'gradient')updateCssOutput();
						   }
					});
					jQuery('input[name="background_position_vertical"]',thiscontainer).val(getPreference('background_position_vertical_value')).TouchSpin({
					  postfix: getPreference('background_position_vertical_unit'),
					  min: MIN,
					  max: MAX
					}).on('change touchspin.on.stopspin', function(ev) {
					  setInputPreference(jQuery(this));
					  renderOutput();
					  if (ev.type === 'touchspin') {
						   if(opts.mode == 'gradient')updateCssOutput();
						   }
					});
					}
			
				updateVisibleOptions();
				
				if(opts.mode == 'gradient')
					{
					renderCssSwatches();
					renderAll(true);
					updateCssOutput();
					elements.preview.removeClass('ajax-loader');
					}
				if(opts.mode == 'image')
					{
					renderOutput();	
					}
				
			  }
		    function initData(data, bgProps) {
				if(opts.mode == 'gradient')
					{
					var extracteddata = {},
						stoppointsdata = '',
						parsed;
				
					try {
					  if (typeof (data) === 'undefined') {
						parsed =  parseGradient(opts.defaultGradient);
						extracteddata = parsed.data;
						stoppointsdata = parsed.colorStops;
						currentgradient = opts.defaultGradient;
					  }
					  else {
						parsed = parseGradient(data);
						currentgradient = data;
						if(!parsed)
							{
							parsed =  parseGradient(opts.defaultGradient);	
							currentgradient = opts.defaultGradient;
							}
						extracteddata = parsed.data;
						stoppointsdata = parsed.colorStops;
					  }
					} 
					catch (e) {
					}
				
					if (typeof extracteddata === 'undefined') {
					  extracteddata = {};
					  currentgradient = opts.defaultGradient;
					}
					if(extracteddata.gradient_type == 'radial')
						{
						extracteddata = switchRadialImplicitPositions(extracteddata);	
						}
					thiscontainer.data({
					  gradient_type: extracteddata.gradient_type || settings.gradient_type,
					  gradient_direction: extracteddata.gradient_direction || settings.gradient_direction,
					  gradient_size: extracteddata.gradient_size || settings.gradient_size,
					  gradient_size_value: extracteddata.gradient_size_value || settings.gradient_size_value,
					  gradient_size_unit: extracteddata.gradient_size_unit || settings.gradient_size_unit,
					  gradient_size_major_value: extracteddata.gradient_size_major_value || settings.gradient_size_major_value,
					  gradient_size_major_unit: extracteddata.gradient_size_major_unit || settings.gradient_size_major_unit,
					  gradient_repeat: extracteddata.gradient_repeat || settings.gradient_repeat,
					  gradient_shape: extracteddata.gradient_shape || settings.gradient_shape,
					  linear_gradient_angle: extracteddata.linear_gradient_angle || settings.linear_gradient_angle,
					  gradient_position_horizontal: extracteddata.gradient_position_horizontal || settings.gradient_position_horizontal,
					  gradient_position_horizontal_value: extracteddata.gradient_position_horizontal_value || settings.gradient_position_horizontal_value,
					  gradient_position_horizontal_unit: extracteddata.gradient_position_horizontal_unit || settings.gradient_position_horizontal_unit,
					  gradient_position_vertical: extracteddata.gradient_position_vertical || settings.gradient_position_vertical,
					  gradient_position_vertical_value: extracteddata.gradient_position_vertical_value || settings.gradient_position_vertical_value,
					  gradient_position_vertical_unit: extracteddata.gradient_position_vertical_unit || settings.gradient_position_vertical_unit
					});
					}
				if(!bgProps && (!!opts.startingBgProps || !!opts.startingImage))
					{
					bgProps = {};
					if(!!opts.startingBgProps)
						{
						bgProps = opts.startingBgProps;	
						}
					if(!!opts.startingImage)
						{
						if(opts.startingImage.indexOf('url(') == -1 && opts.startingImage.indexOf('url (') == -1 && opts.startingImage != 'none' && opts.startingImage != '')
							{
							opts.startingImage = 'url('+opts.startingImage+')';	
							}
						bgProps['background-image'] = opts.startingImage;	
						}
					}
				if(bgProps)
					{
					var extractedBgData = parseBgImg(bgProps);
					backgroundOptionsSet = false;	
					}
				if((opts.mode == 'image' || backgroundOptionsActive) && !backgroundOptionsSet)
					{
					if(!extractedBgData) extractedBgData = {};
					if(opts.mode == 'image')
						{
						if(extractedBgData['background_image'])
							{
							thiscontainer.data('background_image',extractedBgData['background_image']);
							}
						else if(opts.startingImage)
							{
							if(opts.startingImage.indexOf('url(') == -1 && opts.startingImage.indexOf('url (') == -1)
								{
								opts.startingImage = 'url('+opts.startingImage+')';	
								}
							thiscontainer.data('background_image',opts.startingImage);	
							}
						else
							{
							thiscontainer.data('background_image','none');	
							}
						}
					thiscontainer.data('background_size',extractedBgData['background_size'] || settings.background_size);
					thiscontainer.data('background_size_horizontal_value', extractedBgData['background_size_horizontal_value'] || settings.background_size_horizontal_value);
					thiscontainer.data('background_size_horizontal_unit', extractedBgData['background_size_horizontal_unit'] || settings.background_size_horizontal_unit);
					thiscontainer.data('background_size_vertical_value', extractedBgData['background_size_vertical_value'] || settings.background_size_vertical_value);
					thiscontainer.data('background_size_vertical_unit', extractedBgData['background_size_vertical_unit'] || settings.background_size_vertical_unit);
					thiscontainer.data('background_position',settings.background_position);
					thiscontainer.data('background_position_horizontal_value', extractedBgData['background_position_horizontal_value'] || settings.background_position_horizontal_value);
					thiscontainer.data('background_position_horizontal_unit', extractedBgData['background_position_horizontal_unit'] || settings.background_position_horizontal_unit);
					thiscontainer.data('background_position_vertical_value', extractedBgData['background_position_vertical_value'] || settings.background_position_vertical_value);
					thiscontainer.data('background_position_vertical_unit', extractedBgData['background_position_vertical_unit'] || settings.background_position_vertical_unit);
					thiscontainer.data('background_repeat', extractedBgData['background_repeat'] || settings.background_repeat);
					thiscontainer.data('background_attachment', extractedBgData['background_attachment'] || settings.background_attachment);
					thiscontainer.data('background_origin', extractedBgData['background_origin'] || settings.background_origin);
					thiscontainer.data('background_clip', extractedBgData['background_clip'] || settings.background_clip);
					backgroundOptionsSet = true;
					}
			
				initControllers();
				if (typeof stoppointsdata !== 'undefined' && stoppointsdata !== '') {
				  for (var i = 0; i < stoppointsdata.length; i++) {
					addColorStop(stoppointsdata[i]);
				  }
				}
			  }
			function initColorPicker() {
				  var spectrumSetup = {
						move : function(color) {
							jQuery(this).val(color).trigger('change');
						},
						flat: true,
						showAlpha: true,
						allowEmpty:true,
						preferredFormat: "rgb",
						color: "rgb(199,151,151)",
						clickoutFiresChange: true,
						colorOnShow : true,
						showInput: false,
						showButtons: false,
						showPalette : true,
						palette : [],
						maxSelectionSize : 30,
						localStorageKey : "spectrum.ics"
					};
				if(opts.colorpickerDestination.length > 0)
					{
					elements.colorpickerholder.appendTo(opts.colorpickerDestination);
					spectrumSetup['appendTo'] = opts.colorpickerDestination;
					jQuery(elements.colorpickerholder).closest('.ics-styling-panel').find('.ics-right-panel .ics-plugin-panel').bind("scroll", function(){
						elements.colorpickerholder.fadeOut();
					});
					}
				elements.colorpickerholder.show();
				elements.colorpicker.spectrum(spectrumSetup);
				elements.colorpickerholder.addClass('initialized');
				elements.colorpickerholder.hide();
				elements.colorpicker.on('change',function() {
					if(colorpickerShowing)
						{
						setColorStopData(_selectedStopIndex, 'color', jQuery(this).val());
						renderAll();
						}
				});
			  } 
			 
			function setColorPickerPosition() {
				  elements.colorpickerholder.css('display','block');
				  var selectedColorStopPos, 
				  containerOffset = thiscontainer.offset(), 
				  containerWidth = thiscontainer.width(),
				  colorPickerWidth = elements.colorpickerholder.width();
				  elements.markersarea.find('.color-stop').each(function() {
					var $this = jQuery(this);
					if (isSelected($this.data('index'))) {
						 selectedColorStopPos = $this.offset();
					}
				  });
				  if(selectedColorStopPos.top)
					{
					selectedColorStopPos.top = parseInt(selectedColorStopPos.top,10)+32;
					selectedColorStopPos.left = parseInt(selectedColorStopPos.left,10)-68; 	
					}
				if(!opts.colorpickerDestination)//we assume that if its been moved from the default position it will show even if its position falls outside the container
					{
					//if its going out the left
					if(selectedColorStopPos.left < containerOffset.left)
						{
						selectedColorStopPos.left = containerOffset.left;	
						}
					//if its going out the right
					if((parseInt(selectedColorStopPos.left,10)+parseInt(colorPickerWidth,10)) > (parseInt(containerOffset.left,10) + parseInt(containerWidth,10)))
						{
						selectedColorStopPos.left = parseInt(selectedColorStopPos.left,10) - ((parseInt(selectedColorStopPos.left,10)+parseInt(colorPickerWidth,10)) - (parseInt(containerOffset.left,10) + parseInt(containerWidth,10)));	
						}
					}
				  elements.colorpickerholder.offset(selectedColorStopPos);
				  elements.colorpickerholder.css('display','none');
			  }
			  
			function updateInputValues() {
				if(opts.mode == 'gradient')
					{
					jQuery('input[name="gradient_size"]', thiscontainer).val(getPreference('gradient_size_value'));
					jQuery('input[name="gradient_size_major"]', thiscontainer).val(getPreference('gradient_size_major_value'));
					jQuery('input[name="gradient_position_horizontal"]', thiscontainer).val(getPreference('gradient_position_horizontal_value'));
					jQuery('input[name="gradient_position_vertical"]', thiscontainer).val(getPreference('gradient_position_vertical_value'));
				
					changeUnit(jQuery('input[name="gradient_size"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_size_unit'));
					changeUnit(jQuery('input[name="gradient_size_major"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_size_major_unit'));
					changeUnit(jQuery('input[name="gradient_position_horizontal"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_position_horizontal_unit'));
					changeUnit(jQuery('input[name="gradient_position_vertical"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('gradient_position_vertical_unit'));
					}
				//also need to do these if we are in image mode or background options are active
				if(opts.mode == 'image' || backgroundOptionsActive)
					{
					if(getPreference('background_size') == 'explicit')
						{
						jQuery('input[name="background_size_horizontal"]', thiscontainer).val(getPreference('background_size_horizontal_value'));
						jQuery('input[name="background_size_vertical"]', thiscontainer).val(getPreference('background_size_vertical_value'));
						changeUnit(jQuery('input[name="background_size_horizontal"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('background_size_horizontal_unit'));
						changeUnit(jQuery('input[name="background_size_vertical"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('background_size_vertical_unit'));	
						}
					//background-position is always explicit
					jQuery('input[name="background_position_horizontal"]', thiscontainer).val(getPreference('background_position_horizontal_value'));
					jQuery('input[name="background_position_vertical"]', thiscontainer).val(getPreference('background_position_vertical_value'));
					changeUnit(jQuery('input[name="background_position_horizontal"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('background_position_horizontal_unit'));
					changeUnit(jQuery('input[name="background_position_vertical"]', thiscontainer).next('.input-group-addon.bootstrap-touchspin-postfix'), getPreference('background_position_vertical_unit'));
					}
			  }
			  
			function getBgColor(c) {
				var color;
			
				if (c.hasOwnProperty('color')) {
				  color = c.color;
				}
				else {
				  color = c;
				}
				return color;
			  }
			//uses gradient parser.js
			function parseGradient(gradientcss) {
				var gradientAST, posdata = {}, extracteddata = {}, colorStops = [], i;
				  if(!gradientcss)
					{
					gradientcss = 'radial-gradient(circle 531px at 59px 147px,rgb(255, 255, 255) 0%,rgb(229, 68, 198) 70%,rgb(4, 118, 148) 100%)';	
					}
				else
					{
					gradientcss = gradientcss.replace('background-image','').replace(':','').replace(';','');
					gradientcss = gradientcss.trim();
					}
				storeCssSwatches(gradientcss);
				gradientAST = GradientParser.parse(gradientcss);
				//perhaps we show a warning if the length of the ast array is greater than 1?
				if(!gradientAST[0] || !gradientAST[0].orientation)
					{
					return false;	
					}
				var thisGradient = gradientAST[0],
				thisGradientOrientation = thisGradient.orientation[0] || thisGradient.orientation;
				extracteddata.gradient_type = thisGradient.type.indexOf('linear') > -1 ? 'linear' : 'radial';
				if(thisGradientOrientation.type == 'directional' || thisGradientOrientation.type == 'angular')
					{
					if(thisGradientOrientation.type == 'directional')
						{
						extracteddata.gradient_direction = thisGradientOrientation.value;	
						}
					else if (thisGradientOrientation.type == 'angular')
						{
						extracteddata.gradient_direction = 'angle';	
						}
					}
				if(thisGradientOrientation.style)
					{
					if(thisGradientOrientation.style.type == 'extent-keyword')
						{
						extracteddata.gradient_size = thisGradientOrientation.style.value;	
						}
					else
						{
						extracteddata.gradient_size = 'explicit';
						if(thisGradientOrientation.style.type == 'position')
							{
							extracteddata.gradient_size_value = thisGradientOrientation.style.value.x.value;
							extracteddata.gradient_size_unit = thisGradientOrientation.style.value.x.type;
							if(thisGradientOrientation.value == 'ellipse')
								{
								extracteddata.gradient_size_major_value = thisGradientOrientation.style.value.y.value ? thisGradientOrientation.style.value.y.value : thisGradientOrientation.style.value.x.value;
								extracteddata.gradient_size_major_unit = thisGradientOrientation.style.value.y.value ? thisGradientOrientation.style.value.y.type : thisGradientOrientation.style.value.x.type;
								}
							}
						else
							{
							extracteddata.gradient_size_value = thisGradientOrientation.style.value;
							extracteddata.gradient_size_unit = thisGradientOrientation.style.type;
							}
						}
					}
				extracteddata.gradient_repeat = thisGradient.type.indexOf('repeating') > -1 ? 'on' : 'off';
				extracteddata.gradient_shape = thisGradientOrientation.value == 'circle' || thisGradientOrientation.value == 'ellipse' ? thisGradientOrientation.value : '';
				extracteddata.linear_gradient_angle = thisGradientOrientation.type == 'angular' ? thisGradientOrientation.value : '';
				if(thisGradientOrientation.at)
					{
					if(thisGradientOrientation.at.value)
						{
						if(thisGradientOrientation.at.value.x)
							{
							if(thisGradientOrientation.at.value.x.type)
								{
								if(thisGradientOrientation.at.value.x.type == 'position-keyword')
									{
									extracteddata.gradient_position_horizontal = thisGradientOrientation.at.value.x.value;
									}
								else
									{
									extracteddata.gradient_position_horizontal = 'explicit';
									extracteddata.gradient_position_horizontal_value = thisGradientOrientation.at.value.x.value;
									extracteddata.gradient_position_horizontal_unit = thisGradientOrientation.at.value.x.type;		
									}
								}	
							}
						if(thisGradientOrientation.at.value.y)
							{
							if(thisGradientOrientation.at.value.y.type)
								{
								if(thisGradientOrientation.at.value.y.type == 'position-keyword')
									{
									extracteddata.gradient_position_vertical = thisGradientOrientation.at.value.y.value;	
									}
								else
									{
									extracteddata.gradient_position_vertical = 'explicit';
									extracteddata.gradient_position_vertical_value = thisGradientOrientation.at.value.y.value;
									extracteddata.gradient_position_vertical_unit = thisGradientOrientation.at.value.y.type;		
									}
								}
							}	
						}
					}
				//color stops
				for (i = 0; i < thisGradient.colorStops.length; i++) {
				  var color;
				  if(thisGradient.colorStops[i].type == 'literal')
					{
					color = thisGradient.colorStops[i].value;	
					}
				else if(thisGradient.colorStops[i].type == 'hex')
					{
					color = '#'+thisGradient.colorStops[i].value;	
					}
				else if (thisGradient.colorStops[i].type == 'rgb' || thisGradient.colorStops[i].type == 'rgba')
					{
					color = thisGradient.colorStops[i].type+'('+thisGradient.colorStops[i].value[0]+','+thisGradient.colorStops[i].value[1]+','+thisGradient.colorStops[i].value[2];
					if (thisGradient.colorStops[i].type == 'rgba')
					color += ','+thisGradient.colorStops[i].value[3];
					color += ')';	
					}
				  colorStops.push({
					color: tinycolor(color).toRgbString(),
					position: thisGradient.colorStops[i].length.value,
					unit: thisGradient.colorStops[i].length.type,
					index: i,
					toDelete: false
				  });
				}
				return {
				  data: extracteddata,
				  colorStops: colorStops
				};	
			  }
			//takes an object contsining 'background-*' : 'value' pairs
			function parseBgImg(settings) {
				var extractedBgData = {};
				if(settings['background-image'])
					{
					extractedBgData['background_image'] = settings['background-image'].indexOf('url(') > -1 ? settings['background-image'] : 'url('+settings['background-image']+')';	
					}
				if(settings['background-size'])
					{
					if(settings['background-size'] == 'auto' || settings['background-size'] == 'auto auto' || settings['background-size'] == '100% 100%' || settings['background-size'] == 'cover' || settings['background-size'] == 'contain')
						{
						extractedBgData['background_size'] = settings['background-size'] == 'auto' ? 'auto auto' : settings['background-size'];	
						}
					else
						{
						//if we use just parseInt here then 0 gets treated as false so we need it as a string after...
						extractedBgData['background_size'] = 'explicit';
						var bgSize = settings['background-size'].trim().split(' ');
						if(!bgSize[0])
							{
							extractedBgData['background_size'] = 'cover';	
							}
						if(bgSize[0])
							{
							if(bgSize[0] == 'auto')//we dont have a method of dealing with auto 50% or 50% auto yet
								{
								extractedBgData['background_size_horizontal_value'] = '100';
								extractedBgData['background_size_horizontal_unit'] = '%';
								}
							else
								{
								extractedBgData['background_size_horizontal_value'] = parseInt(bgSize[0],10).toString();
								extractedBgData['background_size_horizontal_unit'] = bgSize[0].replace(extractedBgData['background_size_horizontal_value'].toString(), '');
								}
							}
						if(bgSize[1])
							{
							if(bgSize[0] == 'auto')//we dont have a method of dealing with auto 50% or 50% auto yet
								{
								extractedBgData['background_size_vertical_value'] = '100';
								extractedBgData['background_size_vertical_unit'] = '%';
								}
							else
								{
								extractedBgData['background_size_vertical_value'] = parseInt(bgSize[1],10).toString();
								extractedBgData['background_size_vertical_unit'] = bgSize[1].replace(extractedBgData['background_size_vertical_value'].toString(), '');
								}	
							}
						else
							{
							extractedBgData['background_size_vertical_value']= extractedBgData['background_size_horizontal_value'];
							extractedBgData['background_size_vertical_unit']= extractedBgData['background_size_horizontal_unit'];
							}
						}
					}
				if(settings['background-position'])
					{
					extractedBgData['background_position'] = 'explicit';
					var bgPos = settings['background-position'].trim().split(' ');
					if(!bgPos[0])
						{
						extractedBgData['background_position_horizontal_value'] = '0';
						extractedBgData['background_position_horizontal_unit'] = '%';
						extractedBgData['background_position_vertical_value'] = '0';
						extractedBgData['background_position_vertical_unit'] = '%';	
						}
					else
						{
						if(bgPos[0])
							{
							extractedBgData['background_position_horizontal_value'] = parseInt(bgPos[0],10).toString();
							extractedBgData['background_position_horizontal_unit'] = bgPos[0].replace(extractedBgData['background_position_horizontal_value'].toString(), '');
							}
						if(bgPos[1])
							{
							extractedBgData['background_position_vertical_value'] = parseInt(bgPos[1],10).toString();
							extractedBgData['background_position_vertical_unit'] = bgPos[1].replace(extractedBgData['background_position_vertical_value'].toString(), '');
							}
						else
							{
							extractedBgData['background_position_vertical_value'] = extractedBgData['background_position_horizontal_value'];
							extractedBgData['background_position_vertical_unit'] = extractedBgData['background_position_horizontal_unit'];	
							}
						}
					}
				if(settings['background-repeat'])
					{
					extractedBgData['background_repeat'] = settings['background-repeat'];
					}
				if(settings['background-attachment'])
					{
					extractedBgData['background_attachment'] = settings['background-attachment'];
					}
				if(settings['background-origin'])
					{
					extractedBgData['background_origin'] = settings['background-origin'];
					}
				if(settings['background-clip'])
					{
					extractedBgData['background_clip'] = settings['background-clip'];
					}
				return extractedBgData;
			}
			function initControllers() {
				jQuery('.ics-ge-controller', thiscontainer).each(function() {
				  var $this = jQuery(this);
			
				  if ($this.data('name').indexOf('config_') === 0) {
					return;
				  }
			
				  if (thiscontainer.data($this.data('name')) === $this.data('value')) {
					$this.addClass('active');
					$this.trigger('mousedown');
				  }
				  else {
					$this.removeClass('active');
				  }
				});
				//set the origin and clip background options if necessary
				if(opts.mode == 'image' || backgroundOptionsActive)
					{
					thiscontainer.find('.ics-bg-origin-select').val(thiscontainer.data('background_origin'));
					thiscontainer.find('.ics-bg-clip-select').val(thiscontainer.data('background_clip'));
					//set repeat switches
					var xChecked = thiscontainer.data('background_repeat') == 'repeat' || thiscontainer.data('background_repeat') == 'repeat-x' ? true : false;
					var yChecked = thiscontainer.data('background_repeat') == 'repeat' || thiscontainer.data('background_repeat') == 'repeat-y' ? true : false;
					thiscontainer.find('.ics-background-repeat-x').prop('checked', xChecked);
					thiscontainer.find('.ics-background-repeat-y').prop('checked', yChecked);
					}
			  }
			//We are missing setup for touchspins on 991
			function bindEvents() {
				//GENERAL EVENTS
				jQuery('.ics-ge-controller', thiscontainer).on('keydown mousedown touchstart', function(e) {
				  e.preventDefault();
				  e.stopPropagation();
			
				  updateControllerStates(jQuery(this));
				});
				
				thiscontainer.on('click', '.input-group-addon.bootstrap-touchspin-postfix', function() {
				  changeUnit(jQuery(this));
				  renderOutput();
				  updateToolbar();
				  updateCssOutput();
				});

				thiscontainer.on('click', '[data-show-popup]',function() {
					thiscontainer.find('data-show-popup').removeClass('open');
					thiscontainer.find(jQuery(this).attr('data-target')).addClass('open');
					if(jQuery(this).attr('data-target') == '#importmodal')
						{
						//thiscontainer.find(jQuery(this).attr('data-target')).find
						 elements.importtextarea.val('').scrollTop(0).focus().parent().scrollTop(0);	
						}
				});
				thiscontainer.on('click', '.ics-ge-optionbox .close',function() {
					jQuery(this).closest('.ics-ge-optionbox').removeClass('open');
				});
				
				thiscontainer.on('click', '.ics-ge-optionbox .import-css',function() {
					importCssGradient(elements.importtextarea.val());	
				});
			
				thiscontainer.on('change', '.bootstrap-touchspin input', function() {
				  jQuery(this).closest('.ics-ge-controller').trigger('mousedown');
				});
				thiscontainer.on('click', '.ics-ge-radial-position-inputs-toggle, .ics-ge-background-options-inputs-toggle', function() {
					jQuery(this).parent().find('.ics-ge-radial-position-inputs-holder').scrollTop(0);
					jQuery(this).parent().toggleClass('open');
				});
				//GRADIENT ONLY EVENTS
				if(opts.mode == 'gradient')
					{
					thiscontainer.on('icsgradienteditor.changeswatches', function() {
					  renderCssSwatches();
					});
					
					thiscontainer.on('touchmove mousemove', function(ev) {
						  if (!angleMoving && !radialMoving) {
							return;
						  }
						  if(angleMoving)
							{
							  changeAngle(ev);
							  renderAngle();
							  renderOutput();
							}
						if(radialMoving)
							{
							changeRadialPos(ev);
							renderRadialPosition(true);
							renderOutput();	
							}
					});
			
					elements.markersarea.on('click', function(ev) {
						  var stopBefore = '', stopAfter = '', newPos = calculateEventPosition(ev, jQuery(this)).horizontal.percent, newColor = lastSelectedColor;
						jQuery.each(colorStops,function(index,colorStop){
							if(parseInt(colorStop.position,10) < parseInt(newPos,10))
								{
								stopBefore = colorStop;	
								}
							if((parseInt(colorStop.position,10) > parseInt(newPos,10)) && stopAfter == '')
								{
								stopAfter = colorStop;	
								}
						});
						//if there is no stopAfter the stop is to be added in the last position and so gets the color of the stop before
						if(stopAfter == '')
							{
							newColor = stopBefore.color;	
							}
						//if there is no stopBefore then the stop is to be added first and so gets the color of the stop after
						else if(stopBefore == '')
							{
							newColor = stopAfter.color;	
							}
						else
							{
							newColor = tinycolor.mix(stopBefore.color, stopAfter.color);
							newColor = tinycolor(newColor).toRgbString();	
							}
						addColorStop({
						  position: newPos,
						  startingPosition: newPos,
						  unit: '%',
						  color: newColor
						});
				
					  ev.stopPropagation();
					  ev.preventDefault();
				
					  renderAll();
					  updateToolbar();
					  updateCssOutput();
					  
					  //lastSelectedColor = newColor;
					   elements.colorpickerholder.show();
					  if(!elements.colorpickerholder.hasClass('initialized'))
					  	{
						initColorPicker();	
						}
					  setColorPickerPosition();
					  // elements.colorpicker('reflow');
						  colorpickerShowing = true;
						  elements.colorpicker.spectrum('set',newColor);
						});
			
					  jQuery(document).on('touchmove mousemove', function(ev) {//this needs to be document else when it is in a overflow box and clipped off the detectDeleteState is not picked up before the mouse exits the container
						  if (!stopPointDragTarget) {
							return;
						  }
						  detectDeleteState(ev);
						  moveDragTarget(calculateEventPosition(ev, elements.markersarea));
					
						  ev.stopPropagation();
						  ev.preventDefault();
						});
			
					  jQuery(document).on('touchend mouseup', function(ev) { //this can be jQuery(document) because it only targets internal events
						  if (!!stopPointDragTarget) { // a drag was in progress
							if (stopPointDragTarget.data('delete-this')) {
							  removeColorStop(stopPointDragTarget.data('index'));
							}
							//set a starting position so we can test if the marker is subsequently being moved or clicked
							stopPointDragTarget.data({
							  startingPosition: stopPointDragTarget.data('position')
							});
							stopPointDragTarget = false;
							
							updateToolbar();
							updateCssOutput();
					
							ev.stopPropagation();
							ev.preventDefault();
						  }
				
						  if (!!angleMoving) {
							angleMoving = false;
							
							updateToolbar();
							updateCssOutput();
					
							ev.stopPropagation();
							ev.preventDefault();
						  }
					  
						  if (!!radialMoving) {
							radialMoving = false;
							
							updateToolbar();
							updateCssOutput();
							
							ev.stopPropagation();
							ev.preventDefault();
						  }
						  
						  if(!!colorpickerShowing)
							{
							if(!jQuery(ev.target).closest('.sp-container').length)
								{
								colorpickerShowing = false;
								elements.colorpickerholder.hide();
								ev.stopPropagation();
								ev.preventDefault();
								}
							}
						});
			
					  elements.anglecontroller.on('touchstart mousedown', function(ev) {
						  angleMoving = true;
					
						  changeAngle(ev);
						  renderAngle();
						  renderOutput();
					
						  ev.stopPropagation();
						  ev.preventDefault();
						});
					  elements.radialpositioner.on('touchstart mousedown', function(ev) {
						  radialMoving = true;
					
						  changeRadialPos(ev);
						  renderRadialPosition(true);
						  renderOutput();
					
						  ev.stopPropagation();
						  ev.preventDefault();
						});
					  elements.radialpositionercontainer.on('click', function(ev) {
						
						  changeRadialPos(ev);
						  renderRadialPosition(true);
						  renderOutput();
					
						  ev.stopPropagation();
						  ev.preventDefault();
						});
					  elements.angleinput.on('keyup', function() {
						  var intRegex = /^\d+$/,
							  val = jQuery(this).val();
					
						  if (val === '') {
							val = 0;
						  }
					
						  if (!intRegex.test(val)) {
							jQuery(this).val(getPreference('linear_gradient_angle'));
					
							return false;
						  }
						  else {
							setPreference('linear_gradient_angle', val % 360);
							renderAngle(false);
							renderOutput();
							updateToolbar();
							updateCssOutput();
						  }
					
						});
				
					  elements.angleinput.on('blur', function() {
						  var $this = jQuery(this);
					
						  if ($this.val() === '') {
							$this.val('0');
						  }
						  else {
							$this.val(getPreference('linear_gradient_angle'));
						  }
						});
					
					  jQuery('.ics-ge-controller[data-name=gradient_type], .ics-ge-controller[data-name=gradient_shape]', thiscontainer).on('touchstart mousedown click', function() {
						  updateVisibleOptions();
						  updateToolbar();
						  updateCssOutput();
						});
						
					  jQuery('.ics-ge-controller[data-name=gradient_repeat], button[data-name=gradient_size], .ics-ge-linear-direction-implicit [data-name=gradient_direction]', thiscontainer).on('touchstart mousedown click', function() {
						  //updateVisibleOptions();
						  renderOutput();
						  updateToolbar();
						  updateCssOutput();
						});
						
					  jQuery('.ics-ge-radial-preferences input', thiscontainer).on('change keyup', function() {
						  renderOutput();
						});
				
					  elements.swatches.on('click', 'li .ics-ge-preset', function(ev) {
						  loadGradient(jQuery(this).data('gradient'));
						  ev.stopPropagation();
						  ev.preventDefault();
						});
				
					  elements.swatches_add.on('click', function(ev) {
						  addCurrentGradientToSwatches();
						  ev.stopPropagation();
						  ev.preventDefault();
						});
				}
				//end gradient only events
				
				//if background options
				if(backgroundOptionsActive || opts.mode == 'image')
					{
					
					thiscontainer.on('touchmove mousemove', function(ev) {
						  if (!bgInMove) {
							return;
						  }
						if(bgInMove)
							{
							changeBgProp(ev);
							updateCssOutput();	
							}
						});
						
					jQuery(document).on('touchend mouseup', function(ev) {
						if (!!bgInMove) {
							bgInMove = false;
							bgInMoveStartPos = false;
							
							ev.stopPropagation();
							ev.preventDefault();
							updateCssOutput();
						  }
					});
					if (elements.bgpositionctrl) {
						elements.bgpositionctrl.on('touchstart mousedown',function(ev) {
							bgInMove = true;
							
							changeBgProp(ev);
							
							ev.stopPropagation();
							ev.preventDefault();
							updateCssOutput();
						});	
					};
					if (elements.bgsizectrl) {
						elements.bgsizectrl.on('touchstart mousedown',function(ev) {
							bgInMove = true;
							
							changeBgProp(ev);
							
							ev.stopPropagation();
							ev.preventDefault();
							updateCssOutput();
						});	
					};
					
					jQuery('[data-name=background_size]', thiscontainer).on('touchstart mousedown click', function() {
					  updateVisibleOptions();
					  updateCssOutput();
					});
					jQuery('.ics-ge-background-repeat .ics-switch-checkbox', thiscontainer).on('touchstart mousedown click', function() {
						var $repeatArea = jQuery(this).closest('.ics-ge-background-repeat'),
							repeatAcross = $repeatArea.find('.ics-background-repeat-x').prop('checked'),
							repeatDown = $repeatArea.find('.ics-background-repeat-y').prop('checked'),
							repeat = (repeatDown && repeatAcross) ? 'repeat' : (repeatAcross ? 'repeat-x' : (repeatDown ? 'repeat-y' : 'no-repeat'));
						setPreference('background_repeat', repeat);
						renderOutput();	
						updateCssOutput();
					});
					
					//option clip select boxes
					jQuery('.ics-bg-origin-select', thiscontainer).on('change', function(){
						setPreference(jQuery(this).attr('data-name'), jQuery(this).val());
						renderOutput();	
						updateCssOutput();
					});
					jQuery('.ics-bg-clip-select', thiscontainer).on('change', function(){
						setPreference(jQuery(this).attr('data-name'), jQuery(this).val());
						renderOutput();
						updateCssOutput();
					});
					}
			  }
			  
			function updateControllerStates($this) {
				var name = $this.data('name'),
					value = $this.data('value');
			
				if (name.indexOf('config_') !== 0) {
				  if (getPreference(name) === value) {
					return;
				  }
				  $this.addClass('active');
				  setPreference(name, value);
				}
				else {
				  if (!!$this.data('control-group')) {
					if (defaultconfig[name] === value) {
					  return;
					}
					$this.addClass('active');
					//setConfig(name, value);
				  }
				  else {
					if ($this.hasClass('active')) {
					 // setConfig(name, false);
					  $this.removeClass('active');
					}
					else {
					  //setConfig(name, true);
					  $this.addClass('active');
					}
				  }
				}
			
				jQuery('.ics-ge-controller.active[data-control-group="' + $this.data('control-group') + '"]', thiscontainer).removeClass('active').blur();
			
				jQuery('.ics-ge-controller[data-control-group="' + $this.data('control-group') + '"][data-name="' + name + '"][data-value="' + value + '"]', thiscontainer).addClass('active');
			
				renderOutput();
			  }
			  
			function loadGradient(gradient, bgProps) {
				//if the gradient is a css gradient save it to local storage if possible
				if(gradient.indexOf('t=')< 0)
					{
					storeCssSwatches(gradient);	
					}
				elements.previewarea.addClass('loading');
			
				setTimeout(function() {
				  gradientready = false;
				  removeAllColorStops();
				  initData(gradient, bgProps);
				  updateInputValues();
				  initControllers();
				  setTimeout(function() {
					renderAll();
					elements.previewarea.removeClass('loading');
				  }, 100);
				  findGradientsSwatch();
				}, 100);
			  }
			
			function setColorStopData(index, name, value) {
				var i;
			
				if (index === false) {
				  for (i = 0; i < colorStops.length; i++) {
					colorStops[i][name] = value;
				  }
				}
				else {
				  for (i = 0; i < colorStops.length; i++) {
					if (colorStops[i].index === index) {
					  colorStops[i][name] = value;
					  break;
					}
				  }
				}
			  }
			
			function changeUnit(element, newunit) {
				var currentunit = element.html(),
					previnput = element.prev('input'),
					availableunits = previnput.data('units');
			
				if (typeof (newunit) === 'undefined') {
				  newunit = '';
			
				  if (typeof (availableunits) === 'undefined') {
					return;
				  }
			
				  var currentindex = availableunits.indexOf(currentunit);
			
				  if (availableunits.length > currentindex + 1) {
					newunit = availableunits[currentindex + 1];
				  }
				  else {
					newunit = availableunits[0];
				  }
			
				}
			
				element.html(newunit);
				setInputPreference(previnput);
			  }
			
			function updateVisibleOptions(update_gradient_type) {
				if(opts.mode == 'gradient')
					{
					if (typeof (update_gradient_type) === 'undefined') {
					  update_gradient_type = false;
					}
			
					var gradient_type = getPreference('gradient_type');
			
					if (gradient_type === 'linear') {
					  //close the radial options and reset them to be scrolled to the top
					  jQuery('.ics-ge-radial-position-inputs.open .ics-ge-radial-position-inputs-toggle', thiscontainer).trigger('click');
					  jQuery('.ics-ge-linear-preferences', thiscontainer).show();
					  jQuery('.ics-ge-radial-preferences', thiscontainer).hide();
				
					  if (update_gradient_type) {
						jQuery('[data-name=gradient_type][data-value=linear]', thiscontainer).trigger('mousedown');
					  }
					}
					else if (gradient_type === 'radial') {
					  jQuery('.ics-ge-linear-preferences', thiscontainer).hide();
					  jQuery('.ics-ge-radial-preferences', thiscontainer).show();
				
					  if (update_gradient_type) {
						jQuery('[data-name=gradient_type][data-value=radial]', thiscontainer).trigger('mousedown');
					  }
				
					  var gradient_shape = getPreference('gradient_shape');
				
					  if (gradient_shape === 'circle') {
						jQuery('input[name=gradient_size_major]', thiscontainer).parent().hide();
					  }
					  else {
						jQuery('input[name=gradient_size_major]', thiscontainer).parent().show();
					  }
					}
				renderAngle();
				renderRadialPosition();
				}
				if(backgroundOptionsActive || opts.mode == 'image')
					{
					if(opts.mode == 'image')
						{

						var background_image = getPreference('background_image');
						if(	background_image == '' || background_image == 'none')
							{
							jQuery('.ics-bg-chooser-buts .ics-bg-chooseimage', thiscontainer).show();
							jQuery('.ics-bg-chooser-buts .ics-bg-changeimage', thiscontainer).hide();	
							}
						else
							{
							jQuery('.ics-bg-chooser-buts .ics-bg-chooseimage', thiscontainer).hide();
							jQuery('.ics-bg-chooser-buts .ics-bg-changeimage', thiscontainer).show();
							jQuery('.ics-ge-background-options-inputs .form-group',thiscontainer).show();	
							}
						}
					var background_size = getPreference('background_size');
					if(background_size ==='explicit')
							{
							elements.bgpreviewwrapper.addClass('custom');
							elements.bgpreviewwrapper.removeClass('positiononly');
							}
						else if((background_size ==='contain' || background_size ==='cover' || background_size ==='auto auto') && opts.mode != 'gradient')
							{
							elements.bgpreviewwrapper.addClass('positiononly');
							elements.bgpreviewwrapper.removeClass('custom');
							}
						else
							{
							elements.bgpreviewwrapper.removeClass('custom');
							elements.bgpreviewwrapper.removeClass('positiononly');
							}
					if(background_size === 'cover' || background_size === 'contain' || background_size ==='auto auto' || background_size === '100% 100%')
						{
						jQuery('.ics-ge-background-size-explicit', thiscontainer).hide();
						if(opts.mode == 'gradient')
							{
							jQuery('.ics-ge-background-position', thiscontainer).hide();
							jQuery('.ics-ge-background-repeat', thiscontainer).hide();	
							}
						}
					else
						{
						jQuery('.ics-ge-background-size-explicit', thiscontainer).show();
						if(opts.mode == 'gradient')
							{
							jQuery('.ics-ge-background-position', thiscontainer).show();
							jQuery('.ics-ge-background-repeat', thiscontainer).show();	
							}	
						}
					if(	background_image == '' || background_image == 'none')
						{
						elements.bgpreviewwrapper.removeClass('custom');
						elements.bgpreviewwrapper.removeClass('positiononly');
						jQuery('.ics-ge-background-options-inputs .form-group',thiscontainer).hide();	
						}
					}
			  }
			
			function changeAngle(ev) {
				var c = getEventCoordinates(ev),
					offset = elements.anglecontroller.offset(),
					width = elements.anglecontroller.width(),
					height = elements.anglecontroller.height();
			
				if (c === false) {
				  angleMoving = false;
				  return false;
				}
			
				var xd = Math.round(c.pageX - offset.left - width / 2),
					yd = Math.round(c.pageY - offset.top - height / 2);
			
				var rotation_angle = Math.round(getDegreeFromDistance(xd, yd) + 90) % 360;
			
				setPreference('linear_gradient_angle', rotation_angle);
			  }
			
			function changeRadialPos(ev) {
				var c = getEventCoordinates(ev),
				position = calculateEventPosition(ev, elements.radialpositionercontainer);
			
				if (c === false) {
				  radialMoving = false;
				  return false;
				}
				elements.radialpositioner.css({'left' : Math.round(position.horizontal.percent)+'%', 'top':Math.round(position.vertical.percent) + '%'});
			
				setPreference('gradient_position_horizontal_value', Math.round(position.horizontal.percent));
				setPreference('gradient_position_vertical_value', Math.round(position.vertical.percent));
			  }
			function changeBgProp(ev) {
				var $resizeTarget = jQuery(ev.target).closest('.ics-bg-size-ctrl'),
					c = getEventCoordinates(ev),
					evPosition = calculateEventPosition(ev, elements.bgpreviewholder),
					propType = 'position',
					propDir = '',
					hModifier, vModifier, newh, newv;
				if($resizeTarget.length > 0)
					{
					propType = $resizeTarget.hasClass('tm') || $resizeTarget.hasClass('bm') ? 'vertical' : ($resizeTarget.hasClass('ml') || $resizeTarget.hasClass('mr') ? 'horizontal' : 'horizontalvertical');
					propDir = $resizeTarget.prop('class').split(' ');
					propDir.splice( propDir.indexOf('ics-bg-size-ctrl'), 1 );
					propDir = propDir.join('');
					}
					
				if(c === false){
					bgInMove = false;
					bgInMoveStartPos = false;
					return false;
				}
				if(!bgInMoveStartPos)
					{
					bgInMoveStartPos = {
						h : Math.round(evPosition.horizontal.percent),
						v : Math.round(evPosition.vertical.percent),
						elh : propType == 'position' ? Math.round(getPreference('background_position_horizontal_value')) : Math.round(getPreference('background_size_horizontal_value')),
						elv : propType == 'position' ? Math.round(getPreference('background_position_vertical_value')) : Math.round(getPreference('background_size_vertical_value')),
						propType : propType,
						propDir : propDir
						}
					}
				else
					{
					hModifier = Math.round((evPosition.horizontal.percent) - bgInMoveStartPos.h)*2;
					vModifier = Math.round((evPosition.vertical.percent) - bgInMoveStartPos.v)*2;
					if(bgInMoveStartPos.propDir == 'bl' || bgInMoveStartPos.propDir == 'ml' || bgInMoveStartPos.propDir == 'tl' || (getPreference('background_size_horizontal_value') > 100 && bgInMoveStartPos.propType == 'position') ||  (getPreference('background_size') == 'cover' && bgInMoveStartPos.propType == 'position'))
						{
						hModifier *= -1;	
						}
					if(bgInMoveStartPos.propDir == 'tl' || bgInMoveStartPos.propDir == 'tm' || bgInMoveStartPos.propDir == 'tr' || (getPreference('background_size_vertical_value') > 100 && bgInMoveStartPos.propType == 'position') ||  (getPreference('background_size') == 'cover' && bgInMoveStartPos.propType == 'position') || (getPreference('background_size') == 'auto auto' && bgInMoveStartPos.propType == 'position'))
						{
						vModifier *= -1;	
						}
					//also if we are moving position and the size is >= 100% then that needs to be negged aswell
					newh = bgInMoveStartPos.elh + hModifier;
					newv = bgInMoveStartPos.elv + vModifier; 
					if(bgInMoveStartPos.propType == 'position')
						{
						setPreference('background_position_horizontal_value', newh);
						setPreference('background_position_horizontal_unit', '%');	
						setPreference('background_position_vertical_value', newv);
						setPreference('background_position_vertical_unit', '%');
						elements.bgposinputh.val(newh).trigger('change').next('.input-group-addon').html('%');
				  		elements.bgposinputv.val(newv).trigger('change').next('.input-group-addon').html('%');
						}
					else
						{
						if(newh > 100) newh = 100;
						if(newh < 9) newh = 9;
						if(newv > 100) newv = 100;
						if(newv < 15) newv = 15;
						if(bgInMoveStartPos.propType == 'horizontal' || bgInMoveStartPos.propType == 'horizontalvertical')
							{	
							setPreference('background_size_horizontal_value', newh);
							setPreference('background_size_horizontal_unit', '%');
							elements.bgsizeinputh.val(newh).trigger('change').next('.input-group-addon').html('%');		
							}
						if(bgInMoveStartPos.propType == 'vertical' || bgInMoveStartPos.propType == 'horizontalvertical')
							{
							setPreference('background_size_vertical_value', newv);
							setPreference('background_size_vertical_unit', '%');
							elements.bgsizeinputv.val(newv).trigger('change').next('.input-group-addon').html('%');		
							}
							
						}
					}
			} 
			
			function renderAngle(updateinput) {
				var linear_gradient_angle = getPreference('linear_gradient_angle');
				if (typeof updateinput === 'undefined') {
				  updateinput = true;
				}
			
				elements.angleline.css('-webkit-transform', 'rotate(' + linear_gradient_angle + 'deg)');
				elements.angleline.css('-ms-transform', 'rotate(' + linear_gradient_angle + 'deg)');
				elements.angleline.css('transform', 'rotate(' + linear_gradient_angle + 'deg)');
			
				if (updateinput) {
				  elements.angleinput.val(linear_gradient_angle);
				}
			  }
			
			function renderRadialPosition(updateinput) {
				 var gradient_position_horizontal_value = getPreference('gradient_position_horizontal_value'),
				 gradient_position_vertical_value = getPreference('gradient_position_vertical_value'),
				 gradient_position_horizontal_unit = getPreference('gradient_position_horizontal_unit'),
				 gradient_position_vertical_unit = getPreference('gradient_position_vertical_unit'),
				 hPosPerc = parseInt(gradient_position_horizontal_value,10),
				 vPosPerc = parseInt(gradient_position_vertical_value,10);
				 if (typeof updateinput === 'undefined') {
					  updateinput = false;
					}
				if(gradient_position_horizontal_unit == 'px')
					{
					hPosPerc = convertRadialPositionToPerc(hPosPerc, 'h');
					}
				if(gradient_position_vertical_unit == 'px')
					{
					vPosPerc = convertRadialPositionToPerc(vPosPerc, 'v');		
					}
				 if(hPosPerc < 0)
					{
					hPosPerc = 0;	
					}
				if(hPosPerc > 100)
					{
					hPosPerc = 100;	
					}
				if(vPosPerc < 0)
					{
					vPosPerc = 0;	
					}
				if(vPosPerc > 100)
					{
					vPosPerc = 100;	
					}
				elements.radialpositioner.css({'left' : hPosPerc.toString() + '%', 'top': vPosPerc.toString() + '%'});
				if (updateinput) {
					setPreference('gradient_position_horizontal_unit', '%');
					setPreference('gradient_position_horizontal_value', hPosPerc);
					setPreference('gradient_position_vertical_unit', '%');
					setPreference('gradient_position_vertical_value', vPosPerc);
				  elements.radialposinputh.val(hPosPerc).trigger('change').next('.input-group-addon').html('%');
				  elements.radialposinputv.val(vPosPerc).trigger('change').next('.input-group-addon').html('%');
				}
			  }
			  
			function convertRadialPositionToPerc(val,type) {
				  var pWidth = elements.previewarea.width(),
					pHeight = elements.previewarea.height();
				if(!type) type = 'v';
				  if(val < 0)
					{
					val = 0;	
					}
				else
					{
					if(type == 'h')
						{
						//calc what val is as a percentage of pWidth
						val = Math.round((val/parseInt(pWidth,10)) * 100);
						}
					if(type == 'v')
						{
						//calc what val is as a percentage of pHeight
						val = Math.round((val/parseInt(pHeight,10)) * 100);	
						}	
					}
				return val;
			  }
			
			function bindColorstopEvents(colorstopmarker) {
				colorstopmarker.on('touchstart mousedown', function(ev) {
				  // enable for left click only
				  if (ev.which > 1) {
					return;
				  }
				  stopPointDragTarget = jQuery(this);
				  stopPointDragging = false;
			
				  setSelectedIndex(stopPointDragTarget.data('index'));
				  lastSelectedColor = stopPointDragTarget.data('color');
				  setColorPickerPosition();
			
				  ev.stopPropagation();
				  ev.preventDefault();
				});
				colorstopmarker.on('click', function(ev) {
					if (!!stopPointDragging) {
						stopPointDragging = false;
					}
					else
					{
					//maybe we can settimeout here...
					elements.colorpickerholder.show();
				  	if(!elements.colorpickerholder.hasClass('initialized'))
						{
						initColorPicker();	
						}
				  	setColorPickerPosition();
					elements.colorpickerholder.show();
					colorpickerShowing = true;
					elements.colorpicker.spectrum('set',lastSelectedColor);
					}
				  ev.stopPropagation();
				  ev.preventDefault();
				});
			  }
			
			function setSelectedIndex(index) {
				_selectedStopIndex = index;
			  }
			
			function isSelected(index) {
				return index === _selectedStopIndex;
			  }
			
			function detectDeleteState(ev) {
				var originalOffset = elements.markersarea.offset(),
					eventCoordinates = getEventCoordinates(ev),
					toDelete = false;
			
				var deltaY;
			
				if (eventCoordinates.pageY > (originalOffset.top)) {
				  deltaY = Math.abs(eventCoordinates.pageY - 18 - originalOffset.top);
				}
				else {
				  deltaY = Math.abs(eventCoordinates.pageY + 7 - originalOffset.top);
				}
			
				if (deltaY > settings.remove_distance) {
				  if (stopPointDragTarget.data('delete-this')) {
					return;
				  }
			
				  stopPointDragTarget.data('delete-this', 1);
			
				  stopPointDragTarget.hide();
			
				  toDelete = true;
				}
				else {
				  if (!stopPointDragTarget.data('delete-this')) {
					return;
				  }
			
				  stopPointDragTarget.data('delete-this', 0);
			
				  stopPointDragTarget.show();
			
				  toDelete = false;
				}
			
				setColorStopData(stopPointDragTarget.data('index'), 'toDelete', toDelete);
			  }
			  
			function addColorStop(data) {
				var element = {
				  index: colorStopIndex++,
				  position: data.position,
				  startingPosition: data.position,
				  unit: data.unit || lastunit,
				  color: data.color,
				  toDelete: false
				};
			
				lastunit = element.unit;
			
				colorStops.push(element);
			
				setSelectedIndex(element.index);
			  }
			  
			function renderAll() {
				renderOutput();
				renderColorStops();
				setTimeout(function() {
				  gradientready = true;
				}, 20);
			  }
			
			function removeAllColorStops() {
				colorStops = [];
				colorStopIndex = 0;
				setSelectedIndex(-1);
			  }
			
			function removeColorStop(index) {
				for (var i = 0; i < colorStops.length; i++) {
				  if (colorStops[i].index === index) {
					colorStops.splice(i, 1);
					jQuery('input.ics-ge-stop-point-color', elements.colorstopslist).trigger('colorpickersliders.hide');
					break;
				  }
				}
			
				renderOutput();
				renderColorStops();
			  }
			
			function moveDragTarget(position) {
				var currentunit = stopPointDragTarget.data('unit'),
					positioninunit;
			
				if (currentunit === '%') {
				  positioninunit = position.horizontal.percent;
				}
				else {
				  positioninunit = position.horizontal.pixel;
				}
			
				if (positioninunit < MIN) {
				  positioninunit = MIN;
				}
				else if (positioninunit > MAX) {
				  positioninunit = MAX;
				}
				//check that the target is actually being dragged rather than clicked by not doing anything for very small changes of position
				if((positioninunit > (parseInt(stopPointDragTarget.data('startingPosition'),10) + 1.5)) || (positioninunit < (parseInt(stopPointDragTarget.data('startingPosition'),10) -1.5)))
					{
					stopPointDragging = true;
					elements.colorpickerholder.hide();
					colorpickerShowing = false;
					stopPointDragTarget.css('left', positioninunit + currentunit).data({
					  position: positioninunit,
					  unit: currentunit
					});
					setColorStopData(stopPointDragTarget.data('index'), 'position', positioninunit);
			
					renderOutput();
					setStopPointHandlerVisibility();
					}
				   
			  }
			  
			function renderColorStops() {
			
				orderColorStops();
			
				elements.markersarea.empty();
			
				for (var i = 0; i < colorStops.length; i++) {
				  var el = colorStops[i];
				  var added = jQuery('<div></div>').appendTo(elements.markersarea);
			
				  added.addClass('color-stop').css('left', el.position + el.unit).data(el);
			
				  bindColorstopEvents(added);
			
				  var tp = jQuery('<div></div>');
				  var bg = jQuery('<span></span>');
			
				  tp.html(bg);
				  added.html(tp);
			
				  bg.css('background-color', getBgColor(el));
				}
			
				setStopPointHandlerVisibility();
			  }
			
			function setStopPointHandlerVisibility() {
				jQuery('.color-stop', elements.markersarea).each(function() {
				  var $this = jQuery(this),
					  overvalue;
			
				  if ($this.data('unit') === '%') {
					overvalue = 100;
				  }
				  else {
					overvalue = $this.parents('.ics-ge-stoppointmarkers').width();
				  }
			
				  if ($this.data('position') > overvalue) {
					$this.addClass('overflow');
					$this.removeClass('underflow');
				  }
				  else if ($this.data('position') < 0) {
					$this.addClass('underflow');
					$this.removeClass('overflow');
				  }
				  else {
					$this.removeClass('underflow');
					$this.removeClass('overflow');
				  }
				});
			  }
			  
			function getPreference(name, dataset) {
				var data;
			
				if (typeof dataset === 'undefined') {
				  data = thiscontainer.data(name);
				}
				else {
				  data = dataset.data[name];
				}
			
				if (typeof data === 'undefined') {
				  console.log('missing preference: ' + name);
				}
			
				return data;
			  }
			
			function setPreference(name, value) {
				if (typeof (thiscontainer.data(name)) === 'undefined') {
				  console.log('Uninitialized preference: ' + name);
				}
				thiscontainer.data(name, value);
			  }
			  
			function getGradient() {
				  var gradient = currentgradient;
				return gradient;
			  }
			  
			function updateToolbar() {
				currentgradient = getGradient();
			
				findGradientsSwatch();
			  }
			
			function orderColorStops(stops) {
				if (typeof stops === 'undefined') {
				  stops = colorStops;
				}
			
				colorStops.sort(function(a, b) {
				  return a.position - b.position;
				});
			  }
			
			function getStopPointsString(dataset) {
				var colorStops = getActiveColorStops(dataset);
			
				if (colorStops.length < 2) {
				  return false;
				}
			
				orderColorStops(colorStops);
			
				var stoppoints = '';
			
				for (var i = 0; i < colorStops.length; i++) {
				  var el = colorStops[i];
			
				  stoppoints += ',' + getBgColor(el) + ' ' + Math.round(el.position * 10) / 10 + el.unit;
				}
			
				stoppoints += ')';
			
				return stoppoints;
			  }
			
			function recalculatePosition(position, min, max) {
				var length = max - min,
					percent = (position - min) / length;
			
				return Math.round(percent * 1000) / 1000;
			  }
			  
			function getOldWebkitStopPointsData(dataset) {
				var points = getRepeatingStopPointsforSvg(dataset),
					stoppoints = '';
			
				for (var i = 0; i < points.length; i++) {
				  stoppoints += ',color-stop(' + Math.round(points[i].position * 10) / 1000 + ', ' + getBgColor(points[i]) + ')';
				}
			
				return stoppoints;
			  }
			
			function fixEndpoints(points) {
				if (points.length < 2) {
				  return points;
				}
			
				var p_modify,
					p_other,
					length,
					weight_modify,
					p_modify_rgb,
					p_other_rgb,
					reddiff,
					greendiff,
					bluediff,
					newrgb;
			
				if (points[0].position < 0) {
				  p_modify = points[0];
				  p_other = points[1];
			
				  length = p_other.position - p_modify.position;
			
				  weight_modify = 1 - p_other.position / length;
			
				  p_modify_rgb = tinycolor(p_modify.color).toRgb();
				  p_other_rgb = tinycolor(p_other.color).toRgb();
			
				  reddiff = p_other_rgb.r - p_modify_rgb.r;
				  greendiff = p_other_rgb.g - p_modify_rgb.g;
				  bluediff = p_other_rgb.b - p_modify_rgb.b;
			
				  newrgb = {
					r: Math.round(p_modify_rgb.r + weight_modify * reddiff),
					g: Math.round(p_modify_rgb.g + weight_modify * greendiff),
					b: Math.round(p_modify_rgb.b + weight_modify * bluediff)
				  };
			
				  points[0].color = tinycolor(newrgb).toRgbString();
				  points[0].position = 0;
			
				}
			
			
				if (points[points.length - 1].position > 100) {
				  p_modify = points[points.length - 1];
				  p_other = points[points.length - 2];
			
				  length = Math.abs(p_other.position - p_modify.position);
			
				  weight_modify = 1 - (p_modify.position - 100) / length;
			
				  p_modify_rgb = tinycolor(p_modify.color).toRgb();
				  p_other_rgb = tinycolor(p_other.color).toRgb();
			
				  reddiff = p_other_rgb.r - p_modify_rgb.r;
				  greendiff = p_other_rgb.g - p_modify_rgb.g;
				  bluediff = p_other_rgb.b - p_modify_rgb.b;
			
				  newrgb = {
					r: Math.round(p_modify_rgb.r + weight_modify * reddiff),
					g: Math.round(p_modify_rgb.g + weight_modify * greendiff),
					b: Math.round(p_modify_rgb.b + weight_modify * bluediff)
				  };
			
				  points[points.length - 1].color = tinycolor(newrgb).toRgbString();
				  points[points.length - 1].position = 100;
				}
			
			  }
			function getSvgStyle(stoppoint) {
				var color = tinycolor(stoppoint.color);
			
				return 'stop-color="' + color.toHexString() + '" stop-opacity="' + color.toRgb().a + '"';
			  }
			 
			function getRepeatingStopPointsforSvg(dataset) {
				var colorStops = getActiveColorStops(dataset),
					min = false,
					max = false,
					i;
			
				orderColorStops(colorStops);
			
				if (colorStops.length < 2) {
				  return;
				}
			
				min = colorStops[0].position;
				max = colorStops[colorStops.length - 1].position;
				var length = Math.max(max - min, 1);
			
				var offsetmultiplier = 0,
					lastposition = 0,
					repeat = getPreference('gradient_repeat', dataset);
			
				if (repeat === 'on') {
				  offsetmultiplier = -Math.ceil(min / length);
				}
			
				var points = [];
			
				var step = 0;
			
				do {
				  for (i = 0; i < colorStops.length; i++) {
					var position,
						unit;
			
					position = colorStops[i].position;
					unit = colorStops[i].unit;
			
					if (colorStops[i].unit !== '%') {
					  unit = '%';
					  position = recalculatePosition(position, min, max);
					}
					else {
					  position = Math.round(position * 10) / 10;
					}
			
					position += offsetmultiplier * length;
					lastposition = position;
			
					points[step++] = {
					  color: colorStops[i].color,
					  position: position
					};
				  }
				  ++offsetmultiplier;
				} while (repeat === 'on' && lastposition < 100);
			
				var splice_start = 0,
					splice_end = points.length;
			
				for (i = 0; i < points.length; i++) {
				  if (points[i].position < 0) {
					splice_start = i;
				  }
				  else if (points[i].position > 100) {
					splice_end = i;
					break;
				  }
				}
			
				points = points.splice(splice_start, splice_end - splice_start + 1);
			
				fixEndpoints(points);
			
				return points;
			  }
			  
			function getStopPointsForSvg(dataset) {
				var points = getRepeatingStopPointsforSvg(dataset),
					stoppoints = '';
			
				for (var i = 0; i < points.length; i++) {
				  var pointsposition = points[i].position / 100;
				  stoppoints += '<stop ' + getSvgStyle(points[i]) + ' offset="' + pointsposition + '"/>';
				}
			
				return stoppoints;
			  }
			
			function getActiveColorStops(dataset) {
				var colorStops = getColorStops(dataset),
					index = 0,
					stoppoints = [];
			
				orderColorStops(colorStops);
			
				for (var i = 0; i < colorStops.length; i++) {
			
				  if (colorStops[i].toDelete) {
					continue;
				  }
			
				  stoppoints[index++] = jQuery.extend({}, colorStops[i]);
				}
			
				return stoppoints;
			  }
			
			function simplifyDirection(dataset) {
				var gradient_direction = getPreference('gradient_direction', dataset),
					direction = 'right';
			
				switch (getPreference('gradient_type', dataset)) {
				  case 'linear':
					if (gradient_direction === 'angle') {
					  var angle = getPreference('linear_gradient_angle', dataset);
			
					  if (angle > 325 || angle < 45) {
						direction = 'top';
					  }
					  else if (angle < 135) {
						direction = 'right';
					  }
					  else if (angle < 160) {
						direction = 'bottom';
					  }
					  else {
						direction = 'left';
					  }
					}
					else {
					  switch (gradient_direction) {
						case 'top':
						  direction = 'top';
						  break;
						case 'top left':
						  direction = 'top';
						  break;
						case 'top right':
						  direction = 'top';
						  break;
						case 'left':
						  direction = 'left';
						  break;
						case 'bottom':
						  direction = 'bottom';
						  break;
						case 'bottom left':
						  direction = 'bottom';
						  break;
						case 'bottom right':
						  direction = 'bottom';
						  break;
						case 'right':
						  direction = 'right';
						  break;
					  }
					}
					break;
				  case 'radial':
					direction = 'bottom';
					break;
				}
			
				return direction;
			  }
			  
			function getIEFilter(dataset) {
				var colorStops = getActiveColorStops(dataset);
			
				if (colorStops.length < 2) {
				  return false;
				}
			
				var color0 = tinycolor(colorStops[0].color).toHex8String(),
					color1 = tinycolor(colorStops[colorStops.length - 1].color).toHex8String(),
					start,
					end,
					direction = simplifyDirection();
			
				switch (direction) {
				  case 'top':
					start = color1;
					end = color0;
					direction = '0';
					break;
				  case 'right':
					start = color0;
					end = color1;
					direction = '1';
					break;
				  case 'bottom':
					start = color0;
					end = color1;
					direction = '0';
					break;
				  case 'left':
					start = color1;
					end = color0;
					direction = '1';
					break;
				}
			
				return 'progid:DXImageTransform.Microsoft.gradient(startColorstr="' + start + '",endColorstr="' + end + '",GradientType=' + direction + ')';
			  }
			  
			function getValueWithUnit(name, dataset) {
				var value, unit;
			
				if (typeof dataset === 'undefined') {
				  value = jQuery('input[name="' + name + '"]', thiscontainer).val();
				  unit = jQuery('input[name="' + name + '"]', thiscontainer).next('span.input-group-addon.bootstrap-touchspin-postfix').html();
				}
				else {
				  value = dataset.data[name + '_value'];
				  unit = dataset.data[name + '_unit'];
				}
			
				return value + unit;
			  }
			  
			function oldWebkitDirectionKeyword(direction_keyword) {
				switch (direction_keyword) {
				  case 'top':
					return 'bottom';
				  case 'left':
					return 'right';
				  case 'bottom':
					return 'top';
				  case 'right':
					return 'left';
				  case 'top left':
					return 'bottom right';
				  case 'top right':
					return 'bottom left';
				  case 'bottom left':
					return 'top right';
				  case 'bottom right':
					return 'top left';
				}
			  }
			  
			function getOldWebkitLinear(dataset, gradient_direction) {
				var oldwebkit = '-webkit-gradient(linear, ',
					stoppoints = getOldWebkitStopPointsData(dataset);
			
				if (gradient_direction === 'angle') {
				  var angle = getPreference('linear_gradient_angle', dataset);
			
				  var coords = getCoordsForAngle(angle);
			
				  oldwebkit += coords.x1 + ' ' + coords.y1 + ', ' + coords.x2 + ' ' + coords.y2;
				}
				else {
				  switch (gradient_direction) {
					case 'top':
					  oldwebkit += '0% 100%, 0% 0%';
					  break;
					case 'top left':
					  oldwebkit += '100% 100%, 0% 0%';
					  break;
					case 'top right':
					  oldwebkit += '0% 100%, 100% 0%';
					  break;
					case 'left':
					  oldwebkit += '100% 0%, 0% 0%';
					  break;
					case 'bottom':
					  oldwebkit += '0% 0%, 0% 100%';
					  break;
					case 'bottom left':
					  oldwebkit += '100% 0%, 0% 100%';
					  break;
					case 'bottom right':
					  oldwebkit += '0% 0%, 100% 100%';
					  break;
					case 'right':
					  oldwebkit += '0% 0%, 100% 0%';
					  break;
				  }
				}
			
				oldwebkit += stoppoints + ')';
			
				return oldwebkit;
			  }
			  
			function getSvgLinear(dataset, gradient_direction) {
				var svg = '',
					svgstoppoints = getStopPointsForSvg(dataset),
					from = '0%',
					to = '100%',
					x1, y1, x2, y2;
			
				if (gradient_direction === 'angle') {
				  var angle = getPreference('linear_gradient_angle', dataset);
				  var coords = getCoordsForAngle(angle);
			
				  x1 = coords.x1;
				  y1 = coords.y1;
				  x2 = coords.x2;
				  y2 = coords.y2;
				}
				else {
				  switch (gradient_direction) {
					case 'top':
					  x1 = '0%';
					  y1 = to;
					  x2 = '0%';
					  y2 = from;
					  break;
					case 'top left':
					  x1 = '100%';
					  y1 = '100%';
					  x2 = '0%';
					  y2 = '0%';
					  break;
					case 'top right':
					  x1 = '0%';
					  y1 = '100%';
					  x2 = '100%';
					  y2 = '0%';
					  break;
					case 'left':
					  x1 = to;
					  y1 = '0%';
					  x2 = from;
					  y2 = '0%';
					  break;
					case 'bottom':
					  x1 = '0%';
					  y1 = from;
					  x2 = '0%';
					  y2 = to;
					  break;
					case 'bottom left':
					  x1 = '100%';
					  y1 = '0%';
					  x2 = '0%';
					  y2 = '100%';
					  break;
					case 'bottom right':
					  x1 = '0%';
					  y1 = '0%';
					  x2 = '100%';
					  y2 = '100%';
					  break;
					case 'right':
					  x1 = from;
					  y1 = '0%';
					  x2 = to;
					  y2 = '0%';
					  break;
				  }
				}
			
				svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1 1" preserveAspectRatio="none"><linearGradient id="vsgg" gradientUnits="userSpaceOnUse" x1="' + x1 + '" y1="' + y1 + '" x2="' + x2 + '" y2="' + y2 + '">';
			
				svg += svgstoppoints;
			
				svg += '</linearGradient><rect x="0" y="0" width="1" height="1" fill="url(#vsgg)" /></svg>';
			
				svg = 'url(data:image/svg+xml;base64,' + jQuery.base64.encode(svg) + ')';
			
				return svg;
			  }
			  
			function getLinearGradientData(dataset, which) {
				if (typeof which === 'undefined') {
				  which = 'all';
				}
			
				var gradient_direction = getPreference('gradient_direction', dataset),
					noprefix,
					webkit,
					ms,
					oldwebkit,
					svg,
					filter,
					averagebgcolor,
					repeating = '',
					linearpreview = '';
			
				if (getPreference('gradient_repeat', dataset) === 'on') {
				  repeating = 'repeating-';
				}
			
				if (gradient_direction === 'angle') {
				  var angle = getPreference('linear_gradient_angle', dataset);
			
				  if (which === 'all' || which === 'noprefix') {
					noprefix = repeating + 'linear-gradient(' + angle + 'deg' + getStopPointsString(dataset);
					linearpreview = 'linear-gradient(to right' + getStopPointsString(dataset);
				  }
				  if (which === 'all' || which === 'webkit') {
					webkit = '-webkit-' + repeating + 'linear-gradient(' + (Math.abs(angle - 450) % 360) + 'deg' + getStopPointsString(dataset);
					linearpreview = '-webkit-linear-gradient(' + oldWebkitDirectionKeyword('right') + getStopPointsString(dataset);
				  }
				  if (which === 'all' || which === 'ms') {
					ms = '-ms-' + repeating + 'linear-gradient(' + (Math.abs(angle - 450) % 360) + 'deg' + getStopPointsString(dataset);
					linearpreview = '-ms-linear-gradient(' + oldWebkitDirectionKeyword('right') + getStopPointsString(dataset);
				  }
				}
				else {
				  if (which === 'all' || which === 'noprefix') {
					noprefix = repeating + 'linear-gradient(to ' + gradient_direction + getStopPointsString(dataset);
					linearpreview = 'linear-gradient(to right' + getStopPointsString(dataset);
				  }
				  if (which === 'all' || which === 'webkit') {
					webkit = '-webkit-' + repeating + 'linear-gradient(' + oldWebkitDirectionKeyword(gradient_direction) + getStopPointsString(dataset);
					linearpreview = '-webkit-linear-gradient(' + oldWebkitDirectionKeyword('right') + getStopPointsString(dataset);
				  }
				  if (which === 'all' || which === 'ms') {
					ms = '-ms-' + repeating + 'linear-gradient(' + oldWebkitDirectionKeyword(gradient_direction) + getStopPointsString(dataset);
					linearpreview = '-ms-linear-gradient(' + oldWebkitDirectionKeyword('right') + getStopPointsString(dataset);
				  }
				}
			
				if (which === 'all' || which === 'oldwebkit') {
				  oldwebkit = getOldWebkitLinear(dataset, gradient_direction);
				  linearpreview = getOldWebkitLinear(dataset, 'right');
				}
				if (which === 'all' || which === 'svg') {
				  svg = getSvgLinear(dataset, gradient_direction);
				  linearpreview = getSvgLinear(dataset, 'right');
				}
				if (which === 'all' || which === 'filter') {
				  filter = getIEFilter(dataset);
				  linearpreview = getIEFilter(dataset, 'right');
				}
				if (which === 'all' || which === 'averagebgcolor') {
				  averagebgcolor = calculateBgColor(dataset);
				  linearpreview = calculateBgColor(dataset);
				}
				//linearpreview = 'linear-gradient(to right' + getStopPointsString(dataset);
				var r = {
				  valid: true,
				  noprefix: noprefix,
				  webkit: webkit,
				  ms: ms,
				  oldwebkit: oldwebkit,
				  svg: svg,
				  filter: filter,
				  averagebgcolor: averagebgcolor,
				  linearpreview : linearpreview
				};
			
				return r;
			  }
			//TODO we will do something with the following two functions to relate them to the target element width so that when setting position and size in anything other than % the preview doesn't get messed up  
			function getPreviewWidth() {
				  return elements.preview.width();
			  }
			
			function getPreviewHeight() {
				  return elements.preview.height();
			  }

			function getOldWebkitRadial(dataset) {
				var oldwebkit = '-webkit-gradient(radial, ',
					stoppoints = getOldWebkitStopPointsData(dataset),
					r = getPreference('gradient_size', dataset),
					gph = getPreference('gradient_position_horizontal', dataset),
					gpv = getPreference('gradient_position_vertical', dataset);
			
				if (gph === 'explicit') {
				  gph = getPreference('gradient_position_horizontal_value', dataset);
				  if (getPreference('gradient_position_horizontal_unit', dataset) === '%') {
					gph = gph + '%';
				  }
				}
			
				if (gpv === 'explicit') {
				  gpv = getPreference('gradient_position_vertical_value', dataset);
				  if (getPreference('gradient_position_vertical_unit', dataset) === '%') {
					gpv = gpv + '%';
				  }
				}
			
				if (r !== 'explicit') {
				  r = getRadius(gph, gpv, dataset);
			
				  var previewwidth = getPreviewWidth(),
					  previewheight = getPreviewHeight();
			
				  r = Math.round(r / 100 * Math.sqrt(previewwidth * previewwidth + previewheight * previewheight));
				}
				else {
				  r = getPreference('gradient_size_value', dataset);
			
				  if (getPreference('gradient_shape', dataset) === 'ellipse') {
					r = Math.round((parseInt(r,10) + parseInt(getPreference('gradient_size_major_value', dataset),10)) / 2);
				  }
				}
			
				oldwebkit += gph + ' ' + gpv + ', 0, ' + gph + ' ' + gpv + ', ' + r;
			
				oldwebkit += stoppoints + ')';
			
				return oldwebkit;
			  }
			
			function getRadius(xpos, ypos, dataset) {
				var xs, ys;
			
				if (xpos === 'left') {
				  xpos = 0;
				}
				else if (xpos === 'center') {
				  xpos = 50;
				}
				else if (xpos === 'right') {
				  xpos = 100;
				}
			
				if (ypos === 'top') {
				  ypos = 0;
				}
				else if (ypos === 'center') {
				  ypos = 50;
				}
				else if (ypos === 'bottom') {
				  ypos = 100;
				}
			
				xpos = parseInt(xpos,10);
				ypos = parseInt(ypos,10);
			
				switch (getPreference('gradient_size', dataset)) {
				  case 'closest-side':
					if (xpos < 50) {
					  xs = xpos;
					}
					else {
					  xs = 100 - xpos;
					}
					if (ypos < 50) {
					  ys = ypos;
					}
					else {
					  ys = 100 - ypos;
					}
			
					return Math.min(xs, ys);
			
				  case 'closest-corner':
					if (xpos < 50) {
					  xs = xpos;
					}
					else {
					  xs = 100 - xpos;
					}
					if (ypos < 50) {
					  ys = ypos;
					}
					else {
					  ys = 100 - ypos;
					}
			
					return Math.sqrt(xs * xs + ys * ys);
			
				  case 'farthest-side':
					if (xpos < 50) {
					  xs = 100;
					}
					else {
					  xs = xpos;
					}
					if (ypos < 50) {
					  ys = 100 - ypos;
					}
					else {
					  ys = ypos;
					}
			
					return Math.max(xs, ys);
			
				  case 'farthest-corner':
					if (xpos < 50) {
					  xs = 100;
					}
					else {
					  xs = xpos;
					}
					if (ypos < 50) {
					  ys = 100 - ypos;
					}
					else {
					  ys = ypos;
					}
			
					return Math.sqrt(xs * xs + ys * ys);
			
				  default:
					if (xpos > 50) {
					  xs = xpos;
					}
					else {
					  xs = 100 - xpos;
					}
					if (ypos > 50) {
					  ys = ypos;
					}
					else {
					  ys = 100 - ypos;
					}
			
					var r;
			
					if (getPreference('gradient_size_unit', dataset) === '%') {
					  if (getPreference('gradient_shape', dataset) === 'circle') {
						r = getPreference('gradient_size_value', dataset);
					  }
					  else {
						r = (parseInt(getPreference('gradient_size_value', dataset),10) + parseInt(getPreference('gradient_size_major_value'),10)) / 2;
					  }
					}
					else {
					  if (getPreference('gradient_shape', dataset) === 'circle') {
						r = Math.round(parseInt(getPreference('gradient_size_value', dataset),10) / ((getPreviewWidth() + getPreviewHeight()) / 2) * 1000) / 10;
					  }
					  else {
						var avgsize = (parseInt(getPreference('gradient_size_value', dataset),10) + parseInt(getPreference('gradient_size_major_value'),10)) / 2;
						r = Math.round(avgsize / ((getPreviewWidth() + getPreviewHeight()) / 2) * 1000) / 10;
					  }
					}
			
					return r;
				}
			  }
			
			function getSvgRadial(dataset) {
				var svg = '',
					svgstoppoints = getStopPointsForSvg(dataset),
					x,
					y,
					r,
					xpos,
					ypos;
			
				x = getPreference('gradient_position_horizontal', dataset);
			
				switch (x) {
				  case 'explicit':
					x = getPreference('gradient_position_horizontal_value', dataset);
					break;
				  case 'left':
					x = 0;
					break;
				  case 'center':
					x = 50;
					break;
				  case 'right':
					x = 100;
					break;
				}
			
				y = getPreference('gradient_position_vertical', dataset);
			
				switch (y) {
				  case 'explicit':
					y = getPreference('gradient_position_vertical_value', dataset);
					break;
				  case 'top':
					y = 0;
					break;
				  case 'center':
					y = 50;
					break;
				  case 'bottom':
					y = 100;
					break;
				}
			
				if (x > 50) {
				  xpos = x;
				}
				else {
				  xpos = 100 - x;
				}
			
				if (y > 50) {
				  ypos = y;
				}
				else {
				  ypos = 100 - y;
				}
			
				r = getRadius(xpos, ypos, dataset);
			
				svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1 1" preserveAspectRatio="none"><radialGradient id="vsgg" gradientUnits="userSpaceOnUse" cx="' + x + '%" cy="' + y + '%" r="' + r + '%">';
			
				svg += svgstoppoints;
			
				svg += '</radialGradient><rect x="-50" y="-50" width="101" height="101" fill="url(#vsgg)" /></svg>';
			
				svg = 'url(data:image/svg+xml;base64,' + jQuery.base64.encode(svg) + ')';
			
				return svg;
			  }
			  
			function getRadialGradientData(dataset, which) {
				if (typeof which === 'undefined') {
				  which = 'all';
				}
				//we need to switch implicit to explicit positions so we can use the draggable position interface
				if(typeof dataset !== 'undefined')
				if (dataset.data.gradient_position_horizontal != 'explicit' || dataset.data.gradient_position_vertical != 'explicit')
					{
					dataset.data = switchRadialImplicitPositions(dataset.data);
					}
				var gradient_shape = getPreference('gradient_shape', dataset),
					size = getPreference('gradient_size', dataset),
					webkitshapeandsize = gradient_shape + ' ' + size,
					gradient_position_horizontal = getPreference('gradient_position_horizontal', dataset),
					gradient_position_vertical = getPreference('gradient_position_vertical', dataset),
					noprefix,
					webkit,
					ms,
					oldwebkit,
					svg,
					filter,
					averagebgcolor,
					repeating = '',
					linearpreview = '';
					
				if (gradient_position_horizontal === 'explicit') {
				  gradient_position_horizontal = getValueWithUnit('gradient_position_horizontal', dataset);
				}
			
				if (gradient_position_vertical === 'explicit') {
				  gradient_position_vertical = getValueWithUnit('gradient_position_vertical', dataset);
				}
			
				if (size === 'explicit') {
				  size = getValueWithUnit('gradient_size', dataset);
				  if (gradient_shape === 'ellipse') {
					size = size + ' ' + getValueWithUnit('gradient_size_major', dataset);
					webkitshapeandsize = size;
				  }
				  else {
					webkitshapeandsize = size + ' ' + size;
				  }
				}
			
				if (getPreference('gradient_repeat', dataset) === 'on') {
				  repeating = 'repeating-';
				}
			
				if (which === 'all' || which === 'noprefix') {
				  noprefix = repeating + 'radial-gradient(' + gradient_shape + ' ' + size + ' at ' + gradient_position_horizontal + ' ' + gradient_position_vertical + getStopPointsString(dataset);
				  linearpreview = 'linear-gradient(to right' + getStopPointsString(dataset);
				}
				if (which === 'all' || which === 'webkit') {
				  webkit = '-webkit-' + repeating + 'radial-gradient(' + gradient_position_horizontal + ' ' + gradient_position_vertical + ', ' + webkitshapeandsize + getStopPointsString(dataset);
				  linearpreview = '-webkit-linear-gradient(to right' + getStopPointsString(dataset);
				}
				if (which === 'all' || which === 'ms') {
				  ms = '-ms-' + repeating + 'radial-gradient(' + gradient_position_horizontal + ' ' + gradient_position_vertical + ', ' + webkitshapeandsize + getStopPointsString(dataset);
				  linearpreview = '-ms-linear-gradient(to right' + getStopPointsString(dataset);
				}
				if (which === 'all' || which === 'svg') {
				  svg = getSvgRadial(dataset);
				  linearpreview = getSvgLinear(dataset, 'right');
				}
				if (which === 'all' || which === 'filter') {
				  filter = getIEFilter(dataset);
				  linearpreview = getIEFilter(dataset, 'right');
				}
				if (which === 'all' || which === 'averagebgcolor') {
				  averagebgcolor = calculateBgColor(dataset);
				  linearpreview = calculateBgColor(dataset);
				}
				if (which === 'all' || which === 'oldwebkit') {
				  oldwebkit = getOldWebkitRadial(dataset);
				  linearpreview = getOldWebkitLinear(dataset, 'right');
				}
				
				//linearpreview = 'linear-gradient(to right' + getStopPointsString(dataset);
			
				var r = {
				  valid: radialGradientValid(gradient_shape, size, gradient_position_horizontal, gradient_position_vertical),
				  noprefix: noprefix,
				  oldwebkit: oldwebkit,
				  svg: svg,
				  webkit: webkit,
				  ms: ms,
				  filter: filter,
				  averagebgcolor: averagebgcolor,
				  linearpreview : linearpreview
				};
			
				return r;
			  }
			  
			function switchRadialImplicitPositions(dataset) {
				  var hVal = 0, vVal = 0;
				  if(dataset.gradient_position_horizontal != 'explicit')
					{
					if(dataset.gradient_position_horizontal == 'center')
						{
						hVal = 50;
						}
					if(dataset.gradient_position_horizontal == 'right')
						{
						hVal = 100;
						}
					dataset.gradient_position_horizontal = 'explicit';
					dataset.gradient_position_horizontal_unit = '%';
					dataset.gradient_position_horizontal_value = hVal;
					}
				if(dataset.gradient_position_vertical != 'explicit')
					{
					if(dataset.gradient_position_vertical == 'center')
						{
						vVal = 50;
						}
					if(dataset.gradient_position_vertical == 'right')
						{
						vVal = 100;
						}
					dataset.gradient_position_vertical = 'explicit';
					dataset.gradient_position_vertical_unit = '%';
					dataset.gradient_position_vertical_value = vVal;
					}
				return dataset;
			  }
			  
			function getGradientData() {
				if (getPreference('gradient_type') === 'linear') {
				  return getLinearGradientData();
				}
				else {
				  return getRadialGradientData();
				}
			  }
			
			function refreshCssOutput() {
				if(opts.mode == 'gradient')
					{
					var visiblecount = countColorStops(),
						sp = getActiveColorStops(),
						selector = defaultconfig['config_cssselector'];
				
					if (visiblecount > 1) {
					  var outputdata = getGradientData();
				
					  if (outputdata.valid) {
						var css = {
						  bgcolor: '/*###>*/background-color: ' + getBgColor(outputdata.averagebgcolor) + ';/*@@@*/\n',
						  svg: 'background-image: ' + outputdata.svg + '; /* IE9, iOS 3.2+ */\n',
						  oldwebkit: 'background-image: ' + outputdata.oldwebkit + '; /*Old Webkit*/\n',
						  androidhack: 'background-image: ' + outputdata.svg + ',\n        ' + outputdata.oldwebkit + '; /* Android 2.3- hack (needed for radial gradients) */\n',
						  webkit: 'background-image: ' + outputdata.webkit + '; /* Android 2.3 */\n',
						  ms: 'background-image: ' + outputdata.ms + '; /* IE10+ */\n',
						  noprefix: 'background-image: ' + outputdata.noprefix + '; /* W3C */\n',
						  filter: '\n/* IE8- CSS hack */\n@media ' + '\\' + '0screen' + '\\' + ',screen' + '\\' + '9 {\n    ' + selector + ' {\n        filter: ' + outputdata.filter + ';\n    }\n}'
						};
				
						var out = '';
				
						if (defaultconfig['config_generation_bgcolor']) {
						  out += css.bgcolor;
						}
				
						if (defaultconfig['config_generation_svg'] && defaultconfig['config_generation_oldwebkit']) {
						  if (oldWebkitCompatible()) {
							out += css.svg;
							out += css.oldwebkit;
						  }
						  else {
							out += css.svg;
							out += css.androidhack;
						  }
						}
						else {
						  if (defaultconfig['config_generation_svg']) {
							out += css.svg;
						  }
				
						  if (defaultconfig['config_generation_oldwebkit']) {
							out += css.oldwebkit;
						  }
						}
				
						if (defaultconfig['config_generation_webkit']) {
						  out += css.webkit;
						}
						
						if (defaultconfig['config_generation_ms']) {
						  out += css.ms;
						}
						
						out += css.noprefix;
				
						cssoutput = out;
				
						if (defaultconfig['config_generation_iefilter']) {
						  cssoutput = cssoutput + css.filter;
						}
					  }
					  else {
						if (visiblecount > 0) {
						  cssoutput = 'background-color: ' + getBgColor(sp[sp.length - 1]) + ';\n';
						}
						else {
						  cssoutput = 'background-color: transparent;';
						}
					  }
					}
					else if (visiblecount === 1) {
					  cssoutput = 'background-color: ' + getBgColor(sp[0]) + ';\n';
					  if (tinycolor(sp[0].color).getAlpha() < 1) {
				
						var filter = 'progid:DXImageTransform.Microsoft.gradient(startColorstr="' + tinycolor(sp[0].color).toHex8String() + '",endColorstr="' + tinycolor(sp[0].color).toHex8String() + '")';
				
						cssoutput += '\n\n/* IE8- CSS hack */\n@media ' + '\\' + '0screen' + '\\' + ',screen' + '\\' + '9 {\n    .yourtargetelement {\n        background-color:transparent;\n        filter: ' + filter + ';\n    }\n}';
					  }
					}
					else {
					  cssoutput = 'background-color: transparent;\n';
					}
				}
				else
				{
				cssoutput = '';
				var outputdata = {};	
				}
				if(backgroundOptionsActive)
					{
					if(outputdata)
						{
							outputdata = getBackgroundProperties(outputdata);
							jQuery.each(outputdata.backgroundProperties, function(property,value){
								cssoutput += '\n'+property+':'+value+';';
							});
						}
					}
			  }
			
			function updateCssOutput() {
				refreshCssOutput();
				elements.cssoutput.text(cssoutput);
			  }
			
			function getOutput(json) {
				//could return a json of all the output for subsequent processing
				//or the output css as specified when the plugin was called
			}
			function renderLastColor(targetelement, dataset) {
				if (typeof targetelement === 'undefined') {
				  targetelement = elements.preview;
				}
			
				var color = 'transparent';
				var colorStops = getColorStops(dataset);
			
				orderColorStops(colorStops);
			
				for (var i = 0; i < colorStops.length; i++) {
				  var el = colorStops[i];
			
				  if (el.toDelete) {
					continue;
				  }
			
				  color = getBgColor(el);
				}
			
				if (targetelement) {
				  targetelement.css('background', color);
			
				  if (targetelement.is(elements.preview)) {
				  }
				}
				else {
				  elements.preview.css('background', color);
				}
			  }
			
			function getColorStops(dataset) {
				if (typeof dataset === 'undefined') {
				  return colorStops;
				}
				else {
				  return dataset.colorStops;
				}
			
			  }
			
			function countColorStops(dataset) {
				var colorStops = getColorStops(dataset),
					pointscount = 0;
			
				for (var i = 0; i < colorStops.length; i++) {
				  if (colorStops[i].toDelete) {
					continue;
				  }
			
				  ++pointscount;
				}
			
				return pointscount;
			  }
			  
			function renderOutput(targetelement, dataset) {
				if(opts.mode == 'gradient')
					{
					if (typeof targetelement === 'undefined') {
					  targetelement = elements.preview;
						}
					if (countColorStops(dataset) < 2) {
					  renderLastColor(targetelement, dataset);
					  return;
						}
				
					var gradient_type = getPreference('gradient_type', dataset);
				
					switch (gradient_type) {
					  case 'linear':
						renderLinearGradient(targetelement, dataset);
						break;
					  case 'radial':
						renderRadialGradient(targetelement, dataset);
						break;
					  default:
						console.log('Unknown gradient type: ' + gradient_type);
						break;
						}
					}
				else
					{
					renderBackgroundImage(targetelement, dataset);	
					}
			  }
			
			function updatePreview(targetelement, outputdata, dataset) {
				if(opts.mode == 'gradient')
					{
					if (typeof targetelement === 'undefined') 
						{
					  	targetelement = elements.preview;
						}
					var rendermode = getCurrentRenderMode(), triggerChange = false;
					switch (rendermode) 
						{
						  case 'noprefix':
							targetelement.css('background-image', outputdata.noprefix);
							break;
						  case 'webkit':
							targetelement.css('background-image', outputdata.webkit);
							break;
						  case 'ms':
							targetelement.css('background-image', outputdata.ms);
							break;
						  case 'svg': // can not repeat, radial can be only a covering ellipse (maybe there is a workaround, need more investigation)
							targetelement.css('background-image', outputdata.svg);
							break;
						  case 'oldwebkit':   // can not repeat, no percent size with radial gradient (and no ellipse)
							targetelement.css('background-image', outputdata.oldwebkit);
							break;
						  case 'filter':
							targetelement.css('filter', outputdata.filter);
							break;
						  case 'averagebgcolor':
							/* falls through */
						  default:
							targetelement.css('background-color', calculateBgColor(dataset));
							break;
						}
					if (targetelement == elements.preview) 
						{
				  		elements.linearpreview.css('background-image', outputdata.linearpreview);
				  		if(elements.cssTarget)
				  			{
							//elements.cssTarget.css('background-image', outputdata.noprefix);
							switch (rendermode) 
								{
								  case 'noprefix':
									elements.cssTarget.css('background-image', outputdata.noprefix);
									break;
								  case 'webkit':
									elements.cssTarget.css('background-image', outputdata.webkit);
									break;
								  case 'ms':
									elements.cssTarget.css('background-image', outputdata.ms);
									break;
								  case 'svg': // can not repeat, radial can be only a covering ellipse (maybe there is a workaround, need more investigation)
									elements.cssTarget.css('background-image', outputdata.svg);
									break;
								  case 'oldwebkit':   // can not repeat, no percent size with radial gradient (and no ellipse)
									elements.cssTarget.css('background-image', outputdata.oldwebkit);
									break;
								  case 'filter':
									elements.cssTarget.css('filter', outputdata.filter);
									break;
								  case 'averagebgcolor':
									/* falls through */
								  default:
									elements.cssTarget.css('background-color', calculateBgColor(dataset));
									break;
								}
							}
						if(elements.cssInputTarget)
							{
							//here we need to respect the users output decision (either 'all' or 'noprefix' (default)
							if(opts.targetCssOutput == 'noprefix')
								{
				  				var cssInputval = outputdata.noprefix;
								}
							else
								{
								var backgroundOptionsActiveBU = backgroundOptionsActive;
								backgroundOptionsActive = false;
								refreshCssOutput();
								var cssInputval = cssoutput;
								backgroundOptionsActive = backgroundOptionsActiveBU;	
								}
							}
						if(backgroundOptionsActive)
							{
							//if(elements.cssTarget)
							//elements.cssTarget.css(outputdata.backgroundProperties);
							if(elements.bgPreviewEl)
								{
								elements.bgPreviewEl.css('background-image', outputdata.noprefix);
								elements.bgPreviewImg.css('background-image', outputdata.noprefix);
								}
							}
						}
					currentgradient = outputdata.noprefix;
				  	storeCssSwatches(outputdata.noprefix);//this sets the most recent css
					}//end gradient only
				if(backgroundOptionsActive || opts.mode == 'image')
					{
					if(elements.cssTarget)
						elements.cssTarget.css(outputdata.backgroundProperties);
					if(opts.mode == 'image' && elements.cssInputTarget)
						var cssInputval = outputdata.backgroundProperties['background-image'];
					if(elements.bgPreviewEl)
						{
						elements.bgPreviewEl.css(outputdata.backgroundProperties);
						elements.bgPreviewImg.css(outputdata.backgroundPreviewProperties);
						}
					if(elements.cssBgInputTarget && updateInputTargets)
						{
						if(typeof elements.cssBgInputTarget ==='object' && Object.keys(elements.cssBgInputTarget).length > 1 && !elements.cssBgInputTarget.jquery)
							{
							jQuery.each(elements.cssBgInputTarget, function(prop, target){
								target.val(outputdata.backgroundProperties[prop]);
								triggerChange = target;
							});
							}
						else if(elements.cssBgInputTarget instanceof jQuery && elements.cssBgInputTarget.length == 1)
							{
							elements.cssBgInputTarget.val(outputdata.backgroundPropertiesString);
							triggerChange = elements.cssBgInputTarget;
							}
						}
					}
				if(elements.cssInputTarget && updateInputTargets)
				  	{
					elements.cssInputTarget.val(cssInputval);
					triggerChange = elements.cssInputTarget;
					}
				if(!updateInputTargets)
					{
					updateInputTargets = true;	
					}
				if(triggerChange)//we are doing this so events bound to the inputs changing only happen once- the downside is that if events are bound to specic inputs changing these might not get triggered.
					{
					triggerChange.trigger('change');	
					}
			  }
			
			function renderBackgroundImage(targetelement, dataset) {
				var outputdata = {};
				outputdata = getBackgroundProperties(outputdata);
				updatePreview(targetelement, outputdata, dataset);
			}
			
			function renderLinearGradient(targetelement, dataset) {
				if (typeof targetelement === 'undefined') {
				  targetelement = elements.preview;
				}
			
				var outputdata = getLinearGradientData(dataset, getCurrentRenderMode());
				if(backgroundOptionsActive)
					{
					outputdata = getBackgroundProperties(outputdata); 	
					}
				if (outputdata.stoppoints === false) {
				  renderLastColor(targetelement, dataset);
				  return;
				}
				
				updatePreview(targetelement, outputdata, dataset);
			  }
			
			function renderRadialGradient(targetelement, dataset) {
				if (typeof targetelement === 'undefined') {
				  targetelement = elements.preview;
				}
			
				var outputdata = getRadialGradientData(dataset, getCurrentRenderMode());
				if(backgroundOptionsActive)
					{
					outputdata = getBackgroundProperties(outputdata); 	
					}
				if (!outputdata.valid || outputdata.stoppointsstring === false) {
				  renderLastColor(targetelement, dataset);
				  return;
				}
				
				updatePreview(targetelement, outputdata, dataset);
			  }
			
			function getBackgroundProperties(outputdata) {
				if(outputdata)
					{
					var backgroundProperties = {}, backgroundPreviewProperties = {}, backgroundPropertiesString = [];
					if(opts.mode == 'image')
						{
						var bgImg = getPreference('background_image');
						backgroundProperties['background-image'] = bgImg;
						backgroundPreviewProperties['background-image'] = bgImg;
						}
					var backgroundSize = getPreference('background_size'),
						backgroundSizeExplicit = getPreference('background_size_horizontal_value')+getPreference('background_size_horizontal_unit')+' '+getPreference('background_size_vertical_value')+getPreference('background_size_vertical_unit'),
						backgroundPosition = getPreference('background_position_horizontal_value')+getPreference('background_position_horizontal_unit')+' '+getPreference('background_position_vertical_value')+getPreference('background_position_vertical_unit'),
						backgroundRepeat = getPreference('background_repeat'),
						backgroundAttachment = getPreference('background_attachment'),
						backgroundOrigin = getPreference('background_origin'),
						backgroundClip = getPreference('background_clip');
						backgroundProperties['background-size'] = backgroundSize === 'explicit' ? backgroundSizeExplicit : backgroundSize;
						backgroundProperties['background-position']	= backgroundPosition;
						backgroundProperties['background-repeat']	= backgroundRepeat;
						backgroundProperties['background-attachment']	= backgroundAttachment;
						backgroundProperties['background-origin']	= backgroundOrigin;
						backgroundProperties['background-clip']	= backgroundClip;
						jQuery.each(backgroundProperties, function(prop,val){
						backgroundPropertiesString.push(prop+': '+val+';');
					});
					backgroundPropertiesString = backgroundPropertiesString.join('\n');
					if(backgroundSize === 'explicit')
						{
						
						var bgs = [],
							bgp = [],
							bgppWidth = 100,
							bgppHeight = 100,
							bgsHval = parseInt(getPreference('background_size_horizontal_value'),10),
							bgsHunit = getPreference('background_size_horizontal_unit'),
							bgsVval = parseInt(getPreference('background_size_vertical_value'),10),
							bgsVunit = getPreference('background_size_vertical_unit'),
							bgpHval = parseInt(getPreference('background_position_horizontal_value'),10),
							bgpHunit = getPreference('background_position_horizontal_unit'),
							bgpVval = parseInt(getPreference('background_position_vertical_value'),10),
							bgpVunit = getPreference('background_position_vertical_unit');
						backgroundPreviewProperties['background-size'] = '100%';
						if(	bgsHval <= 100)
							{
							backgroundPreviewProperties['width']= bgsHval.toString()+bgsHunit;
							bgppWidth = bgsHval;
							bgs.push('100%');
							bgp.push('0%');	
							}
						else
							{
							backgroundPreviewProperties['width']='100%';
							bgs.push(bgsHval.toString()+bgsHunit);
							bgp.push(bgpHval.toString()+bgpHunit);	
							}
						if(	bgsVval <= 100)
							{
							backgroundPreviewProperties['height']= bgsVval.toString()+bgsVunit;
							bgppHeight = bgsVval;
							bgs.push('100%');
							bgp.push('0%');		
							}
						else
							{
							backgroundPreviewProperties['height']='100%';
							bgs.push(bgsVval.toString()+bgsVunit);
							bgp.push(bgpVval.toString()+bgpVunit);	
							}
						if(bgpHunit == '%' && bgsHunit == '%')
							{
							if(bgsHval > 100) bgsHval = 100;
							backgroundPreviewProperties['left'] = (100 - bgsHval) * (bgpHval / 100);
							if(backgroundPreviewProperties['left'] >= (0 - bgppWidth) && backgroundPreviewProperties['left'] < 100)
								{
								backgroundPreviewProperties['left'] = backgroundPreviewProperties['left'].toString()+'%';
								}
							else if (backgroundPreviewProperties['left'] < (0 - bgppWidth))
								{
								backgroundPreviewProperties['left'] = bgppWidth.toString+'%';	
								}
							else
								{
								backgroundPreviewProperties['left'] = '100%';
								}
							}
						if(bgpVunit == '%' && bgsVunit == '%')
							{
							if(bgsVval > 100) bgsVval = 100;
							backgroundPreviewProperties['top'] = (100 - bgsVval) * (bgpVval / 100);
							if(backgroundPreviewProperties['top'] >= (0 - bgppHeight) && backgroundPreviewProperties['top'] < 100)
								{
								backgroundPreviewProperties['top'] = backgroundPreviewProperties['top'].toString()+'%';
								}
							else if (backgroundPreviewProperties['top'] < (0 - bgppHeight))
								{
								backgroundPreviewProperties['top'] = bgppHeight.toString+'%';	
								}
							else
								{
								backgroundPreviewProperties['top'] = '100%';
								}
							}
						backgroundPreviewProperties['background-size'] = bgs.join(' ');
						backgroundPreviewProperties['background-position'] = bgp.join(' ');
						}
					else
						{
						backgroundPreviewProperties['width'] = '100%';
						backgroundPreviewProperties['height'] = '100%';
						backgroundPreviewProperties['left'] = '0%';
						backgroundPreviewProperties['top'] = '0%';
						backgroundPreviewProperties['background-size'] = backgroundSize;
						backgroundPreviewProperties['background-position'] = backgroundPosition;
						backgroundPreviewProperties['background-repeat'] = 'no-repeat';
						}
					outputdata.backgroundProperties = backgroundProperties;
					outputdata.backgroundPreviewProperties = backgroundPreviewProperties;
					outputdata.backgroundPropertiesString = backgroundPropertiesString;
					return outputdata;
					}
			}
			
			function calculateBgColor(dataset) {
				var stops = getActiveColorStops(dataset);
			
				if (stops.length === 1) {
				  return stops[0].color;
				}
			
				var min = stops[0].position,
					max = stops[stops.length - 1].position,
					length = max - min,
					sumr = 0,
					sumg = 0,
					sumb = 0,
					suma = 0,
					i;
			
				for (i = 0; i < stops.length; i++) {
				  if (max > 100 || getPreference('gradient_repeat', dataset) === 'on') {
					stops[i].percentpos = (stops[i].position - min) / length;
				  }
				  else {
					stops[i].percentpos = parseFloat(stops[i].position) / 100;
				  }
			
				  stops[i].rgb = tinycolor(stops[i].color).toRgb();
				}
			
				for (i = 0; i < stops.length; i++) {
				  var prevpos = i > 0 ? stops[i - 1].percentpos : 0,
					  nextpos = i < stops.length - 1 ? stops[i + 1].percentpos : 1;
			
				  stops[i].weight = (stops[i].percentpos - prevpos) / 2 + (nextpos - stops[i].percentpos) / 2;
				}
			
				stops[0].weight += stops[0].percentpos / 2;
				stops[stops.length - 1].weight += (1 - stops[stops.length - 1].percentpos) / 2;
			
				for (i = 0; i < stops.length; i++) {
				  sumr = sumr + stops[i].rgb.r * stops[i].weight;
				  sumg = sumg + stops[i].rgb.g * stops[i].weight;
				  sumb = sumb + stops[i].rgb.b * stops[i].weight;
				  suma = suma + stops[i].rgb.a * stops[i].weight;
				}
			
				var rgba = {
				  r: sumr,
				  g: sumg,
				  b: sumb,
				  a: suma
				};
			
				var averagecolor = rgba.a === 1 ? tinycolor(rgba).toHexString() : tinycolor(rgba).toRgbString();
			
				return averagecolor;
			  }
			
			/*
			 * sometimes webkit screws things up
			 * https://bugs.webkit.org/show_bug.cgi?id=121642
			 * https://code.google.com/p/chromium/issues/detail?id=295126
			 */
			function radialGradientValid(shape, size, gradient_position_horizontal, gradient_position_vertical) {
				if (size.charAt(0) === '0' || size.indexOf(' 0') > -1) {
				  return false;
				}
			
				var zeropos = 0;
			
				if (gradient_position_horizontal.charAt(0) === '0') {
				  zeropos++;
				}
			
				if (gradient_position_vertical.charAt(0) === '0') {
				  zeropos++;
				}
			
				if ((size.match(/(closest-corner)/i)) &&
					(gradient_position_horizontal.match(/(left|right)/i) && gradient_position_vertical.match(/(top|bottom)/i))) {
				  return false;
				}
			
				if ((size.match(/(closest-side)/i)) &&
					(gradient_position_horizontal.match(/(left|right)/i) || gradient_position_vertical.match(/(top|bottom)/i))) {
				  return false;
				}
			
				if (size === 'closest-side' && zeropos > 0) {
				  return false;
				}
			
				if (size === 'closest-corner' && zeropos > 1) {
				  return false;
				}
			
				if ((shape.match(/(ellipse)/i)) && (size.match(/(closest-corner)/i))) {
				  if (zeropos > 0 || (gradient_position_horizontal.match(/(left|right)/i) || gradient_position_vertical.match(/(top|bottom)/i))) {
					return false;
				  }
				}
			
				return true;
			  }
			
			function loadDefaultCssSwatches() {
				for (var i = 0; i < opts.defaultCssSwatches.length; i++) {
				  cssSwatches.push(opts.defaultCssSwatches[i]);
				}
				storeCssSwatches();
			  }
			
			  function convertToNewGradientFormat(data) {
				var oldformat = data.split('|');
			
				if (oldformat.length === 2) {
				  oldformat[1] = replaceAll('%', '%25', replaceAll('%25', '%', oldformat[1]));
			
				  data = replaceAll(',', '&', oldformat[0]) + '&sp=';
				  data += replaceAll('/', '_', replaceAll(',', '__', oldformat[1]));
				}
			
				data = data.replace(/\+/g, '%20');
			
				return data;
			  }
			  
			function loadCssSwatches() {
				cssSwatches = [];
				if (settings.localStoragePrefix) {
				  var customCssSwatches = [];
				  try {
					customCssSwatches = JSON.parse(localStorage.getItem(settings.localStoragePrefix+'-cssgradientswatches'));
					if (customCssSwatches) {
					  for (var i = 0; i < customCssSwatches.length; i++) {
						cssSwatches.push(customCssSwatches[i]);
					  }
					}
					else {
					  loadDefaultCssSwatches();
					}
				  }
				  catch (err) {
					console.log(err);
					loadDefaultCssSwatches();
				  }
				}
				else {
				  loadDefaultCssSwatches();
				  }
			  }
			  
			function renderCssSwatches() {
				loadCssSwatches();
			
				elements.swatches.html('');
				if (cssSwatches instanceof Array) {
				  for (var i = 0; i < cssSwatches.length; i++) {
					var swatch = cssSwatches[i];
			
					var span = jQuery('<span></span>');
					var button = jQuery('<div class="ics-ge-preset"></div>').data('gradient', swatch);
			
					button.append(span);
			
					elements.swatches.append(jQuery('<li></li>').append(button));
					renderOutput(span, parseGradient(swatch));
				  }
				}
			
				findGradientsSwatch();
			  }
			
			function findGradientsSwatch() {
				var found = false;
			
				currentgradient = getGradient();
			
				jQuery('.ics-ge-preset', elements.swatches).filter(function() {
				  var gradient = jQuery(this).data('gradient');
			
				  if (gradient === currentgradient) {
					found = true;
			
					var currentswatch = jQuery(this).parent();
			
					if (!currentswatch.is(elements.actualswatch)) {
					  if (elements.actualswatch) {
						elements.actualswatch.removeClass('actual');
					  }
					  elements.actualswatch = currentswatch;
					  currentswatch.addClass('actual');
					}
				  }
				});
			
				if (!found) {
				  if (elements.actualswatch) {
					elements.actualswatch.removeClass('actual');
					elements.actualswatch = false;
				  }
				}
			
				if (elements.actualswatch) {
				  elements.swatches_add.prop('disabled', true);
				}
				else {
				  elements.swatches_add.prop('disabled', false);
				}
			  }
			
			function storeSwatches() {
				try {
				  localStorage.setItem(settings.localStoragePrefix+'-gradientswatches', JSON.stringify(swatches));
				}
				catch (err) {
				}
			  }
			function storeCssSwatches(mostrecent) {
				  if(mostrecent)
					{
					try {
					  localStorage.setItem(settings.localStoragePrefix+'-cssgradientswatches-mostrecent', mostrecent);
					}
					catch (err) {
						console.log(err);
					}	
					}
				else
					{
					try {
					  localStorage.setItem(settings.localStoragePrefix+'-cssgradientswatches', JSON.stringify(cssSwatches));
					}
					catch (err) {
						console.log(err);
					}
					}
			  }
			  function getMostRecent() {
				  var mostrecent;
				  try {
					  mostrecent = localStorage.getItem(settings.localStoragePrefix+'-cssgradientswatches-mostrecent');
					}
					catch (err) {
						console.log('couldnt get most recent');
						console.log(err);
					}	
				return mostrecent;
			  }
			
			function gradientSwatchIsUnique(gradient) {
				return (swatches.indexOf(gradient) === -1 && swatches.indexOf(convertToNewGradientFormat(gradient)) === -1);
			  }
			  
			function gradientCssSwatchIsUnique(gradient) {
				return (cssSwatches.indexOf(gradient) === -1);
			  }
			
			function addCurrentGradientToSwatches() {
				addCssGradientToSwatches(currentgradient);
			  }
			  
			function addCssGradientToSwatches(gradient) {
			
				if (!gradientCssSwatchIsUnique(gradient)) {
				  return false;
				}
			
				cssSwatches.unshift(gradient);
			
				storeCssSwatches();
			
				thiscontainer.trigger('icsgradienteditor.changeswatches');//triggers rendercssswatches
			  }
			
			  //function to import gradient from pasted css or from the 'set' method
			  //now this could also be an object from ics2 including other background properties
			  function importCssGradient(importSettings){
				  //handle dirty input by exploding on ';'
				  //then get the actual css by exploding each on ':'
				  //then search for various prefixed versions- ideally we want noprefix
				  var cssrules = [], stylerules = [], csstoparse = '', bgProps;
				  if(importSettings)
					{
					if(typeof importSettings === 'object')
						{
						if(importSettings['background-image'] != '')
							{
							cssrules.push(importSettings['background-image']);
							}
						else
							{
							cssrules = '';
							}
						}
					else
						{
						cssrules = importSettings.split(';');
						}
					if(cssrules != '')
						{
						jQuery.each(cssrules, function(index, value){
							var thisval = value;
							if(thisval.indexOf(':') > -1)
								{
								thisval = thisval.split(':')[1];	
								}
							stylerules.push(thisval.trim());
						});
						jQuery.each(stylerules, function(index, value){
							var thisval = value;
							//we will assume the last one is the best one to use
							if(thisval.indexOf('-gradient') > -1)
								{
								csstoparse = thisval;	
								}
						});
						}
					}
					if(csstoparse != '')
					{
					var parsed = '';
					parsed = parseGradient(csstoparse);
					if(!parsed)
						{
						alert('Sorry I was unable to parse that css, please try again.');	
						}
					else
						{
						thiscontainer.find('.ics-ge-optionbox.open').removeClass('open');
						if(typeof importSettings === 'object')
							{
							bgProps = importSettings;	
							}
						loadGradient(csstoparse, bgProps);
						}
					}
				else //we need to set the controls back to their empty settings
					{
					var mostRecent = getMostRecent();
					if(opts.startingGradient && parseGradient(opts.startingGradient))
						{
						loadGradient(opts.startingGradient);
						}
					else if(mostRecent)
						{
						loadGradient(mostRecent);
						}
					else 
						{
					  	loadGradient(opts.defaultGradient);
						}	
					}
			  }
			  //loads a bg image from the set function requires an object of background-* properties
			  function importBgImg(importSettings) {
			  	  var bgImg = importSettings['background-image'] ? importSettings['background-image'] : 'none', bgProps = importSettings;
				  initData(bgImg, bgProps);
				  updateVisibleOptions();
				  updateInputValues();
				  initControllers();
				  renderOutput();
			  }
			  
			  function oldWebkitCompatible(dataset) {
				if (getPreference('gradient_type', dataset) === 'linear') {
				  return true;
				}
			
				if (getPreference('gradient_shape', dataset) === 'ellipse') {
				  return false;
				}
			
				if (getPreference('gradient_size', dataset) !== 'explicit') {
				  return false;
				}
			
				return true;
			  }
			  
			function detectGradientMode() {
				var testelement = document.createElement('detectGradientSupport').style;
		
				try {
					testelement.backgroundImage = "linear-gradient(to top left, #9f9, white)";
					if (testelement.backgroundImage.indexOf("gradient") !== -1) {
						return "noprefix";
					}
		
					testelement.backgroundImage = "-webkit-linear-gradient(left top, #9f9, white)";
					if (testelement.backgroundImage.indexOf("gradient") !== -1) {
						return "webkit";
					}
		
					testelement.backgroundImage = "-ms-linear-gradient(left top, #9f9, white)";
					if (testelement.backgroundImage.indexOf("gradient") !== -1) {
						return "ms";
					}
		
					testelement.backgroundImage = "-webkit-gradient(linear, left top, right bottom, from(#9f9), to(white))";
					if (testelement.backgroundImage.indexOf("gradient") !== -1) {
						return "oldwebkit";
					}
				}
				catch(err) {
					try {
						testelement.filter = "progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff',endColorstr='#000000',GradientType=0)";
						if (testelement.filter.indexOf("DXImageTransform") !== -1) {
							return "filter";
						}
					}
					catch(err) {}
				}
		
				return false;
			}
			
			function svgSupported() {
				return !! document.createElementNS && !! document.createElementNS('http://www.w3.org/2000/svg','svg').createSVGRect;
			}
			//end plugin functions
			
			//public methods
			function show() {
				thiscontainer.appendTo(container);
			}
			function hide() {
				console.log('hide');
			}
			function option() {
				console.log('option');
			}
			//TODO really we want this to set any of the configurable options
			function set(settings) {
				if(!settings)
					{
					return false;	
					}
				if(settings.targetElement || settings.targetInputElement || settings.targetBgInputElement)
					{
					if(settings.targetElement)
						{
						opts.targetElement = settings.targetElement;	
						}
					if(settings.targetInputElement)
						{
						opts.targetInputElement = settings.targetInputElement;	
						}
					if(settings.targetBgInputElement)
						{
						opts.targetBgInputElement = settings.targetBgInputElement;	
						}
					setCssTargets();
					}
				if(settings.startingGradient || settings.startingImage || settings.startingBgProps)
					{
					updateInputTargets = false;
					var propsToSet = settings.startingBgProps ? settings.startingBgProps : {};
					if(settings.startingGradient)
						{
						if(opts.mode == 'gradient')
							{
							propsToSet['background-image'] = settings.startingGradient;
							}
						else
							{
							console.log('Could not set starting gradient since this editor instance is not in gradient mode');	
							}
						}
					else if(settings.startingImage)
						{
						if(opts.mode == 'image')
							{
							propsToSet['background-image'] = settings.startingImage;	
							}
						else
							{
							console.log('Could not set starting Image since this editor instance is not in image mode');	
							}	
						}
					if(opts.mode == 'gradient')
						{
						importCssGradient(propsToSet);	
						}
					else
						{
						importBgImg(propsToSet);
						}
					}
				/*updateInputTargets = false;
				if(opts.mode == 'gradient')
					{
					importCssGradient(settings);	
					}
				else
					{
					importBgImg(settings);	
					}*/	
			}
			function setInputs(newInputs) {
				if(!newInputs)
					{
					return false;	
					}
				elements.cssBgInputTarget = newInputs;
				elements.cssInputTarget = newInputs['background-image'];
			}
			function get(json) {
				var returnVals = {},
				requestVals = {},
				thisOpts = opts;
				try {
					requestVals = JSON.parse(json);
				}catch(e)
					{
					if(typeof json === 'array' || typeof json === 'object')
						{
						requestVals = json;	
						}
					else
					returnVals = 'no options found';	
					}
				if(!jQuery.isEmptyObject(requestVals) || typeof requestVals === 'array' )
				jQuery.each(requestVals, function(index, val){
						returnVals[val] = thisOpts[val];
					});
				return returnVals;
			}
			function destroy() {
				container.html('');
			}
			function container() {
				console.log('container');
			}
			init();
			gradientAutosave = true;
			var icsge = {
				show: show,
				hide: hide,
				option: option,
				set: function (g) {
					set(g);
				},
				setInputs: function (g) {
					setInputs(g);
				},
				get: function (json) {
					return get(json);
				},
				destroy: destroy,
				container: container
			};
	
			icsge.id = icsges.push(icsge) - 1;
	
			return icsge;
				
		}//end icsge function
		/**
		* noop - do nothing
		*/
		function noop() {
			
		}
		/**
		* Create a function bound to a given object
		* Thanks to underscore.js
		*/
		function bind(func, obj) {
			var slice = Array.prototype.slice;
			var args = slice.call(arguments, 2);
			return function () {
				return func.apply(obj, args.concat(slice.call(arguments)));
			};
		}
		
		function replaceAll(find, replace, str) {
			return str.replace(new RegExp(find, 'g'), replace);
		  } 
		  
		function getDegreeFromDistance(xd, yd) {
				if (yd >= 0) {
				  return Math.atan2(yd, xd) * 180 / Math.PI;
				}
				else {
				  return 360 + Math.atan2(yd, xd) * 180 / Math.PI;
				}
			  }
		
		function getEventCoordinates(ev) {
			if (typeof ev.pageX !== 'undefined') {
			  return {
				pageX: ev.pageX,
				pageY: ev.pageY
			  };
			}
			else if (typeof ev.originalEvent !== 'undefined' && typeof ev.originalEvent.touches !== 'undefined') {
			  return {
				pageX: ev.originalEvent.touches[0].pageX,
				pageY: ev.originalEvent.touches[0].pageY
			  };
			}
			else {
			  return false;
			}
		  }
		  
		function calculateEventPosition(ev, containerElement) {
			var c = getEventCoordinates(ev);
		
			var sizeX = containerElement.width(),
				offsetX = c.pageX - containerElement.offset().left,
				sizeY = containerElement.height(),
				offsetY = c.pageY - containerElement.offset().top;
		
			var percentX = offsetX / sizeX * 100,
				percentY = offsetY / sizeY * 100;
		
			if (percentX < 0) {
			  percentX = 0;
			}
		
			if (percentX > 100) {
			  percentX = 100;
			}
		
			if (percentY < 0) {
			  percentY = 0;
			}
		
			if (percentY > 100) {
			  percentY = 100;
			}
		
			return {
			  horizontal: {
				percent: percentX,
				pixel: offsetX
			  },
			  vertical: {
				percent: percentY,
				pixel: offsetY
			  }
			};
		  }
		function getCoordsForAngle(angle) {
			var xs, ys,
				tan = Math.round(Math.tan(angle % 45 * Math.PI / 180) * 50);
		
			var sin = Math.sin((angle - 45) * 4 * Math.PI / 180);
			var maxi = 6 * Math.sqrt(2);
			var modifier = Math.abs(sin * maxi);
		
			if (angle >= 0 && angle < 45) {
			  xs = tan + modifier;
			  ys = -50 - modifier;
			}
			if (angle >= 45 && angle < 90) {
			  xs = 50 + modifier;
			  ys = -50 + tan - modifier;
			}
			if (angle >= 90 && angle < 135) {
			  xs = 50 + modifier;
			  ys = tan + modifier;
			}
			if (angle >= 135 && angle < 180) {
			  xs = 50 - tan + modifier;
			  ys = 50 + modifier;
			}
			if (angle >= 180 && angle < 225) {
			  xs = -tan - modifier;
			  ys = 50 + modifier;
			}
			if (angle >= 225 && angle < 270) {
			  xs = -50 - modifier;
			  ys = 50 - tan + modifier;
			}
			if (angle >= 270 && angle < 315) {
			  xs = -50 - modifier;
			  ys = -tan - modifier;
			}
			if (angle >= 315 && angle < 360) {
			  xs = -50 + tan - modifier;
			  ys = -50 - modifier;
			}
		
			return {
			  xs: xs,
			  ys: ys,
			  x1: Math.round((50 - xs) * 10) / 10 + '%',
			  y1: Math.round((50 - ys) * 10) / 10 + '%',
			  x2: Math.round((50 + xs) * 10) / 10 + '%',
			  y2: Math.round((50 + ys) * 10) / 10 + '%'
			};
		  }
	/**
    * Define a jQuery plugin
    */
    var dataID = "icsge.id";
    $.fn.icsge = function (opts, extra) {

        if (typeof opts == "string") {

            var returnValue = this;
            var args = Array.prototype.slice.call( arguments, 1 );

            this.each(function () {
                var thisicsge = icsges[$(this).data(dataID)];
                
                if (thisicsge) {
                    var method = thisicsge[opts];
                    if (!method) {
                        throw new Error( "icsge: no such method: '" + opts + "'" );
                    }

                    if (opts == "get") {
                        returnValue = thisicsge.get(args);

                    }
                    else if (opts == "container") {
                        returnValue = thisicsge.container;
                    }
                    else if (opts == "option") {
                        returnValue = thisicsge.option.apply(thisicsge, args);
                    }
                    else if (opts == "destroy") {
                        thisicsge.destroy();
                        $(this).removeData(dataID);
                    }
                    else {
						//thisicsge.show();
                        method.apply(thisicsge, args);
                    }
                }
            });
            return returnValue;
        }

        // Initializing a new instance of spectrum
        return this.icsge("destroy").each(function () {
            var options = $.extend({}, opts, $(this).data());
            var thisicsge = icsge(this, options);
            $(this).data(dataID, thisicsge.id);
        });
    };
	$.fn.icsge.load = true;
    $.fn.icsge.loadOpts = {};
    $.fn.icsge.defaults = defaultOpts;

    $.icsge = { };
    $.icsge.localization = { };
});
/*!=========================================================================
// Copyright (c) 2014 Rafael Caricio. All rights reserved.
// https://github.com/rafaelcaricio/gradient-parser
// The MIT License (MIT)

Copyright (c) 2014 Rafael Carício

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

modified by David O'Sullivan to include parsing for 2015 ellipse syntax
*/
var GradientParser=GradientParser||{};GradientParser.parse=function(){function r(r){var e=new Error(A+": "+r);throw e.source=A,e}function e(){var e=t();return A.length>0&&r("Invalid input not EOF"),e}function t(){return b(n)}function n(){return i("linear-gradient",P.linearGradient,a)||i("repeating-linear-gradient",P.repeatingLinearGradient,a)||i("radial-gradient",P.radialGradient,c)||i("repeating-radial-gradient",P.repeatingRadialGradient,c)}function i(e,t,n){return o(t,function(){var t=n();return t&&(O(P.comma)||r("Missing comma before color stops")),{type:e,orientation:t,colorStops:b(h)}})}function o(e,t){var n=O(e);return n?(O(P.startCall)||r("Missing ("),result=t(n),O(P.endCall)||r("Missing )"),result):void 0}function a(){return u()||l()}function u(){return M("directional",P.sideOrCorner,1)}function l(){return M("angular",P.angleValue,1)}function c(){var r,e,t=s();return t&&(r=[],r.push(t),e=A,O(P.comma)&&(t=s(),t?r.push(t):A=e)),r}function s(){var r=f()||d();if(r)r.at=p();else{var e=m();e&&(r={type:"default-radial",at:e})}return r}function f(){var r=M("shape",/^(circle)/i,0);return r&&(r.style=K()||g()),r}function d(){var r=M("shape",/^(ellipse)/i,0);return r&&(r.style=m()||k()||g()),r}function g(){return M("extent-keyword",P.extentKeywords,1)}function p(){if(M("position",/^at/,0)){var e=m();return e||r("Missing positioning value"),e}}function m(){var r=v();return r.x||r.y?{type:"position",value:r}:void 0}function v(){return{x:k(),y:k()}}function b(e){var t=e(),n=[];if(t)for(n.push(t);O(P.comma);)t=e(),t?n.push(t):r("One extra comma");return n}function h(){var e=x();return e||r("Expected color definition"),e.length=k(),e}function x(){return C()||G()||w()||y()}function y(){return M("literal",P.literalColor,0)}function C(){return M("hex",P.hexColor,1)}function w(){return o(P.rgbColor,function(){return{type:"rgb",value:b(V)}})}function G(){return o(P.rgbaColor,function(){return{type:"rgba",value:b(V)}})}function V(){return O(P.number)[1]}function k(){return M("%",P.percentageValue,1)||z()||K()}function z(){return M("position-keyword",P.positionKeywords,1)}function K(){return M("px",P.pixelValue,1)||M("em",P.emValue,1)}function M(r,e,t){var n=O(e);return n?{type:r,value:n[t]}:void 0}function O(r){var e,t;return t=/^[\n\r\t\s]+/.exec(A),t&&E(t[0].length),e=r.exec(A),e&&E(e[0].length),e}function E(r){A=A.substr(r)}var P={linearGradient:/^(\-(webkit|o|ms|moz)\-)?(linear\-gradient)/i,repeatingLinearGradient:/^(\-(webkit|o|ms|moz)\-)?(repeating\-linear\-gradient)/i,radialGradient:/^(\-(webkit|o|ms|moz)\-)?(radial\-gradient)/i,repeatingRadialGradient:/^(\-(webkit|o|ms|moz)\-)?(repeating\-radial\-gradient)/i,sideOrCorner:/^to (left (top|bottom)|right (top|bottom)|top (right|left)|bottom (right|left)|left|right|top|bottom)/i,extentKeywords:/^(closest\-side|closest\-corner|farthest\-side|farthest\-corner|contain|cover)/,positionKeywords:/^(left|center|right|top|bottom)/i,pixelValue:/^(-?(([0-9]*\.[0-9]+)|([0-9]+\.?)))px/,percentageValue:/^(-?(([0-9]*\.[0-9]+)|([0-9]+\.?)))\%/,emValue:/^(-?(([0-9]*\.[0-9]+)|([0-9]+\.?)))em/,angleValue:/^(-?(([0-9]*\.[0-9]+)|([0-9]+\.?)))deg/,startCall:/^\(/,endCall:/^\)/,comma:/^,/,hexColor:/^\#([0-9a-fA-F]+)/,literalColor:/^([a-zA-Z]+)/,rgbColor:/^rgb/i,rgbaColor:/^rgba/i,number:/^(([0-9]*\.[0-9]+)|([0-9]+\.?))/},A="";return function(r){return A=r.toString(),e()}}();



/*!=========================================================================
 *  Bootstrap TouchSpin
 *  v2.6.2
 *
 *  A mobile and touch friendly input spinner component for Bootstrap 3.
 *
 *      https://github.com/istvan-meszaros/bootstrap-touchspin
 *      http://www.virtuosoft.eu/code/bootstrap-touchspin/
 *
 *  Copyright 2013 István Ujj-Mészáros
 *
 *  Thanks for the contributors:
 *      Stefan Bauer - https://github.com/sba
 *      amid2887 - https://github.com/amid2887
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *
* ====================================================================== */

/*
 *  Bootstrap TouchSpin - v3.0.1
 *  A mobile and touch friendly input spinner component for Bootstrap 3.
 *  http://www.virtuosoft.eu/code/bootstrap-touchspin/
 *
 *  Made by István Ujj-Mészáros
 *  Under Apache License v2.0 License
 */
!function(a){"use strict";function b(a,b){return a+".touchspin_"+b}function c(c,d){return a.map(c,function(a){return b(a,d)})}var d=0;a.fn.TouchSpin=function(b){if("destroy"===b)return void this.each(function(){var b=a(this),d=b.data();a(document).off(c(["mouseup","touchend","touchcancel","mousemove","touchmove","scroll","scrollstart"],d.spinnerid).join(" "))});var e={min:0,max:100,initval:"",step:1,decimals:0,stepinterval:100,forcestepdivisibility:"round",stepintervaldelay:500,verticalbuttons:!1,verticalupclass:"glyphicon glyphicon-chevron-up",verticaldownclass:"glyphicon glyphicon-chevron-down",prefix:"",postfix:"",prefix_extraclass:"",postfix_extraclass:"",booster:!0,boostat:10,maxboostedstep:!1,mousewheel:!0,buttondown_class:"btn btn-default",buttonup_class:"btn btn-default",buttondown_txt:"-",buttonup_txt:"+"},f={min:"min",max:"max",initval:"init-val",step:"step",decimals:"decimals",stepinterval:"step-interval",verticalbuttons:"vertical-buttons",verticalupclass:"vertical-up-class",verticaldownclass:"vertical-down-class",forcestepdivisibility:"force-step-divisibility",stepintervaldelay:"step-interval-delay",prefix:"prefix",postfix:"postfix",prefix_extraclass:"prefix-extra-class",postfix_extraclass:"postfix-extra-class",booster:"booster",boostat:"boostat",maxboostedstep:"max-boosted-step",mousewheel:"mouse-wheel",buttondown_class:"button-down-class",buttonup_class:"button-up-class",buttondown_txt:"button-down-txt",buttonup_txt:"button-up-txt"};return this.each(function(){function g(){if(!J.data("alreadyinitialized")){if(J.data("alreadyinitialized",!0),d+=1,J.data("spinnerid",d),!J.is("input"))return void console.log("Must be an input.");j(),h(),u(),m(),p(),q(),r(),s(),D.input.css("display","block")}}function h(){""!==B.initval&&""===J.val()&&J.val(B.initval)}function i(a){l(a),u();var b=D.input.val();""!==b&&(b=Number(D.input.val()),D.input.val(b.toFixed(B.decimals)))}function j(){B=a.extend({},e,K,k(),b)}function k(){var b={};return a.each(f,function(a,c){var d="bts-"+c;J.is("[data-"+d+"]")&&(b[a]=J.data(d))}),b}function l(b){B=a.extend({},B,b)}function m(){var a=J.val(),b=J.parent();""!==a&&(a=Number(a).toFixed(B.decimals)),J.data("initvalue",a).val(a),J.addClass("form-control"),b.hasClass("input-group")?n(b):o()}function n(b){b.addClass("bootstrap-touchspin");var c,d,e=J.prev(),f=J.next(),g='<span class="input-group-addon bootstrap-touchspin-prefix">'+B.prefix+"</span>",h='<span class="input-group-addon bootstrap-touchspin-postfix">'+B.postfix+"</span>";e.hasClass("input-group-btn")?(c='<button class="'+B.buttondown_class+' bootstrap-touchspin-down" type="button">'+B.buttondown_txt+"</button>",e.append(c)):(c='<span class="input-group-btn"><button class="'+B.buttondown_class+' bootstrap-touchspin-down" type="button">'+B.buttondown_txt+"</button></span>",a(c).insertBefore(J)),f.hasClass("input-group-btn")?(d='<button class="'+B.buttonup_class+' bootstrap-touchspin-up" type="button">'+B.buttonup_txt+"</button>",f.prepend(d)):(d='<span class="input-group-btn"><button class="'+B.buttonup_class+' bootstrap-touchspin-up" type="button">'+B.buttonup_txt+"</button></span>",a(d).insertAfter(J)),a(g).insertBefore(J),a(h).insertAfter(J),C=b}function o(){var b;b=B.verticalbuttons?'<div class="input-group bootstrap-touchspin"><span class="input-group-addon bootstrap-touchspin-prefix">'+B.prefix+'</span><span class="input-group-addon bootstrap-touchspin-postfix">'+B.postfix+'</span><span class="input-group-btn-vertical"><button class="'+B.buttondown_class+' bootstrap-touchspin-up" type="button"><i class="'+B.verticalupclass+'"></i></button><button class="'+B.buttonup_class+' bootstrap-touchspin-down" type="button"><i class="'+B.verticaldownclass+'"></i></button></span></div>':'<div class="input-group bootstrap-touchspin"><span class="input-group-btn"><button class="'+B.buttondown_class+' bootstrap-touchspin-down" type="button">'+B.buttondown_txt+'</button></span><span class="input-group-addon bootstrap-touchspin-prefix">'+B.prefix+'</span><span class="input-group-addon bootstrap-touchspin-postfix">'+B.postfix+'</span><span class="input-group-btn"><button class="'+B.buttonup_class+' bootstrap-touchspin-up" type="button">'+B.buttonup_txt+"</button></span></div>",C=a(b).insertBefore(J),a(".bootstrap-touchspin-prefix",C).after(J),J.hasClass("input-sm")?C.addClass("input-group-sm"):J.hasClass("input-lg")&&C.addClass("input-group-lg")}function p(){D={down:a(".bootstrap-touchspin-down",C),up:a(".bootstrap-touchspin-up",C),input:a("input",C),prefix:a(".bootstrap-touchspin-prefix",C).addClass(B.prefix_extraclass),postfix:a(".bootstrap-touchspin-postfix",C).addClass(B.postfix_extraclass)}}function q(){""===B.prefix&&D.prefix.hide(),""===B.postfix&&D.postfix.hide()}function r(){J.on("keydown",function(a){var b=a.keyCode||a.which;38===b?("up"!==M&&(w(),z()),a.preventDefault()):40===b&&("down"!==M&&(x(),y()),a.preventDefault())}),J.on("keyup",function(a){var b=a.keyCode||a.which;38===b?A():40===b&&A()}),J.on("blur",function(){u()}),D.down.on("keydown",function(a){var b=a.keyCode||a.which;(32===b||13===b)&&("down"!==M&&(x(),y()),a.preventDefault())}),D.down.on("keyup",function(a){var b=a.keyCode||a.which;(32===b||13===b)&&A()}),D.up.on("keydown",function(a){var b=a.keyCode||a.which;(32===b||13===b)&&("up"!==M&&(w(),z()),a.preventDefault())}),D.up.on("keyup",function(a){var b=a.keyCode||a.which;(32===b||13===b)&&A()}),D.down.on("mousedown.touchspin",function(a){D.down.off("touchstart.touchspin"),J.is(":disabled")||(x(),y(),a.preventDefault(),a.stopPropagation())}),D.down.on("touchstart.touchspin",function(a){D.down.off("mousedown.touchspin"),J.is(":disabled")||(x(),y(),a.preventDefault(),a.stopPropagation())}),D.up.on("mousedown.touchspin",function(a){D.up.off("touchstart.touchspin"),J.is(":disabled")||(w(),z(),a.preventDefault(),a.stopPropagation())}),D.up.on("touchstart.touchspin",function(a){D.up.off("mousedown.touchspin"),J.is(":disabled")||(w(),z(),a.preventDefault(),a.stopPropagation())}),D.up.on("mouseout touchleave touchend touchcancel",function(a){M&&(a.stopPropagation(),A())}),D.down.on("mouseout touchleave touchend touchcancel",function(a){M&&(a.stopPropagation(),A())}),D.down.on("mousemove touchmove",function(a){M&&(a.stopPropagation(),a.preventDefault())}),D.up.on("mousemove touchmove",function(a){M&&(a.stopPropagation(),a.preventDefault())}),a(document).on(c(["mouseup","touchend","touchcancel"],d).join(" "),function(a){M&&(a.preventDefault(),A())}),a(document).on(c(["mousemove","touchmove","scroll","scrollstart"],d).join(" "),function(a){M&&(a.preventDefault(),A())}),J.on("mousewheel DOMMouseScroll",function(a){if(B.mousewheel&&J.is(":focus")){var b=a.originalEvent.wheelDelta||-a.originalEvent.deltaY||-a.originalEvent.detail;a.stopPropagation(),a.preventDefault(),0>b?x():w()}})}function s(){J.on("touchspin.uponce",function(){A(),w()}),J.on("touchspin.downonce",function(){A(),x()}),J.on("touchspin.startupspin",function(){z()}),J.on("touchspin.startdownspin",function(){y()}),J.on("touchspin.stopspin",function(){A()}),J.on("touchspin.updatesettings",function(a,b){i(b)})}function t(a){switch(B.forcestepdivisibility){case"round":return(Math.round(a/B.step)*B.step).toFixed(B.decimals);case"floor":return(Math.floor(a/B.step)*B.step).toFixed(B.decimals);case"ceil":return(Math.ceil(a/B.step)*B.step).toFixed(B.decimals);default:return a}}function u(){var a,b,c;a=J.val(),""!==a&&(B.decimals>0&&"."===a||(b=parseFloat(a),isNaN(b)&&(b=0),c=b,b.toString()!==a&&(c=b),b<B.min&&(c=B.min),b>B.max&&(c=B.max),c=t(c),Number(a).toString()!==c.toString()&&(J.val(c),J.trigger("change"))))}function v(){if(B.booster){var a=Math.pow(2,Math.floor(L/B.boostat))*B.step;return B.maxboostedstep&&a>B.maxboostedstep&&(a=B.maxboostedstep,E=Math.round(E/a)*a),Math.max(B.step,a)}return B.step}function w(){u(),E=parseFloat(D.input.val()),isNaN(E)&&(E=0);var a=E,b=v();E+=b,E>B.max&&(E=B.max,J.trigger("touchspin.on.max"),A()),D.input.val(Number(E).toFixed(B.decimals)),a!==E&&J.trigger("change")}function x(){u(),E=parseFloat(D.input.val()),isNaN(E)&&(E=0);var a=E,b=v();E-=b,E<B.min&&(E=B.min,J.trigger("touchspin.on.min"),A()),D.input.val(E.toFixed(B.decimals)),a!==E&&J.trigger("change")}function y(){A(),L=0,M="down",J.trigger("touchspin.on.startspin"),J.trigger("touchspin.on.startdownspin"),H=setTimeout(function(){F=setInterval(function(){L++,x()},B.stepinterval)},B.stepintervaldelay)}function z(){A(),L=0,M="up",J.trigger("touchspin.on.startspin"),J.trigger("touchspin.on.startupspin"),I=setTimeout(function(){G=setInterval(function(){L++,w()},B.stepinterval)},B.stepintervaldelay)}function A(){switch(clearTimeout(H),clearTimeout(I),clearInterval(F),clearInterval(G),M){case"up":J.trigger("touchspin.on.stopupspin"),J.trigger("touchspin.on.stopspin");break;case"down":J.trigger("touchspin.on.stopdownspin"),J.trigger("touchspin.on.stopspin")}L=0,M=!1}var B,C,D,E,F,G,H,I,J=a(this),K=J.data(),L=0,M=!1;g()})}}(jQuery);

/*!
 * jquery.base64.js 0.0.3 - https://github.com/yckart/jquery.base64.js
 * Makes Base64 en & -decoding simpler as it is.
 *
 * Based upon: https://gist.github.com/Yaffle/1284012
 *
 * Copyright (c) 2012 Yannick Albert (http://yckart.com)
 * Licensed under the MIT license (http://www.opensource.org/licenses/mit-license.php).
 * 2013/02/10
 **/
 "use strict";jQuery.base64=(function($){var _PADCHAR="=",_ALPHA="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",_VERSION="1.0";function _getbyte64(s,i){var idx=_ALPHA.indexOf(s.charAt(i));if(idx===-1){throw"Cannot decode base64"}return idx}function _decode(s){var pads=0,i,b10,imax=s.length,x=[];s=String(s);if(imax===0){return s}if(imax%4!==0){throw"Cannot decode base64"}if(s.charAt(imax-1)===_PADCHAR){pads=1;if(s.charAt(imax-2)===_PADCHAR){pads=2}imax-=4}for(i=0;i<imax;i+=4){b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6)|_getbyte64(s,i+3);x.push(String.fromCharCode(b10>>16,(b10>>8)&255,b10&255))}switch(pads){case 1:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12)|(_getbyte64(s,i+2)<<6);x.push(String.fromCharCode(b10>>16,(b10>>8)&255));break;case 2:b10=(_getbyte64(s,i)<<18)|(_getbyte64(s,i+1)<<12);x.push(String.fromCharCode(b10>>16));break}return x.join("")}function _getbyte(s,i){var x=s.charCodeAt(i);if(x>255){throw"INVALID_CHARACTER_ERR: DOM Exception 5"}return x}function _encode(s){if(arguments.length!==1){throw"SyntaxError: exactly one argument required"}s=String(s);var i,b10,x=[],imax=s.length-s.length%3;if(s.length===0){return s}for(i=0;i<imax;i+=3){b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8)|_getbyte(s,i+2);x.push(_ALPHA.charAt(b10>>18));x.push(_ALPHA.charAt((b10>>12)&63));x.push(_ALPHA.charAt((b10>>6)&63));x.push(_ALPHA.charAt(b10&63))}switch(s.length-imax){case 1:b10=_getbyte(s,i)<<16;x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&63)+_PADCHAR+_PADCHAR);break;case 2:b10=(_getbyte(s,i)<<16)|(_getbyte(s,i+1)<<8);x.push(_ALPHA.charAt(b10>>18)+_ALPHA.charAt((b10>>12)&63)+_ALPHA.charAt((b10>>6)&63)+_PADCHAR);break}return x.join("")}return{decode:_decode,encode:_encode,VERSION:_VERSION}}(jQuery));
 
// Spectrum Colorpicker v1.6.1
// https://github.com/bgrins/spectrum
// Author: Brian Grinstead
// License: MIT

!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports&&"object"==typeof module?module.exports=t:t(jQuery)}(function(t,e){"use strict";function r(e,r,a,n){for(var i=[],s=0;s<e.length;s++){var o=e[s];if(o){var l=tinycolor(o),c=l.toHsl().l<.5?"sp-thumb-el sp-thumb-dark":"sp-thumb-el sp-thumb-light";c+=tinycolor.equals(r,o)?" sp-thumb-active":"";var f=l.toString(n.preferredFormat||"rgb"),u=b?"background-color:"+l.toRgbString():"filter:"+l.toFilter();i.push('<span title="'+f+'" data-color="'+l.toRgbString()+'" class="'+c+'"><span class="sp-thumb-inner" style="'+u+';" /></span>')}else{var h="sp-clear-display";i.push(t("<div />").append(t('<span data-color="" style="background-color:transparent;" class="'+h+'"></span>').attr("title",n.noColorSelectedText)).html())}}return"<div class='sp-cf "+a+"'>"+i.join("")+"</div>"}function a(){for(var t=0;t<p.length;t++)p[t]&&p[t].hide()}function n(e,r){var a=t.extend({},d,e);return a.callbacks={move:c(a.move,r),change:c(a.change,r),show:c(a.show,r),hide:c(a.hide,r),beforeShow:c(a.beforeShow,r)},a}function i(i,o){function c(){if($.showPaletteOnly&&($.showPalette=!0),je.text($.showPaletteOnly?$.togglePaletteMoreText:$.togglePaletteLessText),$.palette){ue=$.palette.slice(0),he=t.isArray(ue[0])?ue:[ue],de={};for(var e=0;e<he.length;e++)for(var r=0;r<he[e].length;r++){var a=tinycolor(he[e][r]).toRgbString();de[a]=!0}}_e.toggleClass("sp-flat",W),_e.toggleClass("sp-input-disabled",!$.showInput),_e.toggleClass("sp-alpha-enabled",$.showAlpha),_e.toggleClass("sp-clear-enabled",Ge),_e.toggleClass("sp-buttons-disabled",!$.showButtons),_e.toggleClass("sp-palette-buttons-disabled",!$.togglePaletteOnly),_e.toggleClass("sp-palette-disabled",!$.showPalette),_e.toggleClass("sp-palette-only",$.showPaletteOnly),_e.toggleClass("sp-initial-disabled",!$.showInitial),_e.addClass($.className).addClass($.containerClassName),I()}function d(){function e(e){return e.data&&e.data.ignore?(T(t(e.target).closest(".sp-thumb-el").data("color")),E()):(T(t(e.target).closest(".sp-thumb-el").data("color")),E(),D(!0),$.hideAfterPaletteSelect&&H()),!1}if(g&&_e.find("*:not(input)").attr("unselectable","on"),c(),Ie&&ye.after(ze).hide(),Ge||Ne.hide(),W)ye.after(_e).hide();else{var r="parent"===$.appendTo?ye.parent():t($.appendTo);1!==r.length&&(r=t("body")),r.append(_e)}y(),Be.bind("click.spectrum touchstart.spectrum",function(e){we||A(),e.stopPropagation(),t(e.target).is("input")||e.preventDefault()}),(ye.is(":disabled")||$.disabled===!0)&&K(),_e.click(l),He.change(P),He.bind("paste",function(){setTimeout(P,1)}),He.keydown(function(t){13==t.keyCode&&P()}),Oe.text($.cancelText),Oe.bind("click.spectrum",function(t){t.stopPropagation(),t.preventDefault(),F(),H()}),Ne.attr("title",$.clearText),Ne.bind("click.spectrum",function(t){t.stopPropagation(),t.preventDefault(),Ye=!0,E(),W&&D(!0)}),Ee.text($.chooseText),Ee.bind("click.spectrum",function(t){t.stopPropagation(),t.preventDefault(),g&&He.is(":focus")&&He.trigger("change"),N()&&(D(!0),H())}),je.text($.showPaletteOnly?$.togglePaletteMoreText:$.togglePaletteLessText),je.bind("click.spectrum",function(t){t.stopPropagation(),t.preventDefault(),$.showPaletteOnly=!$.showPaletteOnly,$.showPaletteOnly||W||_e.css("left","-="+(xe.outerWidth(!0)+5)),c()}),f(Me,function(t,e,r){fe=t/ne,Ye=!1,r.shiftKey&&(fe=Math.round(10*fe)/10),E()},S,C),f(Ce,function(t,e){oe=parseFloat(e/re),Ye=!1,$.showAlpha||(fe=1),E()},S,C),f(ke,function(t,e,r){if(r.shiftKey){if(!ve){var a=le*Z,n=te-ce*te,i=Math.abs(t-a)>Math.abs(e-n);ve=i?"x":"y"}}else ve=null;var s=!ve||"x"===ve,o=!ve||"y"===ve;s&&(le=parseFloat(t/Z)),o&&(ce=parseFloat((te-e)/te)),Ye=!1,$.showAlpha||(fe=1),E()},S,C),Ke?(T(Ke),j(),We=$e||tinycolor(Ke).format,w(Ke)):j(),W&&M();var a=g?"mousedown.spectrum":"click.spectrum touchstart.spectrum";Fe.delegate(".sp-thumb-el",a,e),Te.delegate(".sp-thumb-el:nth-child(1)",a,{ignore:!0},e)}function y(){if(Y&&window.localStorage){try{var e=window.localStorage[Y].split(",#");e.length>1&&(delete window.localStorage[Y],t.each(e,function(t,e){w(e)}))}catch(r){}try{pe=window.localStorage[Y].split(";")}catch(r){}}}function w(e){if(X){var r=tinycolor(e).toRgbString();if(!de[r]&&-1===t.inArray(r,pe))for(pe.push(r);pe.length>ge;)pe.shift();if(Y&&window.localStorage)try{window.localStorage[Y]=pe.join(";")}catch(a){}}}function _(){var t=[];if($.showPalette)for(var e=0;e<pe.length;e++){var r=tinycolor(pe[e]).toRgbString();de[r]||t.push(pe[e])}return t.reverse().slice(0,$.maxSelectionSize)}function x(){var e=O(),a=t.map(he,function(t,a){return r(t,e,"sp-palette-row sp-palette-row-"+a,$)});y(),pe&&a.push(r(_(),e,"sp-palette-row sp-palette-row-selection",$)),Fe.html(a.join(""))}function k(){if($.showInitial){var t=Ve,e=O();Te.html(r([t,e],e,"sp-palette-row-initial",$))}}function S(){(0>=te||0>=Z||0>=re)&&I(),_e.addClass(be),ve=null,ye.trigger("dragstart.spectrum",[O()])}function C(){_e.removeClass(be),ye.trigger("dragstop.spectrum",[O()])}function P(){var t=He.val();if(null!==t&&""!==t||!Ge){var e=tinycolor(t);e.isValid()?(T(e),D(!0)):He.addClass("sp-validation-error")}else T(null),D(!0)}function A(){U?H():M()}function M(){var e=t.Event("beforeShow.spectrum");return U?void I():(ye.trigger(e,[O()]),void(Q.beforeShow(O())===!1||e.isDefaultPrevented()||(a(),U=!0,t(me).bind("click.spectrum",R),t(window).bind("resize.spectrum",J),ze.addClass("sp-active"),_e.removeClass("sp-hidden"),I(),j(),Ve=O(),k(),Q.show(Ve),ye.trigger("show.spectrum",[Ve]))))}function R(t){2!=t.button&&(Xe?D(!0):F(),H())}function H(){U&&!W&&(U=!1,t(me).unbind("click.spectrum",R),t(window).unbind("resize.spectrum",J),ze.removeClass("sp-active"),_e.addClass("sp-hidden"),Q.hide(O()),ye.trigger("hide.spectrum",[O()]))}function F(){T(Ve,!0)}function T(t,e){if(tinycolor.equals(t,O()))return void j();var r,a;!t&&Ge?Ye=!0:(Ye=!1,r=tinycolor(t),a=r.toHsv(),oe=a.h%360/360,le=a.s,ce=a.v,fe=a.a),j(),r&&r.isValid()&&!e&&(We=$e||r.getFormat())}function O(t){return t=t||{},Ge&&Ye?null:tinycolor.fromRatio({h:oe,s:le,v:ce,a:Math.round(100*fe)/100},{format:t.format||We})}function N(){return!He.hasClass("sp-validation-error")}function E(){j(),Q.move(O()),ye.trigger("move.spectrum",[O()])}function j(){He.removeClass("sp-validation-error"),q();var t=tinycolor.fromRatio({h:oe,s:1,v:1});ke.css("background-color",t.toHexString());var e=We;1>fe&&(0!==fe||"name"!==e)&&("hex"===e||"hex3"===e||"hex6"===e||"name"===e)&&(e="rgb");var r=O({format:e}),a="";if(Le.removeClass("sp-clear-display"),Le.css("background-color","transparent"),!r&&Ge)Le.addClass("sp-clear-display");else{var n=r.toHexString(),i=r.toRgbString();if(b||1===r.alpha?Le.css("background-color",i):(Le.css("background-color","transparent"),Le.css("filter",r.toFilter())),$.showAlpha){var s=r.toRgb();s.a=0;var o=tinycolor(s).toRgbString(),l="linear-gradient(left, "+o+", "+n+")";g?Ae.css("filter",tinycolor(o).toFilter({gradientType:1},n)):(Ae.css("background","-webkit-"+l),Ae.css("background","-moz-"+l),Ae.css("background","-ms-"+l),Ae.css("background","linear-gradient(to right, "+o+", "+n+")"))}a=r.toString(e)}$.showInput&&He.val(a),$.showPalette&&x(),k()}function q(){var t=le,e=ce;if(Ge&&Ye)Re.hide(),Pe.hide(),Se.hide();else{Re.show(),Pe.show(),Se.show();var r=t*Z,a=te-e*te;r=Math.max(-ee,Math.min(Z-ee,r-ee)),a=Math.max(-ee,Math.min(te-ee,a-ee)),Se.css({top:a+"px",left:r+"px"});var n=fe*ne;Re.css({left:n-ie/2+"px"});var i=oe*re;Pe.css({top:i-se+"px"})}}function D(t){var e=O(),r="",a=!tinycolor.equals(e,Ve);e&&(r=e.toString(We),w(e)),qe&&ye.val(r),t&&a&&(Q.change(e),ye.trigger("change",[e]))}function I(){Z=ke.width(),te=ke.height(),ee=Se.height(),ae=Ce.width(),re=Ce.height(),se=Pe.height(),ne=Me.width(),ie=Re.width(),W||(_e.css("position","absolute"),_e.offset($.offset?$.offset:s(_e,Be))),q(),$.showPalette&&x(),ye.trigger("reflow.spectrum")}function z(){ye.show(),Be.unbind("click.spectrum touchstart.spectrum"),_e.remove(),ze.remove(),p[Qe.id]=null}function B(r,a){return r===e?t.extend({},$):a===e?$[r]:($[r]=a,void c())}function L(){we=!1,ye.attr("disabled",!1),Be.removeClass("sp-disabled")}function K(){H(),we=!0,ye.attr("disabled",!0),Be.addClass("sp-disabled")}function V(t){$.offset=t,I()}var $=n(o,i),W=$.flat,X=$.showSelectionPalette,Y=$.localStorageKey,G=$.theme,Q=$.callbacks,J=u(I,10),U=!1,Z=0,te=0,ee=0,re=0,ae=0,ne=0,ie=0,se=0,oe=0,le=0,ce=0,fe=1,ue=[],he=[],de={},pe=$.selectionPalette.slice(0),ge=$.maxSelectionSize,be="sp-dragging",ve=null,me=i.ownerDocument,ye=(me.body,t(i)),we=!1,_e=t(m,me).addClass(G),xe=_e.find(".sp-picker-container"),ke=_e.find(".sp-color"),Se=_e.find(".sp-dragger"),Ce=_e.find(".sp-hue"),Pe=_e.find(".sp-slider"),Ae=_e.find(".sp-alpha-inner"),Me=_e.find(".sp-alpha"),Re=_e.find(".sp-alpha-handle"),He=_e.find(".sp-input"),Fe=_e.find(".sp-palette"),Te=_e.find(".sp-initial"),Oe=_e.find(".sp-cancel"),Ne=_e.find(".sp-clear"),Ee=_e.find(".sp-choose"),je=_e.find(".sp-palette-toggle"),qe=ye.is("input"),De=qe&&"color"===ye.attr("type")&&h(),Ie=qe&&!W,ze=Ie?t(v).addClass(G).addClass($.className).addClass($.replacerClassName):t([]),Be=Ie?ze:ye,Le=ze.find(".sp-preview-inner"),Ke=$.color||qe&&ye.val(),Ve=!1,$e=$.preferredFormat,We=$e,Xe=!$.showButtons||$.clickoutFiresChange,Ye=!Ke,Ge=$.allowEmpty&&!De;d();var Qe={show:M,hide:H,toggle:A,reflow:I,option:B,enable:L,disable:K,offset:V,set:function(t){T(t),D()},get:O,destroy:z,container:_e};return Qe.id=p.push(Qe)-1,Qe}function s(e,r){var a=0,n=e.outerWidth(),i=e.outerHeight(),s=r.outerHeight(),o=e[0].ownerDocument,l=o.documentElement,c=l.clientWidth+t(o).scrollLeft(),f=l.clientHeight+t(o).scrollTop(),u=r.offset();return u.top+=s,u.left-=Math.min(u.left,u.left+n>c&&c>n?Math.abs(u.left+n-c):0),u.top-=Math.min(u.top,u.top+i>f&&f>i?Math.abs(i+s-a):a),u}function o(){}function l(t){t.stopPropagation()}function c(t,e){var r=Array.prototype.slice,a=r.call(arguments,2);return function(){return t.apply(e,a.concat(r.call(arguments)))}}function f(e,r,a,n){function i(t){t.stopPropagation&&t.stopPropagation(),t.preventDefault&&t.preventDefault(),t.returnValue=!1}function s(t){if(f){if(g&&c.documentMode<9&&!t.button)return l();var a=t.originalEvent&&t.originalEvent.touches&&t.originalEvent.touches[0],n=a&&a.pageX||t.pageX,s=a&&a.pageY||t.pageY,o=Math.max(0,Math.min(n-u.left,d)),b=Math.max(0,Math.min(s-u.top,h));p&&i(t),r.apply(e,[o,b,t])}}function o(r){var n=r.which?3==r.which:2==r.button;n||f||a.apply(e,arguments)!==!1&&(f=!0,h=t(e).height(),d=t(e).width(),u=t(e).offset(),t(c).bind(b),t(c.body).addClass("sp-dragging"),p||s(r),i(r))}function l(){f&&(t(c).unbind(b),t(c.body).removeClass("sp-dragging"),n.apply(e,arguments)),f=!1}r=r||function(){},a=a||function(){},n=n||function(){};var c=document,f=!1,u={},h=0,d=0,p="ontouchstart"in window,b={};b.selectstart=i,b.dragstart=i,b["touchmove mousemove"]=s,b["touchend mouseup"]=l,t(e).bind("touchstart mousedown",o)}function u(t,e,r){var a;return function(){var n=this,i=arguments,s=function(){a=null,t.apply(n,i)};r&&clearTimeout(a),(r||!a)&&(a=setTimeout(s,e))}}function h(){return t.fn.spectrum.inputTypeColorSupport()}var d={beforeShow:o,move:o,change:o,show:o,hide:o,color:!1,flat:!1,showInput:!1,allowEmpty:!1,showButtons:!0,clickoutFiresChange:!1,showInitial:!1,showPalette:!1,showPaletteOnly:!1,hideAfterPaletteSelect:!1,togglePaletteOnly:!1,showSelectionPalette:!0,localStorageKey:!1,appendTo:"body",maxSelectionSize:7,cancelText:"cancel",chooseText:"choose",togglePaletteMoreText:"more",togglePaletteLessText:"less",clearText:"Clear Color Selection",noColorSelectedText:"No Color Selected",preferredFormat:!1,className:"",containerClassName:"",replacerClassName:"",showAlpha:!1,theme:"sp-light",palette:[["#ffffff","#000000","#ff0000","#ff8000","#ffff00","#008000","#0000ff","#4b0082","#9400d3"]],selectionPalette:[],disabled:!1,offset:null},p=[],g=!!/msie/i.exec(window.navigator.userAgent),b=function(){function t(t,e){return!!~(""+t).indexOf(e)}var e=document.createElement("div"),r=e.style;return r.cssText="background-color:rgba(0,0,0,.5)",t(r.backgroundColor,"rgba")||t(r.backgroundColor,"hsla")}(),v=["<div class='sp-replacer'>","<div class='sp-preview'><div class='sp-preview-inner'></div></div>","<div class='sp-dd'>&#9660;</div>","</div>"].join(""),m=function(){var t="";if(g)for(var e=1;6>=e;e++)t+="<div class='sp-"+e+"'></div>";return["<div class='sp-container sp-hidden'>","<div class='sp-palette-container'>","<div class='sp-palette sp-thumb sp-cf'></div>","<div class='sp-palette-button-container sp-cf'>","<button type='button' class='sp-palette-toggle'></button>","</div>","</div>","<div class='sp-picker-container'>","<div class='sp-top sp-cf'>","<div class='sp-fill'></div>","<div class='sp-top-inner'>","<div class='sp-color'>","<div class='sp-sat'>","<div class='sp-val'>","<div class='sp-dragger'></div>","</div>","</div>","</div>","<div class='sp-clear sp-clear-display'>","</div>","<div class='sp-hue'>","<div class='sp-slider'></div>",t,"</div>","</div>","<div class='sp-alpha'><div class='sp-alpha-inner'><div class='sp-alpha-handle'></div></div></div>","</div>","<div class='sp-input-container sp-cf'>","<input class='sp-input' type='text' spellcheck='false'  />","</div>","<div class='sp-initial sp-thumb sp-cf'></div>","<div class='sp-button-container sp-cf'>","<a class='sp-cancel' href='#'></a>","<button type='button' class='sp-choose'></button>","</div>","</div>","</div>"].join("")}(),y="spectrum.id";t.fn.spectrum=function(e){if("string"==typeof e){var r=this,a=Array.prototype.slice.call(arguments,1);return this.each(function(){var n=p[t(this).data(y)];if(n){var i=n[e];if(!i)throw new Error("Spectrum: no such method: '"+e+"'");"get"==e?r=n.get():"container"==e?r=n.container:"option"==e?r=n.option.apply(n,a):"destroy"==e?(n.destroy(),t(this).removeData(y)):i.apply(n,a)}}),r}return this.spectrum("destroy").each(function(){var r=t.extend({},e,t(this).data()),a=i(this,r);t(this).data(y,a.id)})},t.fn.spectrum.load=!0,t.fn.spectrum.loadOpts={},t.fn.spectrum.draggable=f,t.fn.spectrum.defaults=d,t.fn.spectrum.inputTypeColorSupport=function w(){if("undefined"==typeof w._cachedResult){var e=t("<input type='color' value='!' />")[0];w._cachedResult="color"===e.type&&"!"!==e.value}return w._cachedResult},t.spectrum={},t.spectrum.localization={},t.spectrum.palettes={},t.fn.spectrum.processNativeColorInputs=function(){var e=t("input[type=color]");e.length&&!h()&&e.spectrum({preferredFormat:"hex6"})},function(){function t(t){var r={r:0,g:0,b:0},n=1,s=!1,o=!1;return"string"==typeof t&&(t=T(t)),"object"==typeof t&&(t.hasOwnProperty("r")&&t.hasOwnProperty("g")&&t.hasOwnProperty("b")?(r=e(t.r,t.g,t.b),s=!0,o="%"===String(t.r).substr(-1)?"prgb":"rgb"):t.hasOwnProperty("h")&&t.hasOwnProperty("s")&&t.hasOwnProperty("v")?(t.s=R(t.s),t.v=R(t.v),r=i(t.h,t.s,t.v),s=!0,o="hsv"):t.hasOwnProperty("h")&&t.hasOwnProperty("s")&&t.hasOwnProperty("l")&&(t.s=R(t.s),t.l=R(t.l),r=a(t.h,t.s,t.l),s=!0,o="hsl"),t.hasOwnProperty("a")&&(n=t.a)),n=x(n),{ok:s,format:t.format||o,r:D(255,I(r.r,0)),g:D(255,I(r.g,0)),b:D(255,I(r.b,0)),a:n}}function e(t,e,r){return{r:255*k(t,255),g:255*k(e,255),b:255*k(r,255)}}function r(t,e,r){t=k(t,255),e=k(e,255),r=k(r,255);var a,n,i=I(t,e,r),s=D(t,e,r),o=(i+s)/2;if(i==s)a=n=0;else{var l=i-s;switch(n=o>.5?l/(2-i-s):l/(i+s),i){case t:a=(e-r)/l+(r>e?6:0);break;case e:a=(r-t)/l+2;break;case r:a=(t-e)/l+4}a/=6}return{h:a,s:n,l:o}}function a(t,e,r){function a(t,e,r){return 0>r&&(r+=1),r>1&&(r-=1),1/6>r?t+6*(e-t)*r:.5>r?e:2/3>r?t+(e-t)*(2/3-r)*6:t}var n,i,s;if(t=k(t,360),e=k(e,100),r=k(r,100),0===e)n=i=s=r;else{var o=.5>r?r*(1+e):r+e-r*e,l=2*r-o;n=a(l,o,t+1/3),i=a(l,o,t),s=a(l,o,t-1/3)}return{r:255*n,g:255*i,b:255*s}}function n(t,e,r){t=k(t,255),e=k(e,255),r=k(r,255);var a,n,i=I(t,e,r),s=D(t,e,r),o=i,l=i-s;if(n=0===i?0:l/i,i==s)a=0;else{switch(i){case t:a=(e-r)/l+(r>e?6:0);break;case e:a=(r-t)/l+2;break;case r:a=(t-e)/l+4}a/=6}return{h:a,s:n,v:o}}function i(t,e,r){t=6*k(t,360),e=k(e,100),r=k(r,100);var a=j.floor(t),n=t-a,i=r*(1-e),s=r*(1-n*e),o=r*(1-(1-n)*e),l=a%6,c=[r,s,i,i,o,r][l],f=[o,r,r,s,i,i][l],u=[i,i,o,r,r,s][l];return{r:255*c,g:255*f,b:255*u}}function s(t,e,r,a){var n=[M(q(t).toString(16)),M(q(e).toString(16)),M(q(r).toString(16))];return a&&n[0].charAt(0)==n[0].charAt(1)&&n[1].charAt(0)==n[1].charAt(1)&&n[2].charAt(0)==n[2].charAt(1)?n[0].charAt(0)+n[1].charAt(0)+n[2].charAt(0):n.join("")}function o(t,e,r,a){var n=[M(H(a)),M(q(t).toString(16)),M(q(e).toString(16)),M(q(r).toString(16))];return n.join("")}function l(t,e){e=0===e?0:e||10;var r=B(t).toHsl();return r.s-=e/100,r.s=S(r.s),B(r)}function c(t,e){e=0===e?0:e||10;var r=B(t).toHsl();return r.s+=e/100,r.s=S(r.s),B(r)}function f(t){return B(t).desaturate(100)}function u(t,e){e=0===e?0:e||10;var r=B(t).toHsl();return r.l+=e/100,r.l=S(r.l),B(r)}function h(t,e){e=0===e?0:e||10;var r=B(t).toRgb();return r.r=I(0,D(255,r.r-q(255*-(e/100)))),r.g=I(0,D(255,r.g-q(255*-(e/100)))),r.b=I(0,D(255,r.b-q(255*-(e/100)))),B(r)}function d(t,e){e=0===e?0:e||10;var r=B(t).toHsl();return r.l-=e/100,r.l=S(r.l),B(r)}function p(t,e){var r=B(t).toHsl(),a=(q(r.h)+e)%360;return r.h=0>a?360+a:a,B(r)}function g(t){var e=B(t).toHsl();return e.h=(e.h+180)%360,B(e)}function b(t){var e=B(t).toHsl(),r=e.h;return[B(t),B({h:(r+120)%360,s:e.s,l:e.l}),B({h:(r+240)%360,s:e.s,l:e.l})]}function v(t){var e=B(t).toHsl(),r=e.h;return[B(t),B({h:(r+90)%360,s:e.s,l:e.l}),B({h:(r+180)%360,s:e.s,l:e.l}),B({h:(r+270)%360,s:e.s,l:e.l})]}function m(t){var e=B(t).toHsl(),r=e.h;return[B(t),B({h:(r+72)%360,s:e.s,l:e.l}),B({h:(r+216)%360,s:e.s,l:e.l})]}function y(t,e,r){e=e||6,r=r||30;var a=B(t).toHsl(),n=360/r,i=[B(t)];for(a.h=(a.h-(n*e>>1)+720)%360;--e;)a.h=(a.h+n)%360,i.push(B(a));return i}function w(t,e){e=e||6;for(var r=B(t).toHsv(),a=r.h,n=r.s,i=r.v,s=[],o=1/e;e--;)s.push(B({h:a,s:n,v:i})),i=(i+o)%1;return s}function _(t){var e={};for(var r in t)t.hasOwnProperty(r)&&(e[t[r]]=r);return e}function x(t){return t=parseFloat(t),(isNaN(t)||0>t||t>1)&&(t=1),t}function k(t,e){P(t)&&(t="100%");var r=A(t);return t=D(e,I(0,parseFloat(t))),r&&(t=parseInt(t*e,10)/100),j.abs(t-e)<1e-6?1:t%e/parseFloat(e)}function S(t){return D(1,I(0,t))}function C(t){return parseInt(t,16)}function P(t){return"string"==typeof t&&-1!=t.indexOf(".")&&1===parseFloat(t)}function A(t){return"string"==typeof t&&-1!=t.indexOf("%")}function M(t){return 1==t.length?"0"+t:""+t}function R(t){return 1>=t&&(t=100*t+"%"),t}function H(t){return Math.round(255*parseFloat(t)).toString(16)}function F(t){return C(t)/255}function T(t){t=t.replace(O,"").replace(N,"").toLowerCase();var e=!1;if(L[t])t=L[t],e=!0;else if("transparent"==t)return{r:0,g:0,b:0,a:0,format:"name"};var r;return(r=V.rgb.exec(t))?{r:r[1],g:r[2],b:r[3]}:(r=V.rgba.exec(t))?{r:r[1],g:r[2],b:r[3],a:r[4]}:(r=V.hsl.exec(t))?{h:r[1],s:r[2],l:r[3]}:(r=V.hsla.exec(t))?{h:r[1],s:r[2],l:r[3],a:r[4]}:(r=V.hsv.exec(t))?{h:r[1],s:r[2],v:r[3]}:(r=V.hsva.exec(t))?{h:r[1],s:r[2],v:r[3],a:r[4]}:(r=V.hex8.exec(t))?{a:F(r[1]),r:C(r[2]),g:C(r[3]),b:C(r[4]),format:e?"name":"hex8"}:(r=V.hex6.exec(t))?{r:C(r[1]),g:C(r[2]),b:C(r[3]),format:e?"name":"hex"}:(r=V.hex3.exec(t))?{r:C(r[1]+""+r[1]),g:C(r[2]+""+r[2]),b:C(r[3]+""+r[3]),format:e?"name":"hex"}:!1}var O=/^[\s,#]+/,N=/\s+$/,E=0,j=Math,q=j.round,D=j.min,I=j.max,z=j.random,B=function(e,r){if(e=e?e:"",r=r||{},e instanceof B)return e;if(!(this instanceof B))return new B(e,r);var a=t(e);this._originalInput=e,this._r=a.r,this._g=a.g,this._b=a.b,this._a=a.a,this._roundA=q(100*this._a)/100,this._format=r.format||a.format,this._gradientType=r.gradientType,this._r<1&&(this._r=q(this._r)),this._g<1&&(this._g=q(this._g)),this._b<1&&(this._b=q(this._b)),this._ok=a.ok,this._tc_id=E++};B.prototype={isDark:function(){return this.getBrightness()<128},isLight:function(){return!this.isDark()},isValid:function(){return this._ok},getOriginalInput:function(){return this._originalInput},getFormat:function(){return this._format},getAlpha:function(){return this._a},getBrightness:function(){var t=this.toRgb();return(299*t.r+587*t.g+114*t.b)/1e3},setAlpha:function(t){return this._a=x(t),this._roundA=q(100*this._a)/100,this},toHsv:function(){var t=n(this._r,this._g,this._b);return{h:360*t.h,s:t.s,v:t.v,a:this._a}},toHsvString:function(){var t=n(this._r,this._g,this._b),e=q(360*t.h),r=q(100*t.s),a=q(100*t.v);return 1==this._a?"hsv("+e+", "+r+"%, "+a+"%)":"hsva("+e+", "+r+"%, "+a+"%, "+this._roundA+")"},toHsl:function(){var t=r(this._r,this._g,this._b);return{h:360*t.h,s:t.s,l:t.l,a:this._a}},toHslString:function(){var t=r(this._r,this._g,this._b),e=q(360*t.h),a=q(100*t.s),n=q(100*t.l);return 1==this._a?"hsl("+e+", "+a+"%, "+n+"%)":"hsla("+e+", "+a+"%, "+n+"%, "+this._roundA+")"},toHex:function(t){return s(this._r,this._g,this._b,t)},toHexString:function(t){return"#"+this.toHex(t)},toHex8:function(){return o(this._r,this._g,this._b,this._a)},toHex8String:function(){return"#"+this.toHex8()},toRgb:function(){return{r:q(this._r),g:q(this._g),b:q(this._b),a:this._a}},toRgbString:function(){return 1==this._a?"rgb("+q(this._r)+", "+q(this._g)+", "+q(this._b)+")":"rgba("+q(this._r)+", "+q(this._g)+", "+q(this._b)+", "+this._roundA+")"},toPercentageRgb:function(){return{r:q(100*k(this._r,255))+"%",g:q(100*k(this._g,255))+"%",b:q(100*k(this._b,255))+"%",a:this._a}},toPercentageRgbString:function(){return 1==this._a?"rgb("+q(100*k(this._r,255))+"%, "+q(100*k(this._g,255))+"%, "+q(100*k(this._b,255))+"%)":"rgba("+q(100*k(this._r,255))+"%, "+q(100*k(this._g,255))+"%, "+q(100*k(this._b,255))+"%, "+this._roundA+")"},toName:function(){return 0===this._a?"transparent":this._a<1?!1:K[s(this._r,this._g,this._b,!0)]||!1},toFilter:function(t){var e="#"+o(this._r,this._g,this._b,this._a),r=e,a=this._gradientType?"GradientType = 1, ":"";if(t){var n=B(t);r=n.toHex8String()}return"progid:DXImageTransform.Microsoft.gradient("+a+"startColorstr="+e+",endColorstr="+r+")"},toString:function(t){var e=!!t;t=t||this._format;var r=!1,a=this._a<1&&this._a>=0,n=!e&&a&&("hex"===t||"hex6"===t||"hex3"===t||"name"===t);return n?"name"===t&&0===this._a?this.toName():this.toRgbString():("rgb"===t&&(r=this.toRgbString()),"prgb"===t&&(r=this.toPercentageRgbString()),("hex"===t||"hex6"===t)&&(r=this.toHexString()),"hex3"===t&&(r=this.toHexString(!0)),"hex8"===t&&(r=this.toHex8String()),"name"===t&&(r=this.toName()),"hsl"===t&&(r=this.toHslString()),"hsv"===t&&(r=this.toHsvString()),r||this.toHexString())},_applyModification:function(t,e){var r=t.apply(null,[this].concat([].slice.call(e)));return this._r=r._r,this._g=r._g,this._b=r._b,this.setAlpha(r._a),this},lighten:function(){return this._applyModification(u,arguments)},brighten:function(){return this._applyModification(h,arguments)},darken:function(){return this._applyModification(d,arguments)},desaturate:function(){return this._applyModification(l,arguments)},saturate:function(){return this._applyModification(c,arguments)},greyscale:function(){return this._applyModification(f,arguments)},spin:function(){return this._applyModification(p,arguments)},_applyCombination:function(t,e){return t.apply(null,[this].concat([].slice.call(e)))},analogous:function(){return this._applyCombination(y,arguments)},complement:function(){return this._applyCombination(g,arguments)},monochromatic:function(){return this._applyCombination(w,arguments)},splitcomplement:function(){return this._applyCombination(m,arguments)},triad:function(){return this._applyCombination(b,arguments)},tetrad:function(){return this._applyCombination(v,arguments)}},B.fromRatio=function(t,e){if("object"==typeof t){var r={};for(var a in t)t.hasOwnProperty(a)&&(r[a]="a"===a?t[a]:R(t[a]));t=r}return B(t,e)},B.equals=function(t,e){return t&&e?B(t).toRgbString()==B(e).toRgbString():!1},B.random=function(){return B.fromRatio({r:z(),g:z(),b:z()})},B.mix=function(t,e,r){r=0===r?0:r||50;var a,n=B(t).toRgb(),i=B(e).toRgb(),s=r/100,o=2*s-1,l=i.a-n.a;a=o*l==-1?o:(o+l)/(1+o*l),a=(a+1)/2;var c=1-a,f={r:i.r*a+n.r*c,g:i.g*a+n.g*c,b:i.b*a+n.b*c,a:i.a*s+n.a*(1-s)};return B(f)},B.readability=function(t,e){var r=B(t),a=B(e),n=r.toRgb(),i=a.toRgb(),s=r.getBrightness(),o=a.getBrightness(),l=Math.max(n.r,i.r)-Math.min(n.r,i.r)+Math.max(n.g,i.g)-Math.min(n.g,i.g)+Math.max(n.b,i.b)-Math.min(n.b,i.b);return{brightness:Math.abs(s-o),color:l}},B.isReadable=function(t,e){var r=B.readability(t,e);return r.brightness>125&&r.color>500},B.mostReadable=function(t,e){for(var r=null,a=0,n=!1,i=0;i<e.length;i++){var s=B.readability(t,e[i]),o=s.brightness>125&&s.color>500,l=3*(s.brightness/125)+s.color/500;(o&&!n||o&&n&&l>a||!o&&!n&&l>a)&&(n=o,a=l,r=B(e[i]))}return r};var L=B.names={aliceblue:"f0f8ff",antiquewhite:"faebd7",aqua:"0ff",aquamarine:"7fffd4",azure:"f0ffff",beige:"f5f5dc",bisque:"ffe4c4",black:"000",blanchedalmond:"ffebcd",blue:"00f",blueviolet:"8a2be2",brown:"a52a2a",burlywood:"deb887",burntsienna:"ea7e5d",cadetblue:"5f9ea0",chartreuse:"7fff00",chocolate:"d2691e",coral:"ff7f50",cornflowerblue:"6495ed",cornsilk:"fff8dc",crimson:"dc143c",cyan:"0ff",darkblue:"00008b",darkcyan:"008b8b",darkgoldenrod:"b8860b",darkgray:"a9a9a9",darkgreen:"006400",darkgrey:"a9a9a9",darkkhaki:"bdb76b",darkmagenta:"8b008b",darkolivegreen:"556b2f",darkorange:"ff8c00",darkorchid:"9932cc",darkred:"8b0000",darksalmon:"e9967a",darkseagreen:"8fbc8f",darkslateblue:"483d8b",darkslategray:"2f4f4f",darkslategrey:"2f4f4f",darkturquoise:"00ced1",darkviolet:"9400d3",deeppink:"ff1493",deepskyblue:"00bfff",dimgray:"696969",dimgrey:"696969",dodgerblue:"1e90ff",firebrick:"b22222",floralwhite:"fffaf0",forestgreen:"228b22",fuchsia:"f0f",gainsboro:"dcdcdc",ghostwhite:"f8f8ff",gold:"ffd700",goldenrod:"daa520",gray:"808080",green:"008000",greenyellow:"adff2f",grey:"808080",honeydew:"f0fff0",hotpink:"ff69b4",indianred:"cd5c5c",indigo:"4b0082",ivory:"fffff0",khaki:"f0e68c",lavender:"e6e6fa",lavenderblush:"fff0f5",lawngreen:"7cfc00",lemonchiffon:"fffacd",lightblue:"add8e6",lightcoral:"f08080",lightcyan:"e0ffff",lightgoldenrodyellow:"fafad2",lightgray:"d3d3d3",lightgreen:"90ee90",lightgrey:"d3d3d3",lightpink:"ffb6c1",lightsalmon:"ffa07a",lightseagreen:"20b2aa",lightskyblue:"87cefa",lightslategray:"789",lightslategrey:"789",lightsteelblue:"b0c4de",lightyellow:"ffffe0",lime:"0f0",limegreen:"32cd32",linen:"faf0e6",magenta:"f0f",maroon:"800000",mediumaquamarine:"66cdaa",mediumblue:"0000cd",mediumorchid:"ba55d3",mediumpurple:"9370db",mediumseagreen:"3cb371",mediumslateblue:"7b68ee",mediumspringgreen:"00fa9a",mediumturquoise:"48d1cc",mediumvioletred:"c71585",midnightblue:"191970",mintcream:"f5fffa",mistyrose:"ffe4e1",moccasin:"ffe4b5",navajowhite:"ffdead",navy:"000080",oldlace:"fdf5e6",olive:"808000",olivedrab:"6b8e23",orange:"ffa500",orangered:"ff4500",orchid:"da70d6",palegoldenrod:"eee8aa",palegreen:"98fb98",paleturquoise:"afeeee",palevioletred:"db7093",papayawhip:"ffefd5",peachpuff:"ffdab9",peru:"cd853f",pink:"ffc0cb",plum:"dda0dd",powderblue:"b0e0e6",purple:"800080",rebeccapurple:"663399",red:"f00",rosybrown:"bc8f8f",royalblue:"4169e1",saddlebrown:"8b4513",salmon:"fa8072",sandybrown:"f4a460",seagreen:"2e8b57",seashell:"fff5ee",sienna:"a0522d",silver:"c0c0c0",skyblue:"87ceeb",slateblue:"6a5acd",slategray:"708090",slategrey:"708090",snow:"fffafa",springgreen:"00ff7f",steelblue:"4682b4",tan:"d2b48c",teal:"008080",thistle:"d8bfd8",tomato:"ff6347",turquoise:"40e0d0",violet:"ee82ee",wheat:"f5deb3",white:"fff",whitesmoke:"f5f5f5",yellow:"ff0",yellowgreen:"9acd32"},K=B.hexNames=_(L),V=function(){var t="[-\\+]?\\d+%?",e="[-\\+]?\\d*\\.\\d+%?",r="(?:"+e+")|(?:"+t+")",a="[\\s|\\(]+("+r+")[,|\\s]+("+r+")[,|\\s]+("+r+")\\s*\\)?",n="[\\s|\\(]+("+r+")[,|\\s]+("+r+")[,|\\s]+("+r+")[,|\\s]+("+r+")\\s*\\)?";return{rgb:new RegExp("rgb"+a),rgba:new RegExp("rgba"+n),hsl:new RegExp("hsl"+a),hsla:new RegExp("hsla"+n),hsv:new RegExp("hsv"+a),hsva:new RegExp("hsva"+n),hex3:/^([0-9a-fA-F]{1})([0-9a-fA-F]{1})([0-9a-fA-F]{1})$/,hex6:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/,hex8:/^([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})([0-9a-fA-F]{2})$/}}();window.tinycolor=B}(),t(function(){t.fn.spectrum.load&&t.fn.spectrum.processNativeColorInputs()})});