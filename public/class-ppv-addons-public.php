<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://picturesquephotoviews.com/
 * @since      1.0.0
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/public
 * @author     Loren Heisey <imwsite@cox.net>
 */
class Ppv_Addons_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

	wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ppv-addons-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/** uncomment to use
		 * wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ppv-addons-public.js', array( 'jquery' ), $this->version, false );
		 */

	}

    /**
     * List posts by date.
     *
     * @since 1.0.0
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Posts_By_Date( $atts ) {
        $atts = shortcode_atts (
        array( 
            'posts_per_page' => 24,
            'image_size' => 'thumbnail',
            'show_image' => 'yes',
            'use_wp_pagenavi' => 'yes',
            'order' => 'DESC',
            'default_image' => 'ppv-default.jpg',
            'default_post_icon' => 'Blog1.png',
        ), $atts, 'posts-by-date' );
        
        $posts_per_page = intval( $atts['posts_per_page'] );
        $image_size = sanitize_text_field( $atts['image_size'] );
        $show_image = sanitize_text_field( $atts['show_image'] );
        $use_wp_pagenavi = sanitize_text_field( $atts['use_wp_pagenavi'] );
        $order = sanitize_key( $atts['order'] );
        $default_image = sanitize_file_name( $atts['default_image'] );
        $default_post_icon = sanitize_file_name( $atts['default_post_icon'] );
        
         // Make options case insensitive
        $show_image = strtoupper($show_image);
        $use_wp_pagenavi = strtoupper($use_wp_pagenavi);
        
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args = array( 
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'order' => $order
        );
        $the_query = new WP_Query( $args );

        if ( $the_query->have_posts() ) :
            $output = '<div class="ppv-listing ppv-bydate">' . "\n";
            while ( $the_query->have_posts() ) : $the_query->the_post();
                if ( $show_image === 'YES') {
                    $feature_image = ppv_get_Feature_Image( $image_size, $default_image );
                    $output .= ppv_Media_Object( $feature_image );
                } else {
                    $output .= ppv_Archive_List( $default_post_icon );
                }

            endwhile;
            $output .= "</div><!-- .ppv-listing -->" . "\n";
            if ( ( function_exists('wp_pagenavi') ) && ( $use_wp_pagenavi === 'YES' ) ) {
                $output .= wp_pagenavi( array( 'query' => $the_query, 'echo'=>false) );
            } else {
                $current_page = max( 1, get_query_var('paged') );
                $total_pages = $the_query->max_num_pages;
                $output .= ppv_Pagination( $current_page, $total_pages ); 
            }
            wp_reset_postdata();
        else:
            $output .= "<h2>Sorry, no posts were found!</h2>";
        endif;
        
        return $output;
    }
    
    /**
     * List posts alphabetically.
     *
     * @since 1.2.1
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Posts_Alphabetical( $atts ) {
        $atts = shortcode_atts (
        array( 
            'posts_per_page' => 24,
            'image_size' => 'thumbnail',
            'show_image' => 'yes',
            'use_wp_pagenavi' => 'yes',
            'order' => 'ASC',
            'default_image' => 'ppv-default.jpg',
            'default_post_icon' => 'Blog1.png',
        ), $atts, 'posts-alphabetical' );
        
        $posts_per_page = intval( $atts['posts_per_page'] );
        $image_size = sanitize_text_field( $atts['image_size'] );
        $show_image = sanitize_text_field( $atts['show_image'] );
        $use_wp_pagenavi = sanitize_text_field( $atts['use_wp_pagenavi'] );
        $order = sanitize_key( $atts['order'] );
        $default_image = sanitize_file_name( $atts['default_image'] );
        $default_post_icon = sanitize_file_name( $atts['default_post_icon'] );
        
         // Make options case insensitive
        $show_image = strtoupper($show_image);
        $use_wp_pagenavi = strtoupper($use_wp_pagenavi);
        
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args = array( 
            'post_type' => 'post',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'title',
            'order' => $order
        );
        global $wpdb, $mam_global_fields, $mam_global_orderby, $post;
        // Do not alphabetize the, an, a, <em>
        $mam_global_fields = ",
           IF($wpdb->posts.post_title REGEXP('^the '),CONCAT(SUBSTR($wpdb->posts.post_title,5), ', ', SUBSTR($wpdb->posts.post_title,1,4)),
                IF($wpdb->posts.post_title REGEXP('^an '),CONCAT(SUBSTR($wpdb->posts.post_title,4),', ', SUBSTR($wpdb->posts.post_title,1,3)),
                    IF($wpdb->posts.post_title REGEXP('^a '),CONCAT(SUBSTR($wpdb->posts.post_title,3),', ', SUBSTR($wpdb->posts.post_title,1,2)),
                        IF($wpdb->posts.post_title REGEXP('^<em>'),CONCAT(SUBSTR($wpdb->posts.post_title,5),', ', SUBSTR($wpdb->posts.post_title,1,4)),
                            $wpdb->posts.post_title) )  )  )  AS sort_title";
        $mam_global_orderby = " UPPER(sort_title) ASC";
        $the_query = new WP_Query( $args );
        $mam_global_fields = $mam_global_orderby = '';
        $curr_letter = '';
        $post_count = 0;
        if ( $the_query->have_posts() ) :
            $in_this_row = 0;
            $output = '<div class="ppv-listing ppv-alphabetical">' . "\n";
            while ( $the_query->have_posts() ) : $the_query->the_post();
                $first_letter = strtoupper(substr(apply_filters('the_title',$post->sort_title),0,1));
                if ($first_letter != $curr_letter) {
                    if (++$post_count > 1) {
                        $output .= ppv_end_prev_letter();
                    }
                    $output .= ppv_start_new_letter($first_letter);
                    $in_this_row = 0;
                    $curr_letter = $first_letter;
                }
               if (++$in_this_row > 1) {
                    $output .= ppv_end_prev_row();
                    $output .= ppv_start_new_row();
                    $in_this_row = 1;
                }
                if ( $show_image === 'YES') {
                    $feature_image = ppv_get_Feature_Image( $image_size, $default_image );
                    $output .= ppv_Media_Object( $feature_image );
                } else {
                    $output .= ppv_Archive_List( $default_post_icon );
                }

            endwhile;
            $output .= ppv_end_prev_letter();
            $output .= "</div><!-- .ppv-listing -->" . "\n";
            if ( ( function_exists('wp_pagenavi') ) && ( $use_wp_pagenavi === 'YES' ) ) {
                $output .= wp_pagenavi( array( 'query' => $the_query, 'echo'=>false) );
            } else {
                $current_page = max( 1, get_query_var('paged') );
                $total_pages = $the_query->max_num_pages;
                $output .= ppv_Pagination( $current_page, $total_pages ); 
            }
            wp_reset_postdata();
        else:
            $output .= "<h2>Sorry, no posts were found!</h2>";
        endif;
        
        return $output;
    }
    
    /**
     * List posts by categories.
     *
     * @since 1.0.1
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Posts_By_Categories( $atts ) {
        $atts = shortcode_atts (
        array( 
            'image_size' => 'thumbnail',
            'show_image' => 'yes',
            'orderby' => 'name',
            'order' => 'ASC',
            'default_image' => 'ppv-default.jpg',
            'default_post_icon' => 'Blog1.png',
        ), $atts, 'posts-by-categories' );
        
        $image_size = sanitize_text_field( $atts['image_size'] );
        $show_image = sanitize_text_field( $atts['show_image'] );
        $orderby = sanitize_key( $atts['orderby'] );
        $order = sanitize_key( $atts['order'] );
        $default_image = sanitize_file_name( $atts['default_image'] );
        $default_post_icon = sanitize_file_name( $atts['default_post_icon'] );
        
         // Make options case insensitive
        $show_image = strtoupper($show_image);
        
        global $ppv_category;  //for accessing categories from filters in child themes
        
        //get all categories then display all posts in each term
        $taxonomy = 'category';
        $param_type = 'category__in';
        $term_args=array(
            'orderby' => $orderby,
            'order' => $order
        );
        $terms = get_terms($taxonomy,$term_args);
        $output = '';
        if ($terms) {
            $output .= '<div class="ppv-listing ppv-bycategory">' . "\n";
            foreach( $terms as $term ) {
                $args=array(
                  "$param_type" => array($term->term_id),
                  'post_type' => 'post',
                  'post_status' => 'publish',
                  'posts_per_page' => -1,
                  'ignore_sticky_posts' => 1
                  );
                $the_query = null;
                $the_query = new WP_Query($args);     
                if ( $the_query->have_posts() ) {
                    $ppv_category = $term->name;
                    $output .= '<div class="ppv-category-section">' . "\n";
                    /**
                     * Filter markup for category header.
                     * Use global $ppv_category to display category
                     *
                     * @since 1.0.1
                     *
                     * @param string HTML output
                     */
                    $output .= apply_filters('ppv_category_header_filter', '<div class="ppv-category-header">' . $ppv_category . '</div>' . "\n");
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        if ( $show_image === 'YES') {
                            $feature_image = ppv_get_Feature_Image( $image_size, $default_image );
                            $output .= ppv_Media_Object( $feature_image );
                        } else {
                            $output .= ppv_Archive_List( $default_post_icon );
                        }

                    endwhile;
                    $output .= "</div><!-- .ppv-category-section -->" . "\n";
                }
            }
            $output .= "</div><!-- .ppv-listing -->" . "\n";
        } else {
          $output .= "<h2>Sorry, no posts were found!</h2>";
        }

        wp_reset_postdata();
        return $output;
    }

    /**
     * List tags by number.
     * Display tags in columns starting with version 3.0.
     *
     * @since 1.2.0
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Tags_By_Number( $atts ) {
        $atts = shortcode_atts (
        array( 
            'per_page' => 24,
            'order' => 'DESC',
            'default_tag_icon' => 'Tag1.png',
        ), $atts, 'tags-by-number' );
        
        $per_page = sanitize_text_field( $atts['per_page'] );
        $order = sanitize_key( $atts['order'] );
        $default_tag_icon = sanitize_file_name( $atts['default_tag_icon'] );
        
        $page = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
        $offset = ( $page-1 ) * $per_page;
        $term_args = array( 
            'orderby' => 'count',
            'order' => $order,
            'number' => $per_page,
            'offset' => $offset,
            'hide_empty' => 0
            );

        $taxonomy = 'post_tag';
        $tax_terms = get_terms($taxonomy, $term_args);
        $output = '';
        if ($tax_terms) {
            $output .= "<!-- begin list-->" . "\n";
            $output .= '<div id="ppvTagMap" class="myTagMap">' . "\n";
            $output .= '<div class="holdinner">' . "\n";
            $output .= '<div class="tagindex">' . "\n";
            $output .= '<ul class="links">' . "\n";
            foreach ($tax_terms as $tax_term) {
                $output .= '<li><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name . '<span class="ppvtagmap_count"> (' . $tax_term->count . ')</span></a></li>'  . "\n";
            }
            $output .= "</ul>" . "\n";
            $output .= "</div><!-- end tagindex-->" . "\n";
            $output .= "</div><!-- end holdinner -->" . "\n";
            $output .= "<div style='clear: both;'></div>". "\n";
            $output .= "</div><!-- end list-->" . "\n";
        } else {
          $output .= "<h2>Sorry, no posts were found!</h2>";
        }
        // pagination
        $total_terms = wp_count_terms( 'post_tag' );
        $pages = ceil($total_terms/$per_page);

        // if there's more than one page
        if( $pages > 1 ):
            $output .= ppv_Pagination( $page, $pages ); 
        endif;

        return $output;
    }

    /**
     * List tags alphabetically.
     * Display tags in columns starting with version 3.0.1.
     *
     * @since 1.2.2
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Tags_Alphabetical( $atts ) {
        $atts = shortcode_atts (
        array( 
            'per_page' => 24,
            'order' => 'ASC',
            'default_tag_icon' => 'Tag1.png',
        ), $atts, 'tags-alphabetical' );
        
        $per_page = sanitize_text_field( $atts['per_page'] );
        $order = sanitize_key( $atts['order'] );
        $default_tag_icon = sanitize_file_name( $atts['default_tag_icon'] );
        
        $page = ( get_query_var('paged') ) ? get_query_var( 'paged' ) : 1;
        $offset = ( $page-1 ) * $per_page;
        $term_args = array( 
            'orderby' => 'name',
            'order' => $order,
            'number' => $per_page,
            'offset' => $offset,
            'hide_empty' => 0
            );

        $taxonomy = 'post_tag';
        $tax_terms = get_terms($taxonomy, $term_args);
        $output = '';
        $curr_letter = '';
        $post_count = 0;
        if ($tax_terms) {
            $output .= "<!-- begin list-->" . "\n";
            $output .= '<div id="ppvTagMap" class="myTagMap">' . "\n";
            $output .= '<div class="holdinner">' . "\n";
            foreach ($tax_terms as $tax_term) {
                $first_letter = strtoupper(substr($tax_term->name,0,1));
                if ($first_letter != $curr_letter) {
                    if (++$post_count > 1) {
                        // End previous letter
                        $output .= "</ul>" . "\n";
                        $output .= "</div><!-- end tagindex-->" . "\n";
                    }
                    // Start new letter
                    $output .= '<div class="tagindex">' . "\n";
                    $output .= '<div class="tagindex-heading">' . "\n";
                    $output .= '<div class="tagindex-letter">' . $first_letter . '</div>' . "\n";
                    $output .= "</div>" . "\n";
                    $output .= '<ul class="links">' . "\n";
                    $curr_letter = $first_letter;
                }
                $output .= '<li><a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name . '<span class="ppvtagmap_count"> (' . $tax_term->count . ')</span></a></li>'  . "\n";
            }
            // End previous letter
            $output .= "</ul>" . "\n";
            $output .= "</div><!-- end tagindex-->" . "\n";
            $output .= "</div><!-- end holdinner -->" . "\n";
            $output .= "<div style='clear: both;'></div>". "\n";
            $output .= "</div><!-- end list-->" . "\n";
        } else {
          $output .= "<h2>Sorry, no posts were found!</h2>";
        }
        // pagination
        $total_terms = wp_count_terms( 'post_tag' );
        $pages = ceil($total_terms/$per_page);

        // if there's more than one page
        if( $pages > 1 ):
            $output .= ppv_Pagination( $page, $pages ); 
        endif;

        return $output;
    }

    /**
     * Create the topics non-hierarchical taxonomy.
     *
     * @since 1.4.2
     *
     * Creates and registers custom non-hierarchical taxonomy topics
     */
    function ppv_create_topics_taxonomy() {
        $labels = array(
           'name'                       => 'Topics',
           'singular_name'              => 'Topic',
           'search_items'               => 'Search Topics',
           'popular_items'              => 'Popular Topics',
           'all_items'                  => 'All Topics',
           'parent_item'                => null,
           'parent_item_colon'          => null,
           'edit_item'                  => 'Edit Topic',
           'update_item'                => 'Update Topic',
           'add_new_item'               => 'Add New Topic',
           'new_item_name'              => 'New Topic Name',
           'separate_items_with_commas' => 'Separate Topics with commas',
           'add_or_remove_items'        => 'Add or remove Topics',
           'choose_from_most_used'      => 'Choose from most used Topics',
           'menu_name'                  => 'Topics',
        );

        $args = array(
           'labels'            => $labels,
           'public'            => true,
           'show_in_nav_menus' => true,
           'show_ui'           => true,
           'show_tagcloud'     => false,
           'hierarchical'      => false,
           'rewrite'           => array( 'slug' => 'topic', 'with_front' => false ),
           'query_var'         => true,
           'show_admin_column' => true,
        );
        register_taxonomy( 'topic', array( 'post' ), $args );
    }

    /**
     * Make sure there is a leading comma for query.
     *
     * @since 1.2.1
     *
     * @param array $fields
     * @return array $fields modified
     */
    public function mam_posts_fields( $fields ) {
        global $mam_global_fields;
        if ($mam_global_fields) $fields .= (preg_match('/^(\s+)?,/',$mam_global_fields)) ? $mam_global_fields : ", $mam_global_fields";
        return $fields;
    }

    /**
     * Alters the sort order of the query.
     *
     * @since 1.2.1
     *
     * @param array $orderby
     * @return array $orderby modified
     */
    public function mam_posts_orderby( $orderby ) {
       global $mam_global_orderby;
       if ($mam_global_orderby) $orderby = $mam_global_orderby;
       return $orderby;
    }

    
    /**
     * Columns / Grid shortcodes.
     *
     * @since 2.3.3
     *
     */
    function ppv_column_shortcode($atts,$content=NULL) {
        extract( shortcode_atts( array(
            'size' => 'one-third',
            'last' => false
        ), $atts) );

        $lastclass=$last?' ppv-col-last':'';
        $size = 'ppv-' . $size;  // add prefix in case theme uses same css classes
        $output='<div class="ppv-col-grid '.strip_tags($size).$lastclass.'">'.do_shortcode($content).'</div>';
        if($last) {
            $output.='<div class="ppv-clear"></div>';
            }
        $output = custom_filter_shortcode_text($output);
        return $output;
    }

    /**
     *  Display featured post image in RSS feeds - method 1.
     *  Insert image into $content.
     *
     * @since 2.2.0
     *
     * @param $content
     * @return $content modified
     */
    public function ppv_rss_image_content( $content ) {
        global $post;
        $ppv_rss_image_size = 'medium';  // TODO: make Admin Menu option
        if( has_post_thumbnail( $post->ID ) ) {
            $content = '<figure>' . get_the_post_thumbnail( $post->ID, $ppv_rss_image_size ) . '</figure>' . $content;
        }
        return $content;
    }

    /**
     *  Display featured post image in RSS feeds - method 2.
     *  Insert image object into the RSS item (see MB-191).
     *  Format used by many aggregators.
     *
     * @since 2.2.0
     *
     */
    public function ppv_rss_image_separate() {
      global $post;
      $ppv_rss_image_size = 'medium';  // TODO: make Admin Menu option
      if (has_post_thumbnail($post->ID)){
        $thumbnail_ID = get_post_thumbnail_id($post->ID);
        $thumbnail = wp_get_attachment_image_src( $thumbnail_ID, $ppv_rss_image_size );
        if (is_array($thumbnail)) {
          echo '<media:content medium="image" url="' . $thumbnail[0]
            . '" width="' . $thumbnail[1] . '" height="' . $thumbnail[2] . '" />';
        }
      }
    }

    /**
     *  Add namespace for media:image element used by ppv_rss_image_separate().
     *
     * @since 2.2.0
     *
     */
    public function ppv_rss_image_namespace() {
      echo 'xmlns:media="http://search.yahoo.com/mrss/"';
    }

    /**
     * Registers all shortcodes at once
     *
     * @return [type] [description]
     */
    public function register_shortcodes() {

        add_shortcode( 'posts-by-date', array( $this, 'ppv_Posts_By_Date' ) );
        add_shortcode( 'posts-alphabetical', array( $this, 'ppv_Posts_Alphabetical' ) );
        add_shortcode( 'posts-by-categories', array( $this, 'ppv_Posts_By_Categories' ) );
        add_shortcode( 'tags-by-number', array( $this, 'ppv_Tags_By_Number' ) );
        add_shortcode( 'tags-alphabetical', array( $this, 'ppv_Tags_Alphabetical' ) );
        add_shortcode( 'column', array( $this, 'ppv_column_shortcode' ) );
    }

}
