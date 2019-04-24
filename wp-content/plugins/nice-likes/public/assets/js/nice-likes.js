/**
 * Nice Likes by NiceThemes
 *
 * @package Nice_Likes
 * @license GPL-2.0+
 */

/**
 * Manage likes implementation.
 *
 * @since   1.0
 * @package Nice_Likes
 */
var NiceLikes = ( function( $ ) {
	// Tell browsers we're not doing anything silly.
	'use strict';

	/**
	 * Check if the library was already loaded.
	 *
	 * @type {boolean}
	 */
	var loaded = false,

	/**
	 * Update likes.
	 *
	 * @since 1.0
	 */
	updateLikes = function() {
		$( document.body ).on( 'click', '.nice-likes', function( e ) {
			e.preventDefault();

			// Save reference to clicked object.
			var targets = $( '.nice-likes[data-id="' + $( this ).data( 'id' ) + '"]' ),
			    posts = {};

			targets.each( function() {
				// Create a list of posts.
				posts[ $( this ).data( 'query' ) ] = {
					'post_id' : $( this ).data( 'id' ),
					'show_postfix' : $( this ).data( 'postfix' ),
					'icon' : $( this ).find( 'i:first' ).prop( 'outerHTML' )
				};
			} );

			// Construct data to send via AJAX.
			var data = {
				'action' : 'nice_likes_update',
				'update_likes' : true,
				'posts' : posts,
				'post_id' : $( this ).data( 'id' ),
				'query_id' : $( this ).data( 'query' ),
				'show_postfix' : $( this ).data( 'postfix' ),
				'nonce' : window.nice_likes_vars.nonce,
				'fromurl' : window.nice_likes_vars.fromurl,
				'singular' : window.nice_likes_vars.singular
			};

			targets.each( function() {
				// Use a class to indicate an intermediate status.
				$( this ).addClass( 'updating' );

				if ( $( this ).hasClass( 'liked' ) ) {
					$( this ).addClass( 'disliking' );
				} else {
					$( this ).addClass( 'liking' );
				}
			} );

			// Make AJAX request.
			$.post( window.nice_likes_vars.ajaxurl, data, function( response ) {
				/**
				 * Try to received process data.
				 */
				try {
					// Parse response as JSON object.
					response = JSON.parse( response );
				} catch( err ) {
					// Help debugging if we can't use the received data.
					window.console.log( 'Well-formatted Likes data could not be processed. The following data was received instead:' );
					window.console.log( response );

					return;
				}

				// Update markup.
				for ( var i = 0; i < response.length; i++ ) {
					var obj = $( '[data-query=' + response[i].query_id + ']' );
					obj.replaceWith( response[i].content );
				}
			} );
		} );
	},

	/**
	 * Update likes.
	 *
	 * @since 1.0
	 */
	removeLikes = function() {
		$( document.body ).on( 'click', '.nice-likes-unlike', function( e ) {
			e.preventDefault();

			// Save reference to clicked object.
			var like_targets   = $( '.nice-likes[data-id="' + $( this ).data( 'id' ) + '"]' ),
				unlike_targets = $( '.nice-likes-unlike[data-id="' + $( this ).data( 'id' ) + '"]' ),
			    posts          = {};

			like_targets.each( function() {
				// Create a list of posts.
				posts[ $( this ).data( 'query' ) ] = {
					'post_id' : $( this ).data( 'id' ),
					'show_postfix' : $( this ).data( 'postfix' ),
					'icon' : $( this ).find( 'i:first' ).prop( 'outerHTML' )
				};
			} );

			// Construct data to send via AJAX.
			var data = {
				'action' : 'nice_likes_update',
				'update_likes' : true,
				'posts' : posts,
				'post_id' : $( this ).data( 'id' ),
				'query_id' : $( this ).data( 'query' ),
				'nonce' : window.nice_likes_vars.nonce,
				'show_postfix' : $( this ).data( 'postfix' )
			};

			// Use a class to indicate an intermediate status for like and unlike objects.
			like_targets.each( function() {
				$( this ).addClass( 'updating' );
			} );
			unlike_targets.each( function() {
				$( this ).addClass( 'updating' );
			} );

			// Make AJAX request.
			$.post( window.nice_likes_vars.ajaxurl, data, function( response ) {
				/**
				 * Try to received process data.
				 */
				try {
					// Parse response as JSON object.
					response = JSON.parse( response );
				} catch( err ) {
					// Help debugging if we can't use the received data.
					window.console.log( 'Well-formatted Likes data could not be processed. The following data was received instead:' );
					window.console.log( response );

					return;
				}

				// Update markup.
				for ( var i = 0; i < response.length; i++ ) {
					var obj = $( '.nice-likes[data-query=' + response[i].query_id + ']' );
					obj.replaceWith( response[i].content );

				}

				// Remove unlike elements.
				unlike_targets.each( function() {
					$( this ).remove();
				} );
			} );
		} );
	},

	/**
	 * Load likes via AJAX.
	 *
	 * @since 1.0
	 */
	loadLikes = function() {
		$( document ).ready( function() {
			var likes = $( '.nice-likes' ),
				posts = {};

			likes.each( function() {
				// Create a list of posts.
				posts[ $( this ).data( 'query' ) ] = {
					'post_id' : $( this ).data( 'id' ),
					'show_postfix' : $( this ).data( 'postfix' ),
					'icon' : $( this ).find( 'i:first' ).prop( 'outerHTML' )
				};
			} );

			// Construct data to send via AJAX.
			var data = {
				'action': 'nice_likes_load',
				'posts' : posts,
				'nonce' : window.nice_likes_vars.nonce,
				'fromurl' : window.nice_likes_vars.fromurl,
				'singular' : window.nice_likes_vars.singular
			};

			// Make AJAX request.
			$.post( window.nice_likes_vars.ajaxurl, data, function( response ) {
				/**
				 * Try to received process data.
				 */
				try {
					// Parse response as JSON object.
					response = JSON.parse( response );
				} catch( err ) {
					// Help debugging if we can't use the received data.
					window.console.log( 'Well-formatted Likes data could not be processed. The following data was received instead:' );
					window.console.log( response );

					return;
				}

				// Update markup.
				for ( var i = 0; i < response.length; i++ ) {
					var obj = $( '[data-query=' + response[i].query_id + ']' );
					obj.replaceWith( response[i].content );
				}
			} );
		} );
	},

	setup = function() {
		if ( ! loaded ) {
			updateLikes();
			removeLikes();

			loaded = true;
			$( document ).trigger( 'NiceLikesLoaded' );
		}

		loadLikes();

		return true;
	},

	observe = function() {
		/**
		 * Setup an observer, so we can watch DOM changes without
		 * ruining performance.
		 *
		 * @type {MutationObserver}
		 */
		var observer = new MutationObserver( function( mutations ) {
			mutations.forEach( function() {
				if ( waitForReset ) {
					return;
				}

				waitForReset = true;

				// Avoid reloading too frequently.
				setTimeout( function() {
					reset();
					waitForReset = false;
				}, 1000 );
			} );
		} ),
		// Observer configuration.
		observerConfig = {
			childList: true,
			subtree: true
		},
		// Target node.
		targetNode = document.body,
		// Set a flag to check if likes are waiting to be reset.
		waitForReset = false;

		// Watch for DOM changes.
		observer.observe( targetNode, observerConfig );

		return true;
	},

	reset = function() {
		if ( ! $( '.nice-likes.waiting' ).length ) {
			return;
		}

		setup();
	},

	/**
	 * Fire events on document ready, and bind other events.
	 *
	 * @since 1.0
	 */
	ready = function() {
		if ( loaded ) {
			return;
		}

		$( document ).on( 'NiceLikesLoaded', observe );

		setup();
	};

	// Expose the ready function to the world.
	return {
		ready: ready,
		reset: reset
	};

} )( jQuery );

jQuery( NiceLikes.ready );
