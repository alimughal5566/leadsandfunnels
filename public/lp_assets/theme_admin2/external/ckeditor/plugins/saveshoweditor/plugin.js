/**
 * Basic sample plugin inserting current date and time into CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_intro
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'saveshoweditor', {

	// Register the icons. They must match command names.
    icons:  'saveshoweditor',	
	// The plugin initialization logic goes inside this method.
	init: function( editor ) {

		// Define an editor command that inserts a timestamp.
		editor.addCommand( 'saveshoweditor', {

			// Define the function that will be fired when the command is executed.
			exec: function( editor ) {
	//S		    editor.destroy();
			    //POPPAGES.savetheeditor();
			    POPPAGES.previewCurrentPage();
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Saveshoweditor', {
			label: 'Save & Preview',
			command: 'saveshoweditor',
			toolbar: 'saveshowme'

		});
	}
});