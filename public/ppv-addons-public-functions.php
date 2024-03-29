<?php

/**
 * Public functions
 *
 * @link       http://picturesquephotoviews.com/
 * @since      1.0.0
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/public
 */
 
/**
 * Retrieve either the post featured image or a placeholder image.
 *
 * @since 1.0.0
 *
 * @param string  $image_size
 * @return string image tag
 */
function ppv_get_Feature_Image( $image_size, $default_image ) {
    if ( has_post_thumbnail() ) {
        $the_image = get_the_post_thumbnail( get_the_ID(), $image_size );
    } else {
        $the_image =  '<img src="' . PPV_ADDONS_PLUGIN_URL . 'public/images/' . $default_image . '" > ';
    }
    /**
     * Filter the image and its HTML to use for display.
     *
     * @since 1.0.0
     *
     * @param string Image tag for image display
     */
    return apply_filters('ppv_get_Feature_Image', $the_image);
}

/**
 * Output post list with image and link to post.
 *
 * @since 1.0.0
 *
 * @param string  $feature_image
 * @return string HTML output
 */
function ppv_Media_Object( $feature_image ) {
    ob_start();
    ?>
        <div class="ppv-mediaobj">
              <div class="ppv-media__img">
                 <?php echo $feature_image; ?>
              </div>
              <div class="ppv-media__body">
              <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
              </div>
        </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    /**
     * Filter markup to use for display of the image and link to post.
     *
     * @since 1.0.0
     *
     * @param string HTML output
     */
    return apply_filters('ppv_media_object_filter', $output);
}

/**
 * Output post list with link to post.
 * Display in columns without icon with version 3.0.8.
 *
 * @since 1.0.0
 *
 * @return string HTML output
 */
function ppv_Post_List() {
    ob_start();
    ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    /**
     * Filter markup to use for display of the link to post.
     *
     * @since 1.0.0
     *
     * @param string HTML output
     */
    return apply_filters('ppv_post_list_filter', $output);
}

/**
 * Output post card with image and link to post.
 *
 * @since 3.0.3
 *
 * @param string  $feature_image
 * @return string HTML output
 */
function ppv_Post_Card( $feature_image ) {
    ob_start();
    ?>
        <div class="ppv-post-card">
              <div class="ppv-post-link">
                 <a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>"><?php echo $feature_image; ?></a>
              </div>
              <div class="ppv-post-title">
              <a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
              </div>
        </div>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    /**
     * Filter markup to use for display of the image and link to post.
     *
     * @since 3.0.3
     *
     * @param string HTML output
     */
    return apply_filters('ppv_post_card_filter', $output);
}

/**
 * Alphabetical list letter.
 *
 * @since 3.0.5
 *
 * @return string HTML output
 */
function ppv_alphabetical_letter( $letter ) {
    $output = '<div class="ppv-letter-heading">' . "\n";
    $output .= '<div class="ppv-letter">' . $letter . '</div>' . "\n";
    $output .= '</div>' . "\n";    
    /**
     * Filter markup to use for Alphabetical list letter.
     *
     * @since 3.0.5
     *
     * @param string HTML output
     */
    return apply_filters('ppv_alphabetical_letter_filter', $output);
}

/**
 * Categories list title.
 *
 * @since 3.0.6
 *
 * @return string HTML output
 */
function ppv_category_title( $category ) {
    $output = '<div class="ppv-category-heading">' . "\n";
    $output .= '<div class="ppv-category-title">' . $category . '</div>' . "\n";
    $output .= '</div>' . "\n";
    /**
     * Filter markup to use for Categories list title.
     *
     * @since 3.0.6
     *
     * @param string HTML output
     */
    return apply_filters('ppv_category_title_filter', $output);
}

/**
 * Posts by date list title.
 *
 * @since 3.0.7
 *
 * @return string HTML output
 */
function ppv_bydate_title( $text ) {
    $output = '<div class="ppv-bydate-heading">' . "\n";
    $output .= '<div class="ppv-bydate-title">' . $text . '</div>' . "\n";
    $output .= '</div>' . "\n";
    /**
     * Filter markup to use for Posts by date list title.
     *
     * @since 3.0.7
     *
     * @param string HTML output
     */
    return apply_filters('ppv_bydate_title_filter', $output);
}

/**
 * Output pagination.
 *
 * @since 1.0.0
 *
 * @param integer $current_page
 * @param integer $total_pages
 * @return string HTML output
 */
function ppv_Pagination( $current_page, $total_pages ) {
    $output = '<div class="ppv-pagination">' . "\n";
    $big = 999999999; // need an unlikely integer
    $output .= paginate_links( array(
        'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'  => '?paged=%#%',
        'current' => $current_page,
        'total'   => $total_pages
        ) );
    $output .= "\n" . "</div><!-- .ppv-pagination -->";

    /**
     * Filter markup to use for pagination.
     *
     * @since 1.0.0
     *
     * @param string HTML output
     */
    return apply_filters('ppv_pagination_filter', $output);
}

/**
 * Utility function to deal with the way
 * WordPress auto formats text in a shortcode.
 *
 * @since 2.3.3
 *
 */
function custom_filter_shortcode_text($text = "") {
    // Replace all the poorly formatted P tags that WP adds by default.
    $tags = array("<p>", "</p>");
    $text = str_replace($tags, "\n", $text);
    // Remove any BR tags
    $tags = array("<br>", "<br/>", "<br />");
    $text = str_replace($tags, "", $text);
    // Add back in the P and BR tags again, remove empty ones
    return apply_filters("the_content", $text);
}
