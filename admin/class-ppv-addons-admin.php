<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://picturesquephotoviews.com/
 * @since      1.0.0
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/admin
 * @author     Loren Heisey <imwsite@cox.net>
 */
class Ppv_Addons_Admin {

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
	 * The settings of this plugin.
	 *
	 * @since    2.3.0
	 * @access   private
	 */
	private $settings_api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.3.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );

	}

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_options_page( 'PPV Addons', 'PPV Addons', 'delete_posts', 'settings_api_test', array($this, 'plugin_page') );
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'ppvaddons_settings',
                'title' => __( 'Settings', 'ppvaddons' )
//            ),
//            array(
//                'id'    => 'ppvaddons_help',
//                'title' => __( 'Help', 'ppvaddons' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $settings_fields = array(
            'ppvaddons_settings' => array(
                array(
                    'name'        => 'subsection',
                    'label'       => __( 'PPV Addons Settings', 'ppv-addons' ),
                    'desc'        => __( '', 'ppv-addons' ),
                    'type'        => 'subsection'
                ),
                array(
                    'name'    => 'image-in-rss',
                    'label'   => __( 'Featured image in RSS feeds', 'ppv-addons' ),
                    'desc'    => __( 'Choose to display featured post image in RSS feeds and which method to use', 'ppv-addons' ),
                    'type'    => 'radio',
                    'default' => '2',
                    'options' => array(
                        '0' => 'Do not insert featured image in RSS feeds',
                        '1' => 'Insert image in RSS feed content',
                        '2'  => 'Insert as image object in RSS feed'
                    )
                )
            ),
            'ppvaddons_help' => array(
                array(
                    'name'        => 'subsection2',
                    'label'       => __( 'PPV Addons Help', 'ppv-addons' ),
                    'desc'        => __( 'This is where the PPV Addons help will go.', 'ppv-addons' ),
                    'type'        => 'subsection'
                )
            )
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="wrap">';

        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ppv_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ppv_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/** uncomment to use
		 * wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ppv-addons-admin.css', array(), $this->version, 'all' );
		 */

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ppv_Addons_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ppv_Addons_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		/** uncomment to use
		 * wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ppv-addons-admin.js', array( 'jquery' ), $this->version, false );
		 */

	}

    /**
     * For custom taxonomy admin metabox convert term ids (as ints) to term names (as strings).
     *
     * @since 1.4.4
     */
    public function ppv_convert_taxonomy_terms_to_integers() {
        $taxonomy = 'topic';
        if ( isset( $_POST['tax_input'][ $taxonomy ] ) && is_array( $_POST['tax_input'][ $taxonomy ] ) ) {
            $terms = $_POST['tax_input'][ $taxonomy ];
            $new_terms = array_map( 'intval', $terms );
            $_POST['tax_input'][ $taxonomy ] = $new_terms;
        }
    }

}
