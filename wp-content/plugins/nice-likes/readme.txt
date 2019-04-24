=== Nice Likes ===
Contributors: nicethemes, juanfra, andrezrv, ricardoaiello
Tags: likes, shortcode, template-tag, services
Requires at least: 3.6
Tested up to: 4.9
Requires PHP: 5.3
Stable tag: 1.0.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a simple and intuitive "liking" functionality to your WordPress site.

== Description ==

= A simple and customizable Likes plugin for your website's content =

Nice Likes easily adds likes functionality to your website without requiring you to write a single line of code, while offering a lot of possibilities for developers to extend its functionality. You can make use of likes natively or add them with a template tag (PHP function).

This plugin is fully integrated with WordPress. It makes use of its native architecture to show likes for your content, and includes a huge set of hooks, so you can customize it in any way you need.

Nice Likes works right out of the box with any theme.

= General Features =

* Selectively add a Like button to your posts, pages, archives and custom post types.
* Update likes count without reloading the page.
* Available for logged and non-logged users.
* Dislike previously liked entries.
* Powerful and intuitive options page.
* Compatible with all themes.
* Available as shortcode to include inside your post content.
* Available as template tag (PHP function) to include in your own templates.
* Optionally disable functionality without deactivating the plugin.
* Exclude likes from posts and pages by ID.
* Customizable texts.

= Comprehensive settings page =

Define how your likes will be displayed without having to code with our intuitive settings page. Select where your likes are gonna show and which texts will be used through a complete set of options.

= Template tag =

Use our `nice_likes()` PHP function to show likes anywhere you want.

= Developer friendly =

Nice Likes is developed following the [WordPress Coding Standards](http://codex.wordpress.org/WordPress_Coding_Standards). It relies on the native templating architecture of WordPress, and includes a huge set of hooks and pluggable functions and classes, so you can customize it in any way you need.

== Installation ==

= Using The WordPress Dashboard =

1. Navigate to the "Add New" link in the plugins dashboard.
2. Search for "Nice Likes".
3. Click "Install Now".
4. Activate the plugin on the Plugin dashboard.

= Uploading in WordPress Dashboard =

1. Navigate to the "Add New" in the plugins dashboard.
2. Navigate to the "Upload" area.
3. Select `nice-likes.zip` from your computer.
4. Click "Install Now".
5. Activate the plugin in the Plugin dashboard.

= Using FTP =

1. Download `nice-likes.zip`.
2. Extract the `nice-likes` directory to your computer.
3. Upload the `nice-likes` directory to the `/wp-content/plugins/` directory.
4. Activate the plugin in the Plugin dashboard.

== Frequently Asked Questions ==

= How to set up the plugin? =

Once you installed and activated the plugin, you can go to *Settings > Likes* and tweak the options there.

= How to integrate with my templates? =

The simplest way to include likes in your own templates is using our `nice_likes()` function. This is a very basic usage example:

`
<?php
if ( function_exists( 'nice_likes' ) ) :
	nice_likes( array( 'echo' => true ) );
endif;
?>
`

However, we recommend you to use the `nice_likes_custom` action, which allows to select via Likes Settings where likes will be displayed. In the settings page, you'll be presented with three options for the location of your likes: before your post content, after your post content, or in a custom location. If you chose the later, you're gonna need to add `<?php do_action( 'nice_likes_custom' ); ?>` to the the part of your template where you want your likes to display, while still having the possibility to move them to the top or bottom of your content in case you need to.

= How can I use my own CSS? =

You can load a custom stylesheet by using [wp_enqueue_script()](http://codex.wordpress.org/Function_Reference/wp_enqueue_script) and adding your custom CSS to your own file. However, if you *really* want to get rid of the default CSS of Nice Likes, so you can avoid overriding our styles, you can check the "Avoid Plugin CSS" option in *Settings > Likes*.

== Screenshots ==

1. Likes Settings page.
2. Likes inside a post.

== Changelog ==

= 1.0.8 =
* Add `nice_likes_user_ip` to allow customizing the way likes are tracked.

= 1.0.7 =
* Fix issues with MutationObserver when new likes are added to the DOM.

= 1.0.6 =
* Fix PHP fatal error when using custom location.

= 1.0.5 =
* New feature: Add option to show likes count in post and pages lists in admin side.

= 1.0.4 =
* Fix: Obtain admin path using `ABSPATH` constant.

= 1.0.3 =
* Update likes using jQuery's `on()` function instead of the deprecated `live()` function.

= 1.0.2 =
* Fix nonce verification when likes are not processed using AJAX.

= 1.0.1 =
* Make text domains load on `plugins_loaded`.
* Fix potential edge case concerning current select values not being correctly pre-selected inside meta boxes.

= 1.0 =
* First public release.
