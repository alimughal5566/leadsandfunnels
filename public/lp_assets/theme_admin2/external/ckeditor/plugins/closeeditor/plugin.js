/**
 * Basic sample plugin inserting current date and time into CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_intro
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'closeeditor', {

	// Register the icons. They must match command names.
    icons:  'closeeditor',	
	// The plugin initialization logic goes inside this method.
	init: function( editor ) {

		// Define an editor command that inserts a timestamp.
		editor.addCommand( 'closeeditor', {

			// Define the function that will be fired when the command is executed.
			exec: function( editor ) {
	//S		    editor.destroy();
	            var isDirty = CKEDITOR.instances.mychild.checkDirty();
                if (isDirty) {
                    jQuery('#decisionmodaldiv').dialog('open'); 
                }		
                else {
                    POPPAGES.closethetoolbar();
                }				
			    
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Closeeditor', {
			label: 'Cancel',
			command: 'closeeditor',
			toolbar: 'closeme'

		});
	}
});