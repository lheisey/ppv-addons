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
 *
 * @since 1.0.0
 *
 * @return string HTML output
 */
function ppv_Archive_List() {
    ob_start();
    ?>
          <div class="ppv-list__body">
          <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
          </div>
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
    return apply_filters('ppv_archive_list_filter', $output);
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

