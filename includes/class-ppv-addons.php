<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://picturesquephotoviews.com/
 * @since      1.0.0
 *
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ppv_Addons
 * @subpackage Ppv_Addons/includes
 * @author     Loren Heisey <imwsite@cox.net>
 */
class Ppv_Addons {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ppv_Addons_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PPV_ADDONS_VERSION' ) ) {
			$this->version = PPV_ADDONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ppv-addons';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		$this->define_metabox_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ppv_Addons_Loader. Orchestrates the hooks of the plugin.
	 * - Ppv_Addons_i18n. Defines internationalization functionality.
	 * - Ppv_Addons_Admin. Defines all hooks for the admin area.
	 * - Ppv_Addons_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ppv-addons-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ppv-addons-i18n.php';

		/**
		 * The class responsible for defining admin pages and fields for plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class.settings-api.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ppv-addons-admin.php';

		/**
		 * Admin functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/ppv-addons-admin-functions.php';

		/**
		 * The class to use checkbox term selection for non-hierarchical taxonomies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ppv-addons-admin-tag-checklist.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ppv-addons-public.php';

		/**
		 * Public functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/ppv-addons-public-functions.php';

		$this->loader = new Ppv_Addons_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ppv_Addons_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ppv_Addons_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ppv_Addons_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_init', $plugin_admin, 'ppv_convert_taxonomy_terms_to_integers' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ppv_Addons_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        
        $this->loader->add_filter( 'posts_fields', $plugin_public, 'mam_posts_fields' );
        $this->loader->add_filter( 'posts_orderby', $plugin_public, 'mam_posts_orderby' );

        $ppv_rss_image_option = ppv_Get_Val( 'image-in-rss', 'ppvaddons_settings' );
        if ($ppv_rss_image_option === '1') {
            $this->loader->add_filter( 'the_excerpt_rss', $plugin_public, 'ppv_rss_image_content' );
            $this->loader->add_filter( 'the_content_feed', $plugin_public, 'ppv_rss_image_content' );
        }
        if ($ppv_rss_image_option === '2') {
            $this->loader->add_filter( 'rss2_ns', $plugin_public, 'ppv_rss_image_namespace' );
            $this->loader->add_filter( 'rss2_item', $plugin_public, 'ppv_rss_image_separate' );
        }

        $this->loader->add_action( 'init', $plugin_public, 'ppv_create_topics_taxonomy' );
        $this->loader->add_action( 'init', $plugin_public, 'register_shortcodes' );

	}

	/**
	 * Register all of the hooks related to metaboxes
	 *
	 * @since 		1.4.4
	 * @access 		private
	 */
	private function define_metabox_hooks() {

		$ppv_tag_checklist = new Tag_Checklist( 'topic', 'post', false );

	} // define_metabox_hooks()

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ppv_Addons_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
