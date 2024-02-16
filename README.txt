=== PPV Addons ===
Contributors: lheisey
Tags: shortcode, posts, display, list, chronological, custom taxonomy
Requires at least: 5.0
Tested up to: 6.4
Stable tag: 4.3
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A plugin that adds shortcodes for use in your WordPress theme.

== Description ==

Helpful shortcodes for displaying lists of posts on a page. Includes filters to allow output to be customized in your theme's functions.php. There is also a custom taxonomy created and functionality to display the featured post image in RSS feeds.

== Shortcodes Included ==

* posts-by-date - Displays all posts in date order. Can show or not show featured images. Output list will be paged and use wp-navi module for pagination if module is active. Shortcode options:
    * posts_per_page [default 24] - Set number of posts per page for paged output.
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * use_wp_pagenavi [default yes] - Enables not using wp_pagenavi plugin.
    * order [default DESC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image - not used from version 3.0.8.
    * title_text (default Posts Newest to Oldest) - Title text to display before post list.

* posts-alphabetical - Displays all posts alphabetically. Can show or not show featured images. Output list will be paged and use wp-navi module for pagination if module is active. Shortcode options:
    * posts_per_page [default 24] - Set number of posts per page for paged output.
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * use_wp_pagenavi [default yes] - Enables not using wp_pagenavi plugin.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image - not used from version 3.0.8.

* posts-by-categories - Displays all categories and posts in each. Can show or not show featured images. Shortcode options:
    * image_size [default thumbnail] - Set WordPress image size for display of featured image.
    * show_image [default yes] - Whether to display post featured image with the link to post.
    * orderby [default name] - Sort order to display posts.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_image (default ppv-default.jpg) - Image to display for posts that do not have a feature image set.
    * default_post_icon (default Blog1.png) - Post icon to display when not using show_image - not used from version 3.0.8.

* tags-by-number - Displays all tags with count by order of count number. Output list will be paged. Shortcode options:
    * per_page [default 24] - Set number of tags per page for paged output.
    * order [default DESC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing - not used from version 3.0.

* tags-alphabetical - Displays all tags with count by alphabetical order. Output list will be paged. Shortcode options:
    * per_page [default 24] - Set number of tags per page for paged output.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing - not used from version 3.0.1.

* column - Responsive columns which divides a row into columns. A shortcode is used for each column with the last column (including one-full) containing the option last="true". For screen sizes below a breakpoint the columns become a stacked single column. The breakpoint is defined as 719px by the SASS variable $col-grid-max-width.
Column size options:
    * one-full
    * one-half
    * one-third, two-third
    * one-fourth, three-fourth
    * one-fifth, two-fifth, three-fifth, four-fifth

Column shortcode usage example:
```
[column size="one-half"]
Column one information goes here.
[/column]

[column size="one-half" last="true"]
Column two information goes here.
[/column]
```

== Custom Taxonomy ==

The custom taxonomy created is called **topics**, is non-hierarchical and is used in posts. The admin menu Posts - Topics can be used to add or edit the topics, or using quick edit. To enable adding topics in the Topics metabox when editing posts change in the Tag_Checklist function the false parameter to true.

== Display featured post image in RSS feeds ==

Two methods are provided to add the featured post image to the RSS feed. The first adds the image to the $content variable of the RSS feed. The second inserts an image object in the RSS feed. The second format is used by many aggregators.

== Plugin Installation ==

1. Upload ppv-addons.zip to plugins via WordPress admin panel or upload unzipped folder to the `/wp-content/plugins/` folder.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the shortcode to a page.

Starting with version 2 of the plugin, the generated ppv-addons plugin is in ppv-addons.zip located in the dist folder of the Github repository.

== Demo ==

To see this plugin in use visit the https://picturesquephotoviews.com website. There is one page for each shortcode under the **Post & Tag Indexes** menu item.

== Using Gulp functionality ==

As a prerequisite node.js must be installed on the computer. Node.js installers can be found at https://nodejs.org and version 8 or later is recommended. Gulp-cli should also be installed globally.

Starting with version 2 of the plugin, the plugin source folder was moved outside of the WordPress installation. This was so the script files, git repo, node modules, and other files not needed by WordPress are not present. The folder structure used is the ppv-addons plugin source folder and the WordPress installation folder are the same level. The files needed by WordPress are compiled or copied from the ppv-addons plugin source folder to the WordPress installation plugins folder.

Download the zipfile from Github and uzip it. Move the unzipped plugin source folder to the same folder containing the WordPress installation. The ppv-addon plugin source folder can be renamed to avoid confusion with the generated ppv-addon plugin folder.

Open a command prompt/terminal and cd to the ppv-addon plugin source folder. The gulp plugins and their dependencies first need to be installed.
* npm install

Some variables in gulpfile.js will needed to be edited to match the local WordPress installation. These are indicated in the gulpfile.js comments.
After this is done the gulp tasks can be run.

Individual tasks:

Command | Task
--- | ---
gulp publicstyles | compiles public SASS
gulp adminstyles | compiles admin SASS
gulp readme | compiles readme
gulp copy-files | copies non-processed files if changed (php, js, etc)
gulp package | packages the plugin in a ZIP file
gulp watch | watch files for changes
gulp browsersync | Browser-Sync watch files and inject changes

Multiple tasks:

Command | Task
--- | ---
gulp default | runs readme, publicstyles, adminstyles, copy-files
gulp build | runs default, package

== Frequently Asked Questions ==

= What is the location of default_image, default_post_icon, and default_tag_icon? =

The image or icon should be placed in the directory wp-content\plugins\ppv-addons\public\images. Set the option in the shortcode to the filename of the image or icon.

= Which readme file do I make changes in? =

Make changes to the README.txt file. The README.md file is generated by gulp so should never be edited.

= Where is the plugin version updated? =

In the ppv-addons.php file after the comment block that starts with `Currently plugin version` and also in the header comments.

= Why is some of the JS and CSS not showing up on the site? =

Only the JS and CSS files I used are enqueued. To use the others uncomment them in class-ppv-addons-public.php and class-ppv-addons-admin.php.

== Credits ==

* WordPress Plugin Boilerplate https://github.com/DevinVinson/WordPress-Plugin-Boilerplate was used as the starting point for this plugin.
* Icons from Noun Project have a Creative Commons license. The tag icon is created by Victor Fernandez and the blog icon is created by Luke Jarrett.

== Changelog ==

See the CHANGELOG.md file.
