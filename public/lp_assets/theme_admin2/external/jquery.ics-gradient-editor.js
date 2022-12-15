
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
var custom_opts = [];
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
		defaultCssSwatches : []
/*		["linear-gradient(0deg,rgba(30, 87, 153, 0.45) 0%,rgba(41, 137, 216, 0.59) 47.8%,rgba(36, 92, 140, 0.74) 47.8%,rgba(125, 185, 232, 0.53) 100%)",
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
		]*/
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
								'<label>Color palette extracted from logo. <br />Click color tile to select background.</label>',
								'<div class="btn-group" style="display: none">',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_type" data-name="gradient_type" data-value="linear">linear</button>',
									'<button class="btn btn-default btn-sm ics-ge-controller" data-control-group="gradient_type" data-name="gradient_type" data-value="radial">radial</button>',
								'</div>',
							'</div>',
							'<div class="css-gradient-repeating">',
								'<label style="display: none">Repeating:</label>',
								'<div  style="display: none"class="btn-group">',
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
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="top left"><i class="fa fa-arrow-up fa-rotate-315"></i>',
										'</button>',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top" data-control-group="linear-direction" data-name="gradient_direction" data-value="top"><i class="fa fa-arrow-up"></i>',
										'</button>',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-top-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="top right"><i class="fa fa-arrow-up fa-rotate-45"></i>',
										'</button>',
									'</div>',
									'<div class="ics-ge-linear-direction-implicit mid">',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="left"><i class="fa fa-arrow-left"></i>',
										'</button>',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="right"><i class="fa fa-arrow-right"></i>',
										'</button>',
									'</div>',
									'<div class="ics-ge-linear-direction-implicit bot">',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom-left" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom left"><i class="fa fa-arrow-down fa-rotate-45"></i>',
										'</button>',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom"><i class="fa fa-arrow-down"></i>',
										'</button>',
										'<button  style="display: none" class="btn btn-default btn-sm ics-ge-controller ics-ge-direction-bottom-right" data-control-group="linear-direction" data-name="gradient_direction" data-value="bottom right"><i class="fa fa-arrow-down fa-rotate-315"></i>',
										'</button>',
									'</div>',
									'<div  style="display: none"  class="ics-ge-linear-direction-explicit">',
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
					'<label> <span class="fa fa-arrow-down"></span> Click Tiles To Change Background <span class="fa fa-arrow-down"></span></label>',
				'</div>',
				'<div class="ics-ge-swatches-wrapper-swatches panel-body">',
					'<div class="content ics-ge-swatches">',
						'<button style="display: none" type="button" class="btn btn-default btn-sm ics-ge-save" title="Add gradient to swatches"><i class="fa fa-plus-circle"></i></button>',
						'<ul class="ics-ge-swatches-list"></ul>',
					'</div>',
				'</div>',
                '<div class="ics-ge-swatches-wrapper-heading">',
					'<a href="#" onClick="hideColorThief(event)"><label class="goodguy"> Click Here When Finished</label></a>',
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
				settings.localStoragePrefix= opts.localStoragePrefix; // default value for getting the swatches from local storage 'icsge' otherwise value has been empty
				settings.defaultCssSwatches = opts.defaultCssSwatches;
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
				settings.background_size = 'auto auto';
				settings.background_size_horizontal_value = '75';
				settings.background_size_horizontal_unit = '%';
				settings.background_size_vertical_value = '75';
				settings.background_size_vertical_unit = '%';
				settings.background_position = 'explicit';
				settings.background_position_horizontal_value = '50';
				settings.background_position_horizontal_unit = '%';
				settings.background_position_vertical_value = '50';
				settings.background_position_vertical_unit = '%';
				settings.background_repeat = 'repeat';
				settings.background_attachment = 'scroll';
				settings.background_origin = opts.mode == 'image' ? 'padding-box' : 'border-box';
				settings.background_clip = 'border-box';
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
					  elements.colorpicker('reflow');
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
					      jQuery("#swatchnumber").val(jQuery(this).attr("id"));
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
					elements.bgpositionctrl.on('touchstart mousedown',function(ev) {
						bgInMove = true;

						changeBgProp(ev);

						ev.stopPropagation();
						ev.preventDefault();
						updateCssOutput();
					});
					elements.bgsizectrl.on('touchstart mousedown',function(ev) {
						bgInMove = true;

						changeBgProp(ev);

						ev.stopPropagation();
						ev.preventDefault();
						updateCssOutput();
					});
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
						outputdata = 	getBackgroundProperties(outputdata);
						jQuery.each(outputdata.backgroundProperties, function(property,value){
							cssoutput += '\n'+property+':'+value+';';
						});
						}
					}
			  }

			function updateCssOutput() {
				refreshCssOutput();
				elements.cssoutput.text(cssoutput);
				//console.log(cssoutput);
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
// 5/28/2015 comment out so that onload always load default swatches
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
					//console.log(swatch);
					var span = jQuery('<span></span>');
					var button = jQuery('<div id="swatchnumber-'+ i + '" class="ics-ge-preset"></div>').data('gradient', swatch);

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
            return this;
        }

        // Initializing a new instance of spectrum
        return this.icsge("destroy",opts).each(function () {
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
