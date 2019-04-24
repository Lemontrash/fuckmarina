/**
 * NiceThemes Admin UI
 *
 * @package Nice_Likes_Admin_UI
 * @license GPL-2.0+
 */

/**
 * Manage interactions for Admin UI elements.
 *
 * @since   1.0
 * @package Nice_Likes_Admin_UI
 */
var NiceThemesAdminUI = ( function( $ ) {
	// Tell browsers we're not doing anything silly.
	'use strict';

	/**
	 * Initialize tabs.
	 *
	 * @since 1.0
	 */
	var initTabs = function() {
		var tabs = $( '.nice-tabs' );
		if ( tabs.length ) {
			tabs.tabs();
		}
	},

	/**
	 * Initialize accordions.
	 *
	 * @since 1.0
	 */
	initAccordion = function() {
		var accordion = $( '.nice-accordion' );
		if ( accordion.length ) {
			accordion.accordion( { collapsible: true, heightStyle: 'content' } );
		}
	},

	/**
	 * Manage opening and closing of modal buttons.
	 *
	 * @since 1.0
	 */
	handleModal = function() {
		// Open modal on click.
		$( '.modal-open' ).on( 'click', function ( event ) {
			$( '.shade, .modal' ).show();
			event.preventDefault();
		} );
		// Clicking outside modal, or close X closes modal.
		$( '.shade, .modal header .close' ).on( 'click', function ( event ) {
			$( '.shade, .modal' ).hide();
			$( '.manage-right' ).removeClass( 'show' );
			event.preventDefault();
		} );
	},

	/**
	 * Manage showing and hiding of button tooltips.
	 *
	 * @since 1.0
	 */
    handleTooltip = function() {
        $( '.tooltip' ).tooltip({
            items: 'img, a',
            position: {
                my: 'center bottom-15',
                at: 'center top',
                using: function( position, feedback ) {
                    $( this ).css( position );
                    $( '<div>' )
                        .addClass( 'arrow' )
                        .addClass( feedback.vertical )
                        .addClass( feedback.horizontal )
                        .appendTo( this );
                }
            },
            content: function() {
                var element = $( this ), result;
                if ( element.is( '[title]' ) ) {
                    result = element.attr( 'title' );
                }
                if ( element.is( 'img' ) ) {
                    result = element.attr( 'alt' );
                }
	            return result;
            }
        } );
    },

	/**
	 * Manage opening and closing of toggabble elements.
	 *
	 * @since 1.0
	 */
	handleToggle = function() {
		var toggle = $( '.nice-toggle' );
		if ( toggle.length ) {
			toggle.each( function () {
				if ( 'closed' == $( this ).attr( 'data-id' ) ) {
					$( this ).accordion( { header: '.nice-toggle-title', collapsible: true, active: false  } );
				} else {
					$( this ).accordion( { header: '.nice-toggle-title', collapsible: true} );
				}
			} );
		}
	},

	/**
	 * Implement media uploader and image preview for form elements.
	 *
	 * @since 1.0
	 */
	handleUploader = function() {
		// Remove file.
		$( '.nice_likes_upload_remove' ).live( 'click', function( event ) {
			event.preventDefault();
			$( this ).hide();
			$( this ).parents().parents().children( '.nice_likes_admin_upload_field' ).attr( 'value', '' );
			$( this ).parents( '.screenshot' ).slideUp();
		} );

		// Show modal box for uploads.
		if ( nice_likes_admin_ui_vars.wp_version < '3.5' ) {
			// Old Thickbox uploader.
			if ( $( '.nice_likes_admin_upload_button' ).length > 0 ) {
				window.formfield = '';

				$( 'body' ).on( 'click', '.nice_likes_admin_upload_button', function ( e ) {
					e.preventDefault();
					window.formfield = $( this ).parent().prev();
					window.tbframe_interval = setInterval( function () {
						jQuery( '#TB_iframeContent' ).contents().find( '.savesend .button' ).val( nice_likes_admin_ui_vars.use_this_file ).end().find( '#insert-gallery, .wp-post-thumbnail' ).hide();
					}, 2000 );
					tb_show( nice_likes_admin_ui_vars.add_new_download, 'media-upload.php?TB_iframe=true' );
				} );

				window.edd_send_to_editor = window.send_to_editor;
				window.send_to_editor = function ( html ) {
					if ( window.formfield ) {
						var imgurl = $( 'a', '<div>' + html + '</div>' ).attr( 'href' );
						window.formfield.val( imgurl );
						window.clearInterval( window.tbframe_interval );
						tb_remove();
					} else {
						window.edd_send_to_editor( html );
					}
					window.formfield = '';
					window.imagefield = false;
				}
			}
		} else {
			// WP 3.5+ uploader.
			var file_frame;
			window.formfield = '';

			$( 'body' ).on( 'click', '.nice_likes_admin_upload_button', function( e ) {
				e.preventDefault();

				var button = $( this );

				window.formfield = $( this ).parent().prev();

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media( {
					frame: 'post',
					state: 'insert',
					title: button.data( 'uploader_title' ),
					button: { text: button.data( 'uploader_button_text' ) },
					multiple: false
				} );

				file_frame.on( 'menu:render:default', function(view) {
					// Store our views in an object.
					var views = {};

					// Unset default menu items.
					view.unset( 'library-separator' );
					view.unset( 'gallery' );
					view.unset( 'featured-image' );
					view.unset( 'embed' );

					// Initialize the views in our view object.
					view.set( views );
				} );

				// When an image is selected, run a callback.
				file_frame.on( 'insert', function () {
					var selection = file_frame.state().get( 'selection' );
					var image_content;

					selection.each( function ( attachment, index ) {
						attachment = attachment.toJSON();
						window.formfield.val( attachment.url );
						image_content = '<img src="' + attachment.url + '" alt="" /><a href="#" class="nice_likes_upload_remove nice_likes_upload_' + index + '">' + nice_likes_admin_ui_vars.remove_text + '</a>';
						window.formfield.siblings( '.screenshot' ).slideDown().html( image_content );
					} );
				} );

				// Finally, open the modal.
				file_frame.open();
			} );
		}
	},

	/**
	 * Manage dismissal of notices.
	 *
	 * @since 1.0
	 */
	handleNotices = function() {
		var close = $( '.nice-notice .close' );

		// Close warning notice.
		if ( close.length ) {
			close.click( function() {
				$( this ).parent().fadeOut();
			});
		}
	},

	/**
	 * Manage implementation of WP color picker.
	 *
	 * @since 1.0
	 */
	handleColorPicker = function() {
		var colorPicker = $( '.nice-color-picker' );
		if( colorPicker.length ) {
			colorPicker.wpColorPicker();
		}
	},

	/**
	 * Fire events on document ready, and bind other events.
	 *
	 * @since 1.0
	 */
    ready = function() {
	    initTabs();
	    initAccordion();
		handleModal();
		handleTooltip();
	    handleToggle();
	    handleColorPicker();
	    handleUploader();
	    handleNotices();
	};

	// Expose the ready function to the world.
	return {
		ready: ready
	};

} )( jQuery );

jQuery( NiceThemesAdminUI.ready );
