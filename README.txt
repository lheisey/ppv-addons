=== PPV Addons ===
Contributors: lheisey
Tags: shortcode, posts, display, list, chronological
Requires at least: 3.0.1
Tested up to: 5.2
Stable tag: 4.3
Requires PHP: 5.2.4
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
    * use_wp_pagenavi [default yes] - Enables not using wp_pagenavi plugin.
    * order [default DESC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image.

* posts-alphabetical - Displays all posts alphabetically. Can show or not show featured images. Output list will be paged and use wp-navi module for pagination if module is active. Shortcode options:
    * posts_per_page [default 24] - Set number of posts per page for paged output.
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * use_wp_pagenavi [default yes] - Enables not using wp_pagenavi plugin.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image.

* posts-by-categories - Displays all categories and posts in each. Can show or not show featured images. Shortcode options:
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * orderby [default name] - Sort order to display posts.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image.

* tags-by-number - Displays all tags with count by order of count number. Output list will be paged. Shortcode options:
    * per_page [default 24] - Set number of tags per page for paged output.
    * order [default DESC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing.

* tags-alphabetical - Displays all tags with count by alphabetical order. Output list will be paged. Shortcode options:
    * per_page [default 24] - Set number of tags per page for paged output.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing.
    
== Plugin Installation ==

1. Upload ppv-addons.zip to plugins via WordPress admin panel or upload unzipped folder to the `/wp-content/plugins/` folder.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the shortcode to a page.

== Demo ==

To see this plugin in use visit the http://picturesquephotoviews.com website. There is one page for each shortcode under the **Post & Tag Indexes** menu item.

== Using Gulp functionality ==

As a prerequisite node.js must be installed on the computer. Node.js installers can be found at https://nodejs.org and version 8 or later is recommended.

If gulp version 3 is installed globally on the computer it should be uninstalled. Gulp-cli which supports both gulp version 3 and 4 is then installed. Linux users might need to use sudo depending on how the computer is set up. If gulp is not installed globally then just step 2 needs to be done.
1. npm uninstall -g gulp
2. npm install -g gulp-cli

Open a command prompt/terminal and cd to the ppv-addon plugin folder. The gulp plugins and their dependencies first need to be installed.
* npm install

After this is complete the gulp tasks can be run.

Command | Task
--- | ---
gulp | compiles SASS and readme
gulp publicstyles | compiles SASS
gulp readme | compiles readme
gulp watch | watch files for changes
gulp browsersync | Browser-Sync watch files and inject changes

== Frequently Asked Questions ==

= What is the location of default_image, default_post_icon, and default_tag_icon? =

The image or icon should be placed in the directory wp-content\plugins\ppv-addons\public\images. Set the option in the shortcode to the filename of the image or icon.

== Credits ==

* WordPress Plugin Boilerplate https://github.com/DevinVinson/WordPress-Plugin-Boilerplate was used as the starting point for this plugin.
* Icons from Noun Project have a Creative Commons license. The tag icon is created by Victor Fernandez and the blog icon is created by Luke Jarrett.

== Changelog ==
= 1.3.8 =
* Updated gulp-sass and Browser-Sync versions.

= 1.3.7 =
* Updated autoprefixer version.
* Moved autoprefixer options to .browserslistrc file.

= 1.3.6 =
* Moved autoprefixer after SASS in gulpfile.js.

= 1.3.5 =
* Added Requires PHP to readme.
* Updated readme tested up to 5.2.

= 1.3.4 =
* Updated Browser-Sync version.

= 1.3.3 =
* Corrected tag shortcode option in readme.
* Updated readme tested up to 5.0.

= 1.3.2 =
* Add gulp usage to readme.
* Changes for adding .eslint.js file and moving jslint configuration to editor.

= 1.3.1 =
* Changed css class in ppv_start_new_row() to ppv-row-cells.

= 1.3 =
* Updated gulp to version 4.
* Updated gulpfile.js with gulp version 4 syntax.
* Removed watch and browsersync from default gulp task.

= 1.2.3 =
* Added shortcut options for selecting post and tag icons.

= 1.2.2 =
* Added tags-alphabetical shortcode.

= 1.2.1 =
* Added posts-alphabetical shortcode.

= 1.2 =
* Added icons for blog without featured pictures listing and tag listing.
* Numerous styling changes to PPV archive list and PPV pagination.
* Made yes shortcut options case insensitive.
* Added shortcut option to not use wp_pagenavi plugin.
* Restructured ppv_Pagination function.
* Added tags-by-number shortcode.

= 1.1 =
* Added gulp and gulp tasks.
* Changed to enqueue minified version of css.

= 1.0.1 =
* Added posts-by-categories shortcode.
* Changed PLUGIN_NAME_VERSION to PPV_ADDONS_VERSION.

= 1.0 =
* Initial release.
