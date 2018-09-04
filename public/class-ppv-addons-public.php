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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ppv-addons-public.js', array( 'jquery' ), $this->version, false );

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
            'order' => 'DESC',
            'default_image' => 'ppv-default.jpg',
        ), $atts, 'posts-by-date' );
        
        $posts_per_page = intval( $atts['posts_per_page'] );
        $image_size = sanitize_text_field( $atts['image_size'] );
        $show_image = sanitize_text_field( $atts['show_image'] );
        $order = sanitize_key( $atts['order'] );
        $default_image = sanitize_file_name( $atts['default_image'] );
        
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
                if ( $show_image == 'yes') {
                    $feature_image = ppv_get_Feature_Image( $image_size, $default_image );
                    $output .= ppv_Media_Object( $feature_image );
                } else {
                    $output .= ppv_Archive_List();
                }

            endwhile;
            $output .= "</div>" . "\n";
            $output .= ppv_Pagination( $the_query ); 
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
        ), $atts, 'posts-by-date' );
        
        $image_size = sanitize_text_field( $atts['image_size'] );
        $show_image = sanitize_text_field( $atts['show_image'] );
        $orderby = sanitize_key( $atts['orderby'] );
        $order = sanitize_key( $atts['order'] );
        $default_image = sanitize_file_name( $atts['default_image'] );
        
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
                            if ( $show_image == 'yes') {
                                $feature_image = ppv_get_Feature_Image( $image_size, $default_image );
                                $output .= ppv_Media_Object( $feature_image );
                            } else {
                                $output .= ppv_Archive_List();
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
     *
     * @since 1.1.0
     *
     * @param array  $atts
     * @return string HTML output
     */
    public function ppv_Tags_By_Number( $atts ) {
        $atts = shortcode_atts (
        array( 
            'per_page' => 24,
            'order' => 'DESC',
        ), $atts, 'tags-by-number' );
        
        $per_page = sanitize_text_field( $atts['per_page'] );
        $order = sanitize_key( $atts['order'] );
        
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
            $output .= '<div class="ppv-listing ppv-bytagnumber">' . "\n";
            $output .= '<ul>';
            foreach ($tax_terms as $tax_term) {
                $output .=  '<li>' . '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf( __( "View all posts in %s" ), $tax_term->name ) . '" ' . '>' . $tax_term->name .' <span>(' . $tax_term->count . ')</span></a></li>' . "\n";
            }
            $output .= '</ul>' . "\n";
            $output .= "</div><!-- .ppv-listing -->" . "\n";
        } else {
          $output .= "<h2>Sorry, no posts were found!</h2>";
        }
        // pagination
        $total_terms = wp_count_terms( 'post_tag' );
        $pages = ceil($total_terms/$per_page);

        // if there's more than one page
        if( $pages > 1 ):
            $output .= '<div class="ppv-pagination">' . "\n";
            $big = 999999999; // need an unlikely integer
            $output .=  paginate_links( array(
                'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'  => '?paged=%#%',
                'current' => $page,
                'total'   => $pages
                ) );
            $output .=  "\n" . "</div>";
        endif;

        return $output;
    }

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {

		add_shortcode( 'posts-by-date', array( $this, 'ppv_Posts_By_Date' ) );
        add_shortcode( 'posts-by-categories', array( $this, 'ppv_Posts_By_Categories' ) );
        add_shortcode( 'tags-by-number', array( $this, 'ppv_Tags_By_Number' ) );

	}
    
}
