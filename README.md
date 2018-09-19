# PPV Addons #

A plugin that adds shortcodes for use in your WordPress theme.

## Description ##

Helpul shortcodes for displaying lists of posts on a page. Includes filters to allow output to be customized in your theme's functions.php.

## Shortcodes Included ##

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
    * posts_per_page [default 24] - Set number of tags per page for paged output.
    * order [default DESC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing.

* tags-alphabetical - Displays all tags with count by alphabetical order. Output list will be paged. Shortcode options:
    * posts_per_page [default 24] - Set number of tags per page for paged output.
    * order [default ASC] - Whether to display posts in ascending (ASC) or descending (DESC) order.
    * default_tag_icon (default Tag1.png) - Tag icon to display for tag listing.
    
## Plugin Installation ##

1. Upload ppv-addons.zip to plugins via WordPress admin panel or upload unzipped folder to the `/wp-content/plugins/` folder.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Add the shortcode to a page.

## Demo ##

To see this plugin in use visit the http://picturesquephotoviews.com website. There is one page for each shortcode under the **Post & Tag Indexes** menu item.

## Frequently Asked Questions ##

### What is the location of default_image, default_post_icon, and default_tag_icon? ###

The image or icon should be placed in the directory wp-content\plugins\ppv-addons\public\images. Set the option in the shortcode to the filename of the image or icon.

## Credits ##

* WordPress Plugin Boilerplate https://github.com/DevinVinson/WordPress-Plugin-Boilerplate was used as the starting point for this plugin.
* Icons from Noun Project have a Creative Commons license. The tag icon is created by Victor Fernandez and the blog icon is created by Luke Jarrett.

## Changelog ##

### 1.3 ###
* Updated gulp to version 4.
* Updated gulpfile.js with gulp version 4 syntax.
* Removed watch and browsersync from default gulp task.

### 1.2.3 ###
* Added shortcut options for selecting post and tag icons.

### 1.2.2 ###
* Added tags-alphabetical shortcode.

### 1.2.1 ###
* Added posts-alphabetical shortcode.

### 1.2 ###
* Added icons for blog without featured pictures listing and tag listing.
* Numerous styling changes to PPV archive list and PPV pagination.
* Made yes shortcut options case insensitive.
* Added shortcut option to not use wp_pagenavi plugin.
* Restructured ppv_Pagination function.
* Added tags-by-number shortcode.

### 1.1 ###
* Added gulp and gulp tasks.
* Changed to enqueue minified version of css.

### 1.0.1 ###
* Added posts-by-categories shortcode.
* Changed PLUGIN_NAME_VERSION to PPV_ADDONS_VERSION.

### 1.0 ###
* Initial release.