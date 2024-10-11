(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($){
	var ajaxurl = cstm_ajax.admin_url;
	var nonce =  cstm_ajax.nonce;
	function fetchProjects() {
		$.ajax({
            url: ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_architecture_projects',
            },
            success: function(response) {
            	if (response.success) {
            		var jsonContent = JSON.stringify(response, null, 2);
            		$('#show_json').html(jsonContent)
                    console.log(response.data);
                } else {
            		$('#show_json').html('No projects found.')
                	// console.log('No projects found.');
                }
            },
            error: function(error) {
            	console.log('Error fetching projects:', error);
            }
        });
	}
	if($('#show_json').length>0){
		fetchProjects();
	}
})