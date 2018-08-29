=== PPV Addons ===
Contributors: lheisey
Tags: shortcode, posts, display, list, chronological
Requires at least: 3.0.1
Tested up to: 4.9
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that adds shortcodes for use in your WordPress theme.

== Description ==

Helpul shortcodes for displaying lists of posts on a page. Includes filters to allow output to be customized in your theme's functions.php.

== Shortcodes Included ==

* posts-by-date - Displays all posts in date order. Can show or not show featured images. Output list will be paged and use wp-navi module for pagination if module is active. Shortcode options:
    * posts_per_page [default 24] - Set number of posts per page for paged output.
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.

* posts-by-categories - Displays all categories and posts in each. Can show or not show featured images. Shortcode options:
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * orderby [default name] - Sort order to display posts.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.

== Installation ==

1. Upload ppv-addons.zip to plugins via WordPress admin panel or upload unzipped folder to the `/wp-content/plugins/` folder.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the shortcode to a page.

== Frequently Asked Questions ==

= What is the location of default_image? =

The image to be displayed for posts that do not have a feature image set should be placed in the directory wp-content\plugins\ppv-addons\public\images. Set the default_image option in the shortcode to the filename of the image.

== Credits ==

* WordPress Plugin Boilerplate https://github.com/DevinVinson/WordPress-Plugin-Boilerplate was used as the starting point for this plugin.

== Changelog ==
= 1.1.0 =
* Added gulp and gulp tasks.
* Changed to enqueue minified version of css.

= 1.0.1 =
* Added posts-by-categories shortcode.
* Changed PLUGIN_NAME_VERSION to PPV_ADDONS_VERSION.

= 1.0 =
* Initial release.
